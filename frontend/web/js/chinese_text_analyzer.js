ChineseTextAnalyzer = (function () {
    var cjkeRegex = /[0-9]|[a-z]|[\u4E00-\u9FCC\u3400-\u4DB5\uFA0E\uFA0F\uFA11\uFA13\uFA14\uFA1F\uFA21\uFA23\uFA24\uFA27-\uFA29]|[\ud840-\ud868][\udc00-\udfff]|\ud869[\udc00-\uded6\udf00-\udfff]|[\ud86a-\ud86c][\udc00-\udfff]|\ud86d[\udc00-\udf34\udf40-\udfff]|\ud86e[\udc00-\udc1d]/i;

    var getPhraseAddress = function (startCut, endCut, cutOrigin) {
        return 1000000 + (startCut + cutOrigin) * 1000 + endCut + cutOrigin;
    };

    var extractInfoFromPhraseAddress = function (address, cutOrigin) {
        return [
            ((address - address % 1000) / 1000) % 1000 - cutOrigin,
            address % 1000 - cutOrigin
        ];
    };

    function parseChineseText(text) {
        var chars = text.split('');
        var mixedParts = [];
        var letterPartIndexes = [];
        let part = [];
        let isLetterPart = null;
        chars.forEach(function (char) {
            if (cjkeRegex.test(char)) {
                if (isLetterPart === true || isLetterPart === null) {
                    part.push(char);
                } else {
                    mixedParts.push(part);
                    if (isLetterPart) {
                        letterPartIndexes.push(mixedParts.length - 1);
                    }
                    part = [char];
                }
                isLetterPart = true;
            } else {
                if (isLetterPart === false || isLetterPart === null) {
                    part.push(char);
                } else {
                    mixedParts.push(part);
                    if (isLetterPart) {
                        letterPartIndexes.push(mixedParts.length - 1);
                    }
                    part = [char];
                }
                isLetterPart = false;
            }
        });
        mixedParts.push(part);
        if (isLetterPart) {
            letterPartIndexes.push(mixedParts.length - 1);
        }
        return [mixedParts, letterPartIndexes];
    }

    function analyzePhrasePhoneticsOfWords(executedClausesInfo, wordsJoiner, onResult,
                                           maxConcurrentTasks = 8, getFreeWorker = undefined, setWorkerIsFree = undefined)
    {
        var tasks = [];
        var currentTaskIndex = -1;
        var result = [];
        executedClausesInfo.forEach(function (infoItem, clauseIndex) {
            result[clauseIndex] = null;
            var error = infoItem['error'];
            var words = infoItem['words'];
            var phraseMaxWords = infoItem['phraseMaxWords'];
            var phrasesData = infoItem['phrasesData'];
            if (error) {
                result[clauseIndex] = {
                    words: words,
                    error: error
                };
            } else {
                var taskExportOutput = function (phrasePhonetics, taskIndex) {
                    result[clauseIndex] = {
                        words: words,
                        phrasePhonetics: phrasePhonetics
                    };
                    console.log('Task ' + taskIndex + ' ended');
                    if (currentTaskIndex < tasks.length - 1) {
                        currentTaskIndex++;
                        tasks[currentTaskIndex](currentTaskIndex);
                    }
                    if (result.every(function (item) { return item !== null; })) {
                        onResult(result);
                    }
                };
                tasks.push(function (taskIndex) {
                    console.log('Task ' + taskIndex + ' started');
                    if (getFreeWorker) {
                        var workerAndIndex = getFreeWorker();
                        var worker = workerAndIndex[0];
                        var workerIndex = workerAndIndex[1];
                        worker.postMessage(JSON.stringify({
                            workerTask: 'phrasingParse',
                            clauseIndex: clauseIndex,
                            words: words,
                            phraseMaxWords: phraseMaxWords,
                            phrasesData: phrasesData,
                            wordsJoiner: wordsJoiner
                        }));
                        worker.onmessage = function (ev) {
                            if (setWorkerIsFree) {
                                setWorkerIsFree(workerIndex);
                            }
                            var phrasePhonetics = ev.data;
                            taskExportOutput(phrasePhonetics, taskIndex);
                        };
                    } else {
                        setTimeout(function () {
                            ChineseTextAnalyzer.phrasingParse(
                                clauseIndex,
                                words,
                                phraseMaxWords,
                                phrasesData,
                                wordsJoiner,
                                function (phrasePhonetics) {
                                    taskExportOutput(phrasePhonetics, taskIndex);
                                }
                            );
                        }, 10);
                    }
                });
            }
        });

        if (tasks.length > 0) {
            for (var i = 0; i < maxConcurrentTasks && i <= tasks.length - 1; i++) {
                currentTaskIndex = i;
                tasks[currentTaskIndex](currentTaskIndex);
            }
        } else {
            onResult(result);
        }
    }

    function phrasingParse(clauseIndex, words, phraseMaxWords, phrasesData, wordsJoiner, exportResult) {
        var dictPhrasePhonetics = {};
        var phrasePhoneticKey = [];
        getBestPhraseCombinations(words, phraseMaxWords, phrasesData, function (combinations) {
            combinations.forEach(function (combination) {
                var phrases = [];
                var phonetics = [];
                var viPhonetics = [];
                combination.forEach(function (address) {
                    var addressInfo = extractInfoFromPhraseAddress(address, 0);
                    var startCut = addressInfo[0];
                    var endCut = addressInfo[1];
                    var phrase = '';
                    for (var i = startCut; i < endCut; i++) {
                        if (i > startCut) {
                            phrase += wordsJoiner;
                        }
                        phrase += words[i];
                    }
                    phrases.push(phrase);
                    var phraseInfo = phrasesData[address];
                    if (phraseInfo) {
                        phonetics.push(phraseInfo[0]);
                        viPhonetics.push(phraseInfo[1]);
                    } else {
                        phonetics.push(null);
                        viPhonetics.push(null);
                    }
                });
                // unique by combination of phonetics
                var key = JSON.stringify(phonetics);
                if (phrasePhoneticKey.indexOf(key) < 0) {
                    dictPhrasePhonetics[key] = [phrases, phonetics, viPhonetics];
                    phrasePhoneticKey.push(key);
                }
            });

            exportResult(phrasePhoneticKey.map(function (key) {
                // split phrase into words if its phonetic is null
                var phrasePhonetic = dictPhrasePhonetics[key];
                var phrases = phrasePhonetic[0], phonetics = phrasePhonetic[1], viPhonetics = phrasePhonetic[2];
                var newPhrases = [], newPhonetics = [], newViPhonetics = [];
                for (var i = 0; i < phrases.length; i++) {
                    if (phonetics[i] === null) {
                        var _words = phrases[i].split(wordsJoiner);
                        for (var j = 0; j < _words.length; j++) {
                            newPhrases.push(_words[j]);
                            newPhonetics.push(null);
                            newViPhonetics.push(null);
                        }
                    } else {
                        newPhrases.push(phrases[i]);
                        newPhonetics.push(phonetics[i]);
                        newViPhonetics.push(viPhonetics[i]);
                    }
                }
                return [newPhrases, newPhonetics, newViPhonetics];
            }));
        });

    }

    function getBestPhraseCombinations(words, phraseMaxWords, phrasesData, exportResult) {
        var clauseNumWords = words.length;

        var wordsIsOkMap = [];
        for (var i = 0; i < clauseNumWords; i++) {
            wordsIsOkMap[i] = false;
        }
        Object.keys(phrasesData).forEach(function (address) {
            var addressInfo = extractInfoFromPhraseAddress(address, 0);
            var startCut = addressInfo[0];
            var endCut = addressInfo[1];
            for (var i = startCut; i < endCut; i++) {
                wordsIsOkMap[i] = true;
            }
        });
        // if (wordsIsOkMap.every(function (isOk) { return isOk; })) {
        //     return getBestPhraseCombinationsWithMaxScoreAble(
        //         words,
        //         phraseMaxWords,
        //         phrasesData,
        //         0,
        //         clauseNumWords
        //     );
        // }

        // BEGIN: break into sub-clauses
        // so that only process words that all of them are data-available
        // in other words, maxScoreAble === clauseNumWords
        var subClauses = [];
        var subAddressCutOrigins = [];
        var okSubClauseIndexes = [];
        var currentSubClauseIsOk = false;
        for (var i1 = 0; i1 < clauseNumWords; i1++) {
            if (currentSubClauseIsOk) {
                if (wordsIsOkMap[i1]) {
                    subClauses[subClauses.length - 1].push(words[i1]);
                    currentSubClauseIsOk = true;
                } else {
                    subClauses.push([ words[i1] ]);
                    subAddressCutOrigins.push(i1);
                    currentSubClauseIsOk = false;
                }
            } else {
                if (wordsIsOkMap[i1]) {
                    subClauses.push([ words[i1] ]);
                    subAddressCutOrigins.push(i1);
                    okSubClauseIndexes.push(subClauses.length - 1);
                    currentSubClauseIsOk = true;
                } else {
                    if (subClauses.length === 0) {
                        subClauses.push([ words[i1] ]);
                        subAddressCutOrigins.push(i1);
                    } else {
                        subClauses[subClauses.length - 1].push(words[i1]);
                    }
                    currentSubClauseIsOk = false;
                }
            }
        }
        // END: break into sub-clauses

        var listOfSubCombinations = [];
        var minCombinationsLength = -1;

        var getResult = function () {
            var combinations = [];
            for (var row = 0; row < minCombinationsLength; row++) {
                var combination = [];
                for (var col = 0; col < listOfSubCombinations.length; col++) {
                    combination.push.apply(combination, listOfSubCombinations[col][row]);
                }
                combinations.push(combination);
            }
            return combinations;
        };

        var tasksRemain = subClauses.length;
        console.log('tasksRemain init', tasksRemain);
        for (var subIndex = 0; subIndex < subClauses.length; subIndex++) {
            listOfSubCombinations[subIndex] = [];
            if (okSubClauseIndexes.indexOf(subIndex) >= 0) {
                (function (i) {
                    console.log('subClause to exe', subClauses[i]);
                    getBestPhraseCombinationsWithMaxScoreAble(
                        subClauses[i],
                        Math.min(phraseMaxWords, subClauses[i].length),
                        phrasesData,
                        subAddressCutOrigins[i],
                        subClauses[i].length,
                        function (combinations) {
                            listOfSubCombinations[i].push.apply(listOfSubCombinations[i], combinations);
                            if (minCombinationsLength === -1 || listOfSubCombinations[i].length < minCombinationsLength) {
                                minCombinationsLength = listOfSubCombinations[i].length;
                            }

                            tasksRemain--;
                            console.log('tasksRemain', tasksRemain, subClauses[i]);
                            if (tasksRemain === 0) {
                                exportResult(getResult());
                            }
                        }
                    );
                })(subIndex);
            } else {
                (function (i) {
                    console.log('subClause to exe', subClauses[i]);
                    getBestPhraseCombinationsWithMaxScoreAble(
                        subClauses[i],
                        1,
                        phrasesData,
                        subAddressCutOrigins[i],
                        0,
                        function (combinations) {
                            listOfSubCombinations[i].push.apply(listOfSubCombinations[i], combinations);
                            if (minCombinationsLength === -1 || listOfSubCombinations[i].length < minCombinationsLength) {
                                minCombinationsLength = listOfSubCombinations[i].length;
                            }

                            tasksRemain--;
                            console.log('tasksRemain', tasksRemain, subClauses[i]);
                            if (tasksRemain === 0) {
                                exportResult(getResult());
                            }
                        }
                    );
                })(subIndex);
            }
        }
    }

    function getBestPhraseCombinationsWithMaxScoreAble(words, phraseMaxWords, phrasesData, addressCutOrigin, maxScoreAble, exportResult) {
        var clauseNumWords = words.length;

        var rankingTable = [];
        for (var s = 0; s <= maxScoreAble; s++) {
            rankingTable[s] = [];
        }
        var maxScoreEven = 0;
        var maxScoreAbleCombination_minLength = clauseNumWords;

        var getResult = function () {
            for (var s1 = rankingTable.length - 1; s1 >= 0; s1--) {
                if (rankingTable[s1].length > 0) {
                    return rankingTable[s1];
                }
            }
        };

        var pushCombination = (a) => {
            var score = 0, com = [], address;

            var comLength = a.length;
            if (comLength > maxScoreAbleCombination_minLength) {
                return;
            }

            if (a.length === 1) {
                address = getPhraseAddress(0, clauseNumWords, addressCutOrigin);
                com.push(address);
                if (phrasesData[address]) score += clauseNumWords; // endCut - startCut
            }
            else { // a.length > 1
                address = getPhraseAddress(0, a[1], addressCutOrigin);
                com.push(address);
                if (phrasesData[address]) score += a[1];
                for (var i = 2; i < a.length; i++) {
                    address = getPhraseAddress(a[i - 1], a[i], addressCutOrigin);
                    com.push(address);
                    if (phrasesData[address]) score += a[i] - a[i - 1];
                }
                // *Note that: `i` was increased more 1 after end the loop (+1 before check loop condition)
                address = getPhraseAddress(a[i - 1], clauseNumWords, addressCutOrigin);
                com.push(address);
                if (phrasesData[address]) score += clauseNumWords - a[i - 1];
            }

            if (score < maxScoreEven) {
                return;
            }

            maxScoreEven = score;
            if (score === maxScoreAble && comLength < maxScoreAbleCombination_minLength) {
                maxScoreAbleCombination_minLength = comLength;
            }

            rankingTable[score].push(com);
        };

        // BEGIN: get phrase address combinations
        var minOfCuts = Math.ceil(clauseNumWords / phraseMaxWords) - 1;
        var maxOfCuts = clauseNumWords - 1;
        var tasksRemain = maxOfCuts - minOfCuts + 1;
        var k = minOfCuts;
        if (k === 0) {
            pushCombination([ 0 ]);
            tasksRemain--;
            if (tasksRemain === 0) {
                exportResult(getResult());
                return;
            }
            k++;
        }
        var n = clauseNumWords - 1;
        var A = phraseMaxWords;
        var interval = setInterval(function () {
            console.time('task numCuts = ' + k);
            var a = [0];
            var backtrack = (i) => {
                for (var j = a[i - 1] + 1; j <= n - k + i; j++) {
                    if (j - a[i - 1] > A) {
                        break;
                    }
                    if (i === k && n + 1 - j > A) {
                        continue;
                    }
                    a[i] = j;
                    if (i === k) {
                        pushCombination(a);
                    } else {
                        backtrack(i + 1);
                    }
                }
            };
            backtrack(1);
            console.timeEnd('task numCuts = ' + k);

            tasksRemain--;
            if (tasksRemain === 0) {
                exportResult(getResult());
                clearInterval(interval);
            }
            k++;
        }, 10);
        // END: get phrase address combinations
    }

    function getCombinations(n, k) {
        if (k < 1 || k > n) {
            throw new Error('k is invalid. Condition: 1 <= k <= n');
        }
        var combinations = [];
        var a = [0];
        var pushCombination = () => {
            var c = [];
            for (var i = 1; i <= k; i++) {
                c.push(a[i]);
            }
            combinations.push(c);
        };
        var backtrack = (i) => {
            for (var j = a[i - 1] + 1; j <= n - k + i; j++) {
                a[i] = j;
                if (i === k) {
                    pushCombination();
                } else {
                    backtrack(i + 1);
                }
            }
        };
        backtrack(1);
        return combinations;
    }

    return {
        analyzePhrasePhoneticsOfWords: analyzePhrasePhoneticsOfWords,
        phrasingParse: phrasingParse,
        parseChineseText: parseChineseText
    };
})();

// shared worker
self.onmessage = function (ev) {
    try {
        var args = JSON.parse(ev.data);
    } catch (err) {
        return;
    }
    switch (args['workerTask']) {
        case 'analyzePhrasePhoneticsOfWords':
            ChineseTextAnalyzer.analyzePhrasePhoneticsOfWords(
                args['executedClausesInfo'],
                args['wordsJoiner'],
                function (result) {
                    postMessage(result);
                }
            );
            break;
        case 'phrasingParse':
            ChineseTextAnalyzer.phrasingParse(
                args['clauseIndex'],
                args['words'],
                args['phraseMaxWords'],
                args['phrasesData'],
                args['wordsJoiner'],
                function (phrasePhonetics) {
                    postMessage(phrasePhonetics);
                }
            );
            break;
    }
};
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
                            words: words,
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
                                words,
                                phrasesData,
                                wordsJoiner,
                                function (phrasePhonetics) {
                                    taskExportOutput(phrasePhonetics, taskIndex);
                                },
                                maxConcurrentTasks, getFreeWorker, setWorkerIsFree
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

    function phrasingParse(words, phrasesData, wordsJoiner, exportResult,
                           maxConcurrentTasks = 8, getFreeWorker = undefined, setWorkerIsFree = undefined) {
        getBestPhraseCombinations(words, phrasesData, function (combinations) {
            var phrasePhonetics = [];

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
                phrasePhonetics.push([phrases, phonetics, viPhonetics]);
            });

            exportResult(phrasePhonetics);
        }, maxConcurrentTasks, getFreeWorker, setWorkerIsFree);
    }

    function getBestPhraseCombinations(words, phrasesData, exportResult,
                                       maxConcurrentTasks = 8, getFreeWorker = undefined, setWorkerIsFree = undefined) {
        var clauseNumWords = words.length;

        var wordsIsOkMap = [];
        for (var i = 0; i < clauseNumWords; i++) {
            wordsIsOkMap[i] = false;
        }
        var phraseNumWordsList = [];
        Object.keys(phrasesData).forEach(function (address) {
            var addressInfo = extractInfoFromPhraseAddress(address, 0);
            var startCut = addressInfo[0];
            var endCut = addressInfo[1];
            var phraseNumWords = addressInfo[1] - addressInfo[0];
            if (phraseNumWordsList.indexOf(phraseNumWords) < 0) {
                phraseNumWordsList.push(phraseNumWords);
            }
            for (var i = startCut; i < endCut; i++) {
                wordsIsOkMap[i] = true;
            }
        });
        phraseNumWordsList.sort(function (a, b) {
            return a - b;
        });
        // if (wordsIsOkMap.every(function (isOk) { return isOk; })) {
        //     return getBestPhraseCombinationsWithMaxScoreAble(
        //         words,
        //         phraseMinWords,
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
        for (var subIndex = 0; subIndex < subClauses.length; subIndex++) {
            listOfSubCombinations[subIndex] = [];
            if (okSubClauseIndexes.indexOf(subIndex) >= 0) {
                (function (i) {
                    getBestPhraseCombinationsWithMaxScoreAble(
                        subClauses[i],
                        phraseNumWordsList,
                        phrasesData,
                        subAddressCutOrigins[i],
                        subClauses[i].length,
                        function (combinations) {
                            listOfSubCombinations[i].push.apply(listOfSubCombinations[i], combinations);
                            if (minCombinationsLength === -1 || listOfSubCombinations[i].length < minCombinationsLength) {
                                minCombinationsLength = listOfSubCombinations[i].length;
                            }

                            tasksRemain--;
                            if (tasksRemain === 0) {
                                exportResult(getResult());
                            }
                        },
                        maxConcurrentTasks, getFreeWorker, setWorkerIsFree
                    );
                })(subIndex);
            } else {
                (function (i) {
                    getBestPhraseCombinationsWithMaxScoreAble(
                        subClauses[i],
                        [1],
                        phrasesData,
                        subAddressCutOrigins[i],
                        0,
                        function (combinations) {
                            listOfSubCombinations[i].push.apply(listOfSubCombinations[i], combinations);
                            if (minCombinationsLength === -1 || listOfSubCombinations[i].length < minCombinationsLength) {
                                minCombinationsLength = listOfSubCombinations[i].length;
                            }

                            tasksRemain--;
                            if (tasksRemain === 0) {
                                exportResult(getResult());
                            }
                        },
                        maxConcurrentTasks, getFreeWorker, setWorkerIsFree
                    );
                })(subIndex);
            }
        }
    }

    function getBestPhraseCombinationsWithMaxScoreAble(words, phraseNumWordsList, phrasesData, addressCutOrigin, maxScoreAble, exportResult,
                                                       maxConcurrentTasks = 8, getFreeWorker = undefined, setWorkerIsFree = undefined) {
        var clauseNumWords = words.length;

        var rankingTable = [];
        for (var s = 0; s <= maxScoreAble; s++) {
            rankingTable[s] = [];
        }

        var getResult = function () {
            for (var s1 = rankingTable.length - 1; s1 >= 0; s1--) {
                if (rankingTable[s1].length > 0) {
                    for (var c = 0; c < rankingTable[s1].length; c++) {
                        if (rankingTable[s1][c].length > 0) {
                            return rankingTable[s1][c]; // best score with min of cuts
                        }
                    }
                }
            }
        };

        // BEGIN: get phrase address combinations
        var phraseMinWords = phraseNumWordsList[0];
        var phraseMaxWords = phraseNumWordsList[phraseNumWordsList.length - 1];
        var minOfCuts = Math.ceil(clauseNumWords / phraseMaxWords) - 1;
        var maxOfCuts = Math.floor(clauseNumWords / phraseMinWords) - 1;
        if (minOfCuts > maxOfCuts) {
            console.error({minOfCuts, maxOfCuts, phraseMaxWords, phraseMinWords, clauseNumWords});
            throw new Error('minOfCuts > maxOfCuts');
        }

        var tasksDone = [];
        for (var i = minOfCuts; i <= maxOfCuts; i++) {
            tasksDone[i] = false;
        }
        var workersMap = {};

        var pushSubRankingTable = function (subRankingTable, numOfCuts) {
            if (tasksDone[numOfCuts]) {
                return;
            }

            if (subRankingTable[subRankingTable.length - 1].length > 0) { // has combinations reached max score able
                for (var j = numOfCuts + 1; j <= maxOfCuts; j++) {
                    tasksDone[j] = true;
                    if (workersMap[j]) {
                        workersMap[j][0].terminate(); // worker.terminate
                        if (setWorkerIsFree) {
                            setWorkerIsFree(workersMap[j][1]); // workerIndex
                        }
                    }
                }
            }

            var highestScoreEven = 0;
            for (var s = rankingTable.length - 1; s >= 0; s--) {
                if (rankingTable[s].length > 0) {
                    highestScoreEven = s;
                    break;
                }
            }

            for (var s1 = subRankingTable.length - 1; s1 >= 0; s1--) {
                if (subRankingTable[s1].length > 0) {
                    if (s1 < highestScoreEven) {
                        break;
                    }
                    for (var i = 0; i < 5 && i < subRankingTable[s1].length; i++) { // 5 is max number of combinations to export
                        for (var c = 0; c <= maxOfCuts; c++) {
                            rankingTable[s1][c] = [];
                        }
                        rankingTable[s1][numOfCuts].push(subRankingTable[s1][i]);
                    }
                    break; // only add highest score combinations
                }
            }

            tasksDone[numOfCuts] = true;
            if (tasksDone.every(function (isDone) { return isDone; })) {
                exportResult(getResult());
            }
        };
        if (false && getFreeWorker) { // try to not use worker
            console.log('Use worker for nkAB');
            for (var k = minOfCuts; k <= maxOfCuts; k++) {
                (function (k) {
                    var workerAndIndex = getFreeWorker();
                    var worker = workerAndIndex[0];
                    var workerIndex = workerAndIndex[1];
                    worker.postMessage(JSON.stringify({
                        workerTask: 'pushCombinationsWithNumOfCuts',
                        numOfCuts: k,
                        clauseNumWords: clauseNumWords,
                        phraseNumWordsList: phraseNumWordsList,
                        phrasesData: phrasesData,
                        addressCutOrigin: addressCutOrigin,
                        maxScoreAble: maxScoreAble
                    }));
                    worker.onmessage = function (ev) {
                        if (setWorkerIsFree) {
                            setWorkerIsFree(workerIndex);
                        }
                        pushSubRankingTable(ev.data, k);
                    };
                    workersMap[k] = workerAndIndex;
                })(k);
            }
        } else {
            console.log('DO NOT use worker for nkAB');
            for (var j = minOfCuts; j <= maxOfCuts; j++) {
                if (tasksDone[j]) {
                    console.log('break caused by set done by another', j);
                    break;
                }
                pushSubRankingTable(ChineseTextAnalyzer.pushCombinationsWithNumOfCuts(
                    j, clauseNumWords, phraseNumWordsList,
                    phrasesData, addressCutOrigin, maxScoreAble
                ), j);
            }
        }
        // END: get phrase address combinations

    }
    
    function pushCombinationsWithNumOfCuts(numOfCuts, clauseNumWords, phraseNumWordsList, phrasesData,
                                           addressCutOrigin, maxScoreAble) {
        var rankingTable = [];
        for (var s = 0; s <= maxScoreAble; s++) {
            rankingTable[s] = [];
        }
        var maxScoreEven = 0;
        var maxScoreAbleCombination_minLength = clauseNumWords;

        var pushCombination = function (a) {
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

        var n = clauseNumWords - 1;
        var k = numOfCuts;
        var C = phraseNumWordsList;
        var A = C[0];
        var B = C[C.length - 1];

        var timerName = 'nkAB ' + n + '.' + k + '.' + C;
        console.log(timerName + ': start');
        console.time(timerName);
        var a = [0];
        if (k === 0) {
            pushCombination(a);
        } else {
            var backtrack = function (i) {
                var x = 0;
                for (var j = a[i - 1] + A
                    ; j <= n - k + i && j - a[i - 1] <= B
                    ; j += C[x] - C[x - 1]
                ) {
                    x++;
                    if (i === k && (n + 1 - j < A || n + 1 - j > B)) {
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
        }
        console.timeEnd(timerName);
        return rankingTable;
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
        parseChineseText: parseChineseText,
        pushCombinationsWithNumOfCuts: pushCombinationsWithNumOfCuts
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
                args['words'],
                args['phrasesData'],
                args['wordsJoiner'],
                function (phrasePhonetics) {
                    postMessage(phrasePhonetics);
                }
            );
            break;
        case 'pushCombinationsWithNumOfCuts':
            postMessage(ChineseTextAnalyzer.pushCombinationsWithNumOfCuts(
                args['numOfCuts'],
                args['clauseNumWords'],
                args['phraseNumWordsList'],
                args['phrasesData'],
                args['addressCutOrigin'],
                args['maxScoreAble']
            ));
            break;
    }
};
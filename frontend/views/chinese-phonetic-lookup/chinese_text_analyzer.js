ChineseTextAnalyzer = (function () {
    var cjkeRegex = /[0-9]|[a-z]|[\u4E00-\u9FCC\u3400-\u4DB5\uFA0E\uFA0F\uFA11\uFA13\uFA14\uFA1F\uFA21\uFA23\uFA24\uFA27-\uFA29]|[\ud840-\ud868][\udc00-\udfff]|\ud869[\udc00-\uded6\udf00-\udfff]|[\ud86a-\ud86c][\udc00-\udfff]|\ud86d[\udc00-\udf34\udf40-\udfff]|\ud86e[\udc00-\udc1d]/i;

    var getPhraseAddress = function (startCut, endCut, cutOrigin) {
        return 1900000 - (startCut + cutOrigin) * 1000 - (endCut + cutOrigin);
    };

    var extractInfoFromPhraseAddress = function (address, cutOrigin) {
        address = 1900000 - address;
        return [
            (address - address % 1000) / 1000 - cutOrigin,
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
                            // set worker is free as soon as possible
                            if (setWorkerIsFree) {
                                setWorkerIsFree(workerIndex);
                            }
                            var phrasePhonetics = ev.data;
                            taskExportOutput(phrasePhonetics, taskIndex);
                        };
                    } else {
                        setTimeout(function () {
                            var phrasePhonetics = ChineseTextAnalyzer.phrasingParse(
                                words,
                                phrasesData,
                                wordsJoiner
                            );
                            taskExportOutput(phrasePhonetics, taskIndex);
                        }, 0);
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

    function phrasingParse(words, phrasesData, wordsJoiner) {
        var phrasePhonetics = [];
        getBestPhraseCombinations(words.length, phrasesData).forEach(function (cuts) {
            var phrases = [];
            var phonetics = [];
            var viPhonetics = [];
            for (var i = 0; i < cuts.length - 1; i++) {
                var startCut = cuts[i];
                var endCut = cuts[i + 1];
                var address = getPhraseAddress(startCut, endCut, 0);
                var phrase = '';
                for (var j = startCut; j < endCut; j++) {
                    if (j > startCut) {
                        phrase += wordsJoiner;
                    }
                    phrase += words[j];
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
            }
            phrasePhonetics.push([phrases, phonetics, viPhonetics]);
        });
        return phrasePhonetics;
    }

    function getBestPhraseCombinations(clauseNumWords, phrasesData) {
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

        // BEGIN: break into sub-clauses
        // so that only process words that all of them are data-available
        // in other words, maxScoreAble === clauseNumWords
        var subClauseSizes = [];
        var subAddressCutOrigins = [];
        var okSubClauseIndexes = [];
        var currentSubClauseIsOk = false;
        for (var j = 0; j < clauseNumWords; j++) {
            if (currentSubClauseIsOk) {
                if (wordsIsOkMap[j]) {
                    subClauseSizes[subClauseSizes.length - 1]++;
                    currentSubClauseIsOk = true;
                } else {
                    subClauseSizes.push(1);
                    subAddressCutOrigins.push(j);
                    currentSubClauseIsOk = false;
                }
            } else {
                if (wordsIsOkMap[j]) {
                    subClauseSizes.push(1);
                    subAddressCutOrigins.push(j);
                    okSubClauseIndexes.push(subClauseSizes.length - 1);
                    currentSubClauseIsOk = true;
                } else {
                    if (subClauseSizes.length === 0) {
                        subClauseSizes.push(1);
                        subAddressCutOrigins.push(j);
                    } else {
                        subClauseSizes[subClauseSizes.length - 1]++;
                    }
                    currentSubClauseIsOk = false;
                }
            }
        }
        // END: break into sub-clauses

        var listOfSubCombinations = [];
        var minCombinationsLength = -1;

        for (var k = 0; k < subClauseSizes.length; k++) {
            if (okSubClauseIndexes.indexOf(k) >= 0) {
                listOfSubCombinations[k] = getBestCuttingRoutes(subClauseSizes[k], phrasesData, subAddressCutOrigins[k]);
            } else {
                listOfSubCombinations[k] = getBestCuttingRoutes(subClauseSizes[k], null, subAddressCutOrigins[k]);
            }
            if (minCombinationsLength === -1 || listOfSubCombinations[k].length < minCombinationsLength) {
                minCombinationsLength = listOfSubCombinations[k].length;
            }
        }

        var combinations = [];
        for (var row = 0; row < minCombinationsLength; row++) {
            var combination = [ listOfSubCombinations[0][row][0] ]; // [ (start cut of full-clause) ]
            for (var col = 0; col < listOfSubCombinations.length; col++) {
                for (var x = 1; x < listOfSubCombinations[col][row].length; x++) {
                    combination.push(listOfSubCombinations[col][row][x]);
                }
            }
            combinations.push(combination);
        }

        return combinations;
    }

    function getBestCuttingRoutes(clauseNumWords, phrasesData, addressCutOrigin) {
        if (phrasesData === null) {
            var bestRoute = [];
            for (var i = 0; i <= clauseNumWords; i++) {
                bestRoute.push(i + addressCutOrigin);
            }
            return [ bestRoute ];
        }

        var startEndMap = {};

        Object.keys(phrasesData).forEach(function (address) {
            var info = extractInfoFromPhraseAddress(address, addressCutOrigin);
            if (startEndMap[info[0]] !== undefined) {
                startEndMap[info[0]].push(info[1]);
            } else {
                startEndMap[info[0]] = [ info[1] ];
            }
        });

        var routesTable = [];
        for (var numSteps = 0; numSteps <= clauseNumWords + 1; numSteps++) {
            routesTable[numSteps] = null;
        }

        var minSteps = clauseNumWords + 1;
        var backtrack = function (start, route) {
            var numSteps = route.length + 1;
            if (numSteps > minSteps) {
                return;
            }
            route.push(start + addressCutOrigin);
            var endList = startEndMap[start];
            if (endList) {
                for (var i = 0; i < endList.length; i++) {
                    backtrack(endList[i], [].concat(route));
                }
            } else if (start === clauseNumWords) {
                if (numSteps < minSteps) {
                    minSteps = numSteps;
                }
                if (routesTable[numSteps] === null) {
                    routesTable[numSteps] = [ route ];
                } else {
                    routesTable[numSteps].push(route);
                }
            }
        };
        backtrack(0, []);

        for (var j = 2; j < routesTable.length; j++) {
            if (routesTable[j] !== null) {
                return routesTable[j];
            }
        }
    }

    return {
        analyzePhrasePhoneticsOfWords: analyzePhrasePhoneticsOfWords,
        phrasingParse: phrasingParse,
        parseChineseText: parseChineseText,
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
            var phrasePhonetics = ChineseTextAnalyzer.phrasingParse(
                args['words'],
                args['phrasesData'],
                args['wordsJoiner']
            );
            postMessage(phrasePhonetics);
            break;
    }
};
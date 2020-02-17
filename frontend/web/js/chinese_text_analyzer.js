ChineseTextAnalyzer = (function () {
    var cjkeRegex = /[0-9]|[a-z]|[\u4E00-\u9FCC\u3400-\u4DB5\uFA0E\uFA0F\uFA11\uFA13\uFA14\uFA1F\uFA21\uFA23\uFA24\uFA27-\uFA29]|[\ud840-\ud868][\udc00-\udfff]|\ud869[\udc00-\uded6\udf00-\udfff]|[\ud86a-\ud86c][\udc00-\udfff]|\ud86d[\udc00-\udf34\udf40-\udfff]|\ud86e[\udc00-\udc1d]/i;

    var getPhraseAddress = function (clauseIndex, startCut, endCut) {
        return 1000000000 + clauseIndex * 1000000 + startCut * 1000 + endCut;
    };

    var extractInfoFromPhraseAddress = function (address) {
        var endCut = address % 1000;
        address = (address - endCut) / 1000;
        var startCut = address % 1000;
        return [((address - startCut) / 1000) % 1000, startCut, endCut];
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

    function analyzePhrasePhoneticsOfWords(executedClausesInfo, phrasesData, wordsJoiner, onResult,
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
                            var phrasePhonetics = ChineseTextAnalyzer.phrasingParse(
                                clauseIndex,
                                words,
                                phraseMaxWords,
                                phrasesData,
                                wordsJoiner
                            );
                            taskExportOutput(phrasePhonetics, taskIndex);
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

    function phrasingParse(clauseIndex, words, phraseMaxWords, phrasesData, wordsJoiner) {
        var rankingTable = getPhrasesRankingTable(clauseIndex, words, phraseMaxWords, phrasesData);
        console.log('rankingTable', rankingTable);
        var bestCombinations = [];
        for (let score = rankingTable.length - 1; score > 0; score--) {
            if (rankingTable[score].length > 0) {
                let minOfPhrases = rankingTable[score][0].length;
                bestCombinations.push(rankingTable[score][0]);
                for (let i = 1; i < rankingTable[score].length - 1; i++) {
                    if (rankingTable[score][i].length === minOfPhrases) {
                        bestCombinations.push(rankingTable[score][i]);
                    } else {
                        break;
                    }
                }
                break;
            }
        }

        console.log('bestCombinations', bestCombinations);
        var dictPhrasePhonetics = {};
        var phrasePhoneticKey = [];
        bestCombinations.forEach(function (combination) {
            var phrases = [];
            var phonetics = [];
            var viPhonetics = [];
            combination.forEach(function (address) {
                var addressInfo = extractInfoFromPhraseAddress(address);
                var phrase = '';
                for (var i = addressInfo[1]; i < addressInfo[2]; i++) {
                    if (i > addressInfo[1]) {
                        phrase += wordsJoiner;
                    }
                    phrase += words[i];
                }
                console.log('address', address, addressInfo, phrase);
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

        return phrasePhoneticKey.map(function (key) {
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
        });
    }

    function getPhrasesRankingTable(clauseIndex, words, phraseMaxWords, phrasesData) {
        var rankingTable = [];
        for (let score = 0; score <= words.length; score++) {
            rankingTable[score] = [];
        }
        getPhraseAddressesCombinations(clauseIndex, words.length, phraseMaxWords).forEach(function (combination) {
            let score = 0;
            combination.forEach(function (address) {
                if (phrasesData[address]) {
                    var info = extractInfoFromPhraseAddress(address);
                    score += info[2] - info[1]; // endCut - startCut
                }
            });
            rankingTable[score].push(combination);
        });
        return rankingTable;
    }

    function getPhraseAddressesCombinations(clauseIndex, clauseNumWords, phraseMaxWords) {
        var minOfCuts = Math.ceil(clauseNumWords / phraseMaxWords) - 1;
        var maxOfCuts = clauseNumWords - 1;
        var combinations = [];
        for (var numOfCuts = minOfCuts; numOfCuts <= maxOfCuts; numOfCuts++) {
            if (numOfCuts === 0) {
                combinations.push([ getPhraseAddress(clauseIndex, 0, clauseNumWords) ]);
                continue;
            }
            getCombinationsWidthSpaceLimit(clauseNumWords - 1, numOfCuts, phraseMaxWords).forEach(function (cuts) {
                // `cuts` never empty with passed arguments
                var combination = [ getPhraseAddress(clauseIndex, 0, cuts[0]) ];
                for (var i = 1; i < cuts.length; i++) {
                    combination.push(getPhraseAddress(clauseIndex, cuts[i - 1], cuts[i]));
                }
                combination.push(getPhraseAddress(clauseIndex, cuts[i - 1], clauseNumWords));
                combinations.push(combination);
            });
        }
        return combinations;
    }

    function getCombinationsWidthSpaceLimit(n, k, A) {
        if (k < 1 || k > n) {
            throw new Error('k is invalid. Condition: 1 <= k <= n. Received k = ' + k);
        }
        var combinations = [];
        var a = [0];
        // var padding = (L) => {
        //     var str = '';
        //     for (var i = 0; i < L; i++) str += '     ';
        //     return str + '|';
        // };
        var pushCombination = () => {
            var c = [];
            for (var i = 1; i <= k; i++) {
                c.push(a[i]);
            }
            combinations.push(c);
        };
        var backtrack = (i) => {
            // console.log(padding(i), 'backtrack i =', i);
            for (var j = a[i - 1] + 1; j <= n - k + i; j++) {
                if (j - a[i - 1] > A) {
                    // console.log(padding(i), 'break before:', j - (i === 1 ? 1 : a[i - 1]));
                    break;
                }
                if (i === k && n + 1 - j > A) {
                    // console.log(padding(i), 'continue last:', n - j);
                    continue;
                }
                a[i] = j;
                // console.log(padding(i), 'j = ', j);
                // console.log(padding(i), 'a = ', a);
                if (i === k) {
                    // console.log(padding(i), 'push --->');
                    pushCombination();
                } else {
                    backtrack(i + 1);
                }
            }
        };
        backtrack(1);
        return combinations;
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
                args['phrasesData'],
                args['wordsJoiner'],
                function (result) {
                    postMessage(result);
                }
            );
            break;
        case 'phrasingParse':
            var phrasePhonetics = ChineseTextAnalyzer.phrasingParse(
                args['clauseIndex'],
                args['words'],
                args['phraseMaxWords'],
                args['phrasesData'],
                args['wordsJoiner']
            );
            postMessage(phrasePhonetics);
            break;
    }
};
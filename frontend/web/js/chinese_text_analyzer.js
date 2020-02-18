ChineseTextAnalyzer = (function () {
    var cjkeRegex = /[0-9]|[a-z]|[\u4E00-\u9FCC\u3400-\u4DB5\uFA0E\uFA0F\uFA11\uFA13\uFA14\uFA1F\uFA21\uFA23\uFA24\uFA27-\uFA29]|[\ud840-\ud868][\udc00-\udfff]|\ud869[\udc00-\uded6\udf00-\udfff]|[\ud86a-\ud86c][\udc00-\udfff]|\ud86d[\udc00-\udf34\udf40-\udfff]|\ud86e[\udc00-\udc1d]/i;

    var getPhraseAddress = function (startCut, endCut) {
        return 1000000 + startCut * 1000 + endCut;
    };

    var extractInfoFromPhraseAddress = function (address) {
        return [
            ((address - address % 1000) / 1000) % 1000,
            address % 1000
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
        var dictPhrasePhonetics = {};
        var phrasePhoneticKey = [];
        getBestPhraseCombinations(clauseIndex, words, phraseMaxWords, phrasesData).forEach(function (combination) {
            var phrases = [];
            var phonetics = [];
            var viPhonetics = [];
            combination.forEach(function (address, index) {
                var addressInfo = extractInfoFromPhraseAddress(address);
                var startCut = addressInfo[0];
                var endCut = addressInfo[1];
                var addressInfoList = [ [address, startCut, endCut] ];
                if (index === 0) {
                    var firstStartCut = 0;
                    var firstEndCut = startCut;
                    var firstAddress = getPhraseAddress(firstStartCut, firstEndCut);
                    addressInfoList.unshift([firstAddress, firstStartCut, firstEndCut]);
                } else if (index === combination.length - 1) {
                    var lastStartCut = endCut;
                    var lastEndCut = words.length;
                    var lastAddress = getPhraseAddress(lastStartCut, lastEndCut);
                    addressInfoList.push([lastAddress, lastStartCut, lastEndCut]);
                }
                addressInfoList.forEach(function (item) {
                    var phrase = '';
                    for (var i = item[1]; i < item[2]; i++) {
                        if (i > item[1]) {
                            phrase += wordsJoiner;
                        }
                        phrase += words[i];
                    }
                    phrases.push(phrase);
                    var phraseInfo = phrasesData[item[0]];
                    if (phraseInfo) {
                        phonetics.push(phraseInfo[0]);
                        viPhonetics.push(phraseInfo[1]);
                    } else {
                        phonetics.push(null);
                        viPhonetics.push(null);
                    }
                });
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

    function getBestPhraseCombinations(clauseIndex, words, phraseMaxWords, phrasesData) {
        var clauseNumWords = words.length;
        var minOfCuts = Math.ceil(clauseNumWords / phraseMaxWords) - 1;
        var maxOfCuts = clauseNumWords - 1;

        var okWordIndexes = [];
        for (var i = 0; i < clauseNumWords; i++) {
            okWordIndexes[i] = false;
        }
        Object.keys(phrasesData).forEach(function (address) {
            var addressInfo = extractInfoFromPhraseAddress(address);
            var startCut = addressInfo[0];
            var endCut = addressInfo[1];
            for (var i = startCut; i < endCut; i++) {
                okWordIndexes[i] = true;
            }
        });
        var maxScoreAble = 0;
        for (var i1 = 0; i1 < clauseNumWords; i1++) {
            if (okWordIndexes[i1]) {
                maxScoreAble++;
            }
        }
        console.log('clauseIndex', clauseIndex, 'clauseNumWords', clauseNumWords, 'maxScoreAble', maxScoreAble);

        var rankingTable = [];
        for (var s = 0; s <= maxScoreAble; s++) {
            rankingTable[s] = [];
        }
        var maxScoreEven = 0;
        var maxScoreAbleCombination_minLength = clauseNumWords;

        var pushCombination = (a) => {
            var score = 0, com = [], address;

            var comLength = a.length;
            if (comLength > maxScoreAbleCombination_minLength) {
                return;
            }

            if (a.length === 1) {
                address = getPhraseAddress(0, clauseNumWords);
                if (phrasesData[address]) score += clauseNumWords; // endCut - startCut
            }
            else { // a.length > 1
                address = getPhraseAddress(0, a[1]);
                if (phrasesData[address]) score += a[1];
                for (var i = 2; i < a.length; i++) {
                    address = getPhraseAddress(a[i - 1], a[i]);
                    if (phrasesData[address]) score += a[i] - a[i - 1];
                    com.push(address);
                }
                // *Note that: `i` was increased more 1 after end the loop (+1 before check loop condition)
                address = getPhraseAddress(a[i - 1], clauseNumWords);
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
        var n = clauseNumWords - 1;
        var A = phraseMaxWords;
        for (var numOfCuts = minOfCuts; numOfCuts <= maxOfCuts; numOfCuts++) {
            if (numOfCuts === 0) {
                pushCombination([ 0 ]);
                continue;
            }
            var k = numOfCuts; // k >= 1 && k <= n
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
        }
        // END: get phrase address combinations

        for (var s1 = rankingTable.length - 1; s1 >= 0; s1--) {
            if (rankingTable[s1].length > 0) {
                return rankingTable[s1];
            }
        }
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
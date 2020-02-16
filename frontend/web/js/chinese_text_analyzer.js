ChineseTextAnalyzer = (function () {
    var cjkeRegex = /[0-9]|[a-z]|[\u4E00-\u9FCC\u3400-\u4DB5\uFA0E\uFA0F\uFA11\uFA13\uFA14\uFA1F\uFA21\uFA23\uFA24\uFA27-\uFA29]|[\ud840-\ud868][\udc00-\udfff]|\ud869[\udc00-\uded6\udf00-\udfff]|[\ud86a-\ud86c][\udc00-\udfff]|\ud86d[\udc00-\udf34\udf40-\udfff]|\ud86e[\udc00-\udc1d]/i;

    function analyzePhrasePhoneticsOfWords(executedWordsInfo, phrasesData, wordsJoiner, callback) {
        var MAX_CONCURRENT_TASKS = 20;
        var tasks = [];
        var currentTaskIndex = -1;
        var result = [];
        executedWordsInfo.forEach(function (infoItem, index) {
            result[index] = null;
            var error = infoItem['error'];
            var words = infoItem['words'];
            var phraseMaxWords = infoItem['phraseMaxWords'];
            if (error) {
                result[index] = {
                    words: words,
                    error: error
                };
            } else {
                var taskExportOutput = function (phrasePhonetics, taskIndex) {
                    result[index] = {
                        words: words,
                        phrasePhonetics: phrasePhonetics
                    };
                    console.log('Task ' + taskIndex + ' ended');
                    if (currentTaskIndex < tasks.length - 1) {
                        currentTaskIndex++;
                        tasks[currentTaskIndex](currentTaskIndex);
                    }
                    if (result.every(function (item) { return item !== null; })) {
                        callback(result);
                    }
                };
                tasks.push(function (taskIndex) {
                    console.log('Task ' + taskIndex + ' started');
                    setTimeout(function () {
                        var phrasePhonetics = ChineseTextAnalyzer.phrasingParse(
                            words,
                            phraseMaxWords,
                            phrasesData,
                            wordsJoiner
                        );
                        taskExportOutput(phrasePhonetics, taskIndex);
                    }, 10);
                });
            }
        });

        if (tasks.length > 0) {
            for (var i = 0; i <= MAX_CONCURRENT_TASKS && i < tasks.length - 1; i++) {
                currentTaskIndex = i;
                tasks[currentTaskIndex](currentTaskIndex);
            }
        } else {
            callback(result);
        }
    }

    function phrasingParse(words, phraseMaxWords, phrasesData, wordsJoiner) {
        var rankingTable = getPhrasesRankingTable(words, phraseMaxWords, phrasesData, wordsJoiner);
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

        var dictPhrasePhonetics = {};
        var phrasePhoneticKey = [];
        bestCombinations.forEach(function (combination) {
            var phrases = [];
            var phonetics = [];
            var viPhonetics = [];
            combination.forEach(function (phraseWords) {
                var phrase = phraseWords.join(wordsJoiner);
                phrases.push(phrase);
                var item = phrasesData[phrase];
                if (item) {
                    phonetics.push(item[0]);
                    viPhonetics.push(item[1]);
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

    function getPhrasesRankingTable(words, phraseMaxWords, phrasesData, wordsJoiner) {
        var rankingTable = [];
        for (let score = 0; score <= words.length; score++) {
            rankingTable[score] = [];
        }
        getPhrasesCombinations(words, phraseMaxWords).forEach(function (combination) {
            let score = 0;
            combination.forEach(function (phraseWords) {
                var phrase = phraseWords.join(wordsJoiner);
                if (phrasesData.hasOwnProperty(phrase)) {
                    score += phrase.length;
                }
            });
            rankingTable[score].push(combination);
        });

        return rankingTable;
    }

    function getPhrasesCombinations(words, phraseMaxWords) {
        var minOfCuts = Math.ceil(words.length / phraseMaxWords) - 1;
        var maxOfCuts = words.length - 1;
        var combinations = [];
        for (var numOfCuts = minOfCuts; numOfCuts <= maxOfCuts; numOfCuts++) {
            getPhrasesCombinationsWithCertainNumOfCuts(words, numOfCuts, phraseMaxWords).forEach(function (combination) {
                combinations.push(combination);
            });
        }
        return combinations;
    }

    function getPhrasesCombinationsWithCertainNumOfCuts(words, numOfCuts, phraseMaxWords) {
        if (numOfCuts < 0 || numOfCuts > words.length - 1) {
            throw new Error('Invalid numOfCuts: ' + numOfCuts);
        }
        if (numOfCuts === 0) {
            return [[words]];
        }
        var cutsList = getCombinations(words.length - 1, numOfCuts);
        var combinations = [];
        cutsList.forEach(function (cuts) {
            var combination = [];
            let phraseWords = [];
            let cutIndex = 0;
            for (let c = 1; c <= words.length; c++) {
                phraseWords.push(words[c - 1]);
                let cut = cuts[cutIndex];
                if (cut === c) {
                    combination.push(phraseWords);
                    phraseWords = [];
                    cutIndex++;
                } else if (c === words.length) {
                    combination.push(phraseWords);
                    combinations.push(combination);
                }
                if (phraseWords.length > phraseMaxWords) {
                    return;
                }
            }
        });
        return combinations;
    }

    function getCombinations(n, k) {
        if (k < 1 || k > n) {
            throw new Error('k is invalid. Condition: 1 <= k <= n');
        }
        var combinations = [];
        var a = [];
        a[0] = 0;
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

    return {
        analyzePhrasePhoneticsOfWords: analyzePhrasePhoneticsOfWords,
        phrasingParse: phrasingParse,
        parseChineseText: parseChineseText
    };
})();

// web worker
self.addEventListener('message', function (ev) {
    try {
        var args = JSON.parse(ev.data);
    } catch (err) {
        return;
    }
    switch (args['workerTask']) {
        case 'analyzePhrasePhoneticsOfWords':
            ChineseTextAnalyzer.analyzePhrasePhoneticsOfWords(
                args['executedWordsInfo'],
                args['phrasesData'],
                args['wordsJoiner'],
                function (result) {
                    postMessage(result);
                }
            );
            break;
    }
}, false);

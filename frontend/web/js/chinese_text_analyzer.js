ChineseTextAnalyzer = (function () {
    function phrasingParse(words, phraseMaxWords, phrasesData, wordsJoiner) {
        var rankingTable = getPhrasesRankingTable(words, phraseMaxWords, phrasesData, wordsJoiner);
        var bestCombinations = [];
        for (let i = rankingTable.length - 1; i > 0; i--) {
            if (rankingTable[i].length > 0) {
                let minOfPhrases = rankingTable[i][0].length;
                bestCombinations.push(rankingTable[i][0]);
                for (let j = 1; j < rankingTable[i].length - 1; j++) {
                    if (rankingTable[i][j].length === minOfPhrases) {
                        bestCombinations.push(rankingTable[i][j]);
                    } else {
                        break;
                    }
                }
                break;
            }
        }

        const viewGroups = [];
        bestCombinations.forEach(function (combination) {
            const rowPhrases = [];
            const rowPhonetics = [];
            const rowViPhonetics = [];
            combination.forEach(function (phraseWords) {
                const phrase = phraseWords.join(wordsJoiner);
                rowPhrases.push(phrase);
                const item = phrasesData[phrase];
                if (item) {
                    rowPhonetics.push(item[0]);
                    rowViPhonetics.push(item[1]);
                } else {
                    rowPhonetics.push(null);
                    rowViPhonetics.push(null);
                }
            });
            const viewGroup = [rowPhrases, rowPhonetics, rowViPhonetics];
            viewGroups.push(viewGroup);
        });

        return viewGroups;
    }

    function getPhrasesRankingTable(words, phraseMaxWords, phrasesData, wordsJoiner) {
        var rankingTable = [];
        for (let score = 0; score <= words.length; score++) {
            rankingTable[score] = [];
        }
        getPhrasesCombinations(words, phraseMaxWords).forEach(function (combination) {
            let score = 0;
            combination.forEach(function (phraseWords) {
                const phrase = phraseWords.join(wordsJoiner);
                if (phrasesData.hasOwnProperty(phrase)) {
                    score += phrase.length;
                }
            });
            rankingTable[score].push(combination);
        });

        return rankingTable;
    }

    function getPhrasesCombinations(words, phraseMaxWords) {
        const minOfCuts = Math.ceil(words.length / phraseMaxWords) - 1;
        const maxOfCuts = words.length - 1;
        const combinations = [];
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
        const cutsList = getCombinations(words.length - 1, numOfCuts);
        const combinations = [];
        cutsList.forEach(function (cuts) {
            const combination = [];
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
        var cjkeRegex = /[0-9]|[a-z]|[\u4E00-\u9FCC\u3400-\u4DB5\uFA0E\uFA0F\uFA11\uFA13\uFA14\uFA1F\uFA21\uFA23\uFA24\uFA27-\uFA29]|[\ud840-\ud868][\udc00-\udfff]|\ud869[\udc00-\uded6\udf00-\udfff]|[\ud86a-\ud86c][\udc00-\udfff]|\ud86d[\udc00-\udf34\udf40-\udfff]|\ud86e[\udc00-\udc1d]/i;
        var chars = Array.from(text);
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
        phrasingParse: phrasingParse,
        parseChineseText: parseChineseText
    };
})();

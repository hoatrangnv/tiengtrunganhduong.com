<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 2/15/2020
 * Time: 9:49 AM
 */
use yii\helpers\Url;

/**
 * @var $search string
 */
?>
<style>
    .title {
        margin-bottom: 2rem;
        font-size: 1.8em;
    }
    .search-form {
        width: 100%;
    }
    .search-input {
        width: calc(100% - 110px);
        height: 3rem;
        font-size: 1.6em;
        border: 1px solid #ddd;
        border-radius: 3px;
        box-shadow: none;
        display: block;
        float: left;
        padding: 0 0.5rem;
    }
    .search-input:-moz-placeholder {
        color: #888;
    }
    .search-input:-ms-input-placeholder {
        color: #888;
    }
    .search-input::-webkit-input-placeholder {
        color: #888;
    }
    .search-button {
        background-color: #3E82F0;
        color: #fff;
        font-weight: bold;
        border: 1px solid #2F5BB7;
        border-radius: 3px;
        box-shadow: none;
        height: 3rem;
        width: 100px;
        display: block;
        float: right;
        cursor: pointer;
    }
    .result-box {
        margin-top: 1rem;
    }
    .result-box > :not(:first-child) {
        margin-top: 1rem;
    }
    .result-box .error {
        color: #FA0;
        font-size: 0.85em;
    }
    .result-box table {
        border-collapse: collapse;
        border: 1px solid #ccc;
    }
    .result-box table tr td {
        padding: 3px;
    }
    .result-box table tr td:not(:last-child) {
        border-right: 1px solid #ccc;
    }
    .result-box table tr:not(:last-child) td {
        border-bottom: 1px solid #ccc;
    }
    .desc {
        margin-bottom: 2rem;
    }
    #translation-root {
        margin-bottom: 2rem;
    }
    #translation-root ul {
        padding-left: 1.5em;
    }
</style>

<h1 class="title"><?= $this->context->seoInfo->name ? $this->context->seoInfo->name : 'Tra cứu phiên âm' ?></h1>

<div class="desc">
    <?= $this->context->seoInfo->long_description ?>
</div>

<div id="translation-root"></div>

<script>
    var search_text = <?= json_encode($search) ?>;
    var translationRoot = document.getElementById("translation-root");
    var result = elm("div", null, {"class": "result-box"});
    var input = elm(
        "input",
        null,
        {
            type: "text",
            placeholder: "Nhập văn bản",
            value: search_text.split("+").join(" "), "class": "search-input",
            spellcheck: "false"
        }
    );
    var form = elm(
        "form",
        [
            input,
            elm(
                "button",
                "Dịch",
                {
                    type: "submit",
                    "class": "search-button"
                }
            )
        ],
        {
            "class": "search-form clr",
            onsubmit: function (event) {
                event.preventDefault();
                renderResult(input.value);
            }
        }
    );
    appendChildren(translationRoot, [form, result]);

    renderResult(search_text);

    function renderResult(search) {
        if ("string" == typeof search && search.trim()) {
            empty(result);
            result.appendChild(
                elm("div", "Đang dịch...")
            );
            requestTranslation(
                search,
                /**
                 *
                 * @param data
                 * @param {string[]} data.words
                 * @param {string[][]} data.translated_words
                 * @param {string[][]} data.spellings
                 * @param {string[][]} data.meanings
                 */
                function (data) {
                    empty(result);

                    var null_replacement = '_';
                    var wordsJoiner = '';

                    var executedWordsInfo = data['executedWordsInfo'];
                    var phrasesData = data['phrasesData'];

                    executedWordsInfo.forEach(function (infoItem) {
                        var error = infoItem['error'];
                        var words = infoItem['words'];
                        var phraseMaxWords = infoItem['phraseMaxWords'];
                        if (error) {
                            appendChildren(result, elm('table', [
                                elm('tr', elm('td', words.join(wordsJoiner))),
                                elm('tr', elm('td', elm('div', error, {'class': 'error'}))),
                            ]));
                        } else {
                            var viewGroups = calcClauseResultAsViewGroup(words, phraseMaxWords, phrasesData, wordsJoiner);
                            appendChildren(result, viewGroups.map(function (rows) {
                                return elm('table', rows.map(function (cells) {
                                    return elm('tr', cells.map(function (cell) {
                                        return elm('td', cell !== null ? cell : null_replacement);
                                    }));
                                }));
                            }));
                        }
                    });

                },
                function (error_msg) {
                    empty(result);
                    appendChildren(result, [
                        elm("h3", error_msg)
                    ]);
                }
            );
        }
    }

    function requestTranslation(search, onSuccess, onError) {
        var webUrl = "<?= Url::to(['lookup-phonetic-for-chinese-text/index', 'search' => '__SEARCH__']) ?>";
        var apiUrl = "<?= Url::to(['chinese-phrase-phonetic-api/lookup', 'wordsList' => '__WORDS__']) ?>";
        search = search.split(' ').join(''); // chinese does not use white space
        window.history.pushState(history.state, document.title,
            webUrl.split("__SEARCH__").join(search));
        var xhr = new XMLHttpRequest();
        xhr.addEventListener("load", function () {
            var responseText = xhr.responseText;
            var res = JSON.parse(responseText);
            if (res.error_message) {
                onError(res.error_message);
            } else {
                onSuccess(res.data);
            }
        });
        xhr.addEventListener("error", function () {
            onError("An error occurred.")
        });
        var parseResult = parseText(search);
        var wordsList = parseResult[1].map(function (letterPartIndex) {
            return parseResult[0][letterPartIndex];
        });
        xhr.open("GET", apiUrl.split("__WORDS__").join(JSON.stringify(wordsList)));
        xhr.send();
    }

    function calcClauseResultAsViewGroup(words, phraseMaxWords, phrasesData, wordsJoiner) {
        var rankingTable = getPhrasesRankingTable(words, phraseMaxWords, phrasesData, wordsJoiner);
        var bestCombinations = [];
        for (let i = rankingTable.length - 1; i >= 0; i--) {
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

    function parseText(text) {
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

    // =================
    // Helper functions

    //func element
    function elm(nodeName, content, attributes) {
        var node = document.createElement(nodeName);
        appendChildren(node, content);
        setAttributes(node, attributes);
        return node;
    }

    function appendChildren(node, content) {
        var append = function (t) {
            if (/string|number/.test(typeof t)) {
                var textNode = document.createTextNode(t);
                node.appendChild(textNode);
            } else if (t instanceof Node) {
                node.appendChild(t);
            }
        };
        if (content instanceof Array) {
            content.forEach(function (item) {
                append(item);
            });
        } else {
            append(content);
        }
    }

    function setAttributes(node, attributes) {
        if (attributes) {
            var attrName;
            for (attrName in attributes) {
                if (attributes.hasOwnProperty(attrName)) {
                    var attrValue = attributes[attrName];
                    switch (typeof attrValue) {
                        case "string":
                        case "number":
                            node.setAttribute(attrName, attrValue);
                            break;
                        case "function":
                        case "boolean":
                            node[attrName] = attrValue;
                            break;
                        default:
                    }
                }
            }
        }
    }

    function empty(element) {
        while (element.firstChild) {
            element.removeChild(element.firstChild);
        }
    }

    function style(obj) {
        var result_array = [];
        var attrName;
        for (attrName in obj) {
            if (Object.prototype.hasOwnProperty.call(obj, attrName)) {
                result_array.push(attrName + ": " + obj[attrName]);
            }
        }
        return result_array.join("; ");
    }
    
</script>

<?= $this->render('//layouts/likeShare') ?>
<?= $this->render('//layouts/fbComment', ['url' => $this->context->canonicalLink]) ?>

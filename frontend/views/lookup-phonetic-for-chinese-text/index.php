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

$chinese_text_analyzer_src = Yii::getAlias('@web/js/chinese_text_analyzer.js');
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
        display: block;
        width: 100%;
        font-family: inherit;
        height: 8rem;
        font-size: 1.6em;
        border: 1px solid #ddd;
        border-radius: 3px;
        box-shadow: none;
        padding: 0.5rem;
        resize: vertical;
        white-space: pre-line;
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
    .search-button-wrapper {
        margin-top: 0.5rem;
    }
    .search-button {
        color: #fff;
        font-weight: bold;
        border: 1px solid #2F5BB7;
        background: #3E82F0;
        border-radius: 3px;
        box-shadow: none;
        height: 40px;
        width: 100px;
        display: block;
        float: right;
        cursor: pointer;
    }
    .search-button:hover {
        background: #3B7DE0;
    }
    .result-box {
        margin-top: 1rem;
    }
    .result-box > :not(:first-child) {
        margin-top: 1rem;
    }
    .result-box .error {
        font-size: 0.9em;
        font-style: italic;
    }
    .result-box table {
        border-collapse: collapse;
        border: 1px solid #ddd;
    }
    .result-box table tr td {
        padding: 3px;
    }
    .result-box table tr td:not(:last-child) {
        border-right: 1px solid #ddd;
    }
    .result-box table tr:not(:last-child) td {
        border-bottom: 1px solid #ddd;
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
<script src="<?= $chinese_text_analyzer_src ?>"></script>
<script>
    var chinese_phonetic_worker_src = <?= json_encode(Yii::getAlias('@web/js/chinese_phonetic_worker.js')) ?>;
    var search_text = <?= json_encode($search) ?>;
    var translationRoot = document.getElementById("translation-root");
    var result = elm("div", null, {"class": "result-box"});
    var input = elm(
        "textarea",
        search_text,
        {
            placeholder: "Nhập văn bản",
            spellcheck: "false",
            "class": "search-input",
        }
    );
    var form = elm(
        "form",
        [
            input,
            elm('div',
                elm(
                    "button",
                    "Tra cứu",
                    {
                        type: "submit",
                        "class": "search-button"
                    }
                ),
                {
                    "class": "search-button-wrapper clr"
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
                elm("div", "Đang xử lý...", {'class': 'processing'})
            );
            requestTranslation(
                search,
                handleOnRequestSuccess,
                handleOnRequestError
            );
        }
    }

    function handleOnRequestSuccess(data) {
        var null_replacement = '_';
        var wordsJoiner = '';

        var executedWordsInfo = data['executedWordsInfo'];
        var phrasesData = data['phrasesData'];

        var viewItems = [];
        var heavyTasks = [];
        var currentHeavyTaskIndex = -1;
        executedWordsInfo.forEach(function (infoItem, index) {
            viewItems[index] = null;
            var error = infoItem['error'];
            var words = infoItem['words'];
            var phraseMaxWords = infoItem['phraseMaxWords'];
            if (error) {
                viewItems[index] = [
                    elm('h3', words.join(wordsJoiner)),
                    elm('div', error, {'class': 'error'})
                ];
            } else {
                viewItems[index] = null;

                var taskMain = function (viewGroups) {
                    viewItems[index] = [elm('h3', words.join(wordsJoiner))];
                    if (viewGroups.length > 0) {
                        viewItems[index] = viewItems[index].concat((viewGroups.map(function (rows) {
                            return elm('table', rows.map(function (cells) {
                                return elm('tr', cells.map(function (cell) {
                                    return elm('td', cell !== null ? cell : null_replacement);
                                }));
                            }));
                        })));
                    } else {
                        viewItems[index] = viewItems[index].concat((elm('div', 'Không có dữ liệu', {'class': 'error'})));
                    }
                    if (currentHeavyTaskIndex < heavyTasks.length - 1) {
                        currentHeavyTaskIndex++;
                        heavyTasks[currentHeavyTaskIndex]();
                    }
                    if (viewItems.every(function (viewItem) {
                            return viewItem !== null;
                        })) {
                        empty(result);
                        viewItems.forEach(function (viewItem) {
                            appendChildren(result, viewItem);
                        });
                    }
                };

                heavyTasks.push(function () {
                    if (typeof(Worker) !== "undefined") {
                        var worker = new Worker(chinese_phonetic_worker_src);
                        worker.postMessage(JSON.stringify({
                            words: words,
                            phraseMaxWords: phraseMaxWords,
                            phrasesData: phrasesData,
                            wordsJoiner: wordsJoiner
                        }));
                        worker.addEventListener('message', function (ev) {
                            var viewGroups = ev.data;
                            taskMain(viewGroups);
                        });
                    } else {
                        console.log('Worker is not supported!');
                        setTimeout(function () {
                            var viewGroups = ChineseTextAnalyzer.phrasingParse(
                                words,
                                phraseMaxWords,
                                phrasesData,
                                wordsJoiner
                            );
                            taskMain(viewGroups);
                        }, 0);
                    }
                });
            }

            if (heavyTasks.length > 0) {
                currentHeavyTaskIndex = 0;
                heavyTasks[currentHeavyTaskIndex]();
            } else {
                empty(result);
                viewItems.forEach(function (viewItem) {
                    appendChildren(result, viewItem);
                });
            }
        });
    }

    function handleOnRequestError(error) {
        empty(result);
        appendChildren(result, [
            elm("h3", error)
        ]);
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
        var parseResult = ChineseTextAnalyzer.parseChineseText(search);
        var wordsList = parseResult[1].map(function (letterPartIndex) {
            return parseResult[0][letterPartIndex];
        });
        xhr.open("GET", apiUrl.split("__WORDS__").join(JSON.stringify(wordsList)));
        xhr.send();
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

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
<div id="phonetic-lookup">
    <h1 class="title"><?= $this->context->seoInfo->name ? $this->context->seoInfo->name : 'Tra cứu phiên âm' ?></h1>
    <div class="desc"><?= $this->context->seoInfo->long_description ?></div>
    <div class="app-root"></div>
</div>
<script src="<?= $chinese_text_analyzer_src ?>"></script>
<script>
    var chinese_phonetic_worker_src = <?= json_encode(Yii::getAlias('@web/js/chinese_phonetic_worker.js')) ?>;
    var search_text = <?= json_encode($search) ?>;
    var translationRoot = document.querySelector("#phonetic-lookup .app-root");
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
                elm("button", "Tra cứu", {type: "submit", "class": "search-button"}),
                {"class": "search-button-wrapper clr"}
            )
        ],
        {
            "class": "search-form clr",
            onsubmit: function (event) {
                event.preventDefault();
                requestAndUpdateResult(input.value);
            }
        }
    );
    appendChildren(translationRoot, [form, result]);
    requestAndUpdateResult(search_text);

    function requestAndUpdateResult(search) {
        if ("string" == typeof search && search.trim()) {
            empty(result);
            result.appendChild(
                elm("div", "Đang xử lý...", {'class': 'processing'})
            );
            requestPhoneticApi(
                search,
                handleOnRequestSuccess,
                handleOnRequestError
            );
        }
    }

    function handleOnRequestSuccess(data, inputParseResult) {
        var null_replacement = '_';
        var wordsJoiner = '';

        var executedWordsInfo = data['executedWordsInfo'];
        var phrasesData = data['phrasesData'];
        var inputMixedParts = inputParseResult[0];
        var inputLetterPartIndexes = inputParseResult[1];

        var paragraphViewArrItems = [];
        var detailsViewElmItems = [];

        var renderDetailsView = function () {
            appendChildren(result, [
                elm('h2', 'Chi tiết'),
                elm('div', detailsViewElmItems.map(function (elmArr) {
                    return elm('div', elmArr, {'class': 'details-item'});
                }, []), {'class': 'details-view'})
            ]);
        };
        
        var renderParagraphView = function () {
            appendChildren(result, [elm('h2', 'Kết quả')]);
            var paragrapViewArrItemIndex = -1;
            appendChildren(result, elm('div', inputMixedParts.map(function (partChars, index) {
                if (inputLetterPartIndexes.indexOf(index) > -1) {
                    paragrapViewArrItemIndex++;
                    return paragraphViewArrItems[paragrapViewArrItemIndex];
                } else {
                    return partChars.map(function (char) {
                        return [char, char, char];
                    });
                }
            }).reduce(function (arr, item, index) {
                return arr.concat(item);
            }, []).map(function (item) {
                return elm('div', item.map(function (val) {
                    return elm('div', val);
                }));
            }), {'class': 'paragraph-view'}));
        };

        var renderViews = function () {
            empty(result);
            renderParagraphView();
            renderDetailsView();
        };

        var heavyTasks = [];
        var currentHeavyTaskIndex = -1;
        executedWordsInfo.forEach(function (infoItem, index) {
            detailsViewElmItems[index] = null;
            var error = infoItem['error'];
            var words = infoItem['words'];
            var phraseMaxWords = infoItem['phraseMaxWords'];
            if (error) {
                detailsViewElmItems[index] = [
                    elm('h3', words.join(wordsJoiner)),
                    elm('div', error, {'class': 'error'})
                ];
                paragraphViewArrItems[index] = words.map(function (word) {
                    return [word, null_replacement, null_replacement];
                });
            } else {
                detailsViewElmItems[index] = null;
                var taskMain = function (viewGroups) {
                    detailsViewElmItems[index] = [elm('h3', words.join(wordsJoiner))];
                    paragraphViewArrItems[index] = [];
                    if (viewGroups.length > 0) {
                        detailsViewElmItems[index].push.apply(detailsViewElmItems[index], viewGroups.map(function (rows) {
                            return elm('table', rows.map(function (cells) {
                                return elm('tr', cells.map(function (cell) {
                                    return elm('td', cell !== null ? cell : null_replacement);
                                }));
                            }));
                        }));
                        var phrases = viewGroups[0][0];
                        var phonetics = viewGroups[0][1];
                        var viPhonetics = viewGroups[0][2];
                        for (var i = 0; i < phrases.length; i++) {
                            var null_rep = null_replacement;
//                            if (/([0-9]|[a-z])*/i.test(phrases[i])) {
//                                null_rep = phrases[i];
//                            }
                            paragraphViewArrItems[index].push([
                                phrases[i],
                                phonetics[i] !== null ? phonetics[i] : null_rep,
                                viPhonetics[i] !== null ? viPhonetics[i] : null_rep
                            ]);
                        }
                    } else {
                        detailsViewElmItems[index].push(elm('div', 'Không có dữ liệu', {'class': 'error'}));
                        words.forEach(function (word) {
                            var null_rep = null_replacement;
//                            if (/([0-9]|[a-z])*/i.test(word)) {
//                                null_rep = phrases[i];
//                            }
                            paragraphViewArrItems[index].push([word, null_rep, null_rep]);
                        });
                    }
                    if (currentHeavyTaskIndex < heavyTasks.length - 1) {
                        currentHeavyTaskIndex++;
                        heavyTasks[currentHeavyTaskIndex]();
                    }
                    if (detailsViewElmItems.every(function (item) { return item !== null; })) {
                        renderViews();
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
                        }, 10);
                    }
                });
            }
        });

        if (heavyTasks.length > 0) {
            currentHeavyTaskIndex = 0;
            heavyTasks[currentHeavyTaskIndex]();
        } else {
            renderViews();
        }
    }

    function handleOnRequestError(error) {
        empty(result);
        appendChildren(result, [
            elm("h3", error)
        ]);
    }

    function requestPhoneticApi(search, onSuccess, onError) {
        var webUrl = "<?= Url::to(['lookup-phonetic-for-chinese-text/index', 'search' => '__SEARCH__']) ?>";
        var apiUrl = "<?= Url::to(['chinese-phrase-phonetic-api/lookup', 'wordsList' => '__WORDS__']) ?>";
        search = search.split(' ').join(''); // chinese does not use white space
        window.history.pushState(history.state, document.title,
            webUrl.split("__SEARCH__").join(search));
        var inputParseResult = ChineseTextAnalyzer.parseChineseText(search);
        var inputMixedParts = inputParseResult[0];
        var inputLetterPartIndexes = inputParseResult[1];
        var wordsList = inputLetterPartIndexes.map(function (letterPartIndex) {
            return inputMixedParts[letterPartIndex];
        });
        var xhr = new XMLHttpRequest();
        xhr.addEventListener("load", function () {
            var responseText = xhr.responseText;
            var res = JSON.parse(responseText);
            if (res.error_message) {
                onError(res.error_message);
            } else {
                onSuccess(res.data, inputParseResult);
            }
        });
        xhr.addEventListener("error", function () {
            onError("An error occurred.")
        });
        xhr.open("GET", apiUrl.split("__WORDS__").join(JSON.stringify(wordsList)));
        xhr.send();
    }
</script>
<?= $this->render('//layouts/likeShare') ?>
<?= $this->render('//layouts/fbComment', ['url' => $this->context->canonicalLink]) ?>

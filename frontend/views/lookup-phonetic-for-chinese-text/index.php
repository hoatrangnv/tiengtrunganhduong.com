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

$chinese_text_analyzer_src = Yii::getAlias('@web/js/chinese_text_analyzer.js?v=12');
?>
<div id="phonetic-lookup">
    <h1 class="title"><?= $this->context->seoInfo->name ? $this->context->seoInfo->name : 'Tra cứu phiên âm' ?></h1>
    <div class="desc"><?= $this->context->seoInfo->long_description ?></div>
    <div class="app-root"></div>
</div>
<script src="<?= $chinese_text_analyzer_src ?>"></script>
<script>
    var chinese_text_analyzer_src = <?= json_encode($chinese_text_analyzer_src) ?>;
    var workerIsSupported = window.Worker !== undefined;
    window.isUseWorker = true;
    window.maxConcurrentTasks = window.navigator.hardwareConcurrency * 2;
    if (workerIsSupported) {
        console.log('Worker is supported');
        var workersPool = [];
        var workersTrack = [];
        for (var i = 0; i < window.maxConcurrentTasks; i++) {
            workersPool.push(new window.Worker(chinese_text_analyzer_src));
            workersTrack.push(true);
        }
        function getFreeWorker() {
            for (var i = 0; i < workersTrack.length; i++) {
                if (workersTrack[i]) {
                    workersTrack[i] = false;
                    return [workersPool[i], i];
                }
            }
            workersPool.push(new window.Worker(chinese_text_analyzer_src));
            workersTrack.push(false);
            var index = workersTrack.length - 1;
            return [workersPool[index], index];
        }
        function setWorkerIsFree(i) {
            workersTrack[i] = true;
        }
    } else {
        console.log('Worker is not supported!');
    }

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
    var submitButton = elm("button", "Tra cứu", {type: "submit", "class": "search-button"});
    var form = elm(
        "form",
        [
            input,
            elm('div',
                submitButton,
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

    var isSubmittingForm = false;
    function requestAndUpdateResult(search) {
        if (isSubmittingForm) {
            return;
        }
        if (!search || !search.trim()) {
            return;
        }
        isSubmittingForm = true;
        submitButton.disabled = true;
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

    function handleOnRequestSuccess(data, inputParseResult) {
        var null_replacement = '_';
        var wordsJoiner = '';

        var executedClausesInfo = data['executedClausesInfo'];
        var phrasesData = data['phrasesData'];
        var inputMixedParts = inputParseResult[0];
        var inputLetterPartIndexes = inputParseResult[1];

        var paragraphViewArrItems = [];
        var detailsViewElmItems = [];
        var somePartsHasBeenOmitted = false;

        var renderDetailsView = function () {
            appendChildren(result, [
                elm('h2', 'Chi tiết', {'class': 'details-heading'}),
                elm('div', detailsViewElmItems.map(function (elmArr) {
                    return elm('div', elmArr, {'class': 'details-item'});
                }, []), {'class': 'details-view'})
            ]);
        };

        var renderParagraphView = function () {
            appendChildren(result, [elm('h2', 'Kết quả', {'class': 'paragraph-heading'})]);
            var flatArrItems = [];
            var paragraphViewArrItemIndex = -1;
            for (var i = 0; i < inputMixedParts.length; i++) {
                if (inputLetterPartIndexes.indexOf(i) > -1) {
                    paragraphViewArrItemIndex++;
                    // api may ignore some last group of words if they are exceeded limit
                    if (paragraphViewArrItemIndex > paragraphViewArrItems.length - 1 ||
                        paragraphViewArrItems[paragraphViewArrItemIndex] === null
                    ) {
                        somePartsHasBeenOmitted = true;
                        break;
                    }
                    paragraphViewArrItems[paragraphViewArrItemIndex].forEach(function (arrItem) {
                        flatArrItems.push(arrItem);
                    });
                } else {
                    inputMixedParts[i].forEach(function (char) {
                        flatArrItems.push([char, char, char]);
                    });
                }
            }
            appendChildren(result, elm('div', flatArrItems.map(function (item) {
                if (item[0] === '\n') {
                    return elm('br');
                } else {
                    return elm('span', item.map(function (val) {
                        return elm('span', val);
                    }));
                }
            }), {'class': 'paragraph-view'}));
        };

        var renderViews = function () {
            empty(result);
            renderParagraphView();
            if (somePartsHasBeenOmitted) {
                appendChildren(
                    result,
                    elm('div', 'Một số phần đã bị lược bỏ. Vui lòng xem mục "Chi tiết".', {'class': 'error'})
                );
            }
            renderDetailsView();
            isSubmittingForm = false;
            submitButton.disabled = false;
        };

        var fillViewItemsWithResultOfPhrasePhonetics = function (result) {
            result.forEach(function (resultItem, index) {
                var error = resultItem['error'];
                var words = resultItem['words'];
                var phrasePhonetics = resultItem['phrasePhonetics'];
                if (error) {
                    if (words === null) {
                        detailsViewElmItems[index] = [
                            elm('div', error, {'class': 'error'})
                        ];
                        paragraphViewArrItems[index] = null;
                    } else {
                        detailsViewElmItems[index] = [
                            elm('h3', words.join(wordsJoiner)),
                            elm('div', error, {'class': 'error'})
                        ];
                        paragraphViewArrItems[index] = words.map(function (word) {
                            return [word, null_replacement, null_replacement];
                        });
                    }
                } else {
                    detailsViewElmItems[index] = [elm('h3', words.join(wordsJoiner))];
                    paragraphViewArrItems[index] = [];
                    if (phrasePhonetics.length > 0) {
                        detailsViewElmItems[index].push.apply(detailsViewElmItems[index], phrasePhonetics.map(function (rows) {
                            return elm('table', rows.map(function (cells) {
                                return elm('tr', cells.map(function (cell) {
                                    return elm('td', cell !== null ? cell : null_replacement);
                                }));
                            }));
                        }));
                        var phrases = phrasePhonetics[0][0];
                        var phonetics = phrasePhonetics[0][1];
                        var viPhonetics = phrasePhonetics[0][2];
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
                }
            });
        };

        var workerOn = window.isUseWorker && workerIsSupported;
        console.time(workerOn ? 'Worker ON' : 'Worker OFF');
        ChineseTextAnalyzer.analyzePhrasePhoneticsOfWords(
            executedClausesInfo,
            wordsJoiner,
            function (result) {
                fillViewItemsWithResultOfPhrasePhonetics(result);
                renderViews();
                console.timeEnd(workerOn ? 'Worker ON' : 'Worker OFF');
            },
            window.maxConcurrentTasks,
            workerOn ? getFreeWorker : undefined,
            workerOn ? setWorkerIsFree : undefined
        );
    }

    function handleOnRequestError(error) {
        empty(result);
        appendChildren(result, [
            elm("h3", error)
        ]);
    }

    function requestPhoneticApi(search, onSuccess, onError) {
        var webUrl = "<?= Url::to(['lookup-phonetic-for-chinese-text/index', 'search' => '__SEARCH__']) ?>";
        var apiUrl = "<?= Url::to(['chinese-phrase-phonetic-api/lookup']) ?>";

        search = search.split(' ').join(''); // chinese does not use white space
        var stateUrl = webUrl.split("__SEARCH__").join(search.split('\n').join('%0D%0A')); // %0D%0A represents for line break
        window.history.pushState(history.state, document.title, stateUrl);

        var inputParseResult = ChineseTextAnalyzer.parseChineseText(search);
        var inputMixedParts = inputParseResult[0];
        var inputLetterPartIndexes = inputParseResult[1];
        var clauses = inputLetterPartIndexes.map(function (letterPartIndex) {
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
            onError("An error occurred.");
        });
        xhr.open("POST", apiUrl);
        xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        xhr.send('clauses=' + JSON.stringify(clauses));
    }
</script>
<?= $this->render('//layouts/likeShare') ?>
<?= $this->render('//layouts/fbComment', ['url' => $this->context->canonicalLink]) ?>

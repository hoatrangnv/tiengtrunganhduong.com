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

$chinese_text_analyzer_src = Yii::getAlias('@web/js/chinese_text_analyzer.js?v=16');
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

    var search_text = '';
    try {
        location.href.replace(/[?&]+([^=&]+)=([^&]*)/gi, function(m, key, value) {
            if (key === 'text') {
                search_text = decodeURIComponent(value);
            }
        });
    } catch (e) {
        console.error(e);
        ga('send', 'event', {
            eventCategory: 'phonetic.decodeURIError',
            eventAction: 'play',
            eventLabel: JSON.stringify(e),
            eventValue: 1
        });
    }
    var wordsJoiner = '';
    var phoneticsJoiner = ' ';
    var viPhoneticsJoiner = ' ';
    var translationRoot = document.querySelector("#phonetic-lookup .app-root");
    var result = elm("div", null, {"class": "result-box"});
    var input = elm(
        "textarea", search_text,
        {placeholder: "Nhập văn bản", spellcheck: "false", "class": "search-input"}
    );
    var submitButton = elm("button", "Tra cứu", {type: "submit", "class": "search-button"});
    var form = elm(
        "form",
        [
            input,
            elm('div', submitButton, {"class": "search-button-wrapper clr"})
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
    var trackingTimer = null;
    function requestAndUpdateResult(search_text) {
        if (isSubmittingForm) {
            return;
        }
        if (!search_text || !search_text.trim()) {
            return;
        }
        isSubmittingForm = true;
        submitButton.disabled = true;
        empty(result);
        result.appendChild(
            elm("div", "Đang xử lý...", {'class': 'processing'})
        );
        requestPhoneticApi(
            search_text,
            handleOnRequestSuccess,
            handleOnRequestError
        );
        trackingTimer = setTimeout(function () {
            ga('send', 'event', {
                eventCategory: 'phonetic.completionTimeTooLong',
                eventAction: 'play',
                eventLabel: search_text,
                eventValue: 2
            });
        }, 2000);
    }

    function handleOnRequestSuccess(data, inputParseResult) {
        var null_replacement = '_';

        var executedClausesInfo = data['executedClausesInfo'];
        var phrasesDetails = data['phrasesDetails'];
        var inputMixedParts = inputParseResult[0];
        var inputLetterPartIndexes = inputParseResult[1];

        var paragraphViewArrItems = [];
        var notedViewElmItems = [];
        var somePartsHasBeenOmitted = false;

        var getPhraseDetailsHtml = function (details) {
            if (!details) {
                return '<i>Không có dữ liệu</i>';
            }

            return details.replace(/\\n/g, '<br>').replace(/\\t/g, '&nbsp;&nbsp;');
        };

        var renderNotedView = function () {
            if (notedViewElmItems.length > 0) {
                appendChildren(result, [
                    elm('h2', 'Ghi chú', {'class': 'details-heading'}),
                    elm('div', notedViewElmItems.map(function (elmArr) {
                        return elm('div', elmArr, {'class': 'details-item'});
                    }, []), {'class': 'noted-view'})
                ]);
            }
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
            appendChildren(result, resultParagraphElement = elm('div', flatArrItems.map(function (item) {
                if (item[0] === '\n') {
                    return elm('br');
                } else {
                    var itemEl = elm('span', item.map(function (val) {
                        return elm('span', val);
                    }), {
                        onclick: function (ev) {
                            itemEl.classList.add('is-showing-tooltip');
                            showTooltip(
                                getPhraseDetailsHtml(phrasesDetails[item[0].toUpperCase()] || phrasesDetails[item[0].toLowerCase()]),
                                itemEl,
                                function () {
                                    itemEl.classList.remove('is-showing-tooltip');
                                }
                            );
                        }
                    });
                    return itemEl;
                }
            }), {'class': 'paragraph-view'}));
        };

        var renderViews = function () {
            empty(result);
            renderParagraphView();
            if (somePartsHasBeenOmitted) {
                appendChildren(
                    result,
                    elm('div', 'Một số phần đã bị lược bỏ. Vui lòng xem mục "Ghi chú".', {'class': 'error'})
                );
            }
            renderNotedView();
            isSubmittingForm = false;
            submitButton.disabled = false;
            clearTimeout(trackingTimer);
        };

        var fillViewItemsWithResultOfPhrasePhonetics = function (result) {
            result.forEach(function (resultItem, index) {
                var error = resultItem['error'];
                var words = resultItem['words'];
                var phrasePhonetics = resultItem['phrasePhonetics'];
                if (error) {
                    if (words === null) {
                        paragraphViewArrItems[index] = null;
                        notedViewElmItems[index] = [
                            elm('div', error, {'class': 'error'})
                        ];
                    } else {
                        paragraphViewArrItems[index] = words.map(function (word) {
                            return [word, null_replacement, null_replacement];
                        });
                        notedViewElmItems[index] = [
                            elm('h3', words.join(wordsJoiner)),
                            elm('div', error, {'class': 'error'})
                        ];
                    }
                } else {
                    paragraphViewArrItems[index] = [];
                    var phrases = phrasePhonetics[0][0];
                    var phonetics = phrasePhonetics[0][1];
                    var viPhonetics = phrasePhonetics[0][2];
                    for (var i = 0; i < phrases.length; i++) {
                        paragraphViewArrItems[index].push([
                            phrases[i],
                            phonetics[i] !== null ? phonetics[i] : null_replacement,
                            viPhonetics[i] !== null ? viPhonetics[i] : null_replacement
                        ]);
                    }
                    if (phrasePhonetics.length > 1) {
                        console.log('phrasePhonetics', phrasePhonetics);
                        ga('send', 'event', {
                            eventCategory: 'phonetic.tooManyPhraseCombinations',
                            eventAction: 'play',
                            eventLabel: words.join(wordsJoiner),
                            eventValue: phrasePhonetics.length
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
        isSubmittingForm = false;
        submitButton.disabled = false;
        clearTimeout(trackingTimer);
        ga('send', 'event', {
            eventCategory: 'phonetic.displayedAnError',
            eventAction: 'play',
            eventLabel: error,
            eventValue: 1
        });
    }

    function requestPhoneticApi(text, onSuccess, onError) {
        var webUrl = "<?= Url::to(['chinese-phonetic-lookup/index', 'text' => '__TEXT__']) ?>";
        var apiUrl = "<?= Url::to(['chinese-phrase-phonetic-api/lookup']) ?>";

        text = text.split(' ').join(''); // chinese does not use white space
        var stateUrl = webUrl.split("__TEXT__").join(text.split('\n').join('%0D%0A')); // %0D%0A represents for line break
        window.history.pushState(history.state, document.title, stateUrl);

        var inputParseResult = ChineseTextAnalyzer.parseChineseText(text);
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
            onError("An error occurred: " + xhr.statusText + ", " + xhr.responseText);
            console.log(xhr);
        });
        xhr.open("POST", apiUrl);
        xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        xhr.send('clauses=' + JSON.stringify(clauses));
    }

    var resultParagraphElement = null;
    document.addEventListener('copy', function (ev) {
        if (resultParagraphElement === null) {
            return;
        }
        if (resultParagraphElement !== ev.target && !resultParagraphElement.contains(ev.target)) {
            return;
        }
        ev.preventDefault();
        var copiedText = document.getSelection().toString().trim();
        var items = copiedText.split('\n');
        var words = [], phonetics = [], viPhonetics = [];
        for (var i = 0; i < items.length; i += 3) {
            words.push(items[i]);
            phonetics.push(items[i + 1]);
            viPhonetics.push(items[i + 2]);
        }
        ev.clipboardData.setData('text', [
            words.join(wordsJoiner),
            phonetics.join(phoneticsJoiner),
            viPhonetics.join(viPhoneticsJoiner)
        ].join('\n\n'));
    });
</script>
<?= $this->render('//layouts/likeShare', ['url' => $this->context->canonicalLink]) ?>
<?= $this->render('//layouts/fbComment', ['url' => $this->context->canonicalLink]) ?>

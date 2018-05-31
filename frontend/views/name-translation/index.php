<?php
/**
 * Created by PhpStorm.
 * User: Quyet
 * Date: 11/23/2017
 * Time: 4:11 PM
 */
use yii\helpers\Url;

/**
 * @var string $search
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

<h2 class="title"><?= $this->context->seoInfo->name ? $this->context->seoInfo->name : 'Họ tên Tiếng Trung của bạn' ?></h2>

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
            placeholder: "Nhập họ tên của bạn tại đây",
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

                    var null_replacement = "__";
                    var translated_names = [];
                    var spellings = [];
                    var total_translated_names = 0;
                    data.translated_words.forEach(function (translated_word_list, list_index) {
                        if (translated_word_list.length === 0) {
                            data.translated_words[list_index] = [null_replacement];
                            data.spellings[list_index] = [null_replacement];
                        } else {
                            if (total_translated_names > 0) {
                                total_translated_names *= translated_word_list.length;
                            } else {
                                total_translated_names = translated_word_list.length;
                            }
                        }
                    });
                    data.translated_words.forEach(function (translated_word_list, list_index) {
                        if (translated_word_list.length > 0) {
                            var same_count = total_translated_names / translated_word_list.length;
                            var i, j;
                            for (i = 0; i < translated_word_list.length; i ++) {
                                for (j = 0; j < same_count; j++) {
                                    if (0 == list_index) {
                                        translated_names[i * same_count + j] = translated_word_list[i];
                                        spellings[i * same_count + j] = data.spellings[list_index][i];
                                    } else {
                                        translated_names[i * same_count + j] += " " + translated_word_list[i];
                                        spellings[i * same_count + j] += " " + data.spellings[list_index][i];
                                    }
                                }
                            }
                        }
                    });

                    appendChildren(
                        result,
                        [
                            elm("h3", data.words.join(" ")),
                            elm("ul", translated_names.map(function (name, index) {
                                return elm("li", [
                                    elm("b", name),
                                    elm("i", "(" + spellings[index] + ")", {
                                        style: style({
                                            "margin-left": "0.5em"
                                        })
                                    })
                                ]);
                            })),
                            elm("h3", "Ý nghĩa:", {
                                style: style({
                                    "margin-top": "1rem",
                                    "text-decoration": "underline",
                                    color: "#16B0F4"
                                })
                            })
                        ].concat(data.words.map(function (word, index) {
                            return elm(
                                "div",
                                [
                                    elm("h3", word),
                                    elm("ul", data.meanings[index].map(function (meaning, meaning_index) {
                                        return elm("li", [
                                            elm(
                                                "div",
                                                [
                                                    elm("b", data.translated_words[index][meaning_index]),
                                                    elm("i", "(" + data.spellings[index][meaning_index] + ")", {
                                                        style: style({
                                                            "margin-left": "0.5em"
                                                        })
                                                    })
                                                ]
                                            ),
                                            elm("div", meaning.split("\n").map(function (line) {
                                                return elm("p", line);
                                            }), {
                                                style: style({
                                                    color: "#666"
                                                })
                                            })
                                        ]);
                                    }))
                                ],
                                {
                                    style: style({
                                        "margin-top": "0.5rem"
                                    })
                                }
                            );
                        }))
                    );
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

    function requestTranslation(name, onSuccess, onError) {
        name = name.split(" ").join("+");
        window.history.pushState(history.state, document.title, "<?= Url::to(['name-translation/index', 'search' => '__SEARCH__']) ?>".split("__SEARCH__").join(name));
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
        xhr.open("GET", "<?= Url::to(['quiz/translate-name', 'name' => '__NAME__']) ?>".split("__NAME__").join(name));
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
<?= $this->render('//layouts/fbComment') ?>
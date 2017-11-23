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
<div id="translation-root"></div>

<script>
    var search_text = <?= json_encode($search) ?>;
    var translationRoot = document.getElementById("translation-root");
    var result = element("div");
    var input = element("input", null, {type: "text", value: search_text.split("+").join(" ")});
    var form = element(
        "form",
        [
            input,
            element(
                "button",
                "Dịch tên",
                {
                    type: "submit"
                }
            )
        ],
        null,
        {
            submit: [function (event) {
                event.preventDefault();

                renderResult(input.value);
            }]
        }
    );
    appendChildren(translationRoot, [form, result]);

    renderResult(search_text);

    function renderResult(search) {
        empty(result);
        result.appendChild(
            element("div", "Đang dịch...")
        );
        requestTranslation(search, function (data) {
            empty(result);
            appendChildren(result, [
                element("h3", data.name),
                element("h3", data.translated_name),
                element("div", data.spelling)
            ]);
        }, function (error_msg) {
            empty(result);
            appendChildren(result, [
                element("h3", error_msg)
            ]);
        });
    }

    function requestTranslation(name, onSuccess, onError) {
        if ("string" == typeof name && name.trim()) {
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
    }
    
    // =================
    // Helper functions

    function element(nodeName, content, attributes, eventListeners) {
        var node = document.createElement(nodeName);
        appendChildren(node, content);
        setAttributes(node, attributes);
        addEventListeners(node, eventListeners);
        return node;
    }

    function appendChildren(node, content) {
        var append = function (t) {
            if ("string" == typeof t) {
                node.innerHTML += t;
            } else if (t instanceof HTMLElement) {
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
                    node.setAttribute(attrName, attributes[attrName]);
                }
            }
        }
    }

    function addEventListeners(node, listeners) {
        if (listeners) {
            var eventName;
            for (eventName in listeners) {
                if (listeners.hasOwnProperty(eventName)) {
                    if (listeners[eventName] instanceof Array) {
                        listeners[eventName].forEach(function (listener) {
                            node.addEventListener(eventName, listener);
                        })
                    } else {
                        node[eventName] = listeners[eventName];
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
                result_array.push(attrName + ":" + obj[attrName]);
            }
        }
        return result_array.join(";");
    }

    function isContains(root, elem) {
        if (root.contains(elem)) {
            return true;
        } else {
            return [].some.call(root.children, function (child) {
                return isContains(child, elem);
            });
        }
    }

</script>
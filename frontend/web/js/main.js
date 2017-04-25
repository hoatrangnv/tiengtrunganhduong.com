/**
 * Created by User on 4/6/2017.
 */

!function (codeExamples) {
    var tab2space = "    "; // 1 tab ===> 4 space
    var tabSize = 4;
    if (window.innerWidth < 641) {
        tabSize = 2;
    }
    [].forEach.call(codeExamples, function (codeExample) {
        // readonly or editable mode
        codeExample.setReadonly = function (readonly) {
            this.setAttribute("data-readonly", readonly ? "1" : "0");
        };
        codeExample.isReadonly = function () {
            return this.getAttribute("data-readonly") === "1";
        };
        codeExample.setReadonly(true);

        // auto run on loading page
        codeExample.autoRun
            = !codeExample.hasAttribute("data-autorun") // cause auto run is default
            || codeExample.getAttribute("data-autorun") === "1"; // or give auto run = "1"

        // Code snippet (code tag)
        var snippet = codeExample.querySelector("code");
        snippet.className = "code-example-snippet";
        if (!snippet) {
            return false;
        }
        snippet.spellcheck = false;
        // snippet.innerHTML = snippet.innerHTML.split("\t").join(tab2space).trim();
        snippet.textContent = snippet.innerHTML.split(tab2space).join("\t").trim();
        snippet.innerHTML = highlightCode(snippet.textContent);
        // snippet.style.setProperty("tab-size", tabSize);
        // snippet.style.setProperty("-moz-tab-size", tabSize);
        snippet.style["tab-size"] = snippet.style["-moz-tab-size"] = tabSize;

        // Code textArea (textarea tag)
        var textArea = document.createElement("TEXTAREA");
        textArea.spellcheck = false;
        textArea.innerHTML = snippet.textContent;
        // textArea.style.setProperty("tab-size", tabSize);
        // textArea.style.setProperty("-moz-tab-size", tabSize);
        textArea.style["tab-size"] = textArea.style["-moz-tab-size"] = tabSize;
        // textArea.addEventListener("focus", function () {
        //     this.focused = true;
        // });
        var editor = document.createElement("DIV");
        editor.className = "code-example-editor";

        // function openEditor() {
        //     readonly = false;
        //     snippet.parentNode.replaceChild(textArea, snippet);
        //     textAreaAdjust(textArea);
        // }

        var buttonsWrapper = document.createElement("DIV");
        buttonsWrapper.className = "code-example-buttons-wrapper";
        codeExample.appendChild(buttonsWrapper);

        // Code sandbox
        var sandbox = document.createElement("iframe");
        sandbox.className = "code-example-sandbox";
        codeExample.appendChild(sandbox);
        sandbox.init_height = sandbox.offsetHeight;
        sandbox.setHeight = function () {
            var doc = sandbox.contentDocument || sandbox.contentWindow.document;
            sandbox.style.height = sandbox.init_height + doc.body.scrollHeight + "px";
        };
        sandbox.handleLoaded = function(callback) {
            var doc = sandbox.contentDocument || sandbox.contentWindow.document;

            if (doc.readyState  === "complete") {
                callback();
                return;
            }

            window.setTimeout(function () {
                sandbox.handleLoaded(callback);
            }, 100);
        };
        function runCode() {
            var content = codeExample.isReadonly() ? htmlEntitiesDecode(snippet.textContent) : textArea.value;

            var doc = sandbox.contentDocument || sandbox.contentWindow.document;
            doc.open();
            doc.write(content);
            doc.close();

            sandbox.setHeight();
            sandbox.handleLoaded(sandbox.setHeight);
        }
        if (codeExample.autoRun) {
            runCode();
        }

        // Toggle Readonly Mode
        var modeSwitcher = document.createElement("BUTTON");
        modeSwitcher.className = "code-example-mode-switcher";
        modeSwitcher.addEventListener("click", toggleReadonlyMode);
        buttonsWrapper.appendChild(modeSwitcher);

        // Code submit button
        var submit = document.createElement("BUTTON");
        submit.className = "code-example-submit-button";
        submit.addEventListener("click", runCode);
        buttonsWrapper.appendChild(submit);

        function toggleReadonlyMode() {
            if (codeExample.isReadonly()) {
                snippet.parentNode.replaceChild(editor, snippet);
                editor.appendChild(textArea);
                textAreaAdjust(textArea);
                codeExample.setReadonly(false);
            } else {
                while (editor.firstChild) {
                    editor.removeChild(editor.firstChild);
                }
                editor.parentNode.replaceChild(snippet, editor);
                codeExample.setReadonly(true);
            }
            runCode();
        }

        textArea.onkeydown = function (event) {
            if ([9, 13].indexOf(event.keyCode) > -1) {
                var code = textArea.value;

                if (event.keyCode === 9) { // TAB
                    // insertAtCaret(textArea, tab2space);
                    insertAtCaret(textArea, "\t");
                }

                if (event.keyCode === 13) { // ENTER
                    var current_pos = getCaret(textArea);
                    var white_space = "";
                    var last_tag = "";
                    var last_type = false;
                    do {
                        current_pos--;
                        var char = code.charAt(current_pos);
                        if (/ |\t/.test(char)) {
                            white_space += char;
                        } else if (char != "\n") {
                            white_space = "";
                            if (last_type === false) {
                                last_type = char;
                            }
                            if (last_type === ">" && char == "<") {
                                last_type = "<>";
                            }
                            if (last_type === ">" && last_type != char) {
                                last_tag = char + last_tag;
                            }
                        }
                    } while (char && (char != "\n"));

                    if (last_tag.toLowerCase() === "br" || last_tag.search(/(\/|--)/) > -1) {
                        last_type = "";
                    }
                    if (last_type === "{" || last_type === "<>") {
                        // white_space += tab2space;
                        white_space += "\t";
                    }
                    insertAtCaret(textArea, "\n" + white_space);
                }

                return false;
            }
        };

    });
}(document.querySelectorAll(".code-example"));

//    function getCaretOffset(element) {
//        var caretOffset = -1;
//        var sel = window.getSelection && window.getSelection();
//        if (sel && sel.rangeCount > 0) {
//            var range = sel.getRangeAt(0);
//            var preCaretRange = range.cloneRange();
//            preCaretRange.selectNodeContents(element);
//            preCaretRange.setEnd(range.endContainer, range.endOffset);
//            caretOffset = htmlEntitiesDecode(preCaretRange.toString()).length;
//        } else if (typeof document.selection !== "undefined" && document.selection.type !== "Control") {
//            var textRange = document.selection.createRange();
//            var preCaretTextRange = document.body.createTextRange();
//            preCaretTextRange.moveToElementText(element);
//            preCaretTextRange.setEndPoint("EndToEnd", textRange);
//            caretOffset = htmlEntitiesDecode(preCaretTextRange.text).length;
//        }
//        return caretOffset;
//    }

function getCaret(el) {
    if (el.selectionStart) {
        return el.selectionStart;
    } else if (document.selection) {
        el.focus();

        var r = document.selection.createRange();
        if (r == null) {
            return 0;
        }

        var re = el.createTextRange(),
            rc = re.duplicate();
        re.moveToBookmark(r.getBookmark());
        rc.setEndPoint('EndToStart', re);

        return rc.text.length;
    }
    return 0;
}

// function htmlEntitiesEncode(str) {
//     return htmlEntitiesDecode(str)
//         .split("&").join("&amp;")
//         .split("<").join("&lt;")
//         .split(">").join("&gt;")
//         // .split("'").join("&#039;")
//         // .split("\"").join("&quot;")
//         ;
// }

function htmlEntitiesDecode(str) {
    // return str
    //     .split("&gt;").join(">")
    //     .split("&lt;").join("<")
    //     .split("&amp;").join("&")
    // .split("&quot;").join("\"")
    // .split("&#039;").join("'")
    // ;
    var txtArea = document.createElement("TEXTAREA");
    txtArea.innerHTML = str;
    return txtArea.textContent;
}

function insertAtCaret(txtarea, text) {
    if (!txtarea) { return; }

    var scrollPos = txtarea.scrollTop;
    var strPos = 0;
    var br = ((txtarea.selectionStart || txtarea.selectionStart == '0') ?
        "ff" : (document.selection ? "ie" : false ) );
    if (br == "ie") {
        txtarea.focus();
        var range = document.selection.createRange();
        range.moveStart ('character', -txtarea.value.length);
        strPos = range.text.length;
    } else if (br == "ff") {
        strPos = txtarea.selectionStart;
    }

    var front = (txtarea.value).substring(0, strPos);
    var back = (txtarea.value).substring(strPos, txtarea.value.length);
    txtarea.value = front + text + back;
    strPos = strPos + text.length;
    if (br == "ie") {
        txtarea.focus();
        var ieRange = document.selection.createRange();
        ieRange.moveStart ('character', -txtarea.value.length);
        ieRange.moveStart ('character', strPos);
        ieRange.moveEnd ('character', 0);
        ieRange.select();
    } else if (br == "ff") {
        txtarea.selectionStart = strPos;
        txtarea.selectionEnd = strPos;
        txtarea.focus();
    }

    txtarea.scrollTop = scrollPos;
}

function textAreaAdjust(textArea) {
    // Initialize
    var mirror = document.createElement("DIV");
    textArea.parentNode.insertBefore(mirror, textArea);
    setMirrorStyle();
    setMirrorScroll();
    handleKeyEvent();

    // Handle events
    textArea.addEventListener("keydown", handleKeyEvent);
    textArea.addEventListener("keyup", handleKeyEvent);
    textArea.addEventListener("scroll", setMirrorScroll);
    textArea.addEventListener("resize", function () {
        setMirrorStyle();
        setMirrorScroll();
    });


    // Functions
    function handleKeyEvent() {
        var text = textArea.value.replace(/</gi, "&lt;").replace(/>/gi, "&gt;") + "&nbsp;";
        mirror.innerHTML = highlightCode(text);
        textArea.style.height = window.getComputedStyle(mirror, null).getPropertyValue("height");
    }
    function setMirrorStyle() {
        mirror.style.cssText = "position:absolute;top:0;left:0;pointer-events:none;color:red";

        // Copy style of textArea -> mirror
        var textAreaStyle = window.getComputedStyle(textArea, null);
        [
            // "display",
            // "width",
            // "border-box",
            // "-webkit-border-box",
            //
            // "border",
            // "border-top",
            // "border-right",
            // "border-bottom",
            // "border-left",
            //
            // "border-style",
            // "border-top-style",
            // "border-right-style",
            // "border-bottom-style",
            // "border-left-style",
            //
            // "border-width",
            // "border-top-width",
            // "border-right-width",
            // "border-bottom-width",
            // "border-left-width",
            //
            // "font",
            // "font-size",
            // "font-family",
            // "font-weight",
            // "font-stretch",
            //
            // "line-height",
            // "word-spacing",
            // "letter-spacing",
            // "tab-size",
            // "-moz-tab-size",
            // "text-indent",
            // "text-transform",
            //
            // "padding",
            // "padding-left",
            // "padding-top",
            // "padding-bottom",
            // "padding-right",
            //
            // "word-wrap",
            // "white-space",
            // "word-break",
            //
            // "overflow",
            // "overflow-x",
            // "overflow-y",
            // "-webkit-overflow-scrolling"
        ].forEach(
            // var myCSS = [];
            // for (var i = 0; i < textAreaStyle.length; i++) {
            //     myCSS.push(textAreaStyle[i]);
            // }
            // myCSS.forEach(
            function (prop) {
                // if ([
                //         "pointer-events",
                //         "position",
                //         "z-index",
                //         "height",
                //         "left",
                //         "top",
                //         "right",
                //         "bottom",
                //         "color",
                //         "background"
                //     ].indexOf(prop) === -1) {
                if (typeof mirror.style[prop] !== "undefined") {
                    mirror.style[prop] = textAreaStyle.getPropertyValue(prop);
                }
                // }
            }
        );
    }
    function setMirrorScroll() {
        mirror.scrollTop = textArea.scrollTop;
        mirror.scrollLeft = textArea.scrollLeft;
        mirror.scrollWidth = textArea.scrollWidth;
        mirror.scrollHeight = textArea.scrollHeight;
    }
}

function highlightCode(text) {
    // HTML
    text = text.replace(/&lt;!--[\w\W]*?--&gt;/gm, function (comment) {
        return "<span class=\"mirror-html-comment\">" + comment + "</span>";
    });

    // CSS
    text = text.replace(
        /(\&lt\;style[\w\W]*?\&gt\;)[\w\W]*?(?=\&lt\;\/style\&gt\;)/gmi,
        function (style) {
            return style.replace(
                /\/\*[\w\W]*?\*\//gm,
                function (comment) {
                    return "<span class=\"mirror-css-comment\">" + comment + "</span>";
                }
            );
        }
    );

    // JavaScript
    text = text.replace(
        /(\&lt\;script[\w\W]*?\&gt\;)[\w\W]*?(?=\&lt\;\/script\&gt\;)/gmi,
        function (script) {
            return script.replace(
                /\/\*[\w\W]*?\*\/|\/\/.*$/gm,
                function (comment) {
                    return "<span class=\"mirror-js-comment\">" + comment + "</span>";
                }
            );
        }
    );

    return text;
}
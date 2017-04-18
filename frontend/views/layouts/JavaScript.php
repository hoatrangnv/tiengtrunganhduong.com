<script>
    /**
     * Created by User on 4/6/2017.
     */

    !function (code_examples) {
        var tab2space = "    "; // 1 tab ===> 4 space
        var tabSize = 4;
        if (window.innerWidth < 641) {
            tabSize = 2;
        }
        [].forEach.call(code_examples, function (code_example) {
            // Code snippet (code tag)
            var snippet = code_example.querySelector("code");
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

            // Code editor (textarea tag)
            var editor = document.createElement("TEXTAREA");
            editor.spellcheck = false;
            editor.innerHTML = snippet.textContent;
            // editor.style.setProperty("tab-size", tabSize);
            // editor.style.setProperty("-moz-tab-size", tabSize);
            editor.style["tab-size"] = editor.style["-moz-tab-size"] = tabSize;
            editor.addEventListener("focus", function () {
                this.focused = true;
            });
            function openEditor() {
                editor.appeared = true;
                snippet.parentNode.replaceChild(editor, snippet);
                textAreaAdjust(editor);
            }

            // Code submit button
            var submit = document.createElement("BUTTON");
            submit.addEventListener("click", function (event) {
                if (!editor.appeared) {
                    openEditor();
                }
                runCode();
            }, false);
            code_example.appendChild(submit);

            // Code result
            var result = document.createElement("iframe");
            code_example.appendChild(result);
            result.init_height = result.offsetHeight;
            result.setHeight = function () {
                var doc = result.contentDocument || result.contentWindow.document;
                result.style.height = result.init_height + doc.body.scrollHeight + "px";
            };
            result.handleLoaded = function(callback) {
                var doc = result.contentDocument || result.contentWindow.document;

                if (doc.readyState  === "complete") {
                    callback();
                    return;
                }

                window.setTimeout(function () {
                    result.handleLoaded(callback);
                }, 100);
            };
            function runCode() {
                var doc = result.contentDocument || result.contentWindow.document;
                doc.open();
                doc.write(editor.value);
                doc.close();

                result.setHeight();
                result.handleLoaded(result.setHeight);
            }
            if (!code_example.classList.contains("code-example-manual-running")) {
                runCode();
            }

            //----
            snippet.contentEditable = true;
            snippet.onfocus = function () {
                var doc = document.documentElement;
                var scroll_top = (window.pageYOffset || doc.scrollTop)  - (doc.clientTop || 0);
                var caret;
                setTimeout(function () {
                    caret = getCaretOffset(snippet);
                    if (!editor.appeared) {
                        openEditor();
                    }
                    focus();
                }, 100);

                function focus() {
                    if (isNaN(caret)) {
                        return;
                    }
                    editor.focus();
                    editor.setSelectionRange(caret, caret);
                    window.scrollTo(0, scroll_top);
                }

                // iOS/Safari only "accepts" the focus when inside a touch event handler
                // http://stackoverflow.com/questions/18728166/programatically-focus-on-next-input-field-in-mobile-safari
                // https://www.sencha.com/forum/showthread.php?280423-Show-keyboard-on-iOS-automatically
                // https://www.quora.com/Mobile-Safari-iPhone-or-iPad-with-JavaScript-how-can-I-launch-the-on-screen-keyboard
                editor.addEventListener("touchstart", function () {
                    if (!editor.focused) {
                        focus();
                    }
                });
            };

            editor.onkeydown = function (event) {
                if ([9, 13].indexOf(event.keyCode) > -1) {
                    var code = editor.value;

                    if (event.keyCode === 9) { // TAB
                        // insertAtCaret(editor, tab2space);
                        insertAtCaret(editor, "\t");
                    }

                    if (event.keyCode === 13) { // ENTER
                        var current_pos = getCaret(editor);
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
                        insertAtCaret(editor, "\n" + white_space);
                    }

                    return false;
                }
            };

        });
    }(document.querySelectorAll(".code-example"));

    function getCaretOffset(element) {
        var caretOffset = undefined;
        var sel = window.getSelection && window.getSelection();
        if (sel && sel.rangeCount > 0) {
            var range = sel.getRangeAt(0);
            var preCaretRange = range.cloneRange();
            preCaretRange.selectNodeContents(element);
            preCaretRange.setEnd(range.endContainer, range.endOffset);
            caretOffset = htmlEntitiesDecode(preCaretRange.toString()).length;
        } else if (typeof document.selection !== "undefined" && document.selection.type !== "Control") {
            var textRange = document.selection.createRange();
            var preCaretTextRange = document.body.createTextRange();
            preCaretTextRange.moveToElementText(element);
            preCaretTextRange.setEndPoint("EndToEnd", textRange);
            caretOffset = htmlEntitiesDecode(preCaretTextRange.text).length;
        }
        return caretOffset;
    }

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
        var mirror = document.createElement("CODE");
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
            mirror.style.cssText = "position:absolute;pointer-events:none;color:transparent";

            // Copy style of textArea -> mirror
            var textAreaStyle = window.getComputedStyle(textArea, null);
            [
                "display",
                "width",
                "border-box",
                "-webkit-border-box",

                "border",
                "border-top",
                "border-right",
                "border-bottom",
                "border-left",

                "border-style",
                "border-top-style",
                "border-right-style",
                "border-bottom-style",
                "border-left-style",

                "border-width",
                "border-top-width",
                "border-right-width",
                "border-bottom-width",
                "border-left-width",

                "font",
                "font-size",
                "font-family",
                "font-weight",
                "font-stretch",

                "line-height",
                "word-spacing",
                "letter-spacing",
                "tab-size",
                "-moz-tab-size",
                "text-indent",
                "text-transform",

                "padding",
                "padding-left",
                "padding-top",
                "padding-bottom",
                "padding-right",

                "word-wrap",
                "white-space",
                "word-break",

                "overflow",
                "overflow-x",
                "overflow-y"
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
</script>
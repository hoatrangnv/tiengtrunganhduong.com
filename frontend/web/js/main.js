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
        // snippet.innerHTML = snippet.innerHTML.split("\t").join(tab2space).trim();
        snippet.innerHTML = snippet.innerHTML.split(tab2space).join("\t").trim();
        // snippet.style.setProperty("tab-size", tabSize);
        // snippet.style.setProperty("-moz-tab-size", tabSize);
        snippet.style["tab-size"] = snippet.style["-moz-tab-size"] = tabSize;

        // Code editor (textarea tag)
        var editor = document.createElement("TEXTAREA");
        editor.innerHTML = snippet.innerHTML;
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
        submit.innerHTML = "Try it here";
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

            if (doc.readyState  == "complete") {
                callback();
                return;
            }

            window.setTimeout(result.handleLoaded, 100);
        };
        result.handleLoaded(result.setHeight);
        function runCode() {
            var doc = result.contentDocument || result.contentWindow.document;
            doc.open();
            doc.write(editor.value);
            doc.close();

            result.setHeight();
        }
        runCode();

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
    var caretOffset = 0;
    if (typeof window.getSelection != "undefined") {
        var range = window.getSelection().getRangeAt(0);
        var preCaretRange = range.cloneRange();
        preCaretRange.selectNodeContents(element);
        preCaretRange.setEnd(range.endContainer, range.endOffset);
        caretOffset = htmlEntitiesDecode(preCaretRange.toString()).length;
    } else if (typeof document.selection != "undefined" && document.selection.type != "Control") {
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

// function setCaret(elem, caretPos) {
//     if(elem != null) {
//         if(elem.createTextRange) {
//             var range = elem.createTextRange();
//             range.move('character', caretPos);
//             range.select();
//         }
//         else {
//             // if(elem.selectionStart) {
//             //     elem.focus();
//                 elem.setSelectionRange(caretPos, caretPos);
//             // } else {
//             //     elem.focus();
//             // }
//         }
//     }
// }

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

// function nodeClassNamesReplace(node) {
//     var prefix = "_" + Math.random().toString(36).substring(7);
//
//     var classNames = [];
//     [].forEach.call(
//         node.querySelectorAll("*"),
//         function (elem) {
//             for (i = 0; i < elem.classList.length; i++) {
//                 classNames.push(elem.classList[i]);
//             }
//             for (i = 0; i < elem.classList.length; i++) {
//                 elem.classList.remove(elem.classList[i]);
//                 elem.classList.add(prefix + classList[i]);
//             }
//         }
//     );
//     classNames.forEach(function (className) {
//
//     })
// }

// function nodeScriptReplace(node) {
//     if ( node.tagName === 'SCRIPT' ) {
//         node.parentNode.replaceChild( nodeScriptClone(node) , node );
//     }
//     else {
//         var i        = 0;
//         var children = node.childNodes;
//         while ( i < children.length ) {
//             nodeScriptReplace( children[i++] );
//         }
//     }
//
//     return node;
// }

// function nodeScriptClone(node){
//     var script  = document.createElement("SCRIPT");
//     script.text = node.innerHTML;
//     for( var i = node.attributes.length-1; i >= 0; i-- ) {
//         script.setAttribute( node.attributes[i].name, node.attributes[i].value );
//     }
//     return script;
// }

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
    var d = document.createElement("DIV");
    var wrap = document.createElement("DIV");
    wrap.style.position = "fixed";
    wrap.style.width = "0px";
    wrap.style.height = "0px";
    wrap.style.visibility = "hidden";
    wrap.style.pointerEvents = "none";
    wrap.style.overflow = "hidden";
    wrap.appendChild(d);
    document.body.appendChild(wrap);

    // Condition to use rows property to adjust height
    // textArea.style.whiteSpace = "pre";
    // textArea.style.wordWrap = "normal";
    // textArea.style.height = "auto";
    function handleKeyEvent() {
        d.innerHTML = textArea.value.replace(/</gi, "&lt;").replace(/>/gi, "&gt;") + ".";

        var f = window.getComputedStyle(textArea, null);
        [
            "width",
            "border-box",
            "display",

            "border-style",
            "border-width",
            "border-left-width",
            "border-top-width",
            "border-bottom-width",
            "border-right-width",

            "font",
            "font-size",
            "font-family",
            "font-weight",
            "line-height",
            "word-spacing",
            "letter-spacing",
            "tab-size",
            "-moz-tab-size",
            "text-transform",

            "padding",
            "padding-left",
            "padding-top",
            "padding-bottom",
            "padding-right",

            "word-wrap",
            "white-space",
            "word-break",
            "overflow"

        ].forEach(function (prop) {
            if (typeof d.style[prop] !== "undefined") {
                console.log(prop, f.getPropertyValue(prop));
                d.style[prop] = f.getPropertyValue(prop);
            }
        });

        // textArea.style.height = d.offsetHeight + "px";
        textArea.style.height = window.getComputedStyle(d, null).getPropertyValue("height");

        // var computedStyle = window.getComputedStyle(textArea, null);
        // var borderWidth = 0;
        // if (computedStyle) {
        //     borderWidth = parseFloat(computedStyle.getPropertyValue("border-top-width"))
        //      + parseFloat(computedStyle.getPropertyValue("border-bottom-width"));
        // }
        // textArea.style.height =
        //     textArea.scrollHeight
        //     + borderWidth
        //     + "px";

        // textArea.rows = textArea.value.split("\n").length;
    }
    handleKeyEvent();
    textArea.addEventListener("keydown", handleKeyEvent);
    textArea.addEventListener("keyup", handleKeyEvent);
}

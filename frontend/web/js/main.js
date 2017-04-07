/**
 * Created by User on 4/6/2017.
 */

!function (code_blocks) {
    var tab = "\t";
    var tab2space = "    "; // 1 tab ===> 4 space
    [].forEach.call(code_blocks, function (code_block) {
        var code_example = code_block.querySelector("code");
        var editor = document.createElement("TEXTAREA");
        editor.className = "code-example-editor";
        editor.value = code_example.innerHTML.split(tab).join(tab2space).trim();
        if (!code_example || code_example != code_block.firstChild) {
            code_example = code_block;
        }
        code_example.innerHTML = htmlEntitiesEncode(code_example.innerHTML.split(tab).join(tab2space).trim());
        var test_block = document.createElement("DIV");

        editor.style.height = code_example.offsetHeight + "px";
        editor.style.fontSize = window.getComputedStyle(code_example, null).getPropertyValue("font-size");
        editor.style.fontFamily = window.getComputedStyle(code_example, null).getPropertyValue("font-family");
        if (code_block.nextSibling) {
            code_block.parentNode.insertBefore(test_block, code_block.nextSibling);
        } else {
            code_block.parentNode.appendChild(test_block);
        }

        var btn = document.createElement("BUTTON");
        btn.innerHTML = "Try it here";
        var editor_display = false;
        btn.addEventListener("click", function (event) {
            if (!editor_display) {
                editor_display = true;
                code_block.replaceChild(editor, code_example);
                // code_block.parentNode.insertBefore(editor, btn);
            }
            runCode();
        }, false);

        code_block.parentNode.insertBefore(btn, test_block);

        function runCode() {
            test_block.innerHTML = editor.value;
            nodeScriptReplace(test_block);
        }

        runCode();

        code_example.contentEditable = true;
        code_example.onfocus = function () {
            var scroll_top = document.body.scrollTop;
            setTimeout(function () {
                var caret = getCaretOffset(code_example);
                setTimeout(function () {
                    setCaret(editor, caret);
                    console.log('caret'+caret);
                    window.scrollTo(0, scroll_top);
                    // document.body.scrollTop = scroll_top;

                },100);
                if (!editor_display) {
                    editor_display = true;
                    code_block.replaceChild(editor, code_example);
                    // code_block.parentNode.insertBefore(editor, btn);

                    // setTimeout(function () {
                    //
                    // },100);
                }

            },100);
        };

        editor.value.split(tab).join(tab2space);
        editor.onkeydown = function (event) {
            if ([9, 13].indexOf(event.keyCode) > -1) {
                var code = editor.value;

                if (event.keyCode === 9) { // TAB
                    insertAtCaret(editor, tab);
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
                        white_space += tab;
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

function setCaret(elem, caretPos) {
    if(elem != null) {
        if(elem.createTextRange) {
            var range = elem.createTextRange();
            range.move('character', caretPos);
            range.select();
        }
        else {
            if(elem.selectionStart) {
                elem.focus();
                elem.setSelectionRange(caretPos, caretPos);
            }
            else
                elem.focus();
        }
    }
}

function htmlEntitiesEncode(str) {
    return htmlEntitiesDecode(str)
        .split("&").join("&amp;")
        .split("<").join("&lt;")
        .split(">").join("&gt;")
        ;
}

function htmlEntitiesDecode(str) {
    return str
        .split("&gt;").join(">")
        .split("&lt;").join("<")
        .split("&amp;").join("&")
        ;
}

function nodeScriptReplace(node) {
    if ( node.tagName === 'SCRIPT' ) {
        node.parentNode.replaceChild( nodeScriptClone(node) , node );
    }
    else {
        var i        = 0;
        var children = node.childNodes;
        while ( i < children.length ) {
            nodeScriptReplace( children[i++] );
        }
    }

    return node;
}

function nodeScriptClone(node){
    var script  = document.createElement("SCRIPT");
    script.text = node.innerHTML;
    for( var i = node.attributes.length-1; i >= 0; i-- ) {
        script.setAttribute( node.attributes[i].name, node.attributes[i].value );
    }
    return script;
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

function autoGrowTextareas(textareas) {
    for (var i = 0; i < textareas.length; i++) {
        !function (e) {
            var d = document.createElement("div");
            var f = window.getComputedStyle(e, null);

            e.style.overflow = "hidden";
            e.style.transition = "all 0.3s";

            d.style.position = "absolute";
            d.style.top = "0px";
            d.style.left = "0px";
            d.style.visibility = "hidden";
            d.style.pointerEvents = "none";
            d.style.zIndex = -999;
            d.style.width = f.getPropertyValue("width");
            d.style.font = f.getPropertyValue("font");
            d.style.lineHeight = f.getPropertyValue("line-height");
            d.style.padding = f.getPropertyValue("padding");
            d.style.border = f.getPropertyValue("border");

            d.innerHTML = e.placeholder;
            document.body.appendChild(d);

            e.onkeydown = function () {
                // while (e.value.indexOf("    ") > -1) {
                //     e.value = e.value.split("    ").join("   ");
                // }
                // while (e.value.indexOf("\n\n\n\n") > -1) {
                //     e.value = e.value.split("\n\n\n\n").join("\n\n\n");
                // }
                // while (/ |\n/g.test(e.value.charAt(0))) {
                //     e.value = e.value.substring(1);
                // }
                d.innerHTML = e.value
                        .split("<").join("&lt;")
                        .split(">").join("&gt;")
                        .split("\n").join("<br>")
                        .split("  ").join(" &nbsp;");
                e.style.height = d.offsetHeight + "px";

                // var enter_submit = !e.classList.contains("no-enter-submit");
                // if (enter_submit && event.keyCode === 13 && !event.shiftKey) {
                //     submitForm(e.form);
                // }
            };
        }(textareas[i]);
    }
}

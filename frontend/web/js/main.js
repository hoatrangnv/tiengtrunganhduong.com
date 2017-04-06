/**
 * Created by User on 4/6/2017.
 */

!function (code_blocks) {
    var tab = "    "; // 1 tab ===> 4 space
    [].forEach.call(code_blocks, function (code_block) {
        var code_example = code_block.querySelector("code");
        if (!code_example || code_example != code_block.firstChild) {
            code_example = code_block;
        }
        code_example.innerHTML = htmlEntitiesEncode(code_example.innerHTML.trim());
        code_example.innerHTML.split("\t").join(tab);
        var test_block = document.createElement("DIV");

        if (code_block.nextSibling) {
            code_block.parentNode.insertBefore(test_block, code_block.nextSibling);
        } else {
            code_block.parentNode.appendChild(test_block);
        }

        var btn = document.createElement("BUTTON");
        btn.innerHTML = "Try it here";
        btn.addEventListener("click", function (event) {
            test_block.innerHTML = htmlEntitiesDecode(code_example.innerHTML);
            nodeScriptReplace(test_block);
        }, false);
        code_block.parentNode.insertBefore(btn, test_block);
        btn.click();

        code_example.contentEditable = true;

        code_example.onkeydown = function (event) {
            code_example.innerHTML = htmlEntitiesEncode(code_example.innerHTML);
            if (event.keyCode === 9) { // TAB
                code_example.innerHTML.split("\t").join(tab);
                document.execCommand("insertHTML", false, tab);
            }

            if ([9, 13].indexOf(event.keyCode) > -1) {
                var code = htmlEntitiesDecode(code_example.innerHTML);

                if (event.keyCode === 9) { // TAB
                    document.execCommand("insertHTML", false, tab);
                }

                if (event.keyCode === 13) { // ENTER
                    var current_pos = getCaretOffset(code_example);
                    var white_space = "";
                    var last_type = false;
                    var last_tag = "";
                    do {
                        current_pos--;
                        var char = code.charAt(current_pos);
                        if (char == " ") {
                            white_space += " ";
                        } else if (char != "\n") {
                            white_space = "";
                            if (last_type === false) {
                                last_type = char;
                            }
                            if (last_type === ">" && char == "<") {
                                last_type = "<>";
                            }
                            if (last_type === ">" && char == "/") {
                                last_type = "";
                            }
                            if (last_type === ">" && last_type != char) {
                                last_tag = char + last_tag;
                            }
                        }
                    } while (char && (char != "\n"));

                    if (last_tag.toLowerCase() === "br") {
                        last_type = "";
                    }
                    if (last_type === "{" || last_type === "<>") {
                        white_space += tab;
                    }
                    document.execCommand("insertHTML", false, "\n" + white_space);
                    if ( code_example.innerHTML.slice(-1) === "\n"
                      && code_example.innerHTML.slice(-2, -1) !== "\n"
                      && code.length == getCaretOffset(code_example)
                    ) {
                        // Ensure break line
                        document.execCommand("insertHTML", false, "\n");
                    }
                }

                return false;
            }
        };
    });
}(document.querySelectorAll(".code-example"));

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


function nodeScriptReplace(node) {
    if ( nodeScriptIs(node) === true ) {
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
function nodeScriptIs(node) {
    return node.tagName === 'SCRIPT';
}
function nodeScriptClone(node){
    var script  = document.createElement("script");
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
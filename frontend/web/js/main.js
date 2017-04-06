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
                    // if ( code_example.innerHTML.slice(-1) === "\n"
                    //   && code_example.innerHTML.slice(-2, -1) !== "\n"
                    //   && code.length == getCaretOffset(code_example)
                    // ) {
                    //     // Ensure break line
                    //     document.execCommand("insertHTML", false, "\n" + white_space);
                    // }
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
/**
 * Created by User on 4/6/2017.
 */

!function (code_examples) {
    var tab = "    "; // 1 tab ===> 4 space
    [].forEach.call(code_examples, function (code_example) {
        code_example.innerHTML = htmlEntitiesEncode(code_example.innerHTML);
        code_example.innerHTML.split("\t").join(tab);
        var test_block = document.createElement("DIV");

        if (code_example.nextSibling) {
            code_example.parentNode.insertBefore(test_block, code_example.nextSibling);
        } else {
            code_example.parentNode.appendChild(test_block);
        }

        var btn = document.createElement("BUTTON");
        btn.innerHTML = "Try it here";
        btn.addEventListener("click", function (event) {
            test_block.innerHTML = htmlEntitiesDecode(code_example.innerHTML);
        }, false);
        code_example.parentNode.insertBefore(btn, test_block);
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
                        document.execCommand("insertHTML", false, "\n" + white_space);
                    }
                }

                return false;
            }
        };
    });
}(document.querySelectorAll(".code-example"));

function htmlEntitiesEncode(str) {
    return str
        .split("<").join("&lt;")
        .split(">").join("&gt;")
        ;
}

function htmlEntitiesDecode(str) {
    return str
        .split("&gt;").join(">")
        .split("&lt;").join("<")
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
/**
 * Created by User on 4/6/2017.
 */

!function (code_examples) {
    [].forEach.call(code_examples, function (code_example) {
        var test_block = document.createElement("DIV");

        if (code_example.nextSibling) {
            code_example.parentNode.insertBefore(test_block, code_example.nextSibling);
        } else {
            code_example.parentNode.appendChild(test_block);
        }

        var btn = document.createElement("BUTTON");
        btn.innerHTML = "Try it here";
        btn.addEventListener("click", function (event) {
            test_block.innerHTML = code_example.innerHTML;
        }, false);
        code_example.parentNode.insertBefore(btn, test_block);
        btn.click();

        code_example.contentEditable = true;

        code_example.onkeydown = function (event) {
            var tab = "    "; // 1 tab ===> 4 space
            code_example.innerHTML.split("\t").join(tab);

            if (event.keyCode === 13) { // ENTER
                var current_pos = getCaretCharacterOffsetWithin(code_example);
                var white_space = "";
                var last_char = false;
                do {
                    current_pos--;
                    var char = code_example.innerHTML.charAt(current_pos);
                    if (char == " ") {
                        white_space += " ";
                    } else if (char != "\n") {
                        white_space = "";
                        if (last_char === false) {
                            last_char = char;
                        }
                        if (last_char === ">" && char == "/") {
                            last_char = "";
                        }
                    }
                } while (char != "\n");
                if (last_char === "{" || last_char === ">")
                document.execCommand("insertHTML", false, "\n" + white_space);
                return false;
            }

            if (event.keyCode === 9) { // TAB
                document.execCommand("insertHTML", false, tab);
                return false;
            }
        };
    });
}(document.querySelectorAll(".code-example"));

function getCaretCharacterOffsetWithin(element) {
    var caretOffset = 0;
    if (typeof window.getSelection != "undefined") {
        var range = window.getSelection().getRangeAt(0);
        var preCaretRange = range.cloneRange();
        preCaretRange.selectNodeContents(element);
        preCaretRange.setEnd(range.endContainer, range.endOffset);
        caretOffset = preCaretRange.toString().length;
    } else if (typeof document.selection != "undefined" && document.selection.type != "Control") {
        var textRange = document.selection.createRange();
        var preCaretTextRange = document.body.createTextRange();
        preCaretTextRange.moveToElementText(element);
        preCaretTextRange.setEndPoint("EndToEnd", textRange);
        caretOffset = preCaretTextRange.text.length;
    }
    return caretOffset;
}
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

        code_example.addEventListener("keydown", function (event) {
            if (event.keyCode === 13) {
                var current_pos = getCaretCharacterOffsetWithin(code_example);
                var white_space = "";
                do {
                    current_pos--;
                    var char = code_example.innerHTML.charAt(current_pos);
                    if (char == " ") {
                        white_space += "_";
                    } else {
                        white_space = "";
                    }
                } while (char != "\n");
                    console.log(white_space);

                document.execCommand("insertHTML", false, "\n" + white_space);

                return false;
            }
        }, false);
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
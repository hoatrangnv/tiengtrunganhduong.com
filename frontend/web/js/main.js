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
                var lines = code_example.innerHTML.split("\n");
                var current_line_number = code_example.innerHTML.substr(0, code_example.selectionStart).split("\n").length;
                var current_line = lines[current_line_number];
                var white_space = "\n";
                for (var i = 0; i< current_line.length; i++) {
                    if (current_line.charAt(i) == " ") {
                        white_space += " ";
                    } else {
                        break;
                    }
                }

                document.execCommand("insertHTML", false, white_space);

                return false;
            }
        }, false);
    });
}(document.querySelectorAll(".code-example"));
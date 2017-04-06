/**
 * Created by User on 4/6/2017.
 */

!function (code_examples) {
    [].forEach.call(code_examples, function (code_example) {
        var test_block = document.createElement("DIV");
        test_block.innerHTML = code_example.innerHTML;

        if (code_example.nextSibling) {
            code_example.parentNode.insertBefore(test_block, code_example.nextSibling);
        } else {
            code_example.parentNode.appendChild(test_block);
        }
    });
}(document.querySelectorAll("code-example"));
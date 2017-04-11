/**
 * Created by User on 4/2/2017.
 */
!function (tables) {
    [].forEach.call(tables, function (table) {
        var wrap = table.parentNode;
        if (wrap) {
            wrap.classList.add("table-wrap");
        }
    })
}(document.querySelectorAll("table"));

function selectElementText(el){
    var range = document.createRange(); // create new range object
    range.selectNodeContents(el); // set range to encompass desired element text
    var selection = window.getSelection(); // get selection object from currently user selected text
    selection.removeAllRanges(); // deselect any user selected text (if any)
    selection.addRange(range); // add range to Selection object to select it
}

function copySelection(){
    var success; // var to check whether execCommand successfully executed
    try{
        success = document.execCommand("copy"); // run command to copy selected text to clipboard
    } catch(e){
        success = false
    }
    return success;
}
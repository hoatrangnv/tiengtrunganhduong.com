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

function copyTextToClipboard (text) {
    var textArea = document.createElement("TEXTAREA");
    textArea.style.position = "absolute";
    textArea.style.top = "0px";
    textArea.style.left = "0px";
    textArea.style.visibility = "hidden";
    document.body.appendChild(textArea);
    textArea.value = text;
    textArea.select();
    try {
        var successful = document.execCommand("copy");
        console.log("Copying text command was " + (successful ? "successful." : "unsuccessful."));
    } catch (error) {
        console.log("Oops, Unable to copy.");
    }
    document.body.removeChild(textArea);
}
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
    textArea.style.position = "fixed";
    textArea.style.bottom = "0px";
    textArea.style.left = "0px";
    document.body.appendChild(textArea);
    textArea.value = text;
    textArea.select();
    var message = document.createElement("DIV");
    message.style.position = "relative";
    message.style.top = "0px";
    message.style.margin = "auto";
    document.body.appendChild(message);
    try {
        var successful = document.execCommand("copy");
        message.innerHTML = "Copying text command was " + (successful ? "successful." : "unsuccessful.");
    } catch (error) {
        message.innerHTML = "Oops, Unable to copy.";
    }
    document.body.removeChild(textArea);
    // setTimeout(function () {
    //     document.body.removeChild(message);
    // }, 999);
}

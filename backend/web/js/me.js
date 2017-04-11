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
    textArea.disabled = "true";
    document.body.appendChild(textArea);
    textArea.value = text;
    textArea.select();
    var message = document.createElement("DIV");
    message.style.position = "absolute";
    // message.style.bottom = "0px";
    message.style.background = "black";
    message.style.color = "white";
    message.style.zIndex = "9999";
    try {
        var successful = document.execCommand("copy");
        message.innerHTML = "Copying text command was " + (successful ? "successful." : "unsuccessful.");
    } catch (error) {
        message.innerHTML = "Oops, Unable to copy.";
    }
    // document.body.removeChild(textArea);
    document.body.appendChild(message);
    // setTimeout(function () {
    //     document.body.removeChild(message);
    // }, 999);
}

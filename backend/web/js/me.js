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
    textArea.disabled = true;
    document.body.appendChild(textArea);
    textArea.value = text;
    textArea.select();
    var message = document.createElement("DIV");
    message.style.position = "fixed";
    message.style.bottom = "0px";
    message.style.background = "black";
    message.style.color = "white";
    message.style.zIndex = "9999";
    try {
        var successful = document.execCommand("copy");
        message.innerHTML = "Copying text command was " + (successful ? "successful." : "unsuccessful.");
    } catch (error) {
        message.innerHTML = "Oops, Unable to copy.";
    }
    document.body.removeChild(textArea);
    document.body.appendChild(message);
    setTimeout(function () {
        document.body.removeChild(message);
    }, 999);
}

var tooltip, // global variables oh my! Refactor when deploying!
    hidetooltiptimer

function createtooltip(){ // call this function ONCE at the end of page to create tool tip object
    tooltip = document.createElement('div')
    tooltip.style.cssText =
        'position:absolute; background:black; color:white; padding:4px;z-index:10000;'
        + 'border-radius:2px; font-size:12px;box-shadow:3px 3px 3px rgba(0,0,0,.4);'
        + 'opacity:0;transition:opacity 0.3s'
    tooltip.innerHTML = 'Copied!'
    document.body.appendChild(tooltip)
}
createtooltip();

function showtooltip(e){
    var evt = e || event
    clearTimeout(hidetooltiptimer)
    tooltip.style.left = evt.pageX - 10 + 'px'
    tooltip.style.top = evt.pageY + 15 + 'px'
    tooltip.style.opacity = 1
    hidetooltiptimer = setTimeout(function(){
        tooltip.style.opacity = 0
    }, 500)
}

function selectElementText(el){
    var range = document.createRange() // create new range object
    range.selectNodeContents(el) // set range to encompass desired element text
    var selection = window.getSelection() // get Selection object from currently user selected text
    selection.removeAllRanges() // unselect any user selected text (if any)
    selection.addRange(range) // add range to Selection object to select it
}

function copySelectionText(){
    var copysuccess // var to check whether execCommand successfully executed
    try{
        copysuccess = document.execCommand("copy") // run command to copy selected text to clipboard
    } catch(e){
        copysuccess = false
    }
    return copysuccess
}

var motivatebox = document.getElementById('motivatebox')

motivatebox.addEventListener('mouseup', function(e){
    var e = e || event // equalize event object between modern and older IE browsers
    var target = e.target || e.srcElement // get target element mouse is over
    if (target.className == 'motivate'){
        selectElementText(target) // select the element's text we wish to read
        var copysuccess = copySelectionText()
        if (copysuccess){
            showtooltip(e)
        }
    }
}, false)

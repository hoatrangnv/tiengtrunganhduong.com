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

var tooltip, // global variables oh my! Refactor when deploying!
    hideTooltipTimer;

function createTooltip(){ // call this function ONCE at the end of page to create tool tip object
    tooltip = document.createElement('div');
    tooltip.style.cssText =
        'position:absolute; background:black; color:white; padding:4px;z-index:10000;'
        + 'border-radius:2px; font-size:12px;box-shadow:3px 3px 3px rgba(0,0,0,.4);'
        + 'opacity:0;transition:opacity 0.3s';
    tooltip.innerHTML = 'Copied!';
    document.body.appendChild(tooltip);
}
createTooltip();

function showTooltip(e){
    var evt = e || event;
    clearTimeout(hideTooltipTimer);
    tooltip.style.left = evt.pageX - 10 + 'px';
    tooltip.style.top = evt.pageY + 15 + 'px';
    tooltip.style.opacity = 1;
    hideTooltipTimer = setTimeout(function(){
        tooltip.style.opacity = 0
    }, 500);
}

function selectElementText(el){
    var range = document.createRange(); // create new range object
    range.selectNodeContents(el); // set range to encompass desired element text
    var selection = window.getSelection(); // get Selection object from currently user selected text
    selection.removeAllRanges(); // deselect any user selected text (if any)
    selection.addRange(range); // add range to Selection object to select it
}

function copySelectionText(){
    var copysuccess; // var to check whether execCommand successfully executed
    try{
        copysuccess = document.execCommand("copy"); // run command to copy selected text to clipboard
    } catch (e) {
        copysuccess = false;
    }
    return copysuccess;
}

var motivatebox = document.getElementById('motivatebox');

motivatebox.addEventListener('mouseup', function(e){
    e = e || event; // equalize event object between modern and older IE browsers
    var target = e.target || e.srcElement; // get target element mouse is over
    if (target.classList.contains('motivate')) {
        selectElementText(target); // select the element's text we wish to read
        var copysuccess = copySelectionText();
        if (copysuccess){
            showTooltip(e);
        }
    }
}, false);

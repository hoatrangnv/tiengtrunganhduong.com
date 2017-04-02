/**
 * Created by User on 4/2/2017.
 */
!function (tables) {
    [].forEach.call(tables, function (table) {
        var wrap = table.parentNode;
        if (wrap) {
            wrap.style.maxWidth = "100%";
            wrap.style.overflowX = "auto";
        }
    })
}(document.querySelectorAll("table"));
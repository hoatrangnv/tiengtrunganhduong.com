/**
 * Set orientations for images and some other objects
 */
setObjectOrientations();
function setObjectOrientations() {
    web.setObjectOrientation(document.querySelectorAll(".aspect-ratio.__16x9 .img-wrap *"), 16 / 9);
    web.setObjectOrientation(document.querySelectorAll(".aspect-ratio.__5x3 .img-wrap *"), 5 / 3);
    web.setObjectOrientation(document.querySelectorAll(".aspect-ratio.__3x1 .img-wrap *"), 3);
}

/**
 * Trim long text
 */
ellipsisTexts();
function ellipsisTexts() {
    web.ellipsisTexts(document.querySelectorAll(".grid-view > ul > li .name"));
    web.ellipsisTexts(document.querySelectorAll(".grid-view > ul > li .desc"));
    web.ellipsisTexts(document.querySelectorAll(".news-item .name"));
    web.ellipsisTexts(document.querySelectorAll(".news-item .desc"));
}

/**
 * Content popup images
 */
!function (imgs) {
    [].forEach.call(imgs, function (img, idx, arr) {
        img.onclick = function () {
            web.popupImages(arr, idx);
        };
    });
}(document.querySelectorAll(".content-popup-images img"));

/**
 * Loading start
 * @param msg
 * @param container
 */
function loadingStart(msg, container) {
    window.loading = web.loading("<i class=\"icon loading-icon\"></i>"
        + (msg === false ? "" : "<br><span class=\"message-text\">"
        + (msg || "đang tải...") + "</span>") + "", "", container);
}

/**
 * Loading finish
 */
function loadingFinish() {
    if (typeof window.loading !== "undefined") {
        window.loading.finish();
    }
}

/**
 * Primary form
 */
!function (inputs) {
    [].forEach.call(inputs, function (input) {
        input.setAttribute("value", input.value);
        ['keyup', 'keydown', 'change', 'propertychange', 'click', 'input', 'paste'].forEach(function (event) {
            input.addEventListener(event, function () {
                this.setAttribute("value", this.value);
            });
        });
    });
}(document.querySelectorAll("form.primary input, form.primary textarea, form.primary select"));

/**
 * Audio inline
 */
!function (buttons) {
    [].forEach.call(buttons, function (button) {
        var src = button.getAttribute("data-src");
        var loaded = false;
        var audio = new Audio(src);
        audio.preload = 'none';
        audio.onloadeddata = function () {
            loaded = true;
            button.disabled = false;
            button.classList.add('playing');
            audio.play();
        };
        audio.onended = function () {
            button.classList.remove('playing');
        };
        audio.onerror = function () {
            button.disabled = false;
            button.classList.add('error');
        };
        button.addEventListener("click", function () {
            if (loaded) {
                if (button.classList.contains('playing')) {
                    audio.pause();
                    audio.currentTime = 0;
                    button.classList.remove('playing');
                } else {
                    audio.play();
                    button.classList.add('playing');
                }
            } else {
                audio.load();
                button.disabled = true;
            }
        });
    });
}(document.querySelectorAll("button.audio-inline"));
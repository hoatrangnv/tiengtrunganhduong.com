/**
 * Created by User on 6/9/2017.
 */

!function () {
    /**
     *
     * @param c
     * @param d
     * @param t
     * @returns {string}
     */
    Number.prototype.format = function(c, d, t){
        c = isNaN(c = Math.abs(c)) ? 2 : c;
        d = d == undefined ? "." : d;
        t = t == undefined ? "," : t;
        var n = this,
            s = n < 0 ? "-" : "",
            i = String(parseInt(n = Math.abs(Number(n) || 0).toFixed(c))),
            j = (j = i.length) > 3 ? j % 3 : 0;
        return s + (j ? i.substr(0, j) + t : "") + i.substr(j).replace(/(\d{3})(?=\d)/g, "$1" + t) + (c ? d + Math.abs(n - i).toFixed(c).slice(2) : "");
    };
}();

/**
 *
 * @var {} web
 */
var web = {};

/**
 *
 * @returns {boolean}
 */
web.detectMobile = function() {
    return /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent);
};

/**
 *
 * @param objects
 * @param aspect_ratio
 */
web.setObjectOrientation = function (objects, aspect_ratio) {
    for (var i = 0; i < objects.length; i++) {
        !function main(obj) {
            var width = obj.naturalWidth || obj.width;
            var height = obj.naturalHeight || obj.height;

            if (width / height > aspect_ratio) {
                obj.classList.add("landscape");
                obj.classList.remove("portrait");
            } else {
                obj.classList.add("portrait");
                obj.classList.remove("landscape");
            }
            if (typeof obj.onload !== "undefined" && !obj.loaded) {
                obj.onload = function () {
                    main(this);
                    obj.loaded = true;
                };
            }
        }(objects[i]);
    }
};

/**
 *
 * @param element
 * @param target
 * @param duration
 * @param scroll_left
 * @returns {*}
 */
web.smoothScroll = function(element, target, duration, scroll_left) {
    var scroll = "scrollTop";
    if (scroll_left) {
        scroll = "scrollLeft";
    }
    target = Math.round(target);
    duration = Math.round(duration);
    if (duration < 0) {
        return Promise.reject("bad duration");
    }
    if (duration === 0) {
        element[scroll] = target;
        return Promise.resolve();
    }

    var start_time = Date.now();
    var end_time = start_time + duration;

    var start_pos = element[scroll];
    var distance = target - start_pos;

    // based on http://en.wikipedia.org/wiki/Smoothstep
    var smooth_step = function(start, end, point) {
        if(point <= start) { return 0; }
        if(point >= end) { return 1; }
        var x = (point - start) / (end - start); // interpolation
        return x*x*(3 - 2*x);
    };

    return new Promise(function(resolve, reject) {
        // This is to keep track of where the element's scrollTop is
        // supposed to be, based on what we're doing
        var previous_pos = element[scroll];

        // This is like a think function from a game loop
        var scroll_frame = function() {
            if(element[scroll] != previous_pos) {
                reject("interrupted");
                return;
            }

            // set the scrollTop for this frame
            var now = Date.now();
            var point = smooth_step(start_time, end_time, now);
            var frameTop = Math.round(start_pos + (distance * point));
            element[scroll] = frameTop;

            // check if we're done!
            if(now >= end_time) {
                resolve();
                return;
            }

            // If we were supposed to scroll but didn't, then we
            // probably hit the limit, so consider it done; not
            // interrupted.
            if(element[scroll] === previous_pos
                && element[scroll] !== frameTop) {
                resolve();
                return;
            }
            previous_pos = element[scroll];

            // schedule next frame for execution
            setTimeout(scroll_frame, 0);
        };

        // boostrap the animation process
        setTimeout(scroll_frame, 0);
    });
};

/**
 *
 * @param msg
 * @param cls
 * @returns {*|Element}
 */
web.popup = function (msg, cls) {
    var id = "popup";
    msg = msg || "";
    cls = cls || "";

    if (popup = document.querySelector("#" + id)) {
        popup.message.innerHTML = msg;
        popup.className = cls;
        popup.resize();
    } else {
        var popup = document.createElement("div");
        var style = popup.style = document.createElement("style");
        var modal = popup.modal = document.createElement("div");
        var content = popup.content = document.createElement("div");
        var message = popup.message = document.createElement("div");

        popup.id = id;
        popup.className = cls;
        modal.className = "modal";
        content.className = "content";
        message.className = "message";

        popup.disappear = function () {
            if (popup.parentNode) {
                popup.parentNode.removeChild(popup);
            }
        };
        modal.onclick = popup.disappear;

        message.innerHTML = msg;

        content.appendChild(message);

        popup.appendChild(style);
        popup.appendChild(modal);
        popup.appendChild(content);

        document.body.appendChild(popup);

        popup.resize = function () {
            style.innerHTML = "#" + id + " .content{width:"
                + message.offsetWidth + "px;height:" + message.offsetHeight + "px}";
        };
        popup.resize();
        window.addEventListener("resize", popup.resize);
    }

    return popup;
};

/**
 *
 * @param arr
 * @param idx
 * @param data_attr
 * @param loading
 */
web.popupImages = function (arr, idx, data_attr, loading) {
    if (!arr) return;
    if (!idx) idx = 0;
    if (!data_attr) data_attr = {};
    if (!data_attr.src) data_attr.src = "src";
    // if (!data_attr.loaded) data_attr.loaded = "data-loaded";
    if (!loading) loading = {"start": function () {}, "finish": function () {}};

    var temp_image = new Image();
    temp_image.src = arr[idx].getAttribute(data_attr.src);
    // if (!arr[idx].getAttribute(data_attr.loaded)) {
    if (!web.loadedImages.has(arr[idx].getAttribute(data_attr.src))) {
        loading.start();
    }
    temp_image.onload = function () {
        loading.finish();
        // arr[idx].setAttribute(data_attr.loaded, 1);
        web.loadedImages.add(arr[idx].getAttribute(data_attr.src));

        var popup = web.popup(
            "<img src='" + arr[idx].getAttribute(data_attr.src) + "'>" +
            "<button type='button' class='prev-btn'><i class='icon prev-icon'></i></button>" +
            "<button type='button' class='next-btn'><i class='icon next-icon'></i></button>" +
            "<button type='button' class='close-btn'><i class='icon close-icon'></i></button>",
            "images-popup"
        );
        var image = popup.image = popup.querySelector("img");
        var next_btn = popup.next_btn = popup.querySelector(".next-btn");
        var prev_btn = popup.prev_btn = popup.querySelector(".prev-btn");
        var close_btn = popup.close_btn = popup.querySelector(".close-btn");
        next_btn.onclick = function () {
            if (!arr[++idx]) {
                idx = 0;
            }
            changeImage(idx);
        };
        prev_btn.onclick = function () {
            if (!arr[--idx]) {
                idx = arr.length - 1;
            }
            changeImage(idx);
        };
        close_btn.onclick = popup.disappear;

        var angle_small = 20, angle_large = 45;
        var angle = angle_small;
        var scrollLeft0 = 0;
        var scrollTop0 = 0;
        var image_full_size = false;
        var tapped = false;
        popup.addEventListener("touchstart", function(event){
            if(!tapped){ //if tap is not set, set up single tap
                tapped = setTimeout(function(){
                    tapped = null;
                    //insert things you want to do when single tapped
                },300);   //wait 300ms then run single click code
            } else {    //tapped within 300ms of last tap. double tap
                clearTimeout(tapped); //stop single tap callback
                tapped = null;
                //insert things you want to do when double tapped
                image_full_size = !image_full_size;
                if (image_full_size) {
                    angle = angle_large;
                } else {
                    angle = angle_small;
                }
                popup.imageResize();
            }
            // event.preventDefault()
        });
        popup.imageResize = function() {
            if (window.getComputedStyle(image, null).getPropertyValue("max-width") === "none"
                || window.getComputedStyle(image, null).getPropertyValue("max-height") === "none"
            ) {
                if (!image_full_size) {
                    if (image.width / image.height > window.innerWidth / window.innerHeight) {
                        // "lim-height";
                        image.style.maxWidth = "none";
                        image.style.maxHeight = window.innerHeight + "px";
                    } else {
                        // "lim-width";
                        image.style.maxWidth = window.innerWidth + "px";
                        image.style.maxHeight = "none";
                    }
                } else {
                    image.style.maxWidth = "none";
                    image.style.maxHeight = "none";
                }
            }
            popup.message.style.width = image.offsetWidth + "px";
            popup.message.style.height = image.offsetHeight + "px";
            scrollLeft0 = popup.content.scrollLeft = (popup.message.offsetWidth - window.innerWidth) / 2;
            scrollTop0 = popup.content.scrollTop = (popup.message.offsetHeight - window.innerHeight) / 2;
        };
        popup.imageResize();
        window.addEventListener("resize", popup.imageResize);
        if (web.detectMobile()) {
            var ay, ay0 = null;
            var ax, ax0 = null;
            var wpa, hpa;
            var auto_scroll = true;
            var reset_angle = true;
            window.addEventListener('deviceorientation', function(event) {
                wpa = (popup.message.offsetWidth - popup.content.clientWidth) / angle; // length/angle
                hpa = (popup.message.offsetHeight - popup.content.clientHeight) / angle; // height/angle

                var beta = event.beta;
                var gamma = event.gamma;
                if (Math.abs(beta) >  90) {
                    beta = 90 * beta / Math.abs(beta);
                }
                if (window.innerWidth > window.innerHeight) {
                    ax = beta;
                    ay = gamma;
                } else {
                    ax = gamma;
                    ay = beta;
                }

                if (reset_angle) {
                    if (ax0 !== null) {
                        scrollLeft0 = parseInt(popup.content.scrollLeft - wpa * (ax - ax0));
                    }
                    if (ay0 !== null) {
                        scrollTop0 = parseInt(popup.content.scrollTop - hpa * (ay - ay0));
                    }
                    ay0 = ay;
                    ax0 = ax;
                    reset_angle = false;
                }
                if (auto_scroll) {
                    web.smoothScroll(popup.content, parseInt(scrollLeft0 - wpa * (ax - ax0)), 100, true);
                    web.smoothScroll(popup.content, parseInt(scrollTop0 - hpa * (ay - ay0)), 100, false);
                }
            }, true);
            popup.ontouchstart = popup.ontouchmove = function () {
                reset_angle = true;
                auto_scroll = false;
            };
            popup.ontouchend = popup.ontouchcancel = function () {
                reset_angle = true;
                auto_scroll = true;
            };
        }

        function changeImage(idx) {
            var temp_image = new Image();
            temp_image.src = arr[idx].getAttribute(data_attr.src);
            // if (!arr[idx].getAttribute(data_attr.loaded)) {
            if (!web.loadedImages.has(arr[idx].getAttribute(data_attr.src))) {
                loading.start();
            }
            temp_image.onload = function () {
                loading.finish();
                image.src = arr[idx].getAttribute(data_attr.src);
                // arr[idx].setAttribute(data_attr.loaded, 1);
                web.loadedImages.add(arr[idx].getAttribute(data_attr.src));
                popup.imageResize();
                popup.resize();
            };
            temp_image.onerror = function () {
                loading.finish();
            };
        }
    };
    temp_image.onerror = function () {
        loading.finish();
    };
};

/**
 *
 * @param msg
 * @param cls
 * @param container
 * @returns {*|Element}
 */
web.loading = function (msg, cls, container) {
    var id = "loading";
    msg = msg || "";
    cls = cls || "";
    container = container || document.body;

    if (loading = document.getElementById(id)) {
        loading.message.innerHTML = msg;
        loading.className = cls;
        loading.resize();
    } else {
        var loading = document.createElement("DIV");
        var content = loading.content = document.createElement("DIV");
        var message = loading.message = document.createElement("DIV");
        var style = loading.style = document.createElement("STYLE");

        loading.id = id;
        loading.className = cls;
        content.className = "content";
        message.className = "message";
        message.innerHTML = msg;

        content.appendChild(message);

        loading.appendChild(style);
        loading.appendChild(content);
        loading.finish = function () {
            if (loading.parentNode) {
                loading.parentNode.removeChild(loading);
            }
        };

        container.appendChild(loading);

        loading.resize = function () {
            style.innerHTML = "#" + loading.id + " ." + content.className
                + "{width:" + message.offsetWidth + "px;height:" + message.offsetHeight + "px}";
        };
        loading.resize();
        window.addEventListener("resize", loading.resize);
    }

    return loading;
};

/**
 *
 * @param e
 * @param etc
 */
web.ellipsisText = function (e, etc) {
    var wordArray = e.innerHTML.split(" ");
    while (e.scrollHeight > e.offsetHeight) {
        wordArray.pop();
        e.innerHTML = wordArray.join(" ") + (etc || "...");
    }
};

/**
 *
 * @param es
 * @param etc
 */
web.ellipsisTexts = function (es, etc) {
    [].forEach.call(es, function (e) {
        e.myText = e.innerHTML;
    });
    main();
    window.onresize = main;
    function main () {
        [].forEach.call(es, function (e) {
            e.innerHTML = e.myText;
            web.ellipsisText(e, etc);
        });
    }
};

/**
 *
 * @property loadedImages
 */
web.loadedImages = {
    "add": function (src) {
        if (!web.loaded_images) {
            web.loaded_images = [];
        }
        if (web.loaded_images.indexOf(src) < 0) {
            web.loaded_images.push(src);
        }
    },
    "has": function (src) {
        return (web.loaded_images && web.loaded_images.indexOf(src) >= 0);
    }
};

/**
 *
 * @param imgs
 * @param zoom
 * @param lens_bg
 * @param data_attr
 * @param loading
 * @param min_zoom_covered_rate
 */
web.zoomImages = function (imgs, zoom, lens_bg, data_attr, loading, min_zoom_covered_rate) {
    if (!imgs || !zoom || web.detectMobile()) {
        return;
    }
    if (!lens_bg) {
        lens_bg = "data:image/gif;base64,R0lGODlhAQABAIAAAP///wAAACH5BAEAAAAALAAAAAABAAEAAAICRAEAOw==";
    }
    if (!data_attr) {
        data_attr = {};
    }
    if (!data_attr.src) {
        data_attr.src = "src";
    }
    if (!min_zoom_covered_rate) {
        min_zoom_covered_rate = 1;
    }
    if (!loading) {
        loading = {
            "start": function () {},
            "finish": function () {}
        };
    }

    var magnifier = document.createElement("div");
    magnifier.style.display = "none";
    magnifier.style.position = "fixed";
    magnifier.style.pointerEvents = "none";
    magnifier.style.backgroundImage = lens_bg ? "url('" + lens_bg + "')" : "";
    magnifier.style.backgroundRepeat = "repeat";
    document.body.appendChild(magnifier);

    [].forEach.call(imgs, function (img) {
        img.onmousemove = function (event) {
            event = window.event || event;
            var self = this;
            var image = zoom.querySelector("img");
            if (!image) {
                image = new Image();
                // console.log("loaded="+self.getAttribute(data_attr.loaded));
                // if (!self.getAttribute(data_attr.loaded)) {
                if (!web.loadedImages.has(self.getAttribute(data_attr.src))) {
                    // image.src = self.src;
                    loading.start(zoom);
                    var temp_image = new Image();
                    temp_image.src = self.getAttribute(data_attr.src);
                    temp_image.onload = function () {
                        loading.finish();
                        image.src = temp_image.src;
                        // self.setAttribute(data_attr.loaded, 1);
                        web.loadedImages.add(self.getAttribute(data_attr.src));
                    };
                    temp_image.onerror = function () {
                        loading.finish();
                    }
                } else {
                    image.src = self.getAttribute(data_attr.src);
                }

                image.style.position = "absolute";
                zoom.appendChild(image);
            }
            var rect = this.getBoundingClientRect();
            var x = event.clientX - rect.left;
            var y = event.clientY - rect.top;
            // @TODO: Make zoom area always covered by image
            var min_zoom_covered_wid = min_zoom_covered_rate * zoom.clientWidth;
            var min_zoom_covered_hei = min_zoom_covered_rate * zoom.clientHeight;
            if (x < (min_zoom_covered_wid / 2) * rect.width / image.width) {
                x = (min_zoom_covered_wid / 2) * rect.width / image.width;
            }
            if (x > (image.width - min_zoom_covered_wid / 2) * rect.width / image.width) {
                x = (image.width - min_zoom_covered_wid / 2) * rect.width / image.width;
            }
            if (y < (min_zoom_covered_hei / 2) * rect.height / image.height) {
                y = (min_zoom_covered_hei / 2) * rect.height / image.height;
            }
            if (y > (image.height - min_zoom_covered_hei / 2) * rect.height / image.height) {
                y = (image.height - min_zoom_covered_hei / 2) * rect.height / image.height;
            }
            // ./
            image.style.left = (zoom.clientWidth / 2) - (x / rect.width) * image.width + "px";
            image.style.top = (zoom.clientHeight / 2) - (y / rect.height) * image.height + "px";
            var mag_wid = zoom.clientWidth * rect.width / image.width;
            var mag_hei = zoom.clientHeight * rect.height / image.height;
            magnifier.style.width = mag_wid + "px";
            magnifier.style.height = mag_hei + "px";
            magnifier.style.left = rect.left + x - mag_wid / 2 + "px";
            magnifier.style.top = rect.top + y - mag_hei / 2 + "px";
            magnifier.style.display = "block";
        };
        img.onmouseout = function () {
            while (zoom.firstChild) {
                zoom.removeChild(zoom.firstChild);
            }
            magnifier.style.display = "none";
        };
    });
};

/**
 *
 * @param number
 * @param decimals
 * @param abbrev
 * @returns {*}
 */
web.abbreviateNumber = function (number, decimals, abbrev) {
    // Copy from: http://stackoverflow.com/questions/10599933/convert-long-number-into-abbreviated-string-in-javascript-with-a-special-shortn
    // Auth: http://stackoverflow.com/users/179216/jeff-b

    // 2 decimal places => 100, 3 => 1000, etc
    if (!decimals) decimals = 1;
    decimals = Math.pow(10, decimals);

    // Enumerate number abbreviations
    if (!abbrev) abbrev = ["k", "m", "b", "t"];

    // Go through the array backwards, so we do the largest first
    for (var i = abbrev.length - 1; i >= 0; i--) {

        // Convert array index to "1000", "1000000", etc
        var size = Math.pow(10, (i + 1) * 3);

        // If the number is bigger or equal do the abbreviation
        if (size <= number) {
            // Here, we multiply by decimals, round, and then divide by decimals.
            // This gives us nice rounding to a particular decimal place.
            number = Math.round(number * decimals / size) / decimals;

            // Handle special case where we round up to the next abbreviation
            if ((number == 1000) && (i < abbrev.length - 1)) {
                number = 1;
                i++;
            }

            // Add the letter for the abbreviation
            number += abbrev[i];

            // We are done... stop
            break;
        }
    }

    return number;
};

/**
 *
 * @param date
 * @param units
 * @returns {*}
 */
web.timeAgo = function (date, units) {
    if (!units) {
        units = [
            " years",
            " months",
            " days",
            " hours",
            " minutes",
            " seconds"
        ];
    }

    var seconds = Math.floor((new Date() - date) / 1000);
    var interval = Math.floor(seconds / 31536000);

    if (interval > 1) {
        return interval + units[0];
    }
    interval = Math.floor(seconds / 2592000);
    if (interval > 1) {
        return interval + units[1];
    }
    interval = Math.floor(seconds / 86400);
    if (interval > 1) {
        return interval + units[2];
    }
    interval = Math.floor(seconds / 3600);
    if (interval > 1) {
        return interval + units[3];
    }
    interval = Math.floor(seconds / 60);
    if (interval > 1) {
        return interval + units[4];
    }

    return Math.floor(seconds) + units[5];
};

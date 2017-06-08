/**
 * Created by User on 6/9/2017.
 */
var web = {};
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
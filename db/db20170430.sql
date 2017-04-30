-- phpMyAdmin SQL Dump
-- version 4.0.10.12
-- http://www.phpmyadmin.net
--
-- Host: 127.6.245.2:3306
-- Generation Time: Apr 30, 2017 at 09:39 AM
-- Server version: 5.5.52
-- PHP Version: 5.3.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `quyettran_com`
--

-- --------------------------------------------------------

--
-- Table structure for table `article`
--

CREATE TABLE IF NOT EXISTS `article` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `creator_id` int(11) DEFAULT NULL,
  `updater_id` int(11) DEFAULT NULL,
  `image_id` int(11) DEFAULT NULL,
  `category_id` int(11) DEFAULT NULL,
  `slug` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `meta_title` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `meta_description` varchar(511) COLLATE utf8_unicode_ci DEFAULT NULL,
  `meta_keywords` varchar(511) COLLATE utf8_unicode_ci DEFAULT NULL,
  `description` varchar(511) COLLATE utf8_unicode_ci DEFAULT NULL,
  `content` text COLLATE utf8_unicode_ci,
  `sub_content` text COLLATE utf8_unicode_ci,
  `active` smallint(1) DEFAULT NULL,
  `visible` smallint(1) DEFAULT NULL,
  `featured` smallint(1) DEFAULT NULL,
  `type` smallint(6) DEFAULT NULL,
  `status` smallint(6) DEFAULT NULL,
  `sort_order` int(11) DEFAULT NULL,
  `create_time` int(11) DEFAULT NULL,
  `update_time` int(11) DEFAULT NULL,
  `publish_time` int(11) DEFAULT NULL,
  `view_count` int(11) DEFAULT NULL,
  `like_count` int(11) DEFAULT NULL,
  `comment_count` int(11) DEFAULT NULL,
  `share_count` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `slug` (`slug`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=24 ;

--
-- Dumping data for table `article`
--

INSERT INTO `article` (`id`, `creator_id`, `updater_id`, `image_id`, `category_id`, `slug`, `name`, `meta_title`, `meta_description`, `meta_keywords`, `description`, `content`, `sub_content`, `active`, `visible`, `featured`, `type`, `status`, `sort_order`, `create_time`, `update_time`, `publish_time`, `view_count`, `like_count`, `comment_count`, `share_count`) VALUES
(1, 7, 7, 1, NULL, 'css-vertical-align-div', 'CSS vertical align div', 'CSS vertical align div', 'CSS: vertical align div inside another div at middle position. Pros and cons comparison of different solutions.', 'css vertical align div, vertical align div', 'CSS: vertical align div inside another div at middle position. Pros and cons comparison of different solutions.', '<section>\r\n<h2>1. CSS vertical align div using margin auto on item has position absolute</h2>\r\n<div class="code-example">\r\n<code>\r\n<!-- CSS -->\r\n<style>\r\n    .container {\r\n        width: 100%;\r\n        height: 100px;\r\n        border: 2px solid red;\r\n        position: relative;\r\n    }\r\n    .item {\r\n        width: 25%;\r\n        height: 25%;\r\n        margin: auto;\r\n        top: 0;\r\n        bottom: 0;\r\n        left: 0;\r\n        right: 0;\r\n        position: absolute;\r\n        background: green;\r\n    }\r\n</style>\r\n<!-- HTML -->\r\n<div class="container">\r\n    <div class="item">\r\n        Text here...\r\n    </div>\r\n</div>\r\n</code>\r\n</div>\r\n</section>\r\n\r\n<section>\r\n<h2>2. CSS vertical align div using vertical-align property of table cell</h2>\r\n<div class="code-example">\r\n<code>\r\n<!-- CSS -->\r\n<style>\r\n    .container {\r\n        height: 100px;\r\n        display: table-cell;\r\n        vertical-align: middle;\r\n        text-align: center;\r\n        border: solid 2px red;\r\n        width: 200px;\r\n    }\r\n    .item {\r\n        display: inline-block;\r\n        background: green;\r\n    }\r\n</style>\r\n<!-- HTML -->\r\n<div class="container">\r\n    <div class="item">\r\n        Text here...\r\n    </div>\r\n</div>\r\n</code>\r\n</div>\r\n<p>\r\n    By this way, we cannot set size by percent unit for container element,\r\n    but you can add element display as table to wrap it, and set width for this element as below:\r\n</p>\r\n<div class="code-example">\r\n<code>\r\n<!-- CSS -->\r\n<style>\r\n    .container {\r\n        display: table;\r\n        width: 100%;\r\n        border: solid 2px red;\r\n    }\r\n    .container-row {\r\n        display: table-row;\r\n    }\r\n    .container-cell {\r\n        height: 100px;\r\n        display: table-cell;\r\n        vertical-align: middle;\r\n        text-align: center;\r\n    }\r\n    .item {\r\n        display: inline-block;\r\n        background: green;\r\n    }\r\n</style>\r\n<!-- HTML -->\r\n<div class="container">\r\n    <div class="container-row">\r\n        <div class="container-cell">\r\n            <div class="item">\r\n                Text here...\r\n            </div>\r\n        </div>\r\n    </div>\r\n</div>\r\n</code>\r\n</div>\r\n</section>\r\n\r\n<section>\r\n<h2>3. CSS vertical align div using flex box</h2>\r\n<div class="code-example">\r\n<code>\r\n<!-- CSS -->\r\n<style>\r\n    .container {\r\n        width: 100%;\r\n        display: flex;\r\n        align-items: center; /* vertical align div */\r\n        justify-content: center; /* horizontal align */\r\n        border: 2px solid red;\r\n        height: 100px;\r\n    }\r\n    .item {\r\n        background: green;\r\n    }\r\n</style>\r\n<!-- HTML -->\r\n<div class="container">\r\n    <div class="item">\r\n        Text here...\r\n    </div>\r\n</div>\r\n</code>\r\n</div>\r\n</section>\r\n\r\n<section>\r\n<h2>Compare solutions</h2>\r\n<div class="table-wrap">\r\n    <table>\r\n        <tr>\r\n            <th>&nbsp;</th>\r\n            <th>Margin auto and display absolute</th>\r\n            <th>Table cell vertical align</th>\r\n            <th>Flex box</th>\r\n        </tr>\r\n        <tr>\r\n            <th>Container display</th>\r\n            <td>block, inline-block</td>\r\n            <td>table</td>\r\n            <td>flex</td>\r\n        </tr>\r\n        <tr>\r\n            <th>Item display</th>\r\n            <td>block, table, inline-block</td>\r\n            <td>block, table, inline-block, inline</td>\r\n            <td>block, table, inline-block, inline</td>\r\n        </tr>\r\n        <tr>\r\n            <th>Item height</th>\r\n            <td>Specified</td>\r\n            <td>Can adjust to content</td>\r\n            <td>Can adjust to content</td>\r\n        </tr>\r\n    </table>\r\n</div>\r\n</section>', NULL, 1, NULL, NULL, NULL, NULL, NULL, 1491390472, 1492853216, 1491390000, NULL, NULL, NULL, NULL),
(2, 7, 7, 4, NULL, 'css-selector', 'CSS selector', 'CSS selector', '', '', '', 'CSS', NULL, 0, NULL, NULL, NULL, NULL, NULL, 1491464713, 1491713977, 1491462000, NULL, NULL, NULL, NULL),
(3, 7, 7, NULL, NULL, 'css-custom-checkbox-style', 'CSS custom checkbox style', 'CSS custom checkbox style', 'CSS custom checkbox style with different sizes, colors and effects', 'css custom checkbox, css custom checkbox style', 'CSS custom checkbox style with different sizes, colors and effects', 'By default, we cannot edit style of checkbox and radio input, without size.\r\nBut if you still want to make up them, you can create a "fake" checkbox or radio input and hidden "real", hidden but still active.\r\nFirst, in HTML you put checkbox or radio input into label tag, this make user can click esier on label instead of only input.\r\n\r\n<section>\r\n<h2>Change style of radio input</h2>\r\n<div class="code-example">\r\n<code>\r\n<!-- CSS -->\r\n<style>\r\n    label.radio input {\r\n        position: absolute;\r\n        top: 0;\r\n        left: 0;\r\n        visibility: hidden;\r\n        pointer-events: none;\r\n    }\r\n    label.radio input + b {\r\n        /*\r\n         * Using em unit to make its size adjust to context\r\n         */\r\n        width: 1em;\r\n        height: 1em;\r\n        display: inline-block;\r\n        border-radius: 100%;\r\n        border: 1px solid #06b;\r\n        background-color: #fff;\r\n        background-position: center;\r\n        background-repeat: no-repeat;\r\n        background-size: auto;\r\n    }\r\n    label.radio input:checked + b {\r\n        /*\r\n         * Using background-image instead of CSS\r\n         * If using CSS, we will create pseudo element such as b:before\r\n         * and make it stay at center of b tag\r\n         * But with em unit, almost browser cannot make it exactly at center\r\n         */\r\n        background-image: url(''data:image/svg+xml;utf8,<svg xmlns="http:%2F%2Fwww.w3.org%2F2000%2Fsvg" xmlns:xlink="http:%2F%2Fwww.w3.org%2F1999%2Fxlink" version="1.1" viewBox="0 0 100 100"><circle cx="50" cy="50" r="30" fill="%2306b"%2F><%2Fsvg>'');\r\n    }\r\n    label.radio * {\r\n        vertical-align: middle;\r\n    }\r\n</style>\r\n<!-- HTML -->\r\n<form>\r\n    <label class="radio">\r\n        <input type="radio" name="my-choice" value="1" checked>\r\n        <b></b>\r\n        <span>Choice 1</span>\r\n    </label>\r\n    <label class="radio">\r\n        <input type="radio" name="my-choice" value="2">\r\n        <b></b>\r\n        <span>Choice 2</span>\r\n    </label>\r\n    <label class="radio">\r\n        <input type="radio" name="my-choice" value="3">\r\n        <b></b>\r\n        <span>Choice 3</span>\r\n    </label>\r\n</form>\r\n</code>\r\n</div>\r\n</section>\r\n\r\n<section>\r\n<h2>Change style of checkbox input</h2>\r\n<div class="code-example">\r\n<code>\r\n<!-- CSS -->\r\n<style>\r\n    label.checkbox input {\r\n        position: absolute;\r\n        top: 0;\r\n        left: 0;\r\n        visibility: hidden;\r\n        pointer-events: none;\r\n    }\r\n    label.checkbox input + b {\r\n        /*\r\n         * Using em unit to make its size adjust to context\r\n         */\r\n        width: 1em;\r\n        height: 1em;\r\n        display: inline-block;\r\n        border: 1px solid #06b;\r\n        background-color: #fff;\r\n        position: relative;\r\n    }\r\n    label.checkbox input:checked + b:after {\r\n        \r\n        content: "";\r\n        display: block;\r\n        \r\n        /*\r\n         * Align center\r\n         */\r\n        position: absolute;\r\n        margin: auto;\r\n        top: 0;\r\n        right: 0;\r\n        bottom: 0;\r\n        left: 0;\r\n        \r\n        /*\r\n         * Make it look like tick icon\r\n         */\r\n        width: 0.2em;\r\n        height: 0.65em;\r\n        border: solid #06b;\r\n        border-width: 0 0.2em 0.2em 0;\r\n        transform: rotate(45deg);\r\n    }\r\n    label.checkbox * {\r\n        vertical-align: middle;\r\n    }\r\n</style>\r\n<!-- HTML -->\r\n<form>\r\n    <label class="checkbox">\r\n        <input type="checkbox" name="my-choices" value="1" checked>\r\n        <b></b>\r\n        <span>Choice 1</span>\r\n    </label>\r\n    <label class="checkbox">\r\n        <input type="checkbox" name="my-choices" value="2" checked>\r\n        <b></b>\r\n        <span>Choice 2</span>\r\n    </label>\r\n    <label class="checkbox">\r\n        <input type="checkbox" name="my-choices" value="3">\r\n        <b></b>\r\n        <span>Choice 3</span>\r\n    </label>\r\n</form>\r\n</code>\r\n</div>\r\n</section>\r\n', NULL, 1, NULL, NULL, NULL, NULL, NULL, 1491726824, 1492421423, 1491726000, NULL, NULL, NULL, NULL),
(4, 7, 7, NULL, NULL, 'create-javascript-popup-to-show-messages-or-images', 'Create JavaScript popup to show messages or images', 'Create JavaScript popup to show messages or images', 'Create JavaScript popup to show messages, images, or somethings else...', 'create javascript popup, javascript popup', 'Create JavaScript popup to show messages, images, or somethings else...', '<div class="code-example">\r\n<code>\r\n<!-- CSS -->\r\n<style>\r\n    body {\r\n        min-height: 200px;\r\n    }\r\n    .popup {\r\n        position: fixed;\r\n        top: 0;\r\n        right: 0;\r\n        bottom: 0;\r\n        left: 0;\r\n        display: flex;\r\n		align-items: center; /* Vertical align */\r\n		justify-content: center; /* Horizontal align */\r\n    }\r\n    .popup .popup-body {\r\n        position: relative;\r\n        background: #fff;\r\n        padding: calc(1em + 2vh) calc(1em + 2vw);\r\n        max-width: 100%;\r\n        max-height: 100%;\r\n        border: 1px solid #999;\r\n        box-sizing: border-box;\r\n        box-shadow: 0 0 5em rgba(0, 0, 0, 0.3);\r\n    }\r\n    .popup .popup-close-button {\r\n        position: absolute;\r\n        top: -1px;\r\n        right: -1px;\r\n    }\r\n    .popup .popup-close-button:after {\r\n        content: "X";\r\n    }\r\n</style>\r\n<!-- JavaScript -->\r\n<script>\r\n    function showPopup(msg)\r\n    {\r\n        var popup = document.createElement("DIV");\r\n        popup.className = "popup";\r\n        \r\n        popup.body = document.createElement("DIV");\r\n        popup.body.className = "popup-body";\r\n        \r\n        popup.message = document.createElement("DIV");\r\n        popup.message.className = "popup-message";\r\n        \r\n        popup.closeButton = document.createElement("BUTTON");\r\n        popup.closeButton.className = "popup-close-button";\r\n        \r\n        popup.body.appendChild(popup.message);\r\n        popup.body.appendChild(popup.closeButton);\r\n        popup.appendChild(popup.body);\r\n        \r\n        popup.open = function () {\r\n            document.body.appendChild(popup);\r\n        }\r\n        \r\n        popup.close = function () {\r\n            popup.parentNode.removeChild(popup);\r\n        }\r\n        \r\n        popup.addEventListener("click", function (event) {\r\n            if (event.target === popup || event.target === popup.closeButton) {\r\n                popup.close();\r\n            }\r\n        });\r\n        \r\n        popup.message.innerHTML = msg;\r\n        popup.open();\r\n        \r\n        return popup;\r\n    }\r\n</script>\r\n<!-- Try it -->\r\n<button onclick="showPopup(''Hello!!'')">Show popup</button>\r\n</code>\r\n</div>', NULL, 1, NULL, NULL, NULL, NULL, NULL, 1491759231, 1492422893, 1491759000, NULL, NULL, NULL, NULL),
(5, 7, 7, NULL, NULL, 'javascript-upload-image-preview', 'JavaScript upload image preview', 'JavaScript upload image preview', 'JavaScript preview image before upload, single image or multiple images', 'javascript upload image preview, javascript preview image', 'JavaScript preview image before upload, single image or multiple images', '<div class="code-example">\r\n<code>\r\n<!-- CSS -->\r\n<style>\r\nform {\r\n    border: 1px solid;\r\n}\r\nlabel {\r\n    display: block;\r\n    margin: 10px;\r\n}\r\n.image-preview-container img {\r\n    display: inline-block;\r\n    max-width: 50px;\r\n}\r\n</style>\r\n\r\n<!-- HTML -->\r\n<form>\r\n    <label>\r\n        <div>Upload an image</div>\r\n        <input type="file" name="image">\r\n    </label>\r\n</form>\r\n<form>\r\n    <label>\r\n        <div>Upload my images</div>\r\n        <input type="file" name="my-images" multiple>\r\n    </label>\r\n</form>\r\n\r\n<!-- JavaScript -->\r\n<script>\r\n// @TODO: Select all inputs whose type is file and name contains the substring "image"\r\nvar inputs = document.querySelectorAll("input[type=file][name*=image]");\r\n[].forEach.call(inputs, function (input) {\r\n    input.addEventListener("change", function () {\r\n        // @TODO: Prepare an image preview container\r\n        var previewContainer = input.parentNode.querySelector(".image-preview-container");\r\n        if (previewContainer) {\r\n            // @TODO: Empty container\r\n            while(previewContainer.firstChild) {\r\n                previewContainer.removeChild(previewContainer.firstChild);\r\n            }\r\n        } else {\r\n            // @TODO: Create new container\r\n            previewContainer = document.createElement("DIV");\r\n            previewContainer.className = "image-preview-container";\r\n            input.parentNode.insertBefore(previewContainer, input);\r\n        }\r\n        \r\n        [].forEach.call(input.files, function (file) {\r\n            // @TODO: Read image file as URL\r\n            var reader = new FileReader();\r\n            if (reader.readAsDataURL) {\r\n                reader.readAsDataURL(file);\r\n            } else if (reader.readAsDataurl) {\r\n                reader.readAsDataurl(file);\r\n            } else {\r\n                throw "Browser does not support.";\r\n            }\r\n            \r\n            // @TODO: Append image preview\r\n            var preview = document.createElement("IMG");\r\n            reader.addEventListener("load", function () {\r\n                preview.src = reader.result;\r\n                previewContainer.appendChild(preview);\r\n            });\r\n        });\r\n    });\r\n});\r\n</script>\r\n</code>\r\n</div>\r\n', NULL, 1, NULL, NULL, NULL, NULL, NULL, 1491824757, 1492706925, 1491825000, NULL, NULL, NULL, NULL),
(6, 7, 7, NULL, NULL, 'zoom-image-on-hover-with-javascript', 'Zoom image on hover with JavaScript', 'Zoom image on hover with JavaScript', 'Zoom image on hover will show image more detail and clearly, similar to using a magnifier!', 'Zoom image on hover with JavaScript, zoom image on hover', 'Zoom image on hover will show image more detail and clearly, similar to using a magnifier!', '<h2>Create simple JavaScript function to zoom image when move mouse on</h2>\r\n<div class="code-example">\r\n<code>\r\n<!-- CSS -->\r\n<style>\r\n    * {\r\n        /* Normalize */\r\n        position: relative;\r\n        box-sizing: border-box; /* Size of element will include padding and border */\r\n        margin: 0;\r\n        padding: 0;\r\n    }\r\n    img {\r\n        width: auto;\r\n        height: auto;\r\n    }\r\n    .image-wrapper img {\r\n        max-width: 100%;\r\n        max-height: 100%;\r\n    }\r\n    .image-wrapper,\r\n    .zoom-box {\r\n        width: 200px;\r\n        border: 1px solid #999;\r\n        float: left;\r\n        margin: 10px;\r\n        overflow: hidden;\r\n    }\r\n    .zoom-box {\r\n        height: 200px;\r\n    }\r\n</style>\r\n\r\n<!-- HTML -->\r\n<div class="image-wrapper">\r\n    {% Image(4)->imgTag() %}\r\n</div>\r\n<div class="zoom-box">\r\n    <!-- Zoomed image will display here -->\r\n</div>\r\n\r\n<!-- JavaScript -->\r\n<script>\r\n    var imageWrapper = document.querySelector(".image-wrapper");\r\n    var image = imageWrapper.querySelector("img");\r\n    \r\n    var zoomBox = document.querySelector(".zoom-box");\r\n    var zImage = new Image();\r\n    zImage.src = image.src;\r\n    \r\n    imageWrapper.addEventListener("mouseover", zoomStart);\r\n    imageWrapper.addEventListener("mousemove", zoomMove);\r\n    imageWrapper.addEventListener("mouseout", zoomEnd);\r\n    \r\n    function zoomMove(event) {\r\n        event = event || window.event;\r\n        // The Element.getBoundingClientRect() method returns the size of an element and its position relative to the viewport.\r\n        // Here, Element is image we want to zoom\r\n        var imageRect = image.getBoundingClientRect();\r\n        // Get coordinate of pointer (mouse) on image\r\n        // Measured from upper left corner\r\n        var x = event.clientX - imageRect.left;\r\n        var y = event.clientY - imageRect.top;\r\n        \r\n        zImage.style.left = (zoomBox.clientWidth / 2) - (x * zImage.width / imageRect.width) + "px";\r\n        zImage.style.top = (zoomBox.clientHeight / 2) - (y * zImage.height / imageRect.height) + "px";\r\n    }\r\n    function zoomStart() {\r\n        // Put zImage into zoomBox\r\n        zoomBox.appendChild(zImage);\r\n    }\r\n    function zoomEnd() {\r\n        // Remove zImage from container (but zImage object still exists)\r\n        zImage.parentNode.removeChild(zImage);\r\n    }\r\n</script>\r\n</code>\r\n</div>\r\n\r\n<h2>Adds the "magnifier" to show zoomed area on image</h2>\r\n<div class="code-example">\r\n<code>\r\n<!-- CSS -->\r\n<style>\r\n    * {\r\n        /* Normalize */\r\n        position: relative;\r\n        box-sizing: border-box; /* Size of element will include padding and border */\r\n        margin: 0;\r\n        padding: 0;\r\n    }\r\n    img {\r\n        width: auto;\r\n        height: auto;\r\n    }\r\n    .image-wrapper img {\r\n        max-width: 100%;\r\n        max-height: 100%;\r\n    }\r\n    .image-wrapper,\r\n    .zoom-box {\r\n        width: 200px;\r\n        border: 1px solid #999;\r\n        float: left;\r\n        margin: 10px;\r\n        overflow: hidden;\r\n    }\r\n    .zoom-box {\r\n        height: 200px;\r\n    }\r\n    .magnifier {\r\n        position: absolute;\r\n        pointer-events: none;\r\n        background: #eee;\r\n        opacity: 0.5;\r\n        border: 1px solid red;\r\n    }\r\n</style>\r\n\r\n<!-- HTML -->\r\n<div class="image-wrapper">\r\n    {% Image(5)->imgTag() %}\r\n</div>\r\n<div class="zoom-box">\r\n</div>\r\n\r\n<!-- JavaScript -->\r\n<script>\r\n    var imageWrapper = document.querySelector(".image-wrapper");\r\n    var image = imageWrapper.querySelector("img");\r\n    \r\n    var zoomBox = document.querySelector(".zoom-box");\r\n    var zImage = new Image();\r\n    zImage.src = image.src;\r\n    \r\n    var magnifier = document.createElement("DIV");\r\n    magnifier.className = "magnifier";\r\n    \r\n    imageWrapper.addEventListener("mouseover", zoomStart);\r\n    imageWrapper.addEventListener("mousemove", zoomMove);\r\n    imageWrapper.addEventListener("mouseout", zoomEnd);\r\n    \r\n    function zoomMove(event) {\r\n        event = event || window.event;\r\n        \r\n        var imageRect = image.getBoundingClientRect();\r\n        var x = event.clientX - imageRect.left;\r\n        var y = event.clientY - imageRect.top;\r\n        \r\n        zImage.style.left = (zoomBox.clientWidth / 2) - (x * zImage.width / imageRect.width) + "px";\r\n        zImage.style.top = (zoomBox.clientHeight / 2) - (y * zImage.height / imageRect.height) + "px";\r\n        \r\n        // Calculate size for magnifier\r\n        var magWidth = zoomBox.clientWidth * imageRect.width / zImage.width;\r\n        var magHeight = zoomBox.clientWidth * imageRect.width / zImage.width;\r\n        magnifier.style.width = magWidth + "px"; \r\n        magnifier.style.height = magHeight + "px";\r\n        \r\n        // Calculate coordinate for magnifier on imageWrapper\r\n        // Condition: if magnifier element has display property value is "absolute"\r\n        // display property value of imageWrapper element must be relative\r\n        // to make magnifier coordinate base on imageWrapper coordinate\r\n        magnifier.style.left = x - magWidth / 2 + "px";\r\n        magnifier.style.top = y - magHeight / 2 + "px";\r\n    }\r\n    \r\n    function zoomStart() {\r\n        zoomBox.appendChild(zImage);\r\n        imageWrapper.appendChild(magnifier);\r\n    }\r\n    \r\n    function zoomEnd() {\r\n        zoomBox.removeChild(zImage);\r\n        imageWrapper.removeChild(magnifier);\r\n    }\r\n</script>\r\n</code>\r\n</div>\r\n<div><b>***Note:</b></div>\r\nTo optimize page loading speed, you can modify code to use two size of image,\r\none is small size for image need to zoom, two is large size for zoomed image.\r\nFor example, you set <code>src</code> attribute of image by value of small size source,\r\nand add <code>data-zoom</code> attribute and set value by large image source.\r\nThen replace <code>zImage.src = image.src</code> by <code>zImage.src = image.getAttribute("data-zoom")</code>.\r\nPay attention, you need to check the large image have loaded before calling function zoomMove.', NULL, 1, NULL, NULL, NULL, NULL, NULL, 1491874870, 1493486059, 1492189200, NULL, NULL, NULL, NULL),
(7, 7, 7, NULL, NULL, 'css-crop-and-center-image-with-the-specific-aspect-ratio', 'CSS crop and center image with the specific aspect ratio', 'CSS crop and center image with the specific aspect ratio', 'Display image with the specific aspect ratio by CSS and JavaScript', 'CSS crop and center image with the specific aspect ratio, crop and center image, image aspect ratio', 'Display image with the specific aspect ratio by crop and center image using CSS and JavaScript', 'In some cases we need to display image on specific aspect ratio, i.e. 4x3, 5x3, 16x9...\r\n<br>There are two solutions to resolve this problem:\r\n<br>1) Crop image on server follow that aspect ratio (I call "hard crop")\r\n<br>2) Crop image on browser when page was loaded ("soft crop")\r\n<br>With first solution, we can reduce unnecessary pixels when browser loading image.\r\n<br>With second solution, we can flexible change aspect ratio at different pages, contexts or devices...\r\n<br>We also can use both of them, resizing images to standard aspect ratio,\r\nand other way cropping images when display in browser to ensure that all of images display with desired ratio.\r\n<br>I will not discuss about cropping image on server, instead of that,\r\nI will show code to displaying image by aspect ratio on browser by CSS and JavaScript.\r\n\r\n<div class="code-example">\r\n<code>\r\n<!-- CSS -->\r\n<style>\r\n.item-view,\r\n.aspect-ratio,\r\n.aspect-ratio * {\r\n    position: relative;\r\n}\r\n.item-view {\r\n    overflow: hidden;\r\n}\r\n.aspect-ratio .item-view,\r\n.item-view.aspect-ratio {\r\n    width: 100%;\r\n    height: 0;\r\n}\r\n.aspect-ratio .item-view .img-wrap,\r\n.item-view.aspect-ratio .img-wrap {\r\n    position: absolute;\r\n    top: 0;\r\n    left: 0;\r\n    width: 100%;\r\n    height: 100%;\r\n}\r\n.aspect-ratio .item-view .img-wrap > *,\r\n.item-view.aspect-ratio .img-wrap > * {\r\n    display: block;\r\n    position: absolute;\r\n    margin: auto;\r\n    top: -9999px;\r\n    bottom: -9999px;\r\n    left: -9999px;\r\n    right: -9999px;\r\n}\r\n.aspect-ratio .item-view .img-wrap img.landscape,\r\n.item-view.aspect-ratio .img-wrap img.landscape {\r\n    height: 100%;\r\n    width: auto;\r\n}\r\n.aspect-ratio .item-view .img-wrap img.portrait,\r\n.item-view.aspect-ratio .img-wrap img.portrait {\r\n    height: auto;\r\n    width: 100%;\r\n}\r\n.aspect-ratio .item-view .img-wrap :not(img):first-child,\r\n.item-view.aspect-ratio .img-wrap :not(img):first-child {\r\n    width: 100%;\r\n    height: 100%;\r\n}\r\n\r\n/*\r\n * Add your aspect ratios\r\n */\r\n ._7x2 .item-view,\r\n.item-view._7x2 {\r\n    padding-bottom: calc(200% / 7);\r\n}\r\n._16x9 .item-view,\r\n.item-view._16x9 {\r\n    padding-bottom: calc(900% / 16);\r\n}\r\n._5x3 .item-view,\r\n.item-view._5x3 {\r\n    padding-bottom: calc(300% / 5);\r\n}\r\n._4x3 .item-view,\r\n.item-view._4x3 {\r\n    padding-bottom: calc(300% / 4);\r\n}\r\n._1x1 .item-view,\r\n.item-view._1x1 {\r\n    padding-bottom: 100%;\r\n}\r\n\r\n/*\r\n * Others\r\n */\r\nh3 {\r\n    margin: 1.2em 0 0.4em;\r\n}\r\nh4 {\r\n    margin: 0.6em 0 0.2em;\r\n}\r\nstrong {\r\n    color: #f70;\r\n}\r\narticle {\r\n    width: 250px;\r\n    max-width: 100%;\r\n}\r\n</style>\r\n[@ img1 : Image(1)->imgTag("200x200") @][@ img2 : Image(2)->imgTag("200x200") @]\r\n<!-- HTML -->\r\n<h3>1) Set aspect ratio <strong>4x3</strong> for multiple item views</h3>\r\n<article class="aspect-ratio _4x3">\r\n    <div class="item-view">\r\n        <div class="img-wrap">\r\n            {@ img1 @}\r\n        </div>\r\n    </div>\r\n    <br>\r\n    <div class="item-view">\r\n        <div class="img-wrap">\r\n            {@ img2 @}\r\n        </div>\r\n    </div>\r\n</article>\r\n<h3>2) Set aspect ratio for single item view</h3>\r\n<article>\r\n    <h4><strong>1x1</strong></h4>\r\n    <div class="item-view aspect-ratio _1x1">\r\n        <div class="img-wrap">\r\n            {@ img1 @}\r\n        </div>\r\n    </div>\r\n    <h4><strong>5x3</strong></h4>\r\n    <div class="item-view aspect-ratio _5x3">\r\n        <div class="img-wrap">\r\n            {@ img2 @}\r\n        </div>\r\n    </div>\r\n</article>\r\n<h3>3) Set aspect ratio for other object</h3>\r\n<article>\r\n    <h4><strong>16x9</strong></h4>\r\n    <div class="item-view aspect-ratio _16x9" style="width:600px;max-width:100%">\r\n        <div class="img-wrap">\r\n            <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d59587.992123585536!2d105.80194397641313!3d21.022700316266988!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3135ab9bd9861ca1%3A0xe7887f7b72ca17a9!2zSMOgIE7hu5lpLCBIb8OgbiBLaeG6v20sIEjDoCBO4buZaSwgVmnhu4d0IE5hbQ!5e0!3m2!1svi!2s!4v1492102606645" frameborder="0" style="border:0" allowfullscreen></iframe>\r\n        </div>\r\n    </div>\r\n    <h4><strong>7x2</strong></h4>\r\n    <div class="item-view aspect-ratio _7x2" style="width:600px;max-width:100%">\r\n        <div class="img-wrap">\r\n            <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d59587.992123585536!2d105.80194397641313!3d21.022700316266988!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3135ab9bd9861ca1%3A0xe7887f7b72ca17a9!2zSMOgIE7hu5lpLCBIb8OgbiBLaeG6v20sIEjDoCBO4buZaSwgVmnhu4d0IE5hbQ!5e0!3m2!1svi!2s!4v1492102606645" frameborder="0" style="border:0" allowfullscreen></iframe>\r\n        </div>\r\n    </div>\r\n</article>\r\n\r\n<!-- JavaScript -->\r\n<script>\r\nfunction setObjectOrientation(objects, aspect_ratio) {\r\n    for (var i = 0; i < objects.length; i++) {\r\n        !function main(obj) {\r\n            var width = obj.naturalWidth || obj.width;\r\n            var height = obj.naturalHeight || obj.height;\r\n\r\n            if (width / height > aspect_ratio) {\r\n                obj.classList.add("landscape");\r\n                obj.classList.remove("portrait");\r\n            } else {\r\n                obj.classList.add("portrait");\r\n                obj.classList.remove("landscape");\r\n            }\r\n            if (typeof obj.onload !== "undefined" && !obj.loaded) {\r\n                obj.onload = function () {\r\n                    main(this);\r\n                    obj.loaded = true;\r\n                };\r\n            }\r\n        }(objects[i]);\r\n    }\r\n}\r\n\r\nsetObjectOrientation(document.querySelectorAll(".aspect-ratio._7x2 .img-wrap *"), 7 / 2);\r\nsetObjectOrientation(document.querySelectorAll(".aspect-ratio._16x9 .img-wrap *"), 16 / 9);\r\nsetObjectOrientation(document.querySelectorAll(".aspect-ratio._5x3 .img-wrap *"), 5 / 3);\r\nsetObjectOrientation(document.querySelectorAll(".aspect-ratio._4x3 .img-wrap *"), 4 / 3);\r\nsetObjectOrientation(document.querySelectorAll(".aspect-ratio._1x1 .img-wrap *"), 1 / 1);\r\n</script>\r\n</code>\r\n</div>\r\n', NULL, 1, NULL, NULL, NULL, NULL, NULL, 1491875092, 1493485942, 1492126200, NULL, NULL, NULL, NULL),
(8, 7, 7, NULL, NULL, 'create-image-popup-with-javascript', 'Create image popup with JavaScript', '', '', '', '', '<!-- HTML -->', NULL, 0, NULL, NULL, NULL, NULL, NULL, 1491875269, 1491875269, 1491875400, NULL, NULL, NULL, NULL),
(9, 7, 7, NULL, NULL, 'javascript-image-validator', 'JavaScript image validator', '', '', '', '', '<!-- HTML -->', NULL, 0, NULL, NULL, NULL, NULL, NULL, 1491875306, 1491875306, 1491875400, NULL, NULL, NULL, NULL),
(10, 7, 7, NULL, NULL, 'javascript-serialize-form-data', 'JavaScript serialize form data', '', '', '', '', '<!-- HTML -->', NULL, 0, NULL, NULL, NULL, NULL, NULL, 1491875456, 1491875456, 1491875400, NULL, NULL, NULL, NULL),
(11, 7, 7, NULL, NULL, 'css-grid-view', 'CSS grid view', 'CSS grid view', 'CSS grid view using property display inline-block for each grid view item, make them can be aligned very flexible', 'css grid view', 'CSS grid view using property display inline-block for each grid view item, make them can be aligned very flexible', '<div class="code-example">\r\n<code>\r\n<!-- CSS -->\r\n<style>\r\n.grid-view {\r\n    width: 100%;\r\n    max-width: 600px;\r\n    font-size: 5px;\r\n}\r\n.grid-view li * {\r\n    font-size: 14px;\r\n}\r\n.grid-view img {\r\n    display: block;\r\n    width: 100%;\r\n}\r\n\r\n/*\r\n * Define grid-view\r\n */\r\n.grid-view,\r\n.grid-view * {\r\n    position: relative;\r\n    margin: 0;\r\n    padding: 0;\r\n}\r\n.grid-view .clearfix {\r\n    display: block;\r\n    overflow: hidden;\r\n}\r\n.grid-view .clearfix:before,\r\n.grid-view .clearfix:after {\r\n    content: "";\r\n    display: block;\r\n    clear: both;\r\n    height: 0;\r\n    border: none;\r\n}\r\n.grid-view ul {\r\n    display: block;\r\n    margin: -1em;\r\n}\r\n.grid-view li {\r\n    display: inline-block;\r\n    margin: 1em;\r\n    vertical-align: bottom;\r\n}\r\n.grid-view.g1 li {\r\n    width: calc(100% / 1 - 2em);\r\n}\r\n.grid-view.g2 li {\r\n    width: calc(100% / 2 - 2em);\r\n}\r\n.grid-view.g3 li {\r\n    width: calc(100% / 3 - 2em);\r\n}\r\n.grid-view.g4 li {\r\n    width: calc(100% / 4 - 2em);\r\n}\r\n.grid-view.g5 li {\r\n    width: calc(100% / 5 - 2em);\r\n}\r\n@media screen and (max-width: 640px) {\r\n    .grid-view.sm-g1 li {\r\n        width: calc(100% / 1 - 2em);\r\n    }\r\n    .grid-view.sm-g2 li {\r\n        width: calc(100% / 2 - 2em);\r\n    }\r\n    .grid-view.sm-g3 li {\r\n        width: calc(100% / 3 - 2em);\r\n    }\r\n    .grid-view.sm-g4 li {\r\n        width: calc(100% / 4 - 2em);\r\n    }\r\n    .grid-view.sm-g5 li {\r\n        width: calc(100% / 5 - 2em);\r\n    }\r\n}\r\n</style>\r\n\r\n<!-- HTML -->[@ img : Image(1)->imgTag("100x100") @]\r\n<div class="grid-view g4 sm-g2">\r\n    <div class="clearfix">\r\n        <ul>\r\n            <li>\r\n                {@ img @}\r\n            </li><!--\r\n            -- Remove white-space here\r\n            -- Because LIs display as inline-block, like the words,\r\n            -- if has white-space\r\n            -- Space between 2 tags will be bigger than 2em\r\n            --><li>\r\n                {@ img @}\r\n            </li><li>\r\n                {@ img @}\r\n            </li><li>\r\n                {@ img @}\r\n            </li><li>\r\n                {@ img @}\r\n            </li><li>\r\n                {@ img @}\r\n            </li>\r\n        </ul>\r\n    </div>\r\n</div>\r\n</code>\r\n</div>', NULL, 1, NULL, NULL, NULL, NULL, NULL, 1491879190, 1493485551, 1491879600, NULL, NULL, NULL, NULL),
(12, 7, 7, NULL, NULL, 'use-svg-as-base64-image-in-css', 'Use SVG as base64 image in CSS', '', '', '', '', '<div class="code-example">\r\n\r\n</div>', NULL, 0, NULL, NULL, NULL, NULL, NULL, 1491880023, 1491880023, 1491880200, NULL, NULL, NULL, NULL),
(13, 7, 7, NULL, NULL, 'image-optimizer-with-yii2-imagine', 'Image optimizer with Yii2 imagine', '', '', '', '', '<?php\r\n', NULL, 0, NULL, NULL, NULL, NULL, NULL, 1491880085, 1491880085, 1491880200, NULL, NULL, NULL, NULL),
(14, 7, 7, NULL, NULL, 'install-mongodb-on-window', 'Install mongodb on window', '', '', '', '', '<section></section>', NULL, 0, NULL, NULL, NULL, NULL, NULL, 1491880236, 1491880236, 1491880200, NULL, NULL, NULL, NULL),
(15, 7, 7, NULL, NULL, 'create-user-signup-and-login-with-facebook-javascript-sdk', 'Create user signup and login with Facebook JavaScript SDK ', '', '', '', '', '<!-- -->', NULL, 0, NULL, NULL, NULL, NULL, NULL, 1491880495, 1491880495, 1491880800, NULL, NULL, NULL, NULL),
(16, 7, 7, NULL, NULL, 'html5-draw-text-on-canvas', 'HTML5 - draw text on canvas', '', '', '', '', '<!-- -->', NULL, 0, NULL, NULL, NULL, NULL, NULL, 1491880522, 1492165736, 1491880800, NULL, NULL, NULL, NULL),
(17, 7, 7, NULL, NULL, 'create-simple-icons-with-css', 'Create simple icons with CSS', 'Create simple icons with CSS', 'Create simple icons with CSS', 'create simple icons with css', '', '<h2>1. Circle icon</h2>\r\nUsing border-radius property to make square transform circle:\r\n<div class="code-example">\r\n<code>\r\n<!-- CSS -->\r\n<style>\r\n    .circle-icon {\r\n        display: inline-block;\r\n        width: 0.5em;\r\n        height: 0.5em;\r\n        border-radius: 100%;\r\n        background: #06c;\r\n    }\r\n    ul li {\r\n        display: block;\r\n        list-style: none;\r\n    }\r\n    ul li * {\r\n        vertical-align: middle;\r\n    }\r\n    ul li + li {\r\n        margin-top: 0.5em;\r\n    }\r\n</style>\r\n<!-- HTML -->\r\n<ul>\r\n    <li>\r\n        <i class="circle-icon"></i>\r\n        <span>Example of circle icon made by CSS</span>\r\n    </li>\r\n    <li>\r\n        <i class="circle-icon"></i>\r\n        <span>Example of circle icon made by CSS</span>\r\n    </li>\r\n</ul>\r\n</code>\r\n</div>\r\n\r\n<h2>2. Triangle icon</h2>\r\n<div class="code-example">\r\n<code>\r\n<!-- CSS -->\r\n<style>\r\n    .triangle-icon {\r\n        display: inline-block;\r\n        width: 0;\r\n        height: 0;\r\n        border: 0.4em solid transparent;\r\n        border-right-width: 0;\r\n        border-left-color: #5c1;\r\n    }\r\n    ul li {\r\n        display: block;\r\n        list-style: none;\r\n    }\r\n    ul li * {\r\n        vertical-align: middle;\r\n    }\r\n    ul li + li {\r\n        margin-top: 0.5em;\r\n    }\r\n</style>\r\n<!-- HTML -->\r\n<ul>\r\n    <li>\r\n        <i class="triangle-icon"></i>\r\n        <span>Example for triangle icon made by CSS</span>\r\n    </li>\r\n    <li>\r\n        <i class="triangle-icon"></i>\r\n        <span>Example for triangle icon made by CSS</span>\r\n    </li>\r\n</ul>\r\n</code>\r\n</div>\r\nYou can create play video icon from triangle icon:\r\n<!--\r\n<div class="code-example">\r\n<xcode>\r\n<!-- CSS -->\r\n<!--\r\n<style>\r\n	.play-icon {\r\n		display: inline-block;\r\n		box-sizing: border-box;\r\n		width: 10em;\r\n		height: 10em;\r\n		padding: 2em;\r\n		background: #000;\r\n		border-radius: 100%;\r\n	}\r\n	.play-icon:after {\r\n		content: "";\r\n		display: inline-block;\r\n		box-sizing: border-box;\r\n		border: solid transparent;\r\n		border-width: 3em 0 3em calc(6em * 0.866);\r\n		border-left-color: #fff;\r\n		margin-left: calc(3em - 2em * 0.866);\r\n	}\r\n</style>\r\n<!-- HTML -->\r\n<!--\r\n<i class="play-icon"></i>\r\n</xcode>\r\n</div>\r\nI have created a play icon.\r\n<br>...But there is something wrong\r\n<br>Although distance from triangle to left circle border equals to distance to right circle border,\r\nbut distance from each top of triangle to circle not equals to another distance.\r\n<br>In other way, center point of triangle is not at same position with circle center point.\r\n<br>So we will move arrow from center to right a distance equals to <code>[distance from center to top] - [distance from center to edge]</code>\r\n<br>In equilateral triangle, distance from center to top = <code>(2 / 3) * height</code>, distance from center to edge = <code>(1 / 3) * height</code>;\r\n<br>In this example, "height" is border-left-width.\r\n<br>So we need to move triangle <code>(1 / 3) * [border-left-width] == (1 / 6) * (6em * 0.866) == 1.5em * 0.866</code> to right.\r\n<br>Result:\r\n-->\r\n<div class="code-example">\r\n<code>\r\n<!-- CSS -->\r\n<style>\r\n	.play-icon {\r\n		display: inline-block;\r\n		box-sizing: border-box;\r\n		width: 10em;\r\n		height: 10em;\r\n		padding: 2em;\r\n		background: #000;\r\n		border-radius: 100%;\r\n	}\r\n	.play-icon:after {\r\n		content: "";\r\n		display: inline-block;\r\n		box-sizing: border-box;\r\n		border: solid transparent;\r\n		border-width: 3em 0 3em calc(6em * 0.866);\r\n		border-left-color: #fff;\r\n		margin-left: calc(3em - 2em * 0.866);\r\n	}\r\n</style>\r\n<!-- HTML -->\r\n<i class="play-icon"></i>\r\n</code>\r\n</div>\r\nMove triangle to right a distance <code>(a / 2) - (a * sqrt(3) / 6)</code>\r\nto make its center stay at same position with square center.\r\n<div class="img-wrap">{% Image(8)->imgTag("300x300") %}</div>\r\n<h2>3. Arrow icon</h2>\r\n<div class="code-example">\r\n<code>\r\n<!-- CSS -->\r\n<style>\r\n    .arrow-icon {\r\n        display: inline-block;\r\n        box-sizing: border-box;\r\n        width: 0.6em;\r\n        height: 0.6em;\r\n        border: solid #f62;\r\n        border-width: 0.2em 0.2em 0 0;\r\n        transform: rotate(45deg);\r\n        \r\n    }\r\n    ul li {\r\n        display: block;\r\n        list-style: none;\r\n    }\r\n    ul li * {\r\n        vertical-align: middle;\r\n    }\r\n    ul li + li {\r\n        margin-top: 0.5em;\r\n    }\r\n</style>\r\n<!-- HTML -->\r\n<ul>\r\n    <li>\r\n        <i class="arrow-icon"></i>\r\n        <span>Create arrow icon by CSS</span>\r\n    </li>\r\n    <li>\r\n        <i class="arrow-icon"></i>\r\n        <span>Create arrow icon by CSS</span>\r\n    </li>\r\n</ul>\r\n</code>\r\n</div>\r\nI have created a right arrow icon. However, there is an problem here.\r\nThe arrow not stay at center of the square wrap icon, as below:\r\n<div class="img-wrap">{img(7)}</div>\r\nSo I need to move icon to left a distance 0.2em\r\nto make it stay at center of green square.\r\n<code>\r\n.arrow-icon {\r\n    margin-left: -0.2em;\r\n    margin-right: 0.2em;\r\n}\r\n</code>\r\nOther way, we will use &lt;i&gt; tag as the box, and make pseudo :after\r\nas arrow, and align arrow at center of the box.\r\n<div class="code-example">\r\n<code>\r\n<!-- CSS -->\r\n<style>\r\n	body {\r\n		font-size: 20px;\r\n		padding: 50px;	\r\n	}\r\n	.arrow-icon {\r\n		display: inline-block;\r\n		position: relative;\r\n		background: #eee;\r\n		box-sizing: border-box;\r\n		width: 6em;\r\n		height: 6em;\r\n		overflow: hidden;\r\n	}\r\n	.arrow-icon:after {\r\n		content: "";\r\n		display: inline-block;\r\n		position: relative;\r\n		border: solid #f71;\r\n		transform: rotate(45deg);\r\n		width: calc(6em / 1.4142);\r\n		height: calc(6em / 1.4142);\r\n		margin: calc(0.5 * (6em - 6em / 1.4142));\r\n		border-width: 1em 1em 0 0;\r\n		box-sizing: border-box;\r\n		left: calc(-0.5 * (6em - 6em / 1.4142 / 1.4142 - 1em / 1.4142));\r\n	}\r\n</style>\r\n<!-- HTML -->\r\n<i class="arrow-icon"></i>\r\n<ul>\r\n    <li>Box size: 6em x 6em;</li>\r\n    <li>Arrow aside length: 6em / 1.4142;</li>\r\n    <li>Arrow aside thickness: 1em;</li>\r\n</ul>\r\n</code>\r\n</div>', NULL, 1, NULL, NULL, NULL, NULL, NULL, 1491992567, 1493485779, 1491991800, NULL, NULL, NULL, NULL),
(18, 7, 7, NULL, NULL, 'image-blurry-loading', 'Image blurry loading', 'Image blurry loading', 'To improve user exerience, "image blurry loading" will load a lightweight image before while waiting for original image loading.', 'Image blurry loading', '', '[@ image1 : Image(19) @]\r\n[@ image2 : Image(17) @]\r\n[@ image3 : Image(16) @]\r\n\r\nWhen our website have the large image, user will see that image load slowly from top to bottom.\r\nThis make user experience down. We can compress that image to reduce loading time of browser,\r\nbut if loading time still quiet slow, we can consider this way: Create a tiny version of the image,\r\nand browser will loading it very fast to show as blurred image (scale tiny image and blur it) while waiting for origin image loading.\r\n<br>For example, I have two size of an image, one is origin size, and two is tiny version:\r\n<br><strong>Origin size: 1920x1080 - 157kb - loading time: 2.67s</strong>\r\n<br><strong>Tiny size: 50x50 - 1.0kb - loading time 0.38s</strong>\r\n<br>Loading time you can get other result, but sure those will be big different with each other.\r\n<br>Try it in your device:\r\n<div class="code-example" data-autorun="0">\r\n<code>\r\n<!-- CSS -->\r\n<style>\r\n    body { min-height: 600px }\r\n    img { width: auto; max-width: 600px; margin-bottom: 20px; display: block;}\r\n</style>\r\n    \r\n<!-- HTML -->\r\n{% $("image1")->imgTag("10x10", {"alt" : "image blurry loading - tiny size"}) %}\r\n{% $("image1")->imgTag(0, {"alt" : "image blurry loading - original size"}) %}\r\n\r\n<!-- JavaScript -->\r\n<script>\r\n    if (!Date.now) {\r\n        Date.now = function now() {\r\n           return new Date().getTime();\r\n        };\r\n    }\r\n    var startTime = Date.now();\r\n    [].forEach.call(\r\n    	document.getElementsByTagName("img"),\r\n        function (img) {\r\n        	img.addEventListener(\r\n                "load",\r\n                function () {\r\n                    var loadingTime = Date.now() - startTime;\r\n                    var result = document.createElement("DIV");\r\n                    result.innerHTML\r\n                        = "natural size: " + img.naturalWidth + "x" + img.naturalHeight\r\n                        + "; loading time: " + loadingTime + "ms";\r\n                    img.parentNode.insertBefore(result, img);\r\n                }\r\n            );\r\n        }\r\n    );\r\n</script>\r\n</code>\r\n</div>\r\n<br>Okay, I will try its effect.\r\nFirst, I put two version of images into a wrapper, and hidden larger version until it loaded completely.\r\n<div class="code-example" data-autorun="0">\r\n<code>\r\n<!-- CSS -->\r\n<style>\r\n    body {\r\n    	min-height: 300px;\r\n    }\r\n    .img-wrapper {\r\n    	width: 100%;\r\n        max-width: 400px;\r\n        position: relative;\r\n        float: left;\r\n        margin: 10px;\r\n    }\r\n    .img-wrapper img {\r\n    	width: 100%;\r\n        transition: opacity 250ms;\r\n    }\r\n    .img-wrapper img.origin {\r\n    	opacity: 0;\r\n        position: absolute;\r\n        top: 0;\r\n        left: 0;\r\n    }\r\n    .img-wrapper img.tiny {\r\n    	opacity: 1;\r\n        position: relative;\r\n        filter: blur(8px);\r\n    }\r\n    .img-wrapper.loaded img.origin {\r\n    	opacity: 1;\r\n    }\r\n    .img-wrapper.loaded img.tiny {\r\n    	opacity: 0;\r\n    }\r\n</style>\r\n    \r\n<!-- HTML -->\r\n<div class="img-wrapper">\r\n    {% $("image2")->imgTag("10x10", {"class": "tiny", "alt": "image blurry loading - tiny size"}) %}\r\n    {% $("image2")->imgTag(0, {"class": "origin", "alt": "image blurry loading - original size"}) %}\r\n</div>\r\n<div class="img-wrapper">\r\n    {% $("image2")->imgTag(0, {"alt": "image blurry loading - original size"}) %}\r\n</div>\r\n    \r\n<!-- JavaScript -->\r\n<script>\r\n    var imgWrappers = document.getElementsByClassName("img-wrapper");\r\n    [].forEach.call(\r\n    	imgWrappers,\r\n        function (imgWrapper) {\r\n        	var originImg = imgWrapper.querySelector("img.origin");\r\n            if (originImg)\r\n                originImg.addEventListener(\r\n                    "load",\r\n                    function () {\r\n                        imgWrapper.classList.add("loaded");\r\n                    }\r\n                );\r\n        }\r\n    );\r\n</script>\r\n</code>\r\n</div>\r\n<strong>*** Open inspect element mode, disable cache and reload page to see the result most clearly.</strong>\r\n<br>Here, we have another approach, is using only one <code><img></code> tag to store two size version of the image,\r\nwith src initialized by tiny version, and additional attribute data-origin gave by origin version src value.\r\nThen create an Image object with property src equals to data-origin, and check when that Image object loaded,\r\nand reset src of the image by data-origin.\r\n<div class="code-example" data-autorun="0">\r\n<code>\r\n<!-- CSS -->\r\n<style>\r\n    body { min-height: 300px; }\r\n    .img-wrapper { width: 100%; max-width: 400px; margin: 10px; float: left;}\r\n    .img-wrapper img { display: block; width: 100%; }\r\n    img.blurry { filter: blur(8px); opacity: 0; transition: filter 250ms, opacity: 100ms; }\r\n    img.blurry.tiny-loaded { opacity: 1; }\r\n    img.blurry.origin-loaded { filter: blur(0px); opacity: 1; }\r\n</style>\r\n\r\n<!-- HTML -->\r\n<div class="img-wrapper">\r\n    <!--\r\n    <img\r\n     src = .../{% $("image3")->filename("10x10") %}\r\n     data-origin = .../{% $("image3")->filename(0) %}\r\n    >\r\n    -->\r\n    {% $("image3")->imgTag("10x10", {"class": "blurry", "data-origin": "<% this=>source() %>"}) %}\r\n</div>\r\n<div class="img-wrapper">\r\n    {% $("image3")->imgTag() %}\r\n</div>\r\n\r\n<!-- JavaScript -->\r\n<script>\r\n    [].forEach.call(\r\n        document.querySelectorAll("img.blurry"),\r\n        function (img) {\r\n            img.addEventListener(\r\n                "load",\r\n                function () {\r\n                    img.classList.add("tiny-loaded");\r\n                }\r\n            );\r\n            var origin = new Image();\r\n            origin.src = img.getAttribute("data-origin");\r\n            origin.addEventListener(\r\n                "load",\r\n                function () {\r\n                    img.src = origin.src;\r\n                    img.classList.add("origin-loaded");\r\n                }\r\n            );\r\n        }\r\n    );\r\n</script>\r\n</code>\r\n</div>', NULL, 1, NULL, NULL, NULL, NULL, NULL, 1492191993, 1493533881, 1492192200, NULL, NULL, NULL, NULL),
(19, 7, 7, NULL, NULL, 'javascript-crop-image', 'JavaScript crop image', '', '', '', '', '<!-- -->', NULL, 0, NULL, NULL, NULL, NULL, NULL, 1492192117, 1492192117, 1492192200, NULL, NULL, NULL, NULL);
INSERT INTO `article` (`id`, `creator_id`, `updater_id`, `image_id`, `category_id`, `slug`, `name`, `meta_title`, `meta_description`, `meta_keywords`, `description`, `content`, `sub_content`, `active`, `visible`, `featured`, `type`, `status`, `sort_order`, `create_time`, `update_time`, `publish_time`, `view_count`, `like_count`, `comment_count`, `share_count`) VALUES
(20, 7, 7, NULL, NULL, 'water-ripple-effect-with-css-javascript', 'Water ripple effect with CSS & JavaScript', 'Water ripple effect with CSS & JavaScript', 'Create water ripple effect when user click on the button using CSS and JavaScript', 'ripple effect css, ripple effect javascript, css ripple effect, javascript ripple effect, water ripple effect javascript, water ripple effect css', 'Create water ripple effect when user click on the button using CSS and JavaScript', 'To improve web browsing experience for the user, we often create effect when user interactives with the website, by keyboard or mouse.\r\nFor example when user moves the mouse pointer over anchor text then it changes color or has underlined.\r\nOr when user clicks on the button will create an effect like real button was pressed.\r\nIn this article, I will try to make effect like water ripple spreading out by JavaScript.\r\n<br>Let''s start with...\r\n<h2>Step 1: Get coordinate of the point which mouse click event occurring at</h2>\r\n<div class="code-example">\r\n<code>\r\n<style>#result { height: 100px; background: #eee; }</style>\r\n<div id="result"> Click to show the coordinate </div>\r\n\r\n<!-- JavaScript -->\r\n<script>\r\n    function handleClick(event) {\r\n    	var x = event.clientX;\r\n		var y = event.clientY;\r\n		document.getElementById("result").innerHTML = "You clicked at the coordinate (x, y) = (" + x + ", " + y + ")";\r\n    }\r\n    document.getElementById("result").addEventListener("click", handleClick);\r\n</script>\r\n</code>\r\n</div>\r\nOkay, so I have got the coordinate where mouse clicked on. Next step, I will create ripple effect spread out from that point.\r\n<h2>Step 2: Create ripple effect spread out from where mouse clicked on</h2>\r\n<div class="code-example">\r\n<code>\r\n<!-- CSS -->\r\n<style>\r\n    #result {\r\n    	height: 150px;\r\n    }\r\n    .click-ripple {\r\n    	background: rgb(120, 230, 100);\r\n        border-radius: 100%;\r\n        pointer-events: none;\r\n        position: fixed;\r\n    }    \r\n</style>\r\n    \r\n<!-- HTML -->\r\n<div id="result">\r\n	Click to see the ripple \r\n</div>\r\n    \r\n<!-- JavaScript -->\r\n<script>\r\n    function handleClick(event) {\r\n    	var x = event.clientX;\r\n		var y = event.clientY;\r\n		\r\n        // Duration by milisecond of ripple spreading out from 1px to 101px\r\n        var spreadTime = 300;\r\n        \r\n        // Create an element to represent for the ripple\r\n        var ripple = document.createElement("DIV");\r\n        ripple.className = "click-ripple";\r\n        \r\n        // Set transition duration\r\n        ripple.style.transition\r\n            = ripple.style["-moz-transition"]\r\n            = ripple.style["-webkit-transition"]\r\n        	= "all " + spreadTime + "ms";\r\n        \r\n        // Begin state of ripple\r\n        ripple.style.width = "1px";\r\n        ripple.style.height = "1px";\r\n        ripple.style.left = x + "px";\r\n        ripple.style.top = y + "px";\r\n        ripple.style.opacity = "1";\r\n        \r\n        setTimeout(function () {\r\n            // End state of ripple\r\n            ripple.style.width = "101px";\r\n            ripple.style.height = "101px";\r\n            ripple.style.left = x - 50 + "px";\r\n            ripple.style.top = y - 50 + "px";\r\n            ripple.style.opacity = "0.2";\r\n            \r\n            // Remove ripple element when spreaded out\r\n            setTimeout(function () {\r\n				ripple.parentNode.removeChild(ripple);\r\n            }, spreadTime);\r\n        }, 10);\r\n        \r\n        event.target.appendChild(ripple);\r\n    }\r\n    \r\n    // Binding event to element id = "result"\r\n    document.getElementById("result").addEventListener("click", handleClick);\r\n</script>\r\n</code>\r\n</div>\r\n\r\n<h2>Step 3: Handle click event on button we want to make ripple effect on</h2>\r\n<div class="code-example">\r\n<code>\r\n<!-- CSS -->\r\n<style>\r\n    .click-lake {\r\n    	overflow: hidden;\r\n        z-index: 9999;\r\n    }\r\n    .click-ripple {\r\n    	background: rgba(100, 100, 100, 0.5);\r\n        border-radius: 100%;\r\n        pointer-events: none;\r\n    }\r\n    .button-1,\r\n    .button-2 {\r\n    	border: none;\r\n        border-radius: 3px;\r\n        color: #fff;\r\n        overflow: hidden;\r\n        padding: 20px;\r\n        margin: 10px;\r\n        outline: none;\r\n    }\r\n    .button-1 {\r\n    	background: #6b3;\r\n    }\r\n    .button-2 {\r\n    	background: #f72;\r\n    }\r\n</style>\r\n\r\n<!-- HTML -->\r\n<button type="button" class="button-1">Button 1</button>\r\n<br>\r\n<button type="button" class="button-2">Button 2</button>\r\n    \r\n<!-- JavaScript -->\r\n<script>\r\n    function handleClick(event, config) {\r\n    	var x = event.clientX;\r\n		var y = event.clientY;\r\n		        \r\n        // Create an element to represent for the ripple\r\n        var ripple = document.createElement("DIV");\r\n        ripple.className = "click-ripple";\r\n        ripple.style.position = "absolute";\r\n        \r\n        // Set transition duration\r\n        ripple.style.transition\r\n            = ripple.style["-moz-transition"]\r\n            = ripple.style["-webkit-transition"]\r\n        	= "linear all " + config.spreadTime + "ms";\r\n        \r\n        // Create a "lake" to contains ripple, make it does not spill out\r\n        var lake = document.createElement("DIV");\r\n        lake.className = "click-lake";\r\n        lake.style.position = "fixed";\r\n        \r\n        // Size and coordinate of target element (here is element which user click on)\r\n        var tarRect = event.target.getBoundingClientRect();\r\n        lake.style.width = tarRect.width + "px";\r\n        lake.style.height = tarRect.height + "px";\r\n        lake.style.top = tarRect.top + "px";\r\n        lake.style.left = tarRect.left + "px";\r\n        \r\n        lake.appendChild(ripple);\r\n        event.target.appendChild(lake);\r\n        \r\n        // Set value for size: auto\r\n        if (config.begin.width === "auto") {\r\n        	config.begin.width = 1;\r\n        }\r\n        if (config.begin.height === "auto") {\r\n        	config.begin.height = 1;\r\n        }\r\n        if (config.end.width === "auto") {\r\n        	config.end.width = 2 * Math.max(tarRect.width, tarRect.height);\r\n        }\r\n        if (config.end.height === "auto") {\r\n        	config.end.height = 2 * Math.max(tarRect.width, tarRect.height);\r\n        }\r\n        \r\n        \r\n        // Set begin state for the ripple element\r\n        setStateStyle("begin");\r\n        \r\n        setTimeout(function () {\r\n            // Set end state for the ripple element\r\n            setStateStyle("end");\r\n            \r\n            // Remove ripple element when spreaded out\r\n            setTimeout(function () {\r\n                ripple.parentNode.removeChild(ripple);\r\n                lake.parentNode.removeChild(lake);\r\n            }, config.spreadTime);\r\n        }, 10);\r\n        \r\n        function setStateStyle(state) {\r\n        	ripple.style.width = config[state].width + "px";\r\n            ripple.style.height = config[state].height + "px";\r\n            ripple.style.left = (x - tarRect.left) - (config[state].width / 2) + "px";\r\n            ripple.style.top =  (y - tarRect.top) - (config[state].height / 2) + "px";\r\n            ripple.style.opacity = config[state].opacity;\r\n        }\r\n    }\r\n    \r\n    var config = {\r\n    	spreadTime: 200,\r\n        begin: {\r\n        	width: 20, // "auto" or int\r\n            height: 20,\r\n            opacity: 0.2\r\n        },\r\n        end: {\r\n        	width: "auto",\r\n            height: "auto",\r\n            opacity: 0.8\r\n        }\r\n    };\r\n    \r\n    // Binding function handleClick to all button\r\n    [].forEach.call(\r\n    	document.getElementsByTagName("button"),\r\n        function (button) {\r\n        	button.addEventListener("click", function (event) {\r\n            	handleClick(event, config);\r\n            });\r\n        }\r\n    );\r\n</script>\r\n</code>\r\n</div>\r\n', NULL, 1, NULL, NULL, NULL, NULL, NULL, 1492268157, 1493000590, 1492268400, NULL, NULL, NULL, NULL),
(21, 7, 7, NULL, NULL, 'create-tooltip-with-javascript', 'Create tooltip with JavaScript', '', '', '', '', '<!-- -->', NULL, 0, NULL, NULL, NULL, NULL, NULL, 1492393996, 1492393996, 1492394400, NULL, NULL, NULL, NULL),
(22, 7, 7, NULL, NULL, 'create-bar-chart-with-javascript', 'Create bar chart with JavaScript', '', '', '', '', '<!-- -->', NULL, 0, NULL, NULL, NULL, NULL, NULL, 1493198985, 1493198985, 1493199000, NULL, NULL, NULL, NULL),
(23, 7, 7, NULL, NULL, 'javascript-date-time-picker', 'JavaScript date time picker', 'JavaScript date time picker', 'Create JavaScript date time picker widget', '', '', '<!-- -->', NULL, 1, NULL, NULL, NULL, NULL, NULL, 1493544273, 1493544273, 1496136600, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `auth_assignment`
--

CREATE TABLE IF NOT EXISTS `auth_assignment` (
  `item_name` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `user_id` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` int(11) DEFAULT NULL,
  PRIMARY KEY (`item_name`,`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `auth_assignment`
--

INSERT INTO `auth_assignment` (`item_name`, `user_id`, `created_at`) VALUES
('admin', '7', 1490859591);

-- --------------------------------------------------------

--
-- Table structure for table `auth_item`
--

CREATE TABLE IF NOT EXISTS `auth_item` (
  `name` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `type` smallint(6) NOT NULL,
  `description` text COLLATE utf8_unicode_ci,
  `rule_name` varchar(64) COLLATE utf8_unicode_ci DEFAULT NULL,
  `data` blob,
  `created_at` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL,
  PRIMARY KEY (`name`),
  KEY `rule_name` (`rule_name`),
  KEY `idx-auth_item-type` (`type`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `auth_item`
--

INSERT INTO `auth_item` (`name`, `type`, `description`, `rule_name`, `data`, `created_at`, `updated_at`) VALUES
('/*', 2, NULL, NULL, NULL, 1490858371, 1490858371),
('/admin/*', 2, NULL, NULL, NULL, 1490858370, 1490858370),
('/admin/assignment/*', 2, NULL, NULL, NULL, 1490858369, 1490858369),
('/admin/assignment/assign', 2, NULL, NULL, NULL, 1490858369, 1490858369),
('/admin/assignment/index', 2, NULL, NULL, NULL, 1490858369, 1490858369),
('/admin/assignment/revoke', 2, NULL, NULL, NULL, 1490858369, 1490858369),
('/admin/assignment/view', 2, NULL, NULL, NULL, 1490858369, 1490858369),
('/admin/default/*', 2, NULL, NULL, NULL, 1490858369, 1490858369),
('/admin/default/index', 2, NULL, NULL, NULL, 1490858369, 1490858369),
('/admin/menu/*', 2, NULL, NULL, NULL, 1490858369, 1490858369),
('/admin/menu/create', 2, NULL, NULL, NULL, 1490858369, 1490858369),
('/admin/menu/delete', 2, NULL, NULL, NULL, 1490858369, 1490858369),
('/admin/menu/index', 2, NULL, NULL, NULL, 1490858369, 1490858369),
('/admin/menu/update', 2, NULL, NULL, NULL, 1490858369, 1490858369),
('/admin/menu/view', 2, NULL, NULL, NULL, 1490858369, 1490858369),
('/admin/permission/*', 2, NULL, NULL, NULL, 1490858370, 1490858370),
('/admin/permission/assign', 2, NULL, NULL, NULL, 1490858370, 1490858370),
('/admin/permission/create', 2, NULL, NULL, NULL, 1490858370, 1490858370),
('/admin/permission/delete', 2, NULL, NULL, NULL, 1490858370, 1490858370),
('/admin/permission/index', 2, NULL, NULL, NULL, 1490858369, 1490858369),
('/admin/permission/remove', 2, NULL, NULL, NULL, 1490858370, 1490858370),
('/admin/permission/update', 2, NULL, NULL, NULL, 1490858370, 1490858370),
('/admin/permission/view', 2, NULL, NULL, NULL, 1490858370, 1490858370),
('/admin/role/*', 2, NULL, NULL, NULL, 1490858370, 1490858370),
('/admin/role/assign', 2, NULL, NULL, NULL, 1490858370, 1490858370),
('/admin/role/create', 2, NULL, NULL, NULL, 1490858370, 1490858370),
('/admin/role/delete', 2, NULL, NULL, NULL, 1490858370, 1490858370),
('/admin/role/index', 2, NULL, NULL, NULL, 1490858370, 1490858370),
('/admin/role/remove', 2, NULL, NULL, NULL, 1490858370, 1490858370),
('/admin/role/update', 2, NULL, NULL, NULL, 1490858370, 1490858370),
('/admin/role/view', 2, NULL, NULL, NULL, 1490858370, 1490858370),
('/admin/route/*', 2, NULL, NULL, NULL, 1490858370, 1490858370),
('/admin/route/assign', 2, NULL, NULL, NULL, 1490858370, 1490858370),
('/admin/route/create', 2, NULL, NULL, NULL, 1490858370, 1490858370),
('/admin/route/index', 2, NULL, NULL, NULL, 1490858370, 1490858370),
('/admin/route/refresh', 2, NULL, NULL, NULL, 1490858370, 1490858370),
('/admin/route/remove', 2, NULL, NULL, NULL, 1490858370, 1490858370),
('/admin/rule/*', 2, NULL, NULL, NULL, 1490858370, 1490858370),
('/admin/rule/create', 2, NULL, NULL, NULL, 1490858370, 1490858370),
('/admin/rule/delete', 2, NULL, NULL, NULL, 1490858370, 1490858370),
('/admin/rule/index', 2, NULL, NULL, NULL, 1490858370, 1490858370),
('/admin/rule/update', 2, NULL, NULL, NULL, 1490858370, 1490858370),
('/admin/rule/view', 2, NULL, NULL, NULL, 1490858370, 1490858370),
('/admin/user/*', 2, NULL, NULL, NULL, 1490858370, 1490858370),
('/admin/user/activate', 2, NULL, NULL, NULL, 1490858370, 1490858370),
('/admin/user/change-password', 2, NULL, NULL, NULL, 1490858370, 1490858370),
('/admin/user/delete', 2, NULL, NULL, NULL, 1490858370, 1490858370),
('/admin/user/index', 2, NULL, NULL, NULL, 1490858370, 1490858370),
('/admin/user/login', 2, NULL, NULL, NULL, 1490858370, 1490858370),
('/admin/user/logout', 2, NULL, NULL, NULL, 1490858370, 1490858370),
('/admin/user/request-password-reset', 2, NULL, NULL, NULL, 1490858370, 1490858370),
('/admin/user/reset-password', 2, NULL, NULL, NULL, 1490858370, 1490858370),
('/admin/user/signup', 2, NULL, NULL, NULL, 1490858370, 1490858370),
('/admin/user/view', 2, NULL, NULL, NULL, 1490858370, 1490858370),
('/debug/*', 2, NULL, NULL, NULL, 1490858371, 1490858371),
('/debug/default/*', 2, NULL, NULL, NULL, 1490858371, 1490858371),
('/debug/default/db-explain', 2, NULL, NULL, NULL, 1490858370, 1490858370),
('/debug/default/download-mail', 2, NULL, NULL, NULL, 1490858371, 1490858371),
('/debug/default/index', 2, NULL, NULL, NULL, 1490858370, 1490858370),
('/debug/default/toolbar', 2, NULL, NULL, NULL, 1490858370, 1490858370),
('/debug/default/view', 2, NULL, NULL, NULL, 1490858370, 1490858370),
('/gii/*', 2, NULL, NULL, NULL, 1490858371, 1490858371),
('/gii/default/*', 2, NULL, NULL, NULL, 1490858371, 1490858371),
('/gii/default/action', 2, NULL, NULL, NULL, 1490858371, 1490858371),
('/gii/default/diff', 2, NULL, NULL, NULL, 1490858371, 1490858371),
('/gii/default/index', 2, NULL, NULL, NULL, 1490858371, 1490858371),
('/gii/default/preview', 2, NULL, NULL, NULL, 1490858371, 1490858371),
('/gii/default/view', 2, NULL, NULL, NULL, 1490858371, 1490858371),
('/site/*', 2, NULL, NULL, NULL, 1490858371, 1490858371),
('/site/error', 2, NULL, NULL, NULL, 1490858371, 1490858371),
('/site/index', 2, NULL, NULL, NULL, 1490858371, 1490858371),
('/site/login', 2, NULL, NULL, NULL, 1490858371, 1490858371),
('/site/logout', 2, NULL, NULL, NULL, 1490858371, 1490858371),
('admin', 1, NULL, NULL, NULL, 1490859534, 1490859534);

-- --------------------------------------------------------

--
-- Table structure for table `auth_item_child`
--

CREATE TABLE IF NOT EXISTS `auth_item_child` (
  `parent` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `child` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`parent`,`child`),
  KEY `child` (`child`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `auth_item_child`
--

INSERT INTO `auth_item_child` (`parent`, `child`) VALUES
('admin', '/*');

-- --------------------------------------------------------

--
-- Table structure for table `auth_rule`
--

CREATE TABLE IF NOT EXISTS `auth_rule` (
  `name` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `data` blob,
  `created_at` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL,
  PRIMARY KEY (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `image`
--

CREATE TABLE IF NOT EXISTS `image` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `creator_id` int(11) DEFAULT NULL,
  `updater_id` int(11) DEFAULT NULL,
  `file_basename` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `path` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `file_extension` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `mime_type` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `description` varchar(511) COLLATE utf8_unicode_ci DEFAULT NULL,
  `resize_labels` varchar(2047) COLLATE utf8_unicode_ci DEFAULT NULL,
  `encode_data` varchar(2047) COLLATE utf8_unicode_ci DEFAULT NULL,
  `active` smallint(1) DEFAULT NULL,
  `status` smallint(6) DEFAULT NULL,
  `create_time` int(11) DEFAULT NULL,
  `update_time` int(11) DEFAULT NULL,
  `sort_order` smallint(6) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `file_basename` (`file_basename`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=20 ;

--
-- Dumping data for table `image`
--

INSERT INTO `image` (`id`, `creator_id`, `updater_id`, `file_basename`, `path`, `name`, `file_extension`, `mime_type`, `description`, `resize_labels`, `encode_data`, `active`, `status`, `create_time`, `update_time`, `sort_order`) VALUES
(1, 7, 7, '181jmoyvsod4ijpg', '201704/181jmoyvsod4ijpg/', '181jmoyvsod4ijpg', 'jpg', 'image/jpeg', NULL, '{"2":"-100x56","4":"-250x141","5":"-300x169","6":"-350x197","7":"-400x225","8":"-450x253","9":"-500x281"}', NULL, 1, NULL, 1491390300, 1491403029, NULL),
(2, 7, 7, '421a2bc856a6d9ecs', '201704/421a2bc856a6d9ecs/', '421a2bc856a6d9ecs 2', 'jpg', 'image/jpeg', NULL, '{"4":"-250x141","5":"-300x169","6":"-350x197","7":"-400x225","8":"-450x253","9":"-500x281"}', NULL, 1, NULL, 1491390306, 1491390306, NULL),
(3, 7, 7, '6822', '201704/6822/', '6822 3', 'jpeg', 'image/jpeg', NULL, '{"4":"-250x141","5":"-300x169","6":"-350x197","7":"-400x225","8":"-450x253","9":"-500x281"}', NULL, 1, NULL, 1491390311, 1491390311, NULL),
(4, 7, 7, '449741', '201704/449741/', '449741 4', 'jpg', 'image/jpeg', NULL, '{"4":"-250x141","5":"-300x169","6":"-350x197","7":"-400x225","8":"-450x253","9":"-500x281"}', NULL, 1, NULL, 1491390313, 1491390313, NULL),
(5, 7, 7, '13529210_1279546325397817_2535158985257933453_n', '201704/13529210_1279546325397817_2535158985257933453_n/', '13529210_1279546325397817_2535158985257933453_n 5', 'jpg', 'image/jpeg', NULL, '{"4":"-250x166","5":"-300x200","6":"-350x233","7":"-400x266","8":"-450x300","9":"-500x333"}', NULL, 1, NULL, 1491390320, 1491390320, NULL),
(6, 7, 7, 'b076989adf38d7b37456151a4f35ef3c', '201704/b076989adf38d7b37456151a4f35ef3c/', 'b076989adf38d7b37456151a4f35ef3c 6', 'jpg', 'image/jpeg', NULL, '{"4":"-250x141","5":"-300x169","6":"-350x197","7":"-400x225","8":"-450x253","9":"-500x281"}', NULL, 1, NULL, 1491390322, 1491390322, NULL),
(7, 7, 7, 'create-arrow-icon-css', '201704/create-arrow-icon-css/', 'create arrow icon css', 'png', 'image/png', NULL, '[]', NULL, 1, NULL, 1492016086, 1492048843, NULL),
(8, 7, 7, 'triangle-icon-by-css', '201704/triangle-icon-by-css/', 'Triangle icon by CSS', 'jpg', 'image/jpeg', NULL, '{"6":"-263x350","9":"-375x500"}', NULL, 1, NULL, 1492058167, 1492060347, NULL),
(9, 7, 7, 'Create-JavaScript-slideshow-for-website-with-three-steps--1', '201704/Create-JavaScript-slideshow-for-website-with-three-steps--1/', 'Create-JavaScript-slideshow-for-website-with-three-steps--1', 'jpg', 'image/jpeg', NULL, '[]', NULL, 1, NULL, 1492222567, 1492222567, NULL),
(10, 7, 7, 'Dap-an-de-thi-vao-lop-10-mon-Hoa-chuyen-TPHCM-nam-2016-2017', '201704/Dap-an-de-thi-vao-lop-10-mon-Hoa-chuyen-TPHCM-nam-2016-2017/', 'Dap-an-de-thi-vao-lop-10-mon-Hoa-chuyen-TPHCM-nam-2016-2017', 'jpg', 'image/jpeg', NULL, '[]', NULL, 1, NULL, 1492222567, 1492222567, NULL),
(11, 7, 7, 'djs_4312_0', '201704/djs_4312_0/', 'djs_4312_0', 'jpg', 'image/jpeg', NULL, '[]', NULL, 1, NULL, 1492222567, 1492222567, NULL),
(12, 7, 7, 'first-mclaren-p1-in-the-us-wears-giovanna-wheels-advertised-for-23-million-photo-gallery_8', '201704/first-mclaren-p1-in-the-us-wears-giovanna-wheels-advertised-for-23-million-photo-gallery_8/', 'first-mclaren-p1-in-the-us-wears-giovanna-wheels-advertised-for-23-million-photo-gallery_8', 'jpg', 'image/jpeg', NULL, '[]', NULL, 1, NULL, 1492222567, 1492222567, NULL),
(13, 7, 7, 'html-charset', '201704/html-charset/', 'html-charset', 'jpg', 'image/jpeg', NULL, '[]', NULL, 1, NULL, 1492222567, 1492222567, NULL),
(14, 7, 7, 'McLaren-P1_2014_1600x1200_wallpaper_02', '201704/McLaren-P1_2014_1600x1200_wallpaper_02/', 'McLaren-P1_2014_1600x1200_wallpaper_02', 'jpg', 'image/jpeg', NULL, '[]', NULL, 1, NULL, 1492222568, 1492222568, NULL),
(15, 7, 7, 'mclaren-p1-ds_0', '201704/mclaren-p1-ds_0/', 'mclaren-p1-ds_0', 'jpg', 'image/jpeg', NULL, '[]', NULL, 1, NULL, 1492222568, 1492222568, NULL),
(16, 7, 7, 'image-blurry-loading-car', '201704/image-blurry-loading-car/', 'image blurry loading car', 'jpg', 'image/jpeg', NULL, '{"1":"-50x28"}', NULL, 1, NULL, 1492222568, 1492404477, NULL),
(17, 7, 7, 'image-blurry-loading-boat', '201704/image-blurry-loading-boat/', 'image blurry loading boat', 'jpg', 'image/jpeg', NULL, '{"1":"-50x31"}', NULL, 1, NULL, 1492222568, 1492404438, NULL),
(18, 7, 7, 'ultra_4k_wallpap-6325', '201704/ultra_4k_wallpap-6325/', 'ultra_4k_wallpap-6325', 'jpg', 'image/jpeg', NULL, '{"1":"-50x28"}', NULL, 1, NULL, 1492222568, 1492337986, NULL),
(19, 7, 7, 'image-blurry-loading-beach', '201704/image-blurry-loading-beach/', 'image blurry loading beach', 'jpg', 'image/jpeg', NULL, '{"1":"-50x28"}', NULL, 1, NULL, 1492222568, 1492404452, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `menu`
--

CREATE TABLE IF NOT EXISTS `menu` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(128) NOT NULL,
  `parent` int(11) DEFAULT NULL,
  `route` varchar(255) DEFAULT NULL,
  `order` int(11) DEFAULT NULL,
  `data` blob,
  PRIMARY KEY (`id`),
  KEY `parent` (`parent`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `migration`
--

CREATE TABLE IF NOT EXISTS `migration` (
  `version` varchar(180) COLLATE utf8_unicode_ci NOT NULL,
  `apply_time` int(11) DEFAULT NULL,
  PRIMARY KEY (`version`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `migration`
--

INSERT INTO `migration` (`version`, `apply_time`) VALUES
('m000000_000000_base', 1490843601),
('m140506_102106_rbac_init', 1490846580),
('m140602_111327_create_menu_table', 1490843604),
('m160312_050000_create_user', 1490843605),
('m170405_100000_alter_article', 1491389276),
('m170405_100000_alter_image', 1491389276),
('m170405_100000_create_article', 1491389276),
('m170405_100000_create_image', 1491389276),
('m170405_110000_alter_image', 1491389424);

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE IF NOT EXISTS `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `auth_key` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `password_hash` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `password_reset_token` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `activation_token` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `status` smallint(6) NOT NULL,
  `type` smallint(6) DEFAULT NULL,
  `create_time` int(11) NOT NULL,
  `update_time` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=9 ;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `username`, `auth_key`, `password_hash`, `password_reset_token`, `activation_token`, `email`, `status`, `type`, `create_time`, `update_time`) VALUES
(7, 'quyettvq', 'BvJ7KUKELd2mbyPKsuGWLDw9IB3Nsl2_', '$2y$13$4szP5PIJivf4XOUnhQKybOPS4SKt1r9lvWZcSN.x9j2joe4RrFy/e', NULL, NULL, 'quyettvq@gmail.com', 10, 10, 1490858092, 1490868300),
(8, 'vanquyet', 'ge2ZFGReySUTjEJgi96XjFG4Q6fL8mjO', '$2y$13$M8h1id1mI5SWj69tlGUVtecWh6Y8HBKRp1iKlPdox3df3ufmH6p8i', NULL, NULL, 'vanquyet@gmail.com', 1, NULL, 1491307737, 1491307737);

--
-- Constraints for dumped tables
--

--
-- Constraints for table `auth_assignment`
--
ALTER TABLE `auth_assignment`
  ADD CONSTRAINT `auth_assignment_ibfk_1` FOREIGN KEY (`item_name`) REFERENCES `auth_item` (`name`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `auth_item`
--
ALTER TABLE `auth_item`
  ADD CONSTRAINT `auth_item_ibfk_1` FOREIGN KEY (`rule_name`) REFERENCES `auth_rule` (`name`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `auth_item_child`
--
ALTER TABLE `auth_item_child`
  ADD CONSTRAINT `auth_item_child_ibfk_1` FOREIGN KEY (`parent`) REFERENCES `auth_item` (`name`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `auth_item_child_ibfk_2` FOREIGN KEY (`child`) REFERENCES `auth_item` (`name`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `menu`
--
ALTER TABLE `menu`
  ADD CONSTRAINT `menu_ibfk_1` FOREIGN KEY (`parent`) REFERENCES `menu` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

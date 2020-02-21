<script>
    // =================
    // Helper functions

    //func element
    function elm(nodeName, content, attributes) {
        var node = document.createElement(nodeName);
        appendChildren(node, content);
        setAttributes(node, attributes);
        return node;
    }

    function appendChildren(node, content) {
        var append = function (t) {
            if (/string|number/.test(typeof t)) {
                var textNode = document.createTextNode(t);
                node.appendChild(textNode);
            } else if (t instanceof Node) {
                node.appendChild(t);
            }
        };
        if (content instanceof Array) {
            content.forEach(function (item) {
                append(item);
            });
        } else {
            append(content);
        }
    }

    function setAttributes(node, attributes) {
        if (attributes) {
            var attrName;
            for (attrName in attributes) {
                if (attributes.hasOwnProperty(attrName)) {
                    var attrValue = attributes[attrName];
                    switch (typeof attrValue) {
                        case "string":
                        case "number":
                            node.setAttribute(attrName, attrValue);
                            break;
                        case "function":
                        case "boolean":
                            node[attrName] = attrValue;
                            break;
                        default:
                    }
                }
            }
        }
    }

    function empty(element) {
        while (element.firstChild) {
            element.removeChild(element.firstChild);
        }
    }

    function style(obj) {
        var result_array = [];
        var attrName;
        for (attrName in obj) {
            if (Object.prototype.hasOwnProperty.call(obj, attrName)) {
                result_array.push(attrName + ": " + obj[attrName]);
            }
        }
        return result_array.join("; ");
    }

    //-- set click outside to close
    var clickOutsideToCloseComponents = {};
    /**
     *
     * @param id {string}
     * @param ignoredEls {[Node]}
     * @param close {function}
     */
    var setClickOutsideToClose = (id, ignoredEls, close) => {
        if ('string' === typeof id
            && ignoredEls.every(el => el instanceof Node)
            && 'function' === typeof close
        ) {
            clickOutsideToCloseComponents[id] = [ignoredEls, close];
        } else {
            console.error('setClickOutsideToClose invalid arguments', id);
        }
    };
    var handleClickOutsideToClose = (event, ignoredEls, close) => {
        if (ignoredEls.every(ignoredEl => {
            return ignoredEl !== event.target
                && !ignoredEl.contains(event.target)
                && document.body.contains(event.target)
        })) {
            close();
        }
    };
    document.addEventListener('mousedown', function (event) {
        for (var id in clickOutsideToCloseComponents) {
            if (clickOutsideToCloseComponents.hasOwnProperty(id)) {
                handleClickOutsideToClose(event, ...clickOutsideToCloseComponents[id]);
            }
        }
    });

    //-- tooltip
    var showTooltip = (content, openerEl, onClose) => {
        if (openerEl.getAttribute('data-tooltip-shown')) {
            return;
        }

        // tooltip element
        var tooltipEl = document.createElement('div');
        tooltipEl.className = 'tooltip';
        openerEl.setAttribute('data-tooltip-shown', '1');
        document.body.appendChild(tooltipEl);

        var close = () => {
            if (tooltipEl.parentNode) {
                tooltipEl.parentNode.removeChild(tooltipEl);
                openerEl.removeAttribute('data-tooltip-shown');
            }
            onClose && onClose();
        };

        var contentEl = document.createElement('div');
        contentEl.className = 'content';
        contentEl.innerHTML = content;
        tooltipEl.appendChild(contentEl);

        var closeButton = document.createElement('button');
        closeButton.type = 'button';
        closeButton.className = 'close-button';
        closeButton.innerHTML = '&times;';
        closeButton.onclick = close;
        tooltipEl.appendChild(closeButton);

        setClickOutsideToClose('utils.dom.tooltip', [openerEl, tooltipEl], close);

        // set position
        tooltipEl.style.position = 'absolute';

        var updatePos = () => {
            // TODO: clarify this code
            var scrollTop = window.scrollY;
            var scrollLeft = window.scrollX;
            var frameTop = 0;
            var openerRect = openerEl.getBoundingClientRect();
            var tooltipRect = tooltipEl.getBoundingClientRect();
            tooltipEl.style.top = (
                scrollTop
                + Math.max(
                    openerRect.top,
                    frameTop + tooltipRect.height + 10 // move down (10 - 5) px from top edge of layout scroll element
                )
                - tooltipRect.height - 5 // move up 5 px from opener
            ) + 'px';
            tooltipEl.style.left = Math.max(
                5, // 5 px from left
                scrollLeft + Math.min(openerRect.left - tooltipRect.width / 2, window.innerWidth - tooltipRect.width)
            ) + 'px';
        };

        updatePos();
        window.addEventListener('scroll', updatePos);
        window.addEventListener('resize', updatePos);
    };
</script>
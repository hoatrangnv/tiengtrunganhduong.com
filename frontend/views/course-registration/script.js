function popup(msg_html, max_width, max_height) {
    var msg = element(
        "div",
        msg_html,
        {
            style: style({
                background: "white",
                padding: msg_html instanceof HTMLElement ? "0" : "1rem",
                "border-radius": "4px",
                "line-height": "1.5em",
                "max-width": max_width ? max_width : "90vw",
                "max-height": max_height ? max_height : "90vh"
            })
        }
    );

    var closeBtn = element(
        "button",
        "close",
        {
            type: "button",
            style: style({
                color: "white",
                position: "absolute",
                top: 0,
                right: 0,
                padding: "0.5em",
                border: "none",
                cursor: "pointer",
                "background-color": "rgba(0, 0, 0, 0.5)"
            })
        }
    );

    var container = element(
        "div",
        [msg, closeBtn],
        {
            style: style({
                position: "fixed",
                top: 0,
                left: 0,
                bottom: 0,
                right: 0,
                display: "flex",
                "align-items": "center",
                "justify-content": "center",
                "z-index": 9999,
                "background-color": "rgba(0, 0, 0, 0.5)"
            })
        }
    );

    document.addEventListener("click", function (event) {
        if (isContains(container, event.target)
            && msg !== event.target
            && !isContains(msg, event.target)
            && container.parentNode
        ) {
            container.parentNode.removeChild(container);
        }
    });

    closeBtn.addEventListener("click", function () {
        if (container.parentNode) {
            container.parentNode.removeChild(container);
        }
    });

    document.body.appendChild(container);
}

function element(nodeName, content, attributes) {
    var node = document.createElement(nodeName);
    appendChildren(node, content);
    setAttributes(node, attributes);
    return node;
}

function appendChildren(node, content) {
    var append = function (t) {
        if (/string|number/.test(typeof t)) {
            node.innerHTML += t;
        } else if (t instanceof HTMLElement) {
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

function isContains(root, elem) {
    if (root.contains(elem)) {
        return true;
    } else {
        return [].some.call(root.children, function (child) {
            return isContains(child, elem);
        });
    }
}
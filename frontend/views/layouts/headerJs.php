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
</script>
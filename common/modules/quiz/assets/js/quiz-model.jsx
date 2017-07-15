var {SortableContainer, SortableElement, arrayMove} = window.SortableHOC;

class QuizModel extends React.Component {
    constructor(props) {
        super(props);
        this.state = {
            name: this.props.type + "",
            attrs: this.props.attrConfigs.map((config) => <QuizModelAttr
                key={uniqueId()}
                type={config.type}
                name={config.name}
                label={config.label}
                rules={config.rules}
            />),
            childrenData: this.props.childrenData,
            activeChildKey: this.props.activeChildKey
        };
        this.id = this.props.id;
        this.addChild = this.addChild.bind(this);
        this.removeChild = this.removeChild.bind(this);
        this.activateChild = this.activateChild.bind(this);
        this.reorderChildren = this.reorderChildren.bind(this);
        this.updateChildrenData = this.updateChildrenData.bind(this);
    }

    addChild(props) {
        // var newChild = (() => <QuizModel
        //     key={uniqueId()}
        //     type={config.type}
        //     attrConfigs={config.attrConfigs}
        //     childConfigs={config.childConfigs}
        // />)();
        // var newChild = new QuizModel(config);
        var newChildData = {
            id: uniqueId(),
            key: uniqueId(),
            type: props.type,
            attrConfigs: props.attrConfigs,
            childConfigs: props.childConfigs,
            childrenData: [],
            attrsData: [],
            activeChildKey: undefined
        };
        if (this.props.updateChildrenData) {
            this.props.updateChildrenData(this.id, props);
        } else {
            this.setState((prevState) => ({
                name: prevState.name,
                attrs: prevState.attrs,
                childrenData: prevState.childrenData.concat(newChildData),
                activeChildKey: newChildData.key
            }));
        }

    }

    updateChildrenData(key, props) {
        console.log(key, props);
        if (this.props.updateChildrenData) {
            this.props.updateChildrenData(key, props);
        } else {
            var update = function (childrenData) {
                var updated = false;
                childrenData.forEach((childData) => {
                    if (key === childData.id) {
                        updated = true;
                        childData.childrenData.push({
                            id: uniqueId(),
                            type: props.type,
                            attrConfigs: props.attrConfigs,
                            childConfigs: props.childConfigs,
                            childrenData: [],
                            attrsData: [],
                            activeChildKey: undefined
                        });
                    }
                });
                if (!updated) {
                    childrenData.forEach((childData) => {
                        update(childData.childrenData);
                    });
                }
                return childrenData;
            };
            var childrenData = update(this.state.childrenData);
            this.setState((prevState) => ({
                name: prevState.name,
                attrs: prevState.attrs,
                childrenData: childrenData,
                activeChildKey: prevState.activeChildKey
            }));
        }
    }

    removeChild() {
        var children = this.state.children;
        var index = children.indexOf(children.find((child) => this.state.activeChildKey === child.key));
        if (index > -1) {
            children.splice(index, 1);
            this.setState((prevState) => ({
                attrs: prevState.attrs,
                children : children,
                activeChildKey: null
            }));
        }
    }

    activateChild(key) {
        this.setState((prevState) => ({
            attrs: prevState.attrs,
            children: prevState.children,
            activeChildKey: key
        }));
    }

    reorderChildren({oldIndex, newIndex}) {
        this.setState((prevState) => ({
            attrs: prevState.attrs,
            children: arrayMove(prevState.children, oldIndex, newIndex),
            activeChildKey: prevState.activeChildKey
        }));
    }

    render() {
        var activeChildData = this.state.childrenData.find(childData => childData.key === this.state.activeChildKey);
        console.log("This Type", this.props.type);
        console.log("Children Data", this.state.childrenData);
        return (
            <div id={this.key} className="panel panel-default clearfix">
                <div className="panel-body clearfix">
                    <div style={{width:"200px"}} className="pull-left">
                        {this.state.attrs}
                    </div>
                    <div style={{width:"calc(100% - 200px - 10px)"}} className="pull-right">
                        {
                            !this.props.childConfigs ? "" :
                                <div className="clearfix">
                                    <TabBar
                                        items={this.state.childrenData}
                                        reorderItems={this.reorderChildren}
                                        activateItem={this.activateChild}
                                        activeItemId={this.state.activeChildKey}
                                        addItem={this.addChild}
                                        itemConfigs={this.props.childConfigs}
                                    />
                                </div>
                        }
                        {
                            !activeChildData ? "" :
                                <div className="clearfix">
                                    <QuizModel
                                        id={activeChildData.id}
                                        key={activeChildData.id}
                                        type={activeChildData.type}
                                        attrConfigs={activeChildData.attrConfigs}
                                        childConfigs={activeChildData.childConfigs}
                                        childrenData={activeChildData.childrenData}
                                        activeChildKey={activeChildData.activeChildKey}
                                        updateChildrenData={this.updateChildrenData}
                                    />
                                </div>
                        }
                    </div>
                </div>
            </div>
        );
    }
}

class QuizModelAttr extends React.Component {
    constructor(props) {
        super(props);
        this.handleChange = this.handleChange.bind(this);
        this.state = {
            // use `(this.props.value || "")` instead of `this.props.value`
            // to avoid error "change uncontrolled input"
            value: (this.props.value || ""),
            errorMsg: ""
        };
    }

    handleChange(event) {
        var value = event.target.value;
        // this.state.errorMsg = this.props.validate(value);
        if ("" === this.state.errorMsg) {
            this.state.value = value;
        } else {
            this.state.value = "";
        }
        this.props.onChange(this.state.value);
    }

    render() {
        var type = this.props.type;
        var name = this.props.name;
        var value = this.state.value;
        var input;
        switch (type) {
            case "textArea":
                input = <textArea name={name} value={value} onChange={this.handleChange} />;
                break;
            case "selectBox":
                input = <select name={name} value={value} onChange={this.handleChange}>
                    {
                        this.props.options.map((option) => (
                            <option key={option.key} value={option.value}>{option.text}</option>
                        ))
                    }
                </select>;
                break;
            default:
                input = <input type={type} name={name} value={value} onChange={this.handleChange} />;
        }
        return (
            <div>
                <label>{this.props.label}</label>
                <div>{input}</div>
                <div>{this.state.errorMsg}</div>
            </div>
        );
    }
}

class TabBar extends React.Component {
    constructor(props) {
        super(props);
        this.key = uniqueId();
        this.state = {
            lastScrollLeft: 0
        };
    }

    componentDidUpdate() {
        var tabBar = document.querySelector("#" + this.key + " ul");
        var activeItem = tabBar.querySelector("li.active");

        if (activeItem) {
            var tabBarRect = tabBar.getBoundingClientRect();
            var activeItemRect = activeItem.getBoundingClientRect();
            tabBar.scrollLeft = (activeItemRect.left - tabBarRect.left) - (tabBar.clientWidth - activeItem.offsetWidth) / 2;
        } else {
            tabBar.scrollLeft = this.state.lastScrollLeft;
        }

        if (tabBar.scrollLeft !== this.state.lastScrollLeft) {
            this.setState({
                lastScrollLeft: tabBar.scrollLeft
            });
        }
    }

    render() {
        const SortableItem = SortableElement(
            ({item}) => {
                return <li
                    key={item.key}
                    className={"tab" + (this.props.activeItemId === item.key ? " active" : "")}
                    onClick={() => this.props.activateItem(item.key)}
                >
                    <span className="holder">{}</span>
                    <span className="label">{item.type}</span>
                </li>
            }
        );

        const SortableList = SortableContainer(
            ({items}) =>
                <ul>
                    {items.map((item, index) =>
                        <SortableItem
                            key={item.key}
                            index={index}
                            item={item}
                        />
                    )}
                </ul>
        );

        return (
            <div id={this.key} className="tab-bar">
                <div style={{width:"calc(100% - 140px)"}} className="pull-left">
                    <SortableList
                        axis="x"
                        helperClass="SortableHelper"
                        items={this.props.items}
                        onSortEnd={this.props.reorderItems}
                        shouldCancelStart={(event) => "holder" !== event.target.className}
                    />
                </div>
                <div style={{width:"140px"}} className="pull-right">
                    <TabCtrl
                        items={this.props.items}
                        itemConfigs={this.props.itemConfigs}
                        addItem={this.props.addItem}
                        removeItem={this.props.removeItem}
                        activateItem={this.props.activateItem}
                        activeItemId={this.props.activeItemKey}
                    />
                </div>
            </div>
        )
    }
}

class TabCtrl extends React.Component {
    constructor(props) {
        super(props);
        this.key = uniqueId();
        this.state = {
            showItemConfigsMenu: false
        };
        this.activatePrevItem = this.activatePrevItem.bind(this);
        this.activateNextItem = this.activateNextItem.bind(this);
        this.toggleItemConfigsMenu = this.toggleItemConfigsMenu.bind(this);
    }

    activatePrevItem() {
        var key;
        this.props.items.forEach((item, index, items) => {
            if (this.props.activeItemId === item.key && items[index - 1]) {
                key = items[index - 1].key;
            }
        });
        key && this.props.activateItem(key);
    }

    activateNextItem() {
        var key;
        this.props.items.forEach((item, index, items) => {
            if (this.props.activeItemId === item.key && items[index + 1]) {
                key = items[index + 1].key;
            }
        });
        key && this.props.activateItem(key);
    }

    toggleItemConfigsMenu() {
        this.setState({
            showItemConfigsMenu: !this.state.showItemConfigsMenu
        });
    }

    render() {
        var itemConfigs = this.props.itemConfigs.map(
            (item) => <li key={uniqueId()} onClick={() => this.props.addItem(item)}>{item.type}</li>
        );
        return (
            <div id={this.key} className="tab-ctrl">
                <button className="btn btn-sm btn-success" onClick={this.toggleItemConfigsMenu}>
                    <b>+</b>
                    {this.state.showItemConfigsMenu ? <ul className="item-configs-menu">{itemConfigs}</ul> : ""}
                </button>
                <button className="btn btn-sm btn-danger" onClick={this.props.removeItem}><b>&minus;</b></button>
                <button className="btn btn-sm btn-info" onClick={this.activatePrevItem}><b>&lt;</b></button>
                <button className="btn btn-sm btn-info" onClick={this.activateNextItem}><b>&gt;</b></button>
            </div>
        );
    }
}

// class Form extends React.Component {
//     constructor(props) {
//         super(props);
//         this.handleChange = this.handleChange.bind(this);
//         this.state = {
//             inputs: this.props.inputs.reduce((result, item) => {
//                 result[item.name] = item.value;
//                 return result;
//             }, {})
//         };
//     }
//
//     handleChange(name, value) {
//         // Refresh state inputs
//         var inputs = this.props.inputs.reduce((result, item) => {
//             result[item.name] = item.value;
//             return result;
//         }, {});
//         inputs[name] = value;
//         this.setState({inputs: inputs});
//         this.props.onChange(inputs);
//     }
//
//     render() {
//         return (
//             <form>
//                 {
//                     this.props.inputs.map((item) => (
//                         <FormInput
//                             key={item.key}
//                             type={item.type}
//                             name={item.name}
//                             label={item.label}
//                             options={item.options}
//                             validate={item.validate}
//                             value={item.value}
//                             onChange={(value) => {this.handleChange(item.name, value)}}
//                         />
//                     ))
//                 }
//             </form>
//         );
//     }
// }

// class FormInput extends React.Component {
//     constructor(props) {
//         super(props);
//         this.handleChange = this.handleChange.bind(this);
//         this.state = {
//             // use `(this.props.value || "")` instead of `this.props.value`
//             // to avoid error "change uncontrolled input"
//             value: (this.props.value || ""),
//             errorMsg: ""
//         };
//     }
//
//     handleChange(event) {
//         var value = event.target.value;
//         // this.state.errorMsg = this.props.validate(value);
//         if ("" === this.state.errorMsg) {
//             this.state.value = value;
//         } else {
//             this.state.value = "";
//         }
//         this.props.onChange(this.state.value);
//     }
//
//     render() {
//         var type = this.props.type;
//         var name = this.props.name;
//         var value = this.state.value;
//         var input;
//         switch (type) {
//             case "textArea":
//                 input = <textArea name={name} value={value} onChange={this.handleChange} />;
//                 break;
//             case "selectBox":
//                 input = <select name={name} value={value} onChange={this.handleChange}>
//                     {
//                         this.props.options.map((option) => (
//                                 <option key={option.key} value={option.value}>{option.text}</option>
//                             ))
//                     }
//                 </select>;
//                 break;
//             default:
//                 input = <input type={type} name={name} value={value} onChange={this.handleChange} />;
//         }
//         return (
//             <div>
//                 <label>{this.props.label}</label>
//                 <div>{input}</div>
//                 <div>{this.state.errorMsg}</div>
//             </div>
//         );
//     }
// }

function uniqueId() {
    return "__" + Math.floor(1 + (999999999 * Math.random()));
}

window.QuizModel = QuizModel;
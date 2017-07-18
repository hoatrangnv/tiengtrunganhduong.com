var {SortableContainer, SortableElement, arrayMove} = window.SortableHOC;

class QuizModel extends React.Component {
    /**
     * @param props
     * {
     *   id                    string    required
     *   type                  string    required
     *   attrs                 array     required
     *   childConfigs          array     required
     *   childrenData          object    required
     *       {
     *           items         array     required
     *           activeItemId  string    required
     *       }
     *   save                  function  optional
     * }
     */
    constructor(props) {
        super(props);
        this.state = {
            name: this.props.type + "",
            attrs: this.props.attrs,
            childrenData: this.props.childrenData
        };
        this.addChild = this.addChild.bind(this);
        this.removeChild = this.removeChild.bind(this);
        this.activateChild = this.activateChild.bind(this);
        this.reorderChildren = this.reorderChildren.bind(this);
        // this.ancestorUpdateGrandchildren = this.ancestorUpdateGrandchildren.bind(this);
        this.updateAttr = this.updateAttr.bind(this);
    }

    updateAttr(name, value, errorMsg) {
        // Cause `attrs` is an object
        // you don't need to update state
        // And you shouldn't update state
        // DOM updates lead to the input will lose focus
        var attrs = this.state.attrs;
        attrs.forEach((attr) => {
            if (name === attr.name) {
                attr.value = value;
                attr.errorMsg = errorMsg;
            }
        });
    }

    addChild(childConfig) {
        var newChildConfig = JSON.parse(JSON.stringify(childConfig));
        // var grandchildrenData = {
        //     items: [],
        //     activeItemId: null
        // };
        var newChildData = {
            id: uniqueId(),
            type: newChildConfig.type,
            attrs: newChildConfig.attrs,
            childConfigs: newChildConfig.childConfigs,
            childrenData: {
                items: [],
                activeItemId: null
            },
        };
        var childrenData = this.state.childrenData;
        childrenData.items.push(newChildData);
        childrenData.activeItemId = newChildData.id;
        this.setState((prevState) => ({
            name: prevState.name,
            attrs: prevState.attrs,
            childrenData: childrenData
        }));
        // if (this.props.ancestorUpdateGrandchildren) {
        //     this.props.ancestorUpdateGrandchildren(this.props.id, childrenData);
        // }
    }

    removeChild() {
        var childrenData = this.state.childrenData;
        var index = childrenData.items.indexOf(childrenData.items.find((item) => childrenData.activeItemId === item.id));
        if (index > -1) {
            childrenData.items.splice(index, 1);
            this.setState((prevState) => ({
                name: prevState.name,
                attrs: prevState.attrs,
                childrenData: childrenData
            }));
        }
    }

    activateChild(id) {
        var childrenData = this.state.childrenData;
        childrenData.activeItemId = id;
        this.setState((prevState) => ({
            name: prevState.name,
            attrs: prevState.attrs,
            childrenData: childrenData
        }));
        // if (this.props.ancestorUpdateGrandchildren) {
        //     this.props.ancestorUpdateGrandchildren(this.props.id, childrenData);
        // }
    }

    reorderChildren({oldIndex, newIndex}) {
        var childrenData = this.state.childrenData;
        childrenData.items = arrayMove(childrenData.items, oldIndex, newIndex);
        this.setState((prevState) => ({
            name: prevState.name,
            attrs: prevState.attrs,
            childrenData: childrenData
        }));
        // if (this.props.ancestorUpdateGrandchildren) {
        //     this.props.ancestorUpdateGrandchildren(this.props.id, childrenData);
        // }
    }

    // ancestorUpdateGrandchildren(id, grandchildrenData) {
    //     if (this.props.ancestorUpdateGrandchildren) {
    //         this.props.ancestorUpdateGrandchildren(id, grandchildrenData);
    //     } else {
    //         this.setState((prevState) => ({
    //             name: prevState.name,
    //             attrs: prevState.attrs,
    //             childrenData: update(this.state.childrenData),
    //             activeChildId: prevState.activeChildId
    //         }));
    //         function update(childrenData) {
    //             var updated = false;
    //             childrenData.items.forEach((item) => {
    //                 if (id === item.id) {
    //                     item.childrenData = grandchildrenData;
    //                     updated = true;
    //                 }
    //             });
    //             if (!updated) {
    //                 childrenData.items.forEach((childData) => {
    //                     childData.childrenData = update(childData.childrenData);
    //                 });
    //             }
    //             return childrenData;
    //         }
    //     }
    // }

    render() {
        var activeChildData = this.state.childrenData.items.find(childData => childData.id === this.state.childrenData.activeItemId);
        return (
            <div id={this.props.id} className="panel panel-default clearfix">
                {
                    this.props.save &&
                    <div className="panel-heading clearfix">
                        <button
                            className="btn btn-sm btn-primary"
                            onClick={() => this.props.save(this.state)}
                        >Save</button>
                    </div>
                }
                <div className="panel-body clearfix">
                    <div style={activeChildData ? {width:"200px"} : {width:"calc(50% - 5px)"}} className="pull-left">
                        {
                            this.state.attrs.map((attr) => (
                                <QuizModelAttr
                                    key={uniqueId()}
                                    // props:
                                    id={uniqueId()}
                                    name={attr.name}
                                    type={attr.type}
                                    label={attr.label}
                                    rules={attr.rules}
                                    options={attr.options}
                                    value={attr.value}
                                    errorMsg={attr.errorMsg}
                                    onChange={(value, errorMsg) => {this.updateAttr(attr.name, value, errorMsg)}}
                                />
                            ))
                        }
                    </div>
                    <div style={activeChildData ? {width:"calc(100% - 200px - 10px)"} : {width:"calc(50% - 5px)"}} className="pull-right">
                        {
                            !this.props.childConfigs ? "" :
                                <div className="tab-bar-overlap clearfix">
                                    <TabBar
                                        key={uniqueId()}
                                        // props:
                                        id={uniqueId()}
                                        items={this.state.childrenData.items}
                                        activeItemId={this.state.childrenData.activeItemId}
                                        reorderItems={this.reorderChildren}
                                        activateItem={this.activateChild}
                                        addItem={this.addChild}
                                        removeItem={this.removeChild}
                                        itemConfigs={this.props.childConfigs}
                                    />
                                </div>
                        }
                        {
                            activeChildData &&
                                <div className="clearfix">
                                    <QuizModel
                                        key={uniqueId()}
                                        // props:
                                        id={activeChildData.id}
                                        type={activeChildData.type}
                                        attrs={activeChildData.attrs}
                                        childConfigs={activeChildData.childConfigs}
                                        childrenData={activeChildData.childrenData}
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
    /**
     * @param props
     * {
     *    id string required
     *    name string required
     *    type string required
     *    label string required
     *    rules array required
     *    options array required
     *    value string|number required
     *    errorMsg string required
     *    onChange function required
     * }
     */
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
        var errorMsg = "";
        this.setState({
            value: value,
            errorMsg: errorMsg
        });
        this.props.onChange(value, errorMsg);
    }

    render() {
        var type = this.props.type;
        var name = this.props.name;
        var value = this.state.value;
        var input;
        switch (type) {
            case "textArea":
                input = <textArea
                    name={name}
                    value={value}
                    onChange={this.handleChange}
                />;
                break;
            case "selectBox":
                input = <select
                    name={name}
                    value={value}
                    onChange={this.handleChange}
                >
                    {
                        this.props.options.map((option) => (
                            <option key={uniqueId()} value={option.value}>{option.text}</option>
                        ))
                    }
                </select>;
                break;
            default:
                input = <input
                    type={type}
                    name={name}
                    value={value}
                    onChange={this.handleChange}
                />;
        }
        return (
            <div className="input-wrapper">
                <label>{this.props.label}</label>
                {input}
                <div className="error-msg">{this.state.errorMsg}</div>
            </div>
        );
    }
}

class TabBar extends React.Component {
    constructor(props) {
        super(props);
        this.state = {
            lastScrollLeft: 0
        };
    }

    componentDidUpdate() {
        var tabBar = document.querySelector("#" + this.props.id + " ul");
        var activeItem = tabBar.querySelector("li.active");

        if (activeItem) {
            var tabBarRect = tabBar.getBoundingClientRect();
            var activeItemRect = activeItem.getBoundingClientRect();
            tabBar.scrollLeft = (activeItemRect.left - tabBarRect.left)
                - (tabBar.clientWidth - activeItem.offsetWidth) / 2;
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
                    key={item.id}
                    className={"tab" + (this.props.activeItemId === item.id ? " active" : "")}
                    onClick={() => this.props.activateItem(item.id)}
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
                            key={item.id}
                            index={index}
                            item={item}
                        />
                    )}
                </ul>
        );

        return (
            <div id={this.props.id} className="tab-bar">
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
                        key={uniqueId()}
                        // props:
                        id={uniqueId()}
                        items={this.props.items}
                        itemConfigs={this.props.itemConfigs}
                        addItem={this.props.addItem}
                        removeItem={this.props.removeItem}
                        activateItem={this.props.activateItem}
                        activeItemId={this.props.activeItemId}
                    />
                </div>
            </div>
        )
    }
}

class TabCtrl extends React.Component {
    constructor(props) {
        super(props);
        this.state = {
            showItemConfigsMenu: false
        };
        this.activatePrevItem = this.activatePrevItem.bind(this);
        this.activateNextItem = this.activateNextItem.bind(this);
        this.toggleItemConfigsMenu = this.toggleItemConfigsMenu.bind(this);
    }

    activatePrevItem() {
        var id;
        this.props.items.forEach((item, index, items) => {
            if (this.props.activeItemId === item.id && items[index - 1]) {
                id = items[index - 1].id;
            }
        });
        id && this.props.activateItem(id);
    }

    activateNextItem() {
        var id;
        this.props.items.forEach((item, index, items) => {
            if (this.props.activeItemId === item.id && items[index + 1]) {
                id = items[index + 1].id;
            }
        });
        id && this.props.activateItem(id);
    }

    toggleItemConfigsMenu() {
        this.setState({
            showItemConfigsMenu: !this.state.showItemConfigsMenu
        });
    }

    render() {
        var itemConfigs = this.props.itemConfigs.map(
            (itemConfig) => <li key={uniqueId()} onClick={
                () => {
                    this.props.addItem(itemConfig);
                }
            }>{itemConfig.type}</li>
        );
        return (
            <div id={this.props.id} className="tab-ctrl">
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

function uniqueId() {
    return "__" + Math.floor(1 + (999999999 * Math.random()));
}

window.QuizModel = QuizModel;
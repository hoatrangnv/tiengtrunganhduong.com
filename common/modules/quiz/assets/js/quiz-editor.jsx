var {SortableContainer, SortableElement, arrayMove} = window.SortableHOC;

class QuizModel extends React.Component {
    constructor(props) {
        super(props);
        this.state = {
            name: this.props.type + "",
            attrs: this.props.attrs,
            childrenData: this.props.childrenData,
            activeChildId: this.props.activeChildId
        };
        this.addChild = this.addChild.bind(this);
        this.removeChild = this.removeChild.bind(this);
        this.activateChild = this.activateChild.bind(this);
        this.reorderChildren = this.reorderChildren.bind(this);
        this.updateChildrenData = this.updateChildrenData.bind(this);
        this.updateAttr = this.updateAttr.bind(this);
    }

    updateAttr(name, value, errorMsg) {
        var attrs = this.state.attrs;
        attrs.forEach((attr) => {
            if (name === attr.name) {
                attr.value = value;
                attr.errorMsg = errorMsg;
            }
        });
        this.setState((prevState) => ({
            name: prevState.name,
            attrs: attrs,
            childrenData: prevState.childrenData,
            activeChildId: prevState.activeChildId
        }));
    }

    addChild(config) {
        var newChildData = {
            id: uniqueId(),
            type: config.type,
            attrs: config.attrs,
            childConfigs: config.childConfigs,
            childrenData: [],
            activeChildId: undefined
        };
        if (this.props.updateChildrenData) {
            this.props.updateChildrenData(this.props.id, config);
        } else {
            this.setState((prevState) => ({
                name: prevState.name,
                attrs: prevState.attrs,
                childrenData: prevState.childrenData.concat(newChildData),
                activeChildId: newChildData.id
            }));
        }

    }

    updateChildrenData(id, config) {
        if (this.props.updateChildrenData) {
            this.props.updateChildrenData(id, config);
        } else {
            var update = function (childrenData) {
                var newChildId = null;
                childrenData.forEach((childData) => {
                    if (id === childData.id) {
                        newChildId = uniqueId();
                        var newChildData = {
                            id: newChildId,
                            type: config.type,
                            attrs: config.attrs,
                            childConfigs: config.childConfigs,
                            childrenData: [],
                            activeChildId: undefined
                        };
                        childData.childrenData.push(newChildData);
                        childData.activeChildId = newChildId;
                    }
                });
                if (!newChildId) {
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
                activeChildId: prevState.activeChildId
            }));
        }
    }

    removeChild() {
        var childrenData = this.state.childrenData;
        var index = childrenData.indexOf(childrenData.find((childData) => this.state.activeChildId === childData.id));
        if (index > -1) {
            childrenData.splice(index, 1);
            this.setState((prevState) => ({
                name: prevState.name,
                attrs: prevState.attrs,
                childrenData: childrenData,
                activeChildId: prevState.activeChildId
            }));
        }
    }

    activateChild(id) {
        this.setState((prevState) => ({
            name: prevState.name,
            attrs: prevState.attrs,
            childrenData: prevState.childrenData,
            activeChildId: id
        }));
    }

    reorderChildren({oldIndex, newIndex}) {
        this.setState((prevState) => ({
            name: prevState.name,
            attrs: prevState.attrs,
            childrenData: arrayMove(prevState.childrenData, oldIndex, newIndex),
            activeChildId: prevState.activeChildId
        }));
    }

    render() {
        var activeChildData = this.state.childrenData.find(childData => childData.id === this.state.activeChildId);
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
                                    id={uniqueId()}
                                    key={uniqueId()}
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
                                        id={uniqueId()}
                                        items={this.state.childrenData}
                                        reorderItems={this.reorderChildren}
                                        activateItem={this.activateChild}
                                        activeItemId={this.state.activeChildId}
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
                                        id={activeChildData.id}
                                        key={activeChildData.id}
                                        type={activeChildData.type}
                                        childConfigs={activeChildData.childConfigs}
                                        childrenData={activeChildData.childrenData}
                                        attrs={activeChildData.attrs}
                                        activeChildId={activeChildData.activeChildId}
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
        this.submit = this.submit.bind(this);
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
    }

    submit(event) {
        this.props.onChange(this.state.value, this.state.errorMsg);
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
                    onBlur={this.submit}
                />;
                break;
            case "selectBox":
                input = <select
                    name={name}
                    value={value}
                    onChange={this.handleChange}
                    onBlur={this.submit}
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
                    onBlur={this.submit}
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
            (item) => <li key={uniqueId()} onClick={() => this.props.addItem(item)}>{item.type}</li>
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
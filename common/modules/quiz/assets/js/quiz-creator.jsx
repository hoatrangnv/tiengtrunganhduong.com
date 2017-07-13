/**
 * Created by User on 7/11/2017.
 */

var {SortableContainer, SortableElement, arrayMove} = window.SortableHOC;

class Quiz extends React.Component {
    constructor(props) {
        super(props);
        this.addItem = this.addItem.bind(this);
        this.removeItem = this.removeItem.bind(this);
        this.activateItem = this.activateItem.bind(this);
        this.reorderItems = this.reorderItems.bind(this);
        this.state = {
            items: [
                {
                    id: uniqueId(),
                    name: "Meta",
                    active: true,
                    inputs: [
                        {
                            id: uniqueId(),
                            type: "text",
                            name: "name",
                            label: "Quiz Name",
                            validate: function (value) {
                                var isOkay = "string" === typeof value && "" !== value.trim();
                                var errorMsg = "";
                                if (!isOkay) {
                                    errorMsg = "Quiz Name cannot be empty";
                                }
                                return errorMsg;
                            }
                        },
                        {
                            id: uniqueId(),
                            type: "textArea",
                            name: "description",
                            label: "Description About Quiz",
                            validate: function (value) {
                                var isOkay = "string" === typeof value && "" !== value.trim();
                                var errorMsg = "";
                                if (!isOkay) {
                                    errorMsg = "Quiz Description cannot be empty";
                                }
                                return errorMsg;
                            }
                        }
                    ],
                    fixed: true
                },
                {
                    id: uniqueId(),
                    active: false,
                    name: "Results",
                    inputs: [
                        {
                            id: uniqueId(),
                            type: "selectBox",
                            name: "canvasSize",
                            label: "Canvas Size",
                            options: [
                                {id: uniqueId(), value: "720x377", text: "720x377"},
                                {id: uniqueId(), value: "360x292", text: "360x292"}
                            ],
                            validate: function (value) {
                                return "";
                            }
                        }
                    ],
                    fixed: true
                }
            ]
        };
    }

    addItem() {
        this.state.items.forEach((item) => {
            item.active = false;
        });

        var itemName = "Tab " + (this.state.items.length + 1);
        if (itemName) {
            var newItem = {
                id: uniqueId(),
                name: itemName,
                active: true,
                inputs: [],
                validate: function (value) {
                    return "";
                },
                fixed: false
            };
            this.setState((prevState) => ({
                items: prevState.items.concat(newItem)
            }));
            DOMRender();
        }
    }

    removeItem() {
        const items = this.state.items;
        var index = items.indexOf(items.find((item) => item.active));
        items.splice(index, 1);

        this.setState({items : items})
    }

    activateItem(id) {
        this.state.items.forEach((item) => {
            item.active = (id === item.id);
        });
        DOMRender();
    }

    reorderItems({oldIndex, newIndex}) {
        this.setState({
            items: arrayMove(this.state.items, oldIndex, newIndex)
        });
    }

    render() {
        var activeItem = this.state.items.find(item => item.active);
        var formInputs = [];
        if (activeItem) {
            formInputs = activeItem.inputs;
        }
        return (
            <div>
                <div className="page-left">
                    <TabBar
                        items={this.state.items}
                        activateItem={this.activateItem}
                        reorderItems={this.reorderItems}
                    />
                    <Form inputs={formInputs} />
                </div>
                <div className="page-right">
                    <TabCtrl
                        items={this.state.items}
                        addItem={this.addItem}
                        removeItem={this.removeItem}
                        activateItem={this.activateItem}
                    />
                </div>
            </div>
        );
    }
}

class TabCtrl extends React.Component {
    render() {
        return (
            <div className="tab-ctrl" style={{zIndex:10}}>
                <button className="btn btn-sm btn-success" onClick={this.props.addItem}>Add tab</button>
                <button className="btn btn-sm btn-danger" onClick={this.props.removeItem}>Remove tab</button>
                <button
                    className="btn btn-sm btn-info"
                    onClick={() => {
                            var id;
                            this.props.items.forEach((item, index, items) => {
                                if (item.active && items[index + 1]) {
                                    id = items[index + 1].id;
                                }
                            });
                            id && this.props.activateItem(id);
                        }
                    }
                >Activate next tab</button>
                <button
                    className="btn btn-sm btn-info"
                    onClick={() => {
                            var id;
                            this.props.items.forEach((item, index, items) => {
                                if (item.active && items[index - 1]) {
                                    id = items[index - 1].id;
                                }
                            });
                            id && this.props.activateItem(id);
                        }
                    }
                >Activate prev tab</button>
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
        var tabBar = document.querySelector("#tab-bar ul");
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
            ({item, activate}) =>
                <li
                    className={"tab" + (item.active ? " active" : "")}
                    onClick={activate}
                >
                    <span className="holder">{}</span>
                    <span className="label">{item.name}</span>
                </li>
        );

        const SortableList = SortableContainer(
            ({items, activateItem}) =>
                <ul>
                    {items.map((item, index) =>
                        <SortableItem
                            key={item.id}
                            index={index}
                            item={item}
                            activate={() => activateItem(item.id)}
                        />
                    )}
                </ul>
        );

        return (
            <div className="tab-bar" id="tab-bar">
                <SortableList
                    axis="x"
                    helperClass="SortableHelper"
                    items={this.props.items}
                    activateItem={this.props.activateItem}
                    onSortEnd={this.props.reorderItems}
                    shouldCancelStart={(event) => "holder" !== event.target.className}
                />
            </div>
        )
    }
}

class Form extends React.Component {
    render() {
        return (
            <form>
                {
                    this.props.inputs.map((item) => (
                        <FormInput key={item.id} type={item.type} name={item.name} label={item.label} options={item.options} validate={item.validate} />
                    ))
                }
            </form>
        );
    }
}

class FormInput extends React.Component {
    constructor(props) {
        super(props);
        this.handleChange = this.handleChange.bind(this);
        this.state = {
            value: "",
            errorMsg: ""
        };
    }

    handleChange(event) {
        this.state.value = event.target.value;
        this.state.errorMsg = this.props.validate(this.state.value);
        if ("" !== this.state.errorMsg) {
            DOMRender();
        }
    }

    render() {
        var type = this.props.type;
        var name = this.props.name;
        var input;
        switch (type) {
            case "textArea":
                input = <textArea name={name} onChange={this.handleChange} onBlur={this.handleChange} />;
                break;
            case "selectBox":
                input = <select name={name} onChange={this.handleChange} onBlur={this.handleChange}>
                    {
                        this.props.options.map((option) => (
                            <option key={option.id} value={option.value}>{option.text}</option>
                        ))
                    }
                </select>;
                break;
            default:
                input = <input type={type} name={name} onChange={this.handleChange} onBlur={this.handleChange} />;
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

DOMRender();

function DOMRender() {
    ReactDOM.render(<Quiz />, document.getElementById("root"));
}

function uniqueId() {
    return Math.floor((Math.random() * 1000000000) + 1);
}
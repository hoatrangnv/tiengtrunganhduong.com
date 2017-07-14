/**
 * Created by @vanquyet on 7/11/2017.
 */

var {SortableContainer, SortableElement, arrayMove} = window.SortableHOC;

function EditorInput(config) {
    this.id = uniqueId();
    this.name = config.name;
    this.type = config.type;
    this.label = config.label;
    this.options = config.options;
    this.validate = config.validate;
}

function QuizItem(config) {
    this.id = uniqueId();
    this.name = config.name;
    this.type = config.type;
    this.active = config.active;
    this.inputs = config.inputConfigs.map((inputConfig) => (new EditorInput(inputConfig)));
}

class QuizEditor extends React.Component {
    constructor(props) {
        super(props);
        this.addItem = this.addItem.bind(this);
        this.removeItem = this.removeItem.bind(this);
        this.activateItem = this.activateItem.bind(this);
        this.reorderItems = this.reorderItems.bind(this);
        var quizItem = new QuizItem({
            name: "Quiz",
            type: "Quiz",
            inputConfigs: [
                {
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
            ]
        });
        this.state = {
            items: [
                quizItem
            ],
            activeItemId: quizItem.id
        };

        this.addableItems = [
            {
                id: uniqueId(),
                name: "Param",
                type: "Param",
                inputConfigs: [
                    {
                        type: "text",
                        name: "name",
                        label: "Name",
                        validate: function (value) {
                            var isOkay = "string" === typeof value && "" !== value.trim();
                            var errorMsg = "";
                            if (!isOkay) {
                                errorMsg = "Name cannot be empty";
                            }
                            return errorMsg;
                        }
                    }
                ]
            },
            {
                id: uniqueId(),
                name: "Character",
                type: "Character",
                inputConfigs: [
                    {
                        type: "text",
                        name: "name",
                        label: "Name",
                        validate: function (value) {
                            return "";
                        }
                    },
                    {
                        type: "text",
                        name: "var_name",
                        label: "Var Name",
                        validate: function (value) {
                            return "";
                        }
                    },
                    {
                        type: "selectBox",
                        name: "type",
                        label: "Type",
                        validate: function (value) {
                            return "";
                        },
                        options: [
                            {id: uniqueId(), value: "player", text: "Player"},
                            {id: uniqueId(), value: "player_friend", text: "Player's Friend"}
                        ]
                    },
                    {
                        type: "number",
                        name: "index",
                        label: "Index",
                        validate: function (value) {
                            return "";
                        }
                    }
                ]
            },
            {
                id: uniqueId(),
                name: "Character Medium",
                type: "CharacterMedium",
                inputConfigs: [
                    {
                        type: "text",
                        name: "name",
                        label: "Name",
                        validate: function (value) {
                            return "";
                        }
                    },
                    {
                        type: "text",
                        name: "var_name",
                        label: "Var Name",
                        validate: function (value) {
                            return "";
                        }
                    },
                    {
                        type: "selectBox",
                        name: "type",
                        label: "Type",
                        validate: function (value) {
                            return "";
                        },
                        options: [
                            {id: uniqueId(), value: "avatar", text: "Avatar"},
                            {id: uniqueId(), value: "photo", text: "Photo"}
                        ]
                    },
                    {
                        type: "number",
                        name: "index",
                        label: "Index",
                        validate: function (value) {
                            return "";
                        }
                    },
                    {
                        type: "selectBox",
                        name: "character_id",
                        label: "Character",
                        validate: function (value) {
                            return "";
                        },
                        options: () => {
                            return this.state.items
                                .filter((item) => (item.type === "Character"))
                                .map((item) => ({id: uniqueId(), value: item.id, text: item.name}))
                        }
                    }
                ]
            },
            {
                id: uniqueId(),
                name: "Input Group",
                type: "InputGroup",
                inputConfigs: [
                ]
            },
            {
                id: uniqueId(),
                name: "Result",
                type: "Result",
                inputConfigs: [
                    {
                        type: "text",
                        name: "name",
                        label: "Name",
                        validate: function (value) {
                            var isOkay = "string" === typeof value && "" !== value.trim();
                            var errorMsg = "";
                            if (!isOkay) {
                                errorMsg = "Name cannot be empty";
                            }
                            return errorMsg;
                        }
                    },
                    {
                        type: "selectBox",
                        name: "canvas_size",
                        label: "Canvas Size",
                        options: [
                            {id: uniqueId(), value: "720x377", text: "720x377"},
                            {id: uniqueId(), value: "360x292", text: "360x292"}
                        ],
                        validate: function (value) {
                            return "";
                        }
                    }
                ]
            }
        ];
    }

    addItem(itemConfig) {
        var newItem = new QuizItem(itemConfig);
        this.setState((prevState) => ({
            items: prevState.items.concat(newItem),
            activeItemId: newItem.id
        }));
        DOMRender();
    }

    removeItem() {
        var items = this.state.items;
        var index = items.indexOf(items.find((item) => (
            this.state.activeItemId === item.id && this.addableItems.find((itemConf) => (itemConf.type === item.type))
        )));
        if (index > -1) {
            items.splice(index, 1);
            this.setState({
                items : items,
                activeItemId: null
            });
        }
    }

    activateItem(id) {
        this.setState((prevState) => ({
            items: prevState.items,
            activeItemId: id
        }));
        DOMRender();
    }

    reorderItems({oldIndex, newIndex}) {
        this.setState((prevState) => ({
            items: arrayMove(prevState.items, oldIndex, newIndex),
            activeItemId: prevState.activeItemId
        }));
    }

    render() {
        var activeItem = this.state.items.find(item => item.id === this.state.activeItemId);
        var formInputs = [];
        if (activeItem) {
            formInputs = activeItem.inputs;
        }
        return (
            <div>
                <div className="page-left">
                    <TabBar
                        items={this.state.items}
                        reorderItems={this.reorderItems}
                        activateItem={this.activateItem}
                        activeItemId={this.state.activeItemId}
                    />
                    {activeItem.form}
                </div>
                <div className="page-right">
                    <TabCtrl
                        items={this.state.items}
                        addableItems={this.addableItems}
                        addItem={this.addItem}
                        removeItem={this.removeItem}
                        activateItem={this.activateItem}
                        activeItemId={this.state.activeItemId}
                    />
                </div>
            </div>
        );
    }
}

class TabCtrl extends React.Component {
    constructor(props) {
        super(props);
        this.activatePrevItem = this.activatePrevItem.bind(this);
        this.activateNextItem = this.activateNextItem.bind(this);
        this.toggleAddableItemsMenu = this.toggleAddableItemsMenu.bind(this);
        this.state = {
            showAddableItemsMenu: false
        };
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

    toggleAddableItemsMenu() {
        this.setState({
            showAddableItemsMenu: !this.state.showAddableItemsMenu
        });
        DOMRender();
    }

    render() {
        var addableItems = this.props.addableItems.map(
            (item) => <li key={item.id} onClick={() => this.props.addItem(item)}>{item.name}</li>
        );
        return (
            <div className="tab-ctrl">
                <button className="btn btn-success" onClick={this.toggleAddableItemsMenu}>
                    <b>+</b>
                    {this.state.showAddableItemsMenu ? <ul className="addable-items-menu">{addableItems}</ul> : ""}
                </button>
                <button className="btn btn-danger" onClick={this.props.removeItem}><b>&minus;</b></button>
                <button className="btn btn-info" onClick={this.activatePrevItem}><b>&lt;</b></button>
                <button className="btn btn-info" onClick={this.activateNextItem}><b>&gt;</b></button>
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
            ({item}) => {
                return <li
                    className={"tab" + (this.props.activeItemId === item.id ? " active" : "")}
                    onClick={() => this.props.activateItem(item.id)}
                >
                    <span className="holder">{}</span>
                    <span className="label">{item.name}</span>
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
            <div className="tab-bar" id="tab-bar">
                <SortableList
                    axis="x"
                    helperClass="SortableHelper"
                    items={this.props.items}
                    onSortEnd={this.props.reorderItems}
                    shouldCancelStart={(event) => "holder" !== event.target.className}
                />
            </div>
        )
    }
}

class Form extends React.Component {
    constructor(props) {
        super(props);
        this.handleChange = this.handleChange.bind(this);
        var inputs = {};
        this.props.inputs.forEach((input) => {
            inputs[input.name] = null
        });
        this.state = {
            inputs: inputs
        }
    }

    handleChange(name, value) {
        var inputs = this.state.inputs;
        inputs[name] = value;
        this.setState({inputs: inputs});
        this.props.onChange(inputs);
    }

    render() {
        return (
            <form>
                {
                    this.props.inputs.map((item) => (
                        <FormInput
                            key={item.id}
                            type={item.type}
                            name={item.name}
                            label={item.label}
                            options={item.options}
                            validate={item.validate}
                            value={item.value}
                            onChange={(value) => {this.handleChange(item.name, value)}}
                        />
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
            // use `(this.props.value || "")` instead of `this.props.value`
            // to avoid error "change uncontrolled input"
            value: (this.props.value || ""),
            errorMsg: ""
        };
    }

    handleChange(event) {
        var value = event.target.value;
        this.state.errorMsg = this.props.validate(value);
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
                input = <textArea name={name} value={value} onChange={this.handleChange} onBlur={this.handleChange} />;
                break;
            case "selectBox":
                input = <select name={name} value={value} onChange={this.handleChange} onBlur={this.handleChange}>
                    {
                        ("function" === typeof this.props.options ? this.props.options() : this.props.options)
                            .map((option) => (
                                <option key={option.id} value={option.value}>{option.text}</option>
                            ))
                    }
                </select>;
                break;
            default:
                input = <input type={type} name={name} value={value} onChange={this.handleChange} onBlur={this.handleChange} />;
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

// class TextInput extends React.Component {
//     constructor(props) {
//         super(props);
//         this.handleChange = this.handleChange.bind(this);
//         this.state = {
//             value: "",
//             errorMsg: ""
//         };
//     }
//
//     handleChange(event) {
//         this.state.value = event.target.value;
//         this.state.errorMsg = this.props.validate(this.state.value);
//         if ("" !== this.state.errorMsg) {
//             DOMRender();
//         }
//     }
//
//     render() {
//         return (
//             <div className="input-div">
//                 <label>{this.props.label}</label>
//                 <input
//                     type="text"
//                     name={this.props.name}
//                     onChange={this.handleChange}
//                 />
//             </div>
//         );
//     }
// }

DOMRender();

function DOMRender() {
    ReactDOM.render(<QuizEditor />, document.getElementById("root"));
}

function uniqueId() {
    return Math.floor(1 + (9999 * Math.random()));
}

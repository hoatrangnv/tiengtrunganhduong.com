/**
 * Created by User on 7/11/2017.
 */

class Quiz extends React.Component {
    constructor(props) {
        super(props);
        this.addItem = this.addItem.bind(this);
        this.activateItem = this.activateItem.bind(this);
        this.changeOrder = this.changeOrder.bind(this);
        this.state = {
            items: [
                {
                    id: Math.random(),
                    name: "Meta",
                    active: true,
                    inputs: [
                        {
                            id: Math.random(),
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
                            id: Math.random(),
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
                    id: Math.random(),
                    active: false,
                    name: "Results",
                    inputs: [
                        {
                            id: Math.random(),
                            type: "selectBox",
                            name: "canvasSize",
                            label: "Canvas Size",
                            options: [
                                {id: Math.random(), value: "720x377", text: "720x377"},
                                {id: Math.random(), value: "360x292", text: "360x292"}
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

    addItem(event) {
        this.state.items.forEach((item) => {
            item.active = false;
        });

        var itemName = prompt("Please enter item name", "Tab " + (this.state.items.length + 1));
        if (itemName) {
            var newItem = {
                id: Math.random(),
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

    activateItem(id) {
        this.state.items.forEach((item) => {
            item.active = (id === item.id);
        });
        DOMRender();
    }

    changeOrder(curIndex, newIndex) {
        var newItems = this.state.items.filter((item, index) => {return (index !== curIndex)});
        newItems.splice(newIndex, 0, this.state.items[curIndex]);
        this.setState(() => ({
            items: newItems
        }));
    }

    render() {
        var activeItem = this.state.items.find((item) => (item.active));
        var formInputs = [];
        if (activeItem) {
            formInputs = activeItem.inputs;
        }
        return (
            <div>
                <TabBar
                    items={this.state.items}
                    addItem={this.addItem}
                    activateItem={this.activateItem}
                    changeOrder={this.changeOrder}
                />
                <Form inputs={formInputs} />
            </div>
        );
    }
}

var {SortableContainer, SortableElement, arrayMove} = window.SortableHOC;
const SortableItem = SortableElement(({item}) => <li
    className={"SortableItem" + (item.active ? " active" : "")}
    onClick={item.activate}
>{item.name}</li>);

const SortableList = SortableContainer(({items}) => {
    return (
        <ul className="tab-bar">
            {items.map((item, index) =>
                <SortableItem key={item.id} activateItem={this.props.activateItem(item.id)} index={index} item={item} />
            )}
        </ul>
    );
});

class TabBar extends React.Component {

    constructor(props) {
        super(props);
        this.state = {
            items: this.props.items
        }
    }
    onSortEnd({oldIndex, newIndex}) {
        this.setState({
            items: arrayMove(this.state.items, oldIndex, newIndex)
        });
    }
    render() {
        return (
            <SortableList items={this.state.items} axis="x" activateItem={this.props.activateItem} onSortEnd={this.onSortEnd.bind(this)} helperClass="SortableHelper" />
        )
    }
    // var slots = [<li key={Math.random()} {...{"data-index": 0}}>{}</li>];
    // this.props.items.forEach((item, index) => {
    //     slots.push(
    //         <li
    //             key={item.id}
    //             className={item.active ? "active" : ""}
    //             onClick={() => { this.props.activateItem(item.id); }}
    //             {...{"data-index": index}}
    //         >
    //             <div {...{"data-index": index}}>{item.name}</div>
    //         </li>
    //     );
    //     slots.push(<li key={Math.random()} {...{"data-index": index + 1}}>{}</li>);
    // });
    //
    // return (
    //     <ul className="tab-bar">
    //         {slots}
    //         <li onClick={this.props.addItem}>Add #{this.props.items.length + 1}</li>
    //     </ul>
    // );
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

// class TodoApp extends React.Component {
//     constructor(props) {
//         super(props);
//         this.addItem = this.addItem.bind(this);
//         this.state = {items: [
//             {
//                 text: "Quiz Info",
//                 id: Date.now(),
//                 order: 1,
//                 active: true,
//                 form: {
//                     name: "Quiz Info",
//                     fields: [
//                         {
//                             name: "name",
//                             type: "text"
//                         },
//                         {
//                             name: "description",
//                             type: "text"
//                         }
//                     ]
//                 }
//             }
//         ]};
//     }
//
//     render() {
//         this.state.items.sort(function (a, b) {
//             return a.order - b.order;
//         });
//         console.log(this.state.items);
//         return (
//             <div>
//                 <h3>TODO</h3>
//                 <TodoList items={this.state.items} addItem={this.addItem} />
//                 <Form fields={this.state.items.find(function (item) {
//                     return item.active;
//                 }).form.fields} />
//             </div>
//         );
//     }
//
//     addItem() {
//         this.state.items.forEach(function (item) {
//             item.active = false;
//         });
//         var newItem = {
//             text: "Step " + (this.state.items.length + 1),
//             id: Date.now(),
//             order: this.state.items.length + 1,
//             active: true,
//             form: {
//                 name: "",
//                 fields: []
//             }
//         };
//         this.setState((prevState) => ({
//             items: prevState.items.concat(newItem)
//         }));
//     }
// }
//
// class Form extends React.Component {
//     render() {
//         return (
//             <form>{
//                 this.props.fields.map((item, index, items) => {
//                     return (<input name={item.name} type={item.type} />);
//                 })
//             }</form>
//         );
//     }
// }
//
// class TodoList extends React.Component {
//     render() {
//         return (
//             <ul className="tab-list">
//                 {this.props.items.map((item, index, items) => (
//                     <li
//                         key={item.id}
//                         className={item.active ? "active" : ""}
//                         onClick={(e) => {
//                             if (e.target.className != "move-button") {
//                                 items.forEach(function (item) {
//                                     item.active = false;
//                                 });
//                                 item.active = true;
//                                 DOMRender();
//                             }
//                         }}
//                     >
//                         <button className="move-button left-move" onClick={() => {
//                             if (items[index - 1]) {
//                                 item.order --;
//                                 items[index - 1].order ++;
//                                 DOMRender();
//                             }
//                         }}>&lt;</button>
//                         <span className="text">{item.text}</span>
//                         <button className="move-button right-move" onClick={() => {
//                             if (items[index + 1]) {
//                                 item.order ++;
//                                 items[index + 1].order --;
//                                 DOMRender();
//                             }
//                         }}>&gt;</button>
//                     </li>
//                 ))}
//                 <li
//                     onClick={() => {
//                         this.props.addItem();
//                         DOMRender();
//                     }}
//                 ><i>add#{this.props.items.length + 1}</i></li>
//             </ul>
//         );
//     }
// }
//
// DOMRender();
// function DOMRender() {
//     ReactDOM.render(<TodoApp />, document.getElementById("root"));
// }
//

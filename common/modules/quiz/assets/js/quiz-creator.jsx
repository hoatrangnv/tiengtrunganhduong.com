/**
 * Created by User on 7/11/2017.
 */

class TodoApp extends React.Component {
    constructor(props) {
        super(props);
        this.addItem = this.addItem.bind(this);
        this.state = {items: [
            {
                text: "Quiz Info",
                id: Date.now(),
                order: 1,
                active: true,
                form: {
                    name: "Quiz Info",
                    fields: [
                        {
                            name: "name",
                            type: "text"
                        },
                        {
                            name: "description",
                            type: "text"
                        }
                    ]
                }
            }
        ], text: ""};
    }

    render() {
        this.state.items.sort(function (a, b) {
            return a.order - b.order;
        });
        console.log(this.state.items);
        return (
            <div>
                <h3>TODO</h3>
                <TodoList items={this.state.items} addItem={this.addItem} />
                <Form fields={this.state.items.find(function (item) {
                    return item.active;
                }).form.fields} />
            </div>
        );
    }

    addItem() {
        this.state.items.forEach(function (item) {
            item.active = false;
        });
        var newItem = {
            text: "Step " + (this.state.items.length + 1),
            id: Date.now(),
            order: this.state.items.length + 1,
            active: true,
            form: {
                name: "",
                fields: []
            }
        };
        this.setState((prevState) => ({
            items: prevState.items.concat(newItem),
            text: ""
        }));
    }
}

class Form extends React.Component {
    render() {
        return (
            <form>{
                this.props.fields.map((item, index, items) => {
                    return (<input name={item.name} type={item.type} />);
                })
            }</form>
        );
    }
}

class TodoList extends React.Component {
    render() {
        return (
            <ul className="tab-list">
                {this.props.items.map((item, index, items) => (
                    <li
                        key={item.id}
                        className={item.active ? "active" : ""}
                        onClick={(e) => {
                            if (e.target.className != "move-button") {
                                items.forEach(function (item) {
                                    item.active = false;
                                });
                                item.active = true;
                                DOMRender();
                            }
                        }}
                    >
                        <button className="move-button left-move" onClick={() => {
                            if (items[index - 1]) {
                                item.order --;
                                items[index - 1].order ++;
                                DOMRender();
                            }
                        }}>&lt;</button>
                        <span className="text">{item.text}</span>
                        <button className="move-button right-move" onClick={() => {
                            if (items[index + 1]) {
                                item.order ++;
                                items[index + 1].order --;
                                DOMRender();
                            }
                        }}>&gt;</button>
                    </li>
                ))}
                <li
                    onClick={() => {
                        this.props.addItem();
                        DOMRender();
                    }}
                ><i>add#{this.props.items.length + 1}</i></li>
            </ul>
        );
    }
}

DOMRender();
function DOMRender() {
    ReactDOM.render(<TodoApp />, document.getElementById("root"));
}


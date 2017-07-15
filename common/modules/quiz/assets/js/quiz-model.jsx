var {SortableContainer, SortableElement, arrayMove} = window.SortableHOC;

class QuizModel extends React.Component {
    constructor(props) {
        super(props);
        this.id = uniqueId();
        this.type = this.props.type;
        this.state = {
            attrs: this.props.attrConfigs.map((config) => new QuizModelAttr(config)),
            children: this.props.childConfigs.map((config) => new QuizModel(config))
        };
    }

    render() {
        return <div>{this.type}</div>;
    }
}

class QuizModelAttr extends React.Component {
    constructor(props) {
        super(props);
        this.id = uniqueId();
        this.name = this.props.name;
        this.type = this.props.type;
        this.label = this.props.label;
        this.options = this.props.options;
        this.validate = this.props.validate;
    }
}

function uniqueId() {
    return Math.floor(1 + (999999999 * Math.random()));
}

function DOMRender() {
    ReactDOM.render(<QuizModel type="Quiz" attrConfigs={[]} childConfigs={[]} />, document.getElementById("root"));
}

DOMRender();
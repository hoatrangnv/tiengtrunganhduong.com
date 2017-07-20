/**
 * Created by User on 7/21/2017.
 */

class CKEditor extends React.Component {
    constructor(props) {
        super(props);
        this.elementName = this.props.name;
        this.componentDidMount = this.componentDidMount.bind(this);
    }

    render() {
        return (
            <textarea name={this.elementName} defaultValue={this.props.value} onChange={this.props.onChange}>{}</textarea>
        )
    }

    componentDidMount() {
        let configuration = {
            toolbar: "Basic"
        };
        CKEDITOR.replace(this.elementName, configuration);
        CKEDITOR.instances[this.elementName].on("change", function (event) {
            let target = CKEDITOR.instances[this.elementName];
            target.value = target.getData();
            event.target = target;
            this.props.onChange(event);
        }.bind(this));
    }
}

window.CKEditor = CKEditor;

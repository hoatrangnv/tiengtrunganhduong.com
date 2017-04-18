<style>
    * {
        margin: 0;
        padding: 0;
        position: relative;
        box-sizing: border-box;
        -webkit-box-sizing: border-box;
        vertical-align: baseline;
        word-wrap: break-word;
    }
    .container {
        max-width: 640px;
        margin: auto;
        width: 100%;
        padding: 0.5rem;
    }
    html {
        font-family: 'Source Sans Pro', Helvetica, Arial, sans-serif;
        font-size: 15px;
        line-height: 1.4;
        color: #333;
    }
    a {
        text-decoration: none;
        color: inherit;
        cursor: pointer;
    }
    a.link {
        color: #06b;
    }
    a.link:hover {
        text-decoration: underline;
    }

    .breadcrumb {
        margin-bottom: 1em;
        color: #aaa;
    }
    .breadcrumb li {
        display: inline;
    }
    .breadcrumb li a {
        color: #06b;
    }
    .breadcrumb li:not(:first-child):before {
        content: "\00A0\00BB\00A0";
        display: inline;
    }

    footer {
        margin-top: 2rem;
    }
    footer .container {
        background: #eee;
    }

    h1 {
        border-bottom: 0.25em solid #eee;
    }
    h1 + * {
        margin-top: 2em;
    }
    h2 + * {
        margin-top: 0.5em;
    }
    article div + p,
    article p + div,
    article div + div {
        margin-top: 0.5em;
    }

    .list-view li {
        list-style: none;
    }
    .list-view li + li {
        margin-top: 0.5em;
        padding-top: 0.5em;
        border-top: 1px dashed #eee;
    }
    .list-view li a {
        font-size: 1.3em;
    }

    code {
        word-wrap: break-word;
        white-space: normal;
    }
    .code-example code,
    .code-example textarea,
    .code-example iframe {
        display: block;
        width: 100%;
        border-style: solid;
        border-color: #cde;
        border-width: 0;
        border-radius: 0;
        padding: 1rem 0;
        box-sizing: border-box;
        -webkit-box-sizing: border-box;
        margin: 0;
    }
    .code-example code,
    .code-example textarea
    {
        display: block;
        white-space: pre;
        word-wrap: normal;
        overflow-x: auto;
        overflow-y: hidden;
        height: auto;
        width: 100%;
        font-size: 1rem;
        line-height: 1.1;
        font-weight: normal;
        font-family: monospace, monospace;
        font-stretch: normal;
        border-top-width: 1px;
    }
    .code-example code {
        background: #f8f8f8;
    }
    .code-example textarea {
        resize: none;
        background: transparent;
        -webkit-appearance: none;
        -moz-appearance: none;
        appearance: none;
    }
    .code-example iframe {
        height: 0;
        max-height: 90vh;
        border-bottom-width: 1px;
    }
    .code-example button {
        margin: 0;
        width: 100%;
        border: none;
        border-radius: 0;
        background: #e6eaef;
        padding: 0.5em;
    }
    .code-example button:after {
        content: "run code";
    }
    .code-example.code-example-manual-running button:after {
        content: "click to run code";
    }

    .table-wrap {
        display: block;
        overflow-x: auto;
        width: 100%;
    }
    .table-wrap table {
        min-width: 100%;
    }

    .img-wrap,
    .img-wrap img {
        display: block;
        max-width: 100%;
    }

    .mirror-html-comment {
        background: rgba(255, 255, 255, 0.3);
        /*background: #fff;*/
        /*opacity: 0.5;*/
    }
    .mirror-css-comment {
        background: rgba(221, 255, 213, 0.3);
        /*background: #dfc;*/
        /*opacity: 0.5;*/
    }
    .mirror-js-comment {
        background: rgba(204, 247, 255, 0.3);
        /*background: #fdc;*/
        /*opacity: 0.5;*/
    }

</style>
import React, { Component } from 'react';
import ReactDOM from 'react-dom';
import Header from './header/Header';
import Content from './content/Content';

import '../app.css';

export default class Main extends Component {
    constructor(props) {
        super(props);
    }

    render() {
        return (
            <div className = 'content-container'>
                <Header />
                <Content />
            </div>
        );
    }
}

if (document.getElementById('app')) {
    ReactDOM.render(<Main />, document.getElementById('app'));
}

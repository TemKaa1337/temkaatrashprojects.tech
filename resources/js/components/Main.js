import React from 'react';
import ReactDOM from 'react-dom';
import Header from './header/Header';
import Footer from './footer/Footer';
import Content from './content/Content';

import '../app.css';

function Main() {
    return (
        <div className = 'content-container'>
            <Header />
            <Content />
            <Footer />
        </div>
    );
}

export default Main;

if (document.getElementById('app')) {
    ReactDOM.render(<Main />, document.getElementById('app'));
}

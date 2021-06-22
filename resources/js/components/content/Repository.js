import React, { Component } from 'react';

export default class Repository extends Component {
    constructor(props) {
        super(props);
    }

    render() {
        return (
            <div className = 'repository'>
                <div className = 'repo-name'>
                    <p>{this.props.name}</p>
                </div>
                <div className = 'repo-description'>
                    <p>{this.props.description}</p>
                </div>
                <div className = 'repo-info'>
                    <a> <span className = {'repo-language ' + this.props.language.toLowerCase()}></span> {this.props.language}</a>
                    <a href = {this.props.repositoryUrl}>Git</a>
                    <a href = {this.props.cloneUrl}>Clone</a>
                    <a>Created at: {this.props.createdAt}</a>
                    <a href = {this.props.demoUrl ?? '#'}>{this.props.demoUrl ? 'Demo' : '(currently no demo link provided)'}</a>
                </div>
            </div>
        );
    }
}

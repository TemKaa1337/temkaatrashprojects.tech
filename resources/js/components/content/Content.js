import React, { Component } from 'react';
import Repository from './Repository';

export default class Content extends Component {
    constructor(props) {
        super(props);

        this.state = {
            error: null,
            isLoaded: false,
            repositories: []
        };
    }

    componentDidMount() {
        const url = 'http://temkaatrashprojects.tech/api/get/repositories';

        fetch(url)
        .then(response => response.json())
        .then(
            (result) => {
                this.setState({
                    isLoaded: true,
                    repositories: result
                });
            },
            (error) => {
                this.setState({
                    isLoaded: true,
                    error: error
                });
            }
        )
    }

    render() {
        const {error, isLoaded, repositories} = this.state;

        if (error) {
            return <h1>An error occured. Message: {error.message}.</h1>;
        }

        if (!isLoaded) {
            return <h1>Loading...</h1>;
        }

        return (
            <div className = 'content-repositories'>
                <div></div>

                <div className = 'repositories'>
                    {
                        repositories.map(repository =>
                            <Repository
                                key = {repository.id}
                                name = {repository.name}
                                description = {repository.description}
                                language = {repository.language}
                                repositoryUrl = {repository.repository_url}
                                cloneUrl = {repository.clone_url}
                                demoUrl = {repository.demo_url}
                            />
                        )
                    }
                </div>

                <div></div>
            </div>
        );
    }
}

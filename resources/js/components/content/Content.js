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
        // const url = 'http://temkaatrashprojects.tech/api/get/repositories';
        const url = 'https://www.thecocktaildb.com/api/json/v1/1/filter.php?c=Cocktail';

        fetch(url)
        .then(response => response.json())
        .then(
            (result) => {
                // this.setState({
                //     isLoaded: true,
                //     repositories: result
                // });

                this.setState({
                    isLoaded: true,
                    repositories: [
                        {
                            id: 1,
                            name: 'financial-telegram-bot',
                            description: 'Bot that helps you to count your expenses and really helps ypu save so smuch money so you can buy a mazeratti and bentley',
                            language: 'PHP',
                            repository_url: 'https://github.com/TemKaa1337/financial-accounting-telegram-bot',
                            clone_url: 'https://github.com/TemKaa1337/financial-accounting-telegram-bot.git',
                            demo_url: 'http://temkaatrashprojects.tech'
                        },
                        {
                            id: 2,
                            name: 'financial-telegram-bot',
                            description: 'Bot that helps you to count your expenses and really helps ypu save so smuch money so you can buy a mazeratti and bentley',
                            language: 'PHP',
                            repository_url: 'https://github.com/TemKaa1337/financial-accounting-telegram-bot',
                            clone_url: 'https://github.com/TemKaa1337/financial-accounting-telegram-bot.git',
                            demo_url: 'http://temkaatrashprojects.tech'
                        },
                        {
                            id: 3,
                            name: 'financial-telegram-bot',
                            description: 'Bot that helps you to count your expenses and really helps ypu save so smuch money so you can buy a mazeratti and bentley',
                            language: 'PHP',
                            repository_url: 'https://github.com/TemKaa1337/financial-accounting-telegram-bot',
                            clone_url: 'https://github.com/TemKaa1337/financial-accounting-telegram-bot.git',
                            demo_url: 'http://temkaatrashprojects.tech'
                        },
                        {
                            id: 4,
                            name: 'financial-telegram-bot',
                            description: 'Bot that helps you to count your expenses and really helps ypu save so smuch money so you can buy a mazeratti and bentley',
                            language: 'PHP',
                            repository_url: 'https://github.com/TemKaa1337/financial-accounting-telegram-bot',
                            clone_url: 'https://github.com/TemKaa1337/financial-accounting-telegram-bot.git',
                            demo_url: 'http://temkaatrashprojects.tech'
                        },
                        {
                            id: 5,
                            name: 'financial-telegram-bot',
                            description: 'Bot that helps you to count your expenses and really helps ypu save so smuch money so you can buy a mazeratti and bentley',
                            language: 'PHP',
                            repository_url: 'https://github.com/TemKaa1337/financial-accounting-telegram-bot',
                            clone_url: 'https://github.com/TemKaa1337/financial-accounting-telegram-bot.git',
                            demo_url: 'http://temkaatrashprojects.tech'
                        },
                    ]
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

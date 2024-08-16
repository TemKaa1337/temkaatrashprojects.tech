.PHONY: setup snapshot tests

up:
	@docker compose up -d --build

down:
	@docker compose down

php-cli:
	@docker compose exec php zsh

postgres-cli:
	@docker compose exec postgres bash

tests:
	@docker compose exec php php vendor/bin/phpunit --testsuite integrations

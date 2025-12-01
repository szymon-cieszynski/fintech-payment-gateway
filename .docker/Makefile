.PHONY: start stop sh logs dbshell migrate composer test

COMPOSE=docker-compose -f docker-compose.yml

start:
	$(COMPOSE) up -d --build

stop:
	$(COMPOSE) stop

sh:
	$(COMPOSE) exec php bash

logs:
	$(COMPOSE) logs -f nginx

composer:
	$(COMPOSE) exec php bash -lc "composer $(filter-out $@,$(MAKECMDGOALS))"

dbshell:
	$(COMPOSE) exec db bash

migrate:
	$(COMPOSE) exec php bash -lc "php bin/console doctrine:migrations:migrate --no-interaction"

test:
	$(COMPOSE) exec php bash -lc "vendor/bin/phpunit --colors=always"

all: install up
.PHONY: all

up:
	docker-compose up -d --force-recreate --remove-orphans
.PHONY: up

down:
	docker-compose down
.PHONY: down

restart: down up
.PHONY: restart

migrate:
	docker-compose run --rm web php oil refine migrate:current
.PHONY: migrate

seed:
	docker-compose run --rm web php oil r seed:all
.PHONY: seed

install: setup sleep migrate create_default_user
	docker-compose run --rm web php oil r create_default_user
.PHONY: install

create_default_user:
	docker-compose run --rm web php oil r create_default_user
.PHONY: create_default_user

setup:
	docker-compose build
	git submodule init
	docker-compose run --rm composer install
	git submodule init
	git submodule update
.PHONY: setup

build:
	docker-compose build --no-cache
.PHONY: build

test:
	docker-compose run --rm web php oil test --group=App
.PHONY: test

console:
	docker-compose run --rm web php oil console
.PHONY: console

composer:
	docker-compose run --rm composer install
.PHONY: composer

sleep:
	sleep 20
.PHONY: sleep

reset: clean up sleep migrate seed create_default_user
.PHONY: reset

clean:
	docker-compose down
	docker volume rm kinyujoshi_db-data
.PHONY: clean

mysql:
	docker-compose exec db mysql -uroot -ppass -Dkinyujoshi_development
.PHONY: mysql

change_administrator:
	docker-compose run --rm web php oil r change_administrator
.PHONY: change_administrator

bash:
	docker-compose run --rm web bash
.PHONY: bash

ps:
	docker-compose ps
.PHONY: ps

open:
	open http:/localhost
.PHONY: open

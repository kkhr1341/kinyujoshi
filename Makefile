all: install up
.PHONY: all

up:
	docker-compose up -d
.PHONY: up

migrate:
	docker-compose run --rm web php oil refine migrate:current
.PHONY: migrate

seed:
	docker-compose run --rm web php oil r seed:all
.PHONY: seed

install: setup sleep10 migrate
.PHONY: install

setup:
	docker-compose build
	git submodule init
	docker-compose run --rm composer install
	git submodule init
	git submodule update
	docker-compose run --rm createbuckets
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

down:
	docker-compose down
.PHONY: down

sleep10:
	sleep 10
.PHONY: sleep10

reset: clean up sleep10 migrate seed
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
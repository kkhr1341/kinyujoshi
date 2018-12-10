all: install up
.PHONY: all

up:
	docker-compose up -d
.PHONY: up

migrate:
	docker-compose run --rm web php oil refine migrate:current
	docker-compose run --rm -e FUEL_ENV=test web php oil refine migrate:current
.PHONY: migrate

seed:
	docker-compose run --rm web php oil r seed:all
.PHONY: seed

install:
	docker-compose build
	git submodule init
	docker-compose run --rm composer install
	git submodule init
	git submodule update
	docker-compose run --rm createbuckets
.PHONY: install

build:
	docker-compose build --no-cache
.PHONY: build

test:
	docker-compose run --rm web php oil test --group=App
.PHONY: test

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
	docker volume rm kinyujoshi_test-db-data
.PHONY: clean

mysql:
	docker-compose exec db mysql -uroot -ppass -Dkinyujoshi_development
.PHONY: mysql

change_administrator:
	docker-compose run --rm web php oil r change_administrator
.PHONY: change_administrator
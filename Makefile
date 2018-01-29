all: install up
.PHONY: all

up:
	docker-compose up -d
.PHONY: up

migrate:
	docker-compose run --rm web php oil refine migrate:current
	docker-compose run --rm -e FUEL_ENV=test web php oil refine migrate:current
.PHONY: migrate

install:
	docker-compose build
	git submodule init
	docker-compose run composer update
	git submodule init
	git submodule update
	docker-compose run --rm createbuckets
.PHONY: install

test:
	docker-compose run --rm web php oil test --group=App
.PHONY: test

clean:
	docker-compose down
.PHONY: clean

reset:
	docker-compose down
	docker volume rm kinyujoshi_db-data
	docker volume rm kinyujoshi_test-db-data
	docker-compose up -d
.PHONY: reset

mysql:
	docker-compose exec db mysql -uroot -ppass
.PHONY: mysql

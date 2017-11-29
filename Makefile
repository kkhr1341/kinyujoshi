all: install up
.PHONY: all

up:
	docker-compose up -d
.PHONY: up

migrate:
	docker-compose run --rm web php oil refine migrate
	docker-compose run --rm -e FUEL_ENV=test web php oil refine migrate
.PHONY: migrate

install:
	git submodule init
	docker-compose run composer update
	git submodule update --init --recursive
.PHONY: install

test:
	docker-compose run --rm web php oil test --group=App
.PHONY: test

clean:
	docker-compose down
.PHONY: clean

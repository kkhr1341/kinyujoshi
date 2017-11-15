all: install up
.PHONY: all

up:
	docker-compose up -d
.PHONY: up

migrate:
	docker-compose run --rm web php oil refine migrate
.PHONY: migrate

install:
	git submodule init
	docker-compose run composer install
	git submodule update --init --recursive
.PHONY: install

clean:
	docker-compose down
.PHONY: clean

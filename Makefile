all: install up
.PHONY: all

up:
	docker-compose up -d
.PHONY: up

install:
	docker-compose run composer install
.PHONY: install

clean:
	docker-compose down
.PHONY: clean
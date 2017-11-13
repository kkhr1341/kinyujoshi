all: install up
.PHONY: all

up:
	docker-compose up -d
.PHONY: up

install:
	git submodule init
	#git submodule update
	#git submodule foreach 'git pull'
	docker-compose run composer install
	git submodule update --init --recursive
.PHONY: install

clean:
	docker-compose down
.PHONY: clean

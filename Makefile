all: install up
.PHONY: all

up:
	docker-compose up -d
.PHONY: up

install:
	git submodule init
	#git submodule update
	#git submodule foreach 'git pull'
	git submodule update --init --recursive
	docker-compose run composer install
.PHONY: install

clean:
	docker-compose down
.PHONY: clean

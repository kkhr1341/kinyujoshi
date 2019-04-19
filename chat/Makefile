build:
	docker build -t chat-app .
.PHONY: build

login:
	$(eval TIMESTAMP=$(shell aws ecr get-login --no-include-email))
	eval $(TIMESTAMP)
.PHONY: login 

run:
	docker run -d --rm -p 8080:80 --env-file=.env --name chat-app chat-app
.PHONY: run

stop:
	docker rm -f chat-app
.PHONY: stop 

restart: stop run
.PHONY: restart 

push:
	docker tag chat-app:latest 270242396698.dkr.ecr.ap-northeast-1.amazonaws.com/chat-app:latest
	docker push 270242396698.dkr.ecr.ap-northeast-1.amazonaws.com/chat-app:latest
.PHONY: push


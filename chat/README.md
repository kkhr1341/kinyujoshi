
# login for ecr
```
$(aws ecr get-login --no-include-email --region ap-northeast-1)
```

# build docker image
```
docker build -t chat-app .
```

# tag
```
docker tag chat-app:latest 270242396698.dkr.ecr.ap-northeast-1.amazonaws.com/chat-app:latest
```

# push container
```
docker push 270242396698.dkr.ecr.ap-northeast-1.amazonaws.com/chat-app:latest
```
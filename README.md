# Installation

## composer token登録

### githubでtoken生成

[github Personal access tokens](https://github.com/settings/tokens)

### 生成したトークンを以下ファイルに設定

~/.composer/.auth.json

```~/.composer/.auth.json
{  
  "config": {
    "github-oauth": {
      "github.com": "<TOKEN>"
      }
    }
}
```

## githubに公開鍵登録

### 公開鍵生成（無い方の場合のみ）

```
$ ssh-keygen
```

### githubに作成した公開鍵を登録

https://github.com/settings/keys

## docker download & install

[for mac](https://download.docker.com/mac/stable/Docker.dmg)

[for windows](https://download.docker.com/win/stable/Docker%20for%20Windows%20Installer.exe)

## ソースダウンロード

```
git clone git@bitbucket.org:kinyujoshi/kinyujoshi.git
```

## 環境を立ち上げる

```
cd kinyujoshi

make
```

## DBのテーブルを更新する（マイグレーション）

立ち上げ直後はDBが接続状態なるまで時間がかかるため、失敗した場合は時間を空けて再実行

```
make migrate
```

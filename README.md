# physiaki
# 環境構築手順
#### このディレクトリをプルしたフォルダに移動する
$ cd {フォルダ名}

# Dockerイメージを作成
$ docker-compose build

# Dockerを起動
#### -d でバックグランド起動する
$ docker-compose up -d

# 起動しているコンテナが表示される
$ docker ps

# コンテナの中に入る
$ winpty docker-compose exec app bash

# Laravelプロジェクト作成
$ composer create-project --prefer-dist laravel/laravel test "6.18.*"

# Laravelプロジェクト移動
$ cd test

# ストレージの権限変更
$ chmod 777 -R storage/

$ php artisan key:generate

http://localhostに接続

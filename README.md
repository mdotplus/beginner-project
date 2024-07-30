# お問い合わせフォーム

## 環境構築
### Dockerビルド
1. `git clone git@github.com:coachtech-material/laravel-docker-template.git`
1. `docker compose up -d --build`
### Laravel環境構築
1. docker compose exec php bash
1. composer install
1. .env.exampleファイルを複製して.envファイルを作成し、環境変数を変更
1. php artisan key:generate
1. php artisan migrate
1. php artisan db:seed

## 使用技術(実行環境)
- laravel:8.83.8
- nginx:1.21.1
- php:7.4.9
- mysql:8.0.26
- phpmyadmin

## ER図

## URL
- 開発環境：https://127.0.0.1/
- phpMyAdmin：https://127.0.0.1:8080/

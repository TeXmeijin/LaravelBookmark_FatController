# このリポジトリについて

<a href='https://www.techpit.jp/'>Techpit</a>にて登録されている教材、「LaravelでFat Controllerを卒業しよう」のリポジトリです。

# 環境構築

- 動作確認はMacBook Pro/Google Chromeにて行っています。
- Windowsの方はコマンドを読み替えていただけたらと思います。
- Git,Docker,docker-compose の導入が前提となっています。

## 初回セットアップ

### Intel / M1 共通

1. `git clone https://github.com/TeXmeijin/LaravelBookmark_FatController.git`
2. `cd LaravelBookmark_FatController`
3. `cp src/.env.sample src/.env`

### Intel Mac向け

1. `docker-compose up -d`
2. `docker-compose exec app composer install`
3. `docker-compose exec app php artisan key:generate`
4. `docker-compose exec app php artisan migrate`
5. `docker-compose exec app php artisan db:seed`
6. `docker-compose logs -f` ※コンテナのログをターミナルで見ることができます
7. `docker-compose down` ※作業を終了するときに使います

### M1 Mac向け

1. `docker-compose -f docker-compose.yml -f docker-compose.m1-mac.yml up -d`
2. `docker-compose exec app composer install`
3. `docker-compose exec app php artisan key:generate`
4. `docker-compose exec app php artisan migrate`
5. `docker-compose exec app php artisan db:seed`
6. `docker-compose logs -f` ※コンテナのログをターミナルで見ることができます
7. `docker-compose -f docker-compose.yml -f docker-compose.m1-mac.yml up down` ※作業を終了するときに使います

## ページ確認

- https://localhost へアクセスする

> https-portalというコンテナを使うことでlocalhostでもhttpsでアクセスできます。もしChromeをご利用で、https://localhost を開けなかった場合、[ChromeのSSL警告を、localhostの時だけ表示しないようにする](https://qiita.com/yanchi4425/items/76e502c41cbfb4f0542b )のとおりに対応することで開くことができます

## 初回以降の起動方法

### Intel / M1 共通

- `docker-compose logs -f`※コンテナのログをターミナルで見ることができます

### Intel Mac向け

1. `docker-compose up -d` ※作業を開始するときに使います
2. `docker-compose down` ※作業を終了するときに使います

### M1 Mac向け

1. `docker-compose -f docker-compose.yml -f docker-compose.m1-mac.yml up -d` ※作業を開始するときに使います
2. `docker-compose -f docker-compose.yml -f docker-compose.m1-mac.yml down` ※作業を終了するときに使います

# Laravelからデータベースに接続する際の接続情報

| 項目名      | 値                |
|----------|------------------|
| HOST     | db               |
| PORT     | 3306             |
| DATABASE | laravel-bookmark |
| USERNAME | root             |
| PASSWORD | secret           |

# GUIアプリケーションからの接続情報

| 項目名      | 値                | 
|----------|------------------|
| HOST     | 127.0.0.1        | 
| PORT     | 3306             | 
| DATABASE | laravel-bookmark | 
| USERNAME | root             | 
| PASSWORD | secret           | 

## 以下のアプリがおすすめです。

- Sequel Pro https://www.sequelpro.com/
- Table Plus https://tableplus.com/
- MySQL Workbench https://www.mysql.com/jp/products/workbench/

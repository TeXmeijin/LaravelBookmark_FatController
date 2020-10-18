# このリポジトリについて
<a href='https://www.techpit.jp/'>Techpit</a>にて登録されている教材、「LaravelでFat Controllerを卒業しよう」のリポジトリです。

# 環境構築
- 動作確認はMacBook Pro/Google Chromeにて行っています。
- Windowsの方はコマンドを読み替えていただけたらと思います。
- Git,Docker,docker-compose の導入が前提となっています。

## 初回セットアップ
1. `git clone https://github.com/TeXmeijin/LaravelBookmark_FatController.git`
1. `cd LaravelBookmark_FatController`
1. `cp src/.env.sample src/.env`
1. `docker-compose up -d`
1. `docker-compose exec app composer install`
1. `docker-compose exec app php artisan key:generate`
1. `docker-compose exec app php artisan migrate`
1. `docker-compose exec app php artisan db:seed`
1. `docker-compose logs -f`※コンテナのログをターミナルで見ることができます
1. https://localhost へアクセスする

> https-portalというコンテナを使うことでlocalhostでもhttpsでアクセスできます。もしChromeをご利用で、https://localhost を開けなかった場合、[ChromeのSSL警告を、localhostの時だけ表示しないようにする](https://qiita.com/yanchi4425/items/76e502c41cbfb4f0542b )のとおりに対応することで開くことができます

## 初回以降の起動方法
1. `docker-compose up -d`
1. `docker-compose logs -f`※コンテナのログをターミナルで見ることができます
1. https://localhost へアクセスする

## 作業終了時
1. `docker-compose down`

# Laravelからデータベースに接続する際の接続情報
| 項目名   | 値               | 
| -------- | ---------------- | 
| HOST     | db               | 
| PORT     | 3306             | 
| DATABASE | laravel-bookmark | 
| USERNAME | root             | 
| PASSWORD | secret           | 

# GUIアプリケーションからの接続情報
| 項目名   | 値               | 
| -------- | ---------------- | 
| HOST     | 127.0.0.1       | 
| PORT     | 3306             | 
| DATABASE | laravel-bookmark | 
| USERNAME | root             | 
| PASSWORD | secret           | 

## 以下のアプリがおすすめです。
- Sequel Pro https://www.sequelpro.com/
- Table Plus https://tableplus.com/
- MySQL Workbench https://www.mysql.com/jp/products/workbench/

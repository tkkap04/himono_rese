# himono_rese
## Rese
![Stamp](https://github.com/tkkap04/himono_rese/blob/main/shop_all.png)

## 作成した目的
飲食店の予約と決済を行うため

## アプリケーションURL
http://localhost
ログインパスワードは8文字以上

## 機能一覧
- 会員登録機能
- ログイン機能
- メール認証機能
- 飲食店検索機能
- 飲食店ソート機能
- お気に入り機能（登録・削除）
- 予約機能（新規・変更・削除）
- リマインダー機能
- QRコード照会機能
- 評価機能
- 口コミ投稿機能
- csvファイルから店舗データ取り込み機能
- 決済機能
- 管理者-店舗代表者作成機能
- 店舗代表者-店舗情報作成・更新機能
- 管理者・店舗代表者-メール送信機能

csvファイルは1列目に下記の通り項目を記載
1-A 店舗名　1-B 地域　1-C ジャンル　1-D 店舗概要　1-E 画像URL
2列目以降に各店舗ごとの情報を入力

## 使用技術(実行環境)
- Laravel Framework 8.83.27
- PHP 8.1.2

## テーブル設計
![Table](https://github.com/tkkap04/himono_rese/blob/main/table.png)

## ER図
![Atte](https://github.com/tkkap04/himono_rese/blob/main/rese.png)

## 環境構築
- Dockerのビルドからマイグレーション、シーディングまでを記述する
1. docker-compose exec php bash
2. composer install
3. .env.exampleファイルから.envを作成し、環境変数を変更
4. php artisan key:generate
5. php artisan migrate
6. php artisan storage:link
7. http://localhost/import にアクセスしてcsvファイルをインポート
8. himono_rese直下にあるshops.csvに加えて、newshop.csvを配置しました

## URL
- 開発環境：http://localhost/
- phpmyadmin：http://localhost:8080/

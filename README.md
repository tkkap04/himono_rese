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
- お気に入り機能（登録・削除）
- 予約機能（新規・変更・削除）
- リマインダー機能
- QRコード照会機能
- 評価機能
- 決済機能
- 管理者-店舗代表者作成機能
- 店舗代表者-店舗情報作成・更新機能
- 管理者・店舗代表者-メール送信機能

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

## URL
- 開発環境：http://localhost/
- phpmyadmin：http://localhost:8080/

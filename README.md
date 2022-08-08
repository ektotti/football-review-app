# football-review-app ⚽

<p align="center">
    <img src="https://user-images.githubusercontent.com/87711422/183411889-1080768a-39cf-43a3-82ad-82cb10940444.png" alt="football-review-app">
</p>

## 概要

サッカーのレビューを作戦ボードを使って共有するSNS。  
サッカーを戦術的な目線で見ることが好き！  
でも毎回作戦ボードに名前と番号を設定するのが面倒！  
という思いからできた、便利に観戦体験を共有するアプリです。


## 使用技術
- PHP 7.4.3
- Laravel 6.20.44
- Mysql 8.0 
- Nginx
- Javascript
- Vue.js 2.6.14
- AWS
  - VPC
  - EC2
  - RDS
  - S3
  - Route53
  - ALB
  - ACM
- Docker/Docker-compose


## AWS構成図

<p align="center">
    <img src="https://user-images.githubusercontent.com/87711422/183419406-06950099-d629-4327-b702-2bbb366068ad.png" alt="football-review-app">
</p>

## ER図

<p align="center">
    <img src="https://user-images.githubusercontent.com/87711422/183425095-01c680d7-258f-4db0-83ff-ffea171635ac.png" alt="football-review-app">
</p>



## 実装した機能の概要と使用したスキル

- バックエンド（Laravel:PHP）
  - 投稿のCRUD処理
  - ソーシャルログインの実装(google)
  - 画像をAWSのS3へアップロード
  - トランザクション処理
  - 中間テーブルを使ったリレーション(いいね！機能)
  - スクレイピングでのデータ取得(コマンドの作成と定期実行)
  - 正規表現を利用したタグ検索機能
- フロントエンド（Vue.js:Javascript/html/Bootstrap:css）
  - Bootstarapを使用したレイアウト及びスタイリング
  - ライブラリを使用したスライダーと無限スクロール
  - マウスイベントを利用した画面上のオブジェクトの移動
  - 図形やフリーハンドでの描画とそれのキャプチャ
  - Axiosでのサーバーとのデータのやり取り
  - async/awaitを使用した非同期処理
  - モーダル画面の作成
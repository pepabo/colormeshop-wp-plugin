# カラーミーショップ WordPress プラグイン

WordPress で [カラーミーショップ](https://shop-pro.jp/) に登録している商品情報を扱ったり、商品ページを自動生成することができるプラグインです :muscle: 

## 利用方法

当プラグインは [カラーミーショップ API](https://shop-pro.jp/func/api/) を利用して商品情報などを取得しています。  
そのため、予め下記に登録していただき、発行された情報を WordPress 管理画面で入力してください。

- [カラーミーデベロッパーアカウント](https://api.shop-pro.jp/developers/sign_up)
- [OAuthアプリケーション登録](https://api.shop-pro.jp/oauth/applications/new)

## 動作環境

PHP 5.6 以上

## 一緒に開発しませんか？

当プラグインについて、お気づきの点やアイデアをお持ちのかたはぜひ開発にご参加ください。  
また、「こんな機能あったら良さそうなんだけど、どうでしょう？」といったお話も大歓迎ですので気軽に [Issues](https://github.com/pepabo/colormeshop-wp-plugin/issues) に投稿してみましょう!

### 開発の流れ

1. このリポジトリに Star をつける (重要です! :sparkles: )
1. 自分のリポジトリにフォーク
1. ブランチを切る (`git checkout -b my-new-feature`)
1. 変更をコミット (`git commit -am 'Add some feature`)
1. ブランチをプッシュ (`git push origin my-new-feature`)
1. Pull Request を作成

### すぐに開発を始められます

[docker](https://www.docker.com/) 用のコンテナ定義ファイル `docker-compose.yml` を用意していますので、ローカル環境にすばやく WordPress を立ち上げてプラグインの開発を始められます。

```
$ cp wp.env.sample wp.env
$ docker-compose up -d
$ open http://localhost:8080
```
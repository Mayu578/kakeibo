# 家計簿アプリ (Kakeibo)

シンプルで使いやすい家計簿管理アプリケーションです。日々の収入・支出の記録や、家賃・サブスクなどの固定費管理をまとめて行うことができます。

## 🌐 サービスURL
- 本番環境: [https://kakeibo-r93g.onrender.com](https://kakeibo-r93g.onrender.com)

## 主な機能

### 📊 取引管理 (Transactions)
- 日々の収入・支出の記録、編集
- 月ごとの集計チャート表示

### ⏳ 固定費管理 (Fixed Costs)
- 家賃、保険、サブスクなど、毎月定額で発生する支出の登録・管理

### 🔐 ユーザー認証
- ログイン・新規登録機能
- ユーザーごとにデータを管理（取引・固定費・アカウント情報）

## 技術スタック

- **フレームワーク**: Laravel
- **言語**: PHP
- **フロントエンド**: Blade / CSS
- **データベース**: MySQL

## セットアップ

### 必要要件

- PHP
- Composer
- MySQL
- Node.js / npm

### インストール手順

```bash
# リポジトリをクローン
git clone https://github.com/Mayu578/kakeibo.git
cd kakeibo

# 依存パッケージをインストール
composer install
npm install

# 環境設定ファイルをコピー
cp .env.example .env
php artisan key:generate

# .envファイルにデータベース情報を設定
# DB_DATABASE, DB_USERNAME, DB_PASSWORD など

# マイグレーション実行
php artisan migrate

# アセットのビルド
npm run build

# 開発サーバーを起動
php artisan serve
```

## 開発の流れ

新しい機能を追加する際は、以下の流れで作業してください。

```bash
# 新しいブランチを作成
git checkout -b feature/機能名

# 変更をコミット
git add .
git commit -m "変更内容"

# GitHubにpush
git push -u origin feature/機能名

# GitHub上でPull Requestを作成し、mainにマージ
```

## ライセンス

このプロジェクトは個人利用・学習目的で作成されています。

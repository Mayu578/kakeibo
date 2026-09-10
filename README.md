# 家計簿アプリ (Kakeibo)

シンプルで使いやすい家計簿管理アプリケーションです。日々の収入・支出の記録や、家賃・サブスクなどの固定費管理をまとめて行うことができます。

## 🌐 サービスURL
- 本番環境: https://kakeibo-1-8t8y.onrender.com

## 主な機能

### 📊 取引管理 (Transactions)
- 日々の収入・支出の記録、編集
- 月ごとの集計チャート表示
![alt text](<スクリーンショット 2026-09-10 16.20.47.png>)

### ⏳ 固定費管理 (Fixed Costs)
- 家賃、保険、サブスクなど、毎月定額で発生する支出の登録・管理
![alt text](<スクリーンショット 2026-09-10 16.21.42.png>)

### 🔐 ユーザー認証
- ログイン・新規登録機能
- ユーザーごとにデータを管理(取引・固定費・アカウント情報)
![alt text](<スクリーンショット 2026-09-10 16.22.14.png>)

## 技術スタック

### Backend
- PHP
- Laravel

### Frontend
- Blade
- Tailwind CSS
- Vite

### Database
- PostgreSQL

### Infrastructure
- Render

## セットアップ(ローカル開発)

### 必要要件

- PHP
- Composer
- MySQL
- Node.js / npm

### インストール手順

\`\`\`bash
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
\`\`\`

## 本番環境へのデプロイ(Render)

本番環境はRender上にDockerコンテナとしてデプロイされ、データベースはRenderのマネージドPostgreSQLを使用しています。

- Web Service: Dockerfileをもとに自動ビルド
- Database: Render Postgres(内部ネットワーク経由で接続)
- デプロイ方法: `main`ブランチへのマージで自動デプロイ

### ⚠️ ローカル(MySQL)と本番(PostgreSQL)の違いに関する注意

このプロジェクトはローカルとRender環境でDBの種類が異なります。マイグレーションで生SQL(`DB::statement`など)を書く場合は、MySQLとPostgreSQLで構文が異なる点に注意してください。

| 項目 | MySQL | PostgreSQL |
|---|---|---|
| 現在のDB名取得 | `DATABASE()` | `current_schema()` |
| CHECK制約の削除 | `DROP CHECK` | `DROP CONSTRAINT` |

`Schema::getConnection()->getDriverName()` でDBの種類を判定し、環境ごとに分岐させる方法を推奨します。

## 開発の流れ

新しい機能を追加する際は、以下の流れで作業してください。

\`\`\`bash
# 新しいブランチを作成
git checkout -b feature/機能名

# 変更をコミット
git add .
git commit -m "変更内容"

# GitHubにpush
git push -u origin feature/機能名

# GitHub上でPull Requestを作成し、mainにマージ
\`\`\`

## ライセンス

このプロジェクトは個人利用・学習目的で作成されています。
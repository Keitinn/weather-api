<?php

// Vercel用のエントリーポイント
// 作業ディレクトリをプロジェクトルートに変更
chdir(__DIR__ . '/..');

// Laravelのブートストラップ
require __DIR__ . '/../public/index.php';
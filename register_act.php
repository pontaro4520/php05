<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

session_start();
require_once 'funcs.php';

// POSTデータの取得とバリデーション
$name = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_STRING);
$lid = filter_input(INPUT_POST, 'lid', FILTER_SANITIZE_STRING);
$lpw = filter_input(INPUT_POST, 'lpw', FILTER_SANITIZE_STRING);
$lpw_confirm = filter_input(INPUT_POST, 'lpw_confirm', FILTER_SANITIZE_STRING);

// 入力値の検証
if (empty($name) || empty($lid) || empty($lpw) || empty($lpw_confirm)) {
    $_SESSION['register_error'] = '全ての項目を入力してください。';
    header('Location: register.php');
    exit();
}

if ($lpw !== $lpw_confirm) {
    $_SESSION['register_error'] = 'パスワードが一致しません。';
    header('Location: register.php');
    exit();
}

if (strlen($lpw) < 8) {
    $_SESSION['register_error'] = 'パスワードは8文字以上で設定してください。';
    header('Location: register.php');
    exit();
}

try {
    // データベース接続
    $pdo = db_conn();

    // トランザクション開始
    $pdo->beginTransaction();

    // ユーザーIDの重複チェック
    $stmt = $pdo->prepare('SELECT COUNT(*) FROM users WHERE lid = :lid');
    $stmt->bindValue(':lid', $lid, PDO::PARAM_STR);
    $stmt->execute();
    $user_count = $stmt->fetchColumn();

    if ($user_count > 0) {
        throw new Exception('このユーザーIDは既に使用されています。');
    }

    // パスワードのハッシュ化
    $hashed_password = password_hash($lpw, PASSWORD_DEFAULT);

    // 新規ユーザー登録
    $stmt = $pdo->prepare('INSERT INTO users (name, lid, lpw, kanri_flg, life_flg) VALUES (:name, :lid, :lpw, 0, 0)');
    $stmt->bindValue(':name', $name, PDO::PARAM_STR);
    $stmt->bindValue(':lid', $lid, PDO::PARAM_STR);
    $stmt->bindValue(':lpw', $hashed_password, PDO::PARAM_STR);

    $status = $stmt->execute();

    if ($status === false) {
        throw new Exception('データベースエラーが発生しました。');
    }

    // トランザクションコミット
    $pdo->commit();

    // 登録成功
    $_SESSION['register_success'] = '新規登録が完了しました。ログインしてください。';
    header('Location: login.php');
    exit();

} catch (Exception $e) {
    // エラー発生時はロールバック
    $pdo->rollBack();
    
    $_SESSION['register_error'] = $e->getMessage();
    error_log('Registration Error: ' . $e->getMessage());
    header('Location: register.php');
    exit();
}
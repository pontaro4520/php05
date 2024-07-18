<?php
session_start();
require_once('funcs.php');

// POSTデータ取得
$lid = $_POST['lid'];
$new_password = $_POST['new_password'];
$confirm_password = $_POST['confirm_password'];

// バリデーション
if (empty($lid) || empty($new_password) || empty($confirm_password)) {
    $_SESSION['reset_error'] = '全ての項目を入力してください。';
    header('Location: reset_password.php');
    exit();
}

if ($new_password !== $confirm_password) {
    $_SESSION['reset_error'] = '新しいパスワードと確認用パスワードが一致しません。';
    header('Location: reset_password.php');
    exit();
}

// パスワードの強度チェック（例：最低8文字）
if (strlen($new_password) < 8) {
    $_SESSION['reset_error'] = 'パスワードは最低8文字以上必要です。';
    header('Location: reset_password.php');
    exit();
}

try {
    $pdo = db_conn();

    // ユーザーの存在確認
    $stmt = $pdo->prepare("SELECT * FROM users WHERE lid = :lid");
    $stmt->bindValue(':lid', $lid, PDO::PARAM_STR);
    $stmt->execute();
    $user = $stmt->fetch();

    if (!$user) {
        $_SESSION['reset_error'] = '指定されたユーザーIDは存在しません。';
        header('Location: pw_reset.php');
        exit();
    }

    // パスワードのハッシュ化
    $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);

    // パスワード更新
    $stmt = $pdo->prepare("UPDATE users SET lpw = :lpw WHERE lid = :lid");
    $stmt->bindValue(':lpw', $hashed_password, PDO::PARAM_STR);
    $stmt->bindValue(':lid', $lid, PDO::PARAM_STR);
    $status = $stmt->execute();

    if ($status) {
        $_SESSION['reset_success'] = 'パスワードが正常に更新されました。';
    } else {
        $_SESSION['reset_error'] = 'パスワードの更新に失敗しました。';
    }

} catch (PDOException $e) {
    $_SESSION['reset_error'] = 'データベースエラー: ' . $e->getMessage();
}

header('Location: login.php');
exit();
?>
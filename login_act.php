<?php
session_start();
require_once 'funcs.php';

// CSRFトークンの検証
if ($_POST['csrf_token'] !== $_SESSION['csrf_token']) {
    die('不正なリクエストです');
}

$lid = $_POST['lid'];
$lpw = $_POST['lpw'];

$pdo = db_conn();

$stmt = $pdo->prepare('SELECT * FROM users WHERE lid = :lid');
$stmt->bindValue(':lid', $lid, PDO::PARAM_STR);
$status = $stmt->execute();

if ($status === false) {
    sql_error($stmt);
}

$val = $stmt->fetch();

if ($val && password_verify($lpw, $val['lpw'])) {
    $_SESSION['chk_ssid'] = session_id();
    $_SESSION['kanri_flg'] = $val['kanri_flg'];
    $_SESSION['user_name'] = $val['name'];
    $_SESSION['user_id'] = $val['id'];
    header('Location: select.php');
} else {
    $_SESSION['login_error'] = 'ログインIDまたはパスワードが間違っています。';
    header('Location: login.php');
}
exit();
<?php
session_start();
require_once('funcs.php');
loginCheck();

// POSTデータ取得
$date = $_POST['date'];
$material = $_POST['material'];
$form = $_POST['form'];
$thickness = $_POST['thickness'];
$size = $_POST['size'];
$price = $_POST['price'];
$id = $_POST['id'];

// 入力チェック（空欄と数値チェック）
if (
    empty($date) || empty($material) || empty($form) || 
    empty($thickness) || empty($size) || empty($price) || empty($id)
) {
    exit('ParamError');
}

// 数値チェック
if (!is_numeric($price) || !is_numeric($id)) {
    exit('TypeError');
}

// DB接続
$pdo = db_conn();

// SQL文を用意
$stmt = $pdo->prepare('UPDATE kadai02_table SET 
    date = :date,
    material = :material,
    form = :form,
    thickness = :thickness,
    size = :size,
    price = :price
WHERE id = :id');

// バインド変数を用意
$stmt->bindValue(':date', $date, PDO::PARAM_STR);
$stmt->bindValue(':material', $material, PDO::PARAM_STR);
$stmt->bindValue(':form', $form, PDO::PARAM_STR);
$stmt->bindValue(':thickness', $thickness, PDO::PARAM_STR);
$stmt->bindValue(':size', $size, PDO::PARAM_STR);
$stmt->bindValue(':price', $price, PDO::PARAM_INT);
$stmt->bindValue(':id', $id, PDO::PARAM_INT);

// 実行
$status = $stmt->execute();

// データ登録処理後
if ($status === false) {
    $error = $stmt->errorInfo();
    exit('SQLError:' . print_r($error, true));
} else {
    $_SESSION['success_message'] = 'データが正常に更新されました。';
    header('Location: select.php');
    exit();
}
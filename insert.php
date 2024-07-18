<?php

session_start();
require_once ('funcs.php');

//1. POSTデータ取得
$date = $_POST['date'];
$material = $_POST['material'];
$form = $_POST['form'];
$thickness = $_POST['thickness'];
$size = $_POST['size'];
$price = $_POST['price'];

// // var_dumpを実行
// var_dump($date, $material, $form, $thickness, $size, $price);
// // 処理を停止してvar_dumpの結果を確認する場合
// exit;

// DB接続
$pdo = db_conn();

//３．データ登録SQL作成
// 1. SQL文を用意
  $stmt = $pdo->prepare('INSERT INTO kadai02_table(id, material, form, thickness, size, price, date) 
  VALUES (NULL, :material, :form, :thickness, :size, :price, :date)');

//  2. バインド変数を用意
// Integer 数値の場合 PDO::PARAM_INT
// String文字列の場合 PDO::PARAM_STR

$stmt->bindValue(':date', $date, PDO::PARAM_STR);
$stmt->bindValue(':material', $material, PDO::PARAM_STR);
$stmt->bindValue(':form', $form, PDO::PARAM_STR);
$stmt->bindValue(':thickness', $thickness, PDO::PARAM_STR);
$stmt->bindValue(':size', $size, PDO::PARAM_STR);
$stmt->bindValue(':price', $price, PDO::PARAM_STR);

//  3. 実行
$status = $stmt->execute();

//４．データ登録処理後
if($status === false){
  // SQL実行時にエラーがある場合（エラーオブジェクト取得して表示）
  $error = $stmt->errorInfo();
  $_SESSION['error_message'] = 'エラーが発生しました: ' . $error[2];
  header('Location: index.php');
  exit();
} else {
  // ５．成功メッセージをセットしてindex.phpへリダイレクト
  $_SESSION['success_message'] = '登録が成功しました。';
  header('Location: index.php');
  exit();

  
}
?>

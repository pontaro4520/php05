<?php

require_once('funcs.php');

$id = $_GET['id'];

//2. DB接続します
//DB接続関数：db_conn() 
$pdo = db_conn();

//３．データ登録SQL作成
$stmt = $pdo->prepare('DELETE FROM kadai02_table WHERE id = :id');
$stmt->bindValue(':id', $id, PDO::PARAM_INT);
$status = $stmt->execute(); //実行

//４．データ登録処理後
if ($status === false) {
    sql_error($stmt);
} else {
    redirect ('select.php');
}
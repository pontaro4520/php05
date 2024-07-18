<?php
//共通に使う関数を記述

function h($str){
    return htmlspecialchars($str, ENT_QUOTES, 'UTF-8');
  }

  function db_conn(){

  //   //ローカル環境
  // try {
  //   $db_name = 'kadai05_db';    //データベース名
  //   $db_id   = 'root';      //アカウント名
  //   $db_pw   = '';      //パスワード：MAMPは'root'
  //   $db_host = 'localhost'; //DBホスト
  //   $pdo = new PDO('mysql:dbname=' . $db_name . ';charset=utf8;host=' . $db_host, $db_id, $db_pw);
  //   return $pdo;
  // } catch (PDOException $e) {
  //   exit('DB Connection Error:' . $e->getMessage());
  // }


//本番環境
$prod_db = "pontaro_kadai_05";
$prod_host = "mysql640.db.sakura.ne.jp";
$prod_id = "pontaro";
$prod_pass = "pontaro-";
//2. DB接続します
try {
    //ID:'root', Password: xamppは 空白 ''
  $pdo = new PDO('mysql:dbname='. $prod_db . ';charset=utf8;host='. $prod_host ,$prod_id,$prod_pass);
  return $pdo;
} catch (PDOException $e) {
  exit('DBConnectError:'.$e->getMessage());
}
  
  }


//XSS対応（ echoする場所で使用！それ以外はNG ）

//SQLエラー関数：sql_error($stmt)
function sql_error($stmt){
  $error = $stmt->errorInfo();
  exit('SQLError:' . print_r($error, true));
}

//リダイレクト関数: redirect($file_name)
function redirect($file_name){
  //*** function化する！*****************
  header('Location:' . $file_name);
  exit();
}


// ログインチェク処理 loginCheck()
function loginCheck(){
  if( !isset($_SESSION['chk_ssid']) || $_SESSION['chk_ssid'] !== session_id()){
      exit('LOGIN ERROR');
      };
      
      session_regenerate_id(true);
      $_SESSION['chk_ssid'] = session_id();
}

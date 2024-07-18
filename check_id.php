<?php
// データベース接続情報などの設定ファイルを読み込む
require_once('funcs.php');

// POSTリクエストからユーザーIDを取得
$lid = isset($_POST['lid']) ? $_POST['lid'] : '';

// 結果を格納する配列
$response = ['exists' => false];

if (!empty($lid)) {
    try {
        // データベースに接続
        $pdo = db_conn();
        
        // ユーザーIDの存在を確認するSQLクエリ
        $sql = "SELECT COUNT(*) FROM users WHERE lid = :lid";
        $stmt = $pdo->prepare($sql);
        $stmt->bindValue(':lid', $lid, PDO::PARAM_STR);
        $stmt->execute();
        
        // 結果を取得
        $count = $stmt->fetchColumn();
        
        // ユーザーIDが存在する場合、existsをtrueに設定
        if ($count > 0) {
            $response['exists'] = true;
        }
    } catch (PDOException $e) {
        // エラーが発生した場合はエラーメッセージを設定
        $response['error'] = 'データベースエラー: ' . $e->getMessage();
    }
}

// JSONヘッダーを設定
header('Content-Type: application/json');

// 結果をJSON形式で出力
echo json_encode($response);
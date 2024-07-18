<?php
session_start();
require_once ('funcs.php');

loginCheck();
// DB接続
$pdo = db_conn();

$material = isset($_GET['material']) ? $_GET['material'] : '';
$form = isset($_GET['form']) ? $_GET['form'] : '';

// ページネーションの設定
$items_per_page = 10;
$current_page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($current_page - 1) * $items_per_page;

// SQLクエリの基本部分
$sql = "SELECT * FROM kadai02_table WHERE 1=1";
$count_sql = "SELECT COUNT(*) as count FROM kadai02_table WHERE 1=1";
$params = array();

if (!empty($material)) {
    $sql .= " AND material = :material";
    $count_sql .= " AND material = :material";
    $params[':material'] = $material;
}

if (!empty($form)) {
    $sql .= " AND form = :form";
    $count_sql .= " AND form = :form";
    $params[':form'] = $form;
}

$sql .= " ORDER BY date DESC LIMIT :limit OFFSET :offset";

// メインクエリの準備と実行
$stmt = $pdo->prepare($sql);
foreach ($params as $key => $val) {
    $stmt->bindValue($key, $val, PDO::PARAM_STR);
}
$stmt->bindValue(':limit', $items_per_page, PDO::PARAM_INT);
$stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
$status = $stmt->execute();

// 総アイテム数を取得
$count_stmt = $pdo->prepare($count_sql);
foreach ($params as $key => $val) {
    $count_stmt->bindValue($key, $val, PDO::PARAM_STR);
}
$count_stmt->execute();
$total_items = $count_stmt->fetch(PDO::FETCH_ASSOC)['count'];
$total_pages = ceil($total_items / $items_per_page);

// ページネーションリンクの生成
$pagination = "";
for ($i = 1; $i <= $total_pages; $i++) {
    $url = "select.php?page=$i";
    if (!empty($material)) $url .= "&material=$material";
    if (!empty($form)) $url .= "&form=$form";
    $pagination .= "<a href='$url' class='page-link " . ($i == $current_page ? 'active' : '') . "'>$i</a>";
}

function getMaterialName($material) {
  switch ($material) {
      case 'st':
          return '鉄';
      case 'sus':
          return 'ステンレス';
      case 'al':
          return 'アルミ';
      default:
          return $material;
  }
}

// 形状の日本語表記を取得する関数
function getFormName($form) {
  switch ($form) {
      case 'sheetMetal':
          return '板';
      case 'flatBar':
          return 'フラットバー';
      case 'squarePipe':
          return '角パイプ';
      case 'roundPipe':
          return '丸パイプ';
      case 'others':
          return 'その他';
      default:
          return $form;
  }
}



// データ表示部分
$view = "<table class='result-table'>
            <tr>
                <th>日付</th>
                <th>材料</th>
                <th>形状</th>
                <th>厚み</th>
                <th>サイズ</th>
                <th>価格</th>
                <th>編集</th>
                <th>削除</th>
            </tr>";
if ($status == false) {
    $error = $stmt->errorInfo();
    exit("ErrorQuery:".$error[2]);
} else {
    while($result = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $view .= "<tr>
                    <td>{$result['date']}</td>
                    <td>" . getMaterialName($result['material']) . "</td>
                    <td>" . getFormName($result['form']) . "</td>
                    <td>{$result['thickness']}</td>
                    <td>{$result['size']}</td>
                    <td>{$result['price']}円</td>
                    <td>
                        <a href='detail.php?id={$result['id']}'>編集</a>
                    </td>
                    <td>
                        <a href='delete.php?id={$result['id']}' class='delete-link'>削除</a>
                    </td>
                  </tr>";
    }
}
$view .= "</table>";

// HTMLの部分は変更なし
?>




<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="css/login.css" />
    <link rel="stylesheet" href="css/common.css" />
    <title>集積結果リスト表示</title>
</head>

<body>
    <header>
        <nav class="navbar navbar-default">SELECT</nav>
    </header>
    
    <?php
    if (isset($_SESSION['success_message'])) {
        echo '<div class="success">' . htmlspecialchars($_SESSION['success_message']) . '</div>';
        unset($_SESSION['success_message']);
    }
    ?>

    <main>
        <h2>見積もり結果表示</h2>
        
        <div class="result-container">
            <?= $view ?>
        </div>

        <div class="pagination">
            <?= $pagination ?>
        </div>

        <div class="filter-buttons">
            <div class="button-group">
                <a class="btn <?= $material === 'st' ? 'active' : '' ?>" href="select.php?material=st<?= $form ? "&form=$form" : '' ?>">鉄</a>
                <a class="btn <?= $material === 'sus' ? 'active' : '' ?>" href="select.php?material=sus<?= $form ? "&form=$form" : '' ?>">ステンレス</a>
                <a class="btn <?= $material === 'al' ? 'active' : '' ?>" href="select.php?material=al<?= $form ? "&form=$form" : '' ?>">アルミ</a>
                <a class="btn <?= $material === '' ? 'active' : '' ?>" href="select.php<?= $form ? "?form=$form" : '' ?>">すべて</a>
            </div>
    <div class="button-group">
        <a class="btn <?= $form === 'sheetMetal' ? 'active' : '' ?>" href="select.php?form=sheetMetal<?= $material ? "&material=$material" : '' ?>">板</a>
        <a class="btn <?= $form === 'flatBar' ? 'active' : '' ?>" href="select.php?form=flatBar<?= $material ? "&material=$material" : '' ?>">フラットバー</a>
        <a class="btn <?= $form === 'squarePipe' ? 'active' : '' ?>" href="select.php?form=squarePipe<?= $material ? "&material=$material" : '' ?>">角パイプ</a>
        <a class="btn <?= $form === 'roundPipe' ? 'active' : '' ?>" href="select.php?form=roundPipe<?= $material ? "&material=$material" : '' ?>">丸パイプ</a>
        <a class="btn <?= $form === 'others' ? 'active' : '' ?>" href="select.php?form=others<?= $material ? "&material=$material" : '' ?>">その他</a>          
        <a class="btn <?= $form === '' ? 'active' : '' ?>" href="select.php<?= $material ? "?material=$material" : '' ?>">すべて</a>
    </div>
</div>

        <div class="links">
            <p><a href="index.php">データ登録に戻る</a></p>
            <p><a href="logout.php">ログアウト</a></p>
        </div>
    </main>

    <footer>
        <nav class="navbar navbar-default">presented by 金子軽窓工業</nav>
    </footer>

    <script>
    document.addEventListener('DOMContentLoaded', function() {
        document.querySelectorAll('.details-link').forEach(function(link) {
            link.addEventListener('click', function(e) {
                e.preventDefault();
                var detailsRow = document.getElementById('details-' + this.dataset.id);
                detailsRow.style.display = detailsRow.style.display === 'none' ? 'table-row' : 'none';
            });
        });
    });
    </script>
</body>

</html>
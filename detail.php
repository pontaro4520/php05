<?php
session_start();
require_once('funcs.php');
loginCheck();

$id = $_GET['id'];

$pdo = db_conn();

//２．データ登録SQL作成
$stmt = $pdo->prepare("SELECT * FROM kadai02_table WHERE id=:id");
$stmt->bindValue(':id', $id, PDO::PARAM_INT);
$status = $stmt->execute();

//３．データ表示
if ($status == false) {
    sql_error($stmt);
} else {
    $result = $stmt->fetch();
}
?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="css/index.css" />
    <link rel="stylesheet" href="css/common.css" />
    <title>データ編集</title>
</head>
<body>
    <header>
        <nav class="navbar navbar-default">EDIT</nav>
    </header>
    <main>
        <img src="img/logo.png" alt="金子軽窓工業ロゴ" class="logo">
        <form method="POST" action="update.php" id="priceData" onsubmit="return validateForm()">
            <div class="jumbotron">
                <fieldset>
                    <legend>鋼材価格見積集積アプリ</legend>
                    <label for="date">見積取得日 <input type="date" name="date" id="date" value="<?= h($result['date']) ?>" required></label><br>

                    <fieldset class="form-group">
                        <legend>鋼種：</legend>
                        <div class="radio-group">
                            <label>
                            <input type="radio" name="material" value="st" <?= $result['material'] == 'st' ? 'checked' : '' ?> required>
                            <span>鉄</span>
                            </label>
                            <label>
                            <input type="radio" name="material" value="sus" <?= $result['material'] == 'sus' ? 'checked' : '' ?>>
                            <span>ステンレス</span>
                            </label>
                            <label>
                            <input type="radio" name="material" value="al" <?= $result['material'] == 'al' ? 'checked' : '' ?>>
                            <span>アルミ</span>
                            </label>
                        </div>
                    </fieldset>
                   
                    <fieldset class="form-group">
                        <legend>材種：</legend>
                        <div class="radio-group">
                            <label>
                            <input type="radio" name="form" value="sheetMetal" <?= $result['form'] == 'sheetMetal' ? 'checked' : '' ?> required>
                            <span>板</span>
                            </label>
                            <label>
                            <input type="radio" name="form" value="flatBar" <?= $result['form'] == 'flatBar' ? 'checked' : '' ?>>
                            <span>フラットバー</span>
                            </label>
                            <label>
                            <input type="radio" name="form" value="squarePipe" <?= $result['form'] == 'squarePipe' ? 'checked' : '' ?>>
                            <span>角パイプ</span>
                            </label>
                            <label>
                            <input type="radio" name="form" value="roundPipe" <?= $result['form'] == 'roundPipe' ? 'checked' : '' ?>>
                            <span>丸パイプ</span>
                            </label>
                            <label>
                            <input type="radio" name="form" value="others" <?= $result['form'] == 'others' ? 'checked' : '' ?>>
                            <span>その他</span>
                            </label>
                        </div>
                    </fieldset>

                    <div class="form-group">
                        <label for="thickness">板厚：</label>
                        <div class="input-group">
                            <input type="text" id="thickness" name="thickness" value="<?= h($result['thickness']) ?>" required>
                            <span class="unit">t</span>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="size">サイズ：</label>
                        <input type="text" id="size" name="size" value="<?= h($result['size']) ?>" required placeholder="例：100x200">
                        <span class="help-text">幅x高さ(mm)で入力してください</span>
                    </div>

                    <div class="form-group">
                        <label for="price">金額：</label>
                        <div class="input-group">
                            <input type="number" id="price" name="price" value="<?= h($result['price']) ?>" min="0" step="1" required>
                            <span class="unit">円</span>
                        </div>
                    </div>
                    <input type="hidden" name="id" value="<?= $result['id'] ?>">
                    <input type="submit" value="更新">
                </fieldset>
            </div>
        </form>
        <div class="links">
            <p><a href="select.php">一覧に戻る</a></p>
        </div>
    </main>
    <footer>
        <nav class="navbar navbar-default">presented by 金子軽窓工業</nav>
    </footer>

    <script src="js/index.js"></script>
</body>
</html>
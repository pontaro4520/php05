<?php
session_start();
?>
<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="css/index.css" />
    <link rel="stylesheet" href="css/common.css" />
    <title>鋼材価格見積集積</title>
</head>


<body>

    <?php
    if (isset($_SESSION['success_message'])) {
        echo '<div class="success">' . htmlspecialchars($_SESSION['success_message']) . '</div>';
        unset($_SESSION['success_message']);
    }
    if (isset($_SESSION['error_message'])) {
        echo '<div class="error">' . htmlspecialchars($_SESSION['error_message']) . '</div>';
        unset($_SESSION['error_message']);
    }

    ?>

    <!-- Main[Start] -->
    <form method="post" action="insert.php" id="priceData" onsubmit="return validateForm()">
        <div class="jumbotron">
            <fieldset>
                <legend>鋼材価格見積集積アプリ</legend>
                <label for="date">見積取得日 <input type="date" name="date" id="date" required></label><br>


                <fieldset class="form-group">
                    <legend>鋼種：</legend>
                    <div class="radio-group">
                        <label>
                        <input type="radio" name="material" value="st" required>
                        <span>鉄</span>
                        </label>
                        <label>
                        <input type="radio" name="material" value="sus">
                        <span>ステンレス</span>
                        </label>
                        <label>
                        <input type="radio" name="material" value="al">
                        <span>アルミ</span>
                        </label>
                    </div>
                    </fieldset>
                   
                   
                    <fieldset class="form-group">
                    <legend>材種：</legend>
                    <div class="radio-group">
                        <label>
                        <input type="radio" name="form" value="sheetMetal" required>
                        <span>板</span>
                        </label>
                        <label>
                        <input type="radio" name="form" value="flatBar">
                        <span>フラットバー</span>
                        </label>
                        <label>
                        <input type="radio" name="form" value="squarePipe">
                        <span>角パイプ</span>
                        </label>
                        <label>
                        <input type="radio" name="form" value="roundPipe">
                        <span>丸パイプ</span>
                        </label>
                        <label>
                        <input type="radio" name="form" value="others">
                        <span>その他</span>
                        </label>
                    </div>
                    </fieldset>

                    <div class="form-group">
                    <label for="thickness">板厚：</label>
                    <div class="input-group">
                        <input type="text" id="thickness" name="thickness" required>
                        <span class="unit">t</span>
                    </div>
                    </div>

                    <div class="form-group">
                        <label for="size">サイズ：</label>
                        <input type="text" id="size" name="size" required placeholder="例：100x200">
                        <span class="help-text">幅x高さ(mm)で入力してください</span>
                        </div>

                    <div class="form-group">
                        <label for="price">金額：</label>
                        <div class="input-group">
                            <input type="number" id="price" name="price" min="0" step="1" required>
                            <span class="unit">円</span>
                        </div>
                        </div>
                <input type="submit" value="送信">
            </fieldset>
        </div>
    </form>

    <!-- Main[End] -->

        <!-- Foot[Start] -->
        <footer>
        <nav class="navbar navbar-default">
            <div class="container-fluid">
                <div class="navbar-header"><a class="navbar-brand" href="select.php">集積結果一覧
                </a></div>
            </div>
        </nav>
    </footer>
    <!-- foot[End] -->


    <footer>
            <p>presented by 金子軽窓工業</p>
        </footer>


    <script src="js/index.js"></script>


</body>

</html>

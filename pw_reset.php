<?php
session_start();
if (isset($_SESSION['reset_error'])) {
    echo '<p class="error">' . htmlspecialchars($_SESSION['reset_error']) . '</p>';
    unset($_SESSION['reset_error']);
}
if (isset($_SESSION['reset_success'])) {
    echo '<p class="success">' . htmlspecialchars($_SESSION['reset_success']) . '</p>';
    unset($_SESSION['reset_success']);
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width">
    <link rel="stylesheet" href="css/reset_password.css" />
    <link rel="stylesheet" href="css/common.css" />
    <link rel="stylesheet" href="css/login.css" />
    <title>パスワード再設定</title>
</head>

<body>
    <header>
        <nav class="navbar navbar-default">パスワード再設定</nav>
    </header>
    <img src="img/logo.png" alt="ロゴ" class="logo">
    
    <form id="resetForm" action="pw_reset_act.php" method="post">
        <div id="step1">
            <label for="lid">ユーザーID:</label>
            <input type="text" name="lid" id="lid" required />
            <span class="help-text">登録済みのIDを確認してください</span>
            <button type="button" id="checkId">IDを確認</button>
        </div>
        
        <div id="step2" style="display:none;">
            <label for="new_password">新しいパスワード:</label>
            <input type="password" name="new_password" id="new_password" required placeholder="8文字以上"/>
            <label for="confirm_password">新しいパスワード（確認）:</label>
            <input type="password" name="confirm_password" id="confirm_password" required placeholder="パスワードは一致する必要があります"/>
            <input type="submit" value="パスワードを変更" />
        </div>
    </form>
</body>

<footer>
    <nav class="navbar navbar-default">presented by 金子軽窓工業</nav>
</footer>

<script src="js/pw_reset.js"></script>

</html>
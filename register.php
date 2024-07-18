<?php
session_start();
if (isset($_SESSION['register_error'])) {
    echo '<p class="error">' . htmlspecialchars($_SESSION['register_error']) . '</p>';
    unset($_SESSION['register_error']);
}
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width">
    <link rel="stylesheet" href="css/login.css" />
    <link rel="stylesheet" href="css/common.css" />
    <title>登録画面</title>
</head>

<body>

    <header>
        <nav class="navbar navbar-default">REGISTER</nav>
    </header>
    <img src="img/logo.png" alt="ロゴ" class="logo">
    <form name="form1" action="register_act.php" method="post">
    <label for="name">ユーザー名:</label><input type="text" name="name" id="name" required />
    <label for="lid">ユーザーID:</label><input type="text" name="lid" id="lid" required placeholder="ログインに必要です"/>
    <label for="lpw">パスワード:</label><input type="password" name="lpw" id="lpw" required placeholder="8文字以上"/>
    <label for="lpw_confirm">パスワード（確認）:</label><input type="password" name="lpw_confirm" id="lpw_confirm" required placeholder="パスワードは一致する必要があります"/>
    <input type="submit" value="REGISTER" />
</form>
</body>

<footer>
        <nav class="navbar navbar-default">presented by 金子軽窓工業</nav>
    </footer>

    <script>
document.querySelector('form').addEventListener('submit', function(e) {
  var password = document.getElementById('lpw').value;
  var confirmPassword = document.getElementById('lpw_confirm').value;
  
  if (password !== confirmPassword) {
    e.preventDefault();
    alert('パスワードが一致しません。');
  }
});
</script>

</html>




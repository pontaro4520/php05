<?php
session_start();
$csrf_token = bin2hex(random_bytes(32));
$_SESSION['csrf_token'] = $csrf_token;
?>

<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="css/login.css" />
    <link rel="stylesheet" href="css/common.css" />
    <title>ログイン</title>
</head>

<body>
    <header>
        <nav class="navbar navbar-default">LOGIN</nav>
    </header>

    <main>
        <img src="img/logo.png" alt="金子軽窓工業ロゴ" class="logo">

        <?php
        if (isset($_SESSION['register_success'])) {
            echo '<p class="success">' . htmlspecialchars($_SESSION['register_success']) . '</p>';
            unset($_SESSION['register_success']);
        }

        if (isset($_SESSION['login_error'])) {
            echo '<p class="error">' . htmlspecialchars($_SESSION['login_error']) . '</p>';
            unset($_SESSION['login_error']);
        }


        if (isset($_SESSION['reset_error'])) {
            echo '<p class="error">' . htmlspecialchars($_SESSION['reset_error']) . '</p>';
            unset($_SESSION['reset_error']);
        }
        if (isset($_SESSION['reset_success'])) {
            echo '<p class="success">' . htmlspecialchars($_SESSION['reset_success']) . '</p>';
            unset($_SESSION['reset_success']);
        }
        ?>

        <form name="login_form" action="login_act.php" method="post" autocomplete="off">
            <div class="form-group">
                <label for="lid">ユーザーID:</label>
                <input type="text" name="lid" id="lid" required>
            </div>
                <div class="form-group password-group">
                        <label for="lpw">パスワード:</label>
                        <div class="password-input-group">
                            <input type="password" name="lpw" id="lpw" required placeholder="8文字以上">
                            <div class="show-password-group">
                                <input type="checkbox" id="show-password">
                                <label for="show-password">表示</label>
                            </div>
                        </div>
                    </div>
            </div>
            <input type="hidden" name="csrf_token" value="<?php echo $csrf_token; ?>">
            <input type="submit" value="ログイン">
        </form>

        <div class="links">
            <p>初めてですか？ <a href="register.php">新規登録はこちら</a></p>
            <p>パスワードをお忘れの方は <a href="pw_reset.php">こちら</a></p>
        </div>
    </main>

    <footer>
        <nav class="navbar navbar-default">presented by 金子軽窓工業</nav>
    </footer>

    <script>
    document.getElementById('show-password').addEventListener('change', function() {
        document.getElementById('lpw').type = this.checked ? 'text' : 'password';
    });
    </script>
</body>

</html>
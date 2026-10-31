<?php
require_once 'config/database.php';
require_once 'session_init.php';

if (isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = sanitize($_POST['username']);
    $password = $_POST['password'];

    if (empty($username) || empty($password)) {
        $error = "Semua bidang harus diisi!";
    } else {
        $stmt = mysqli_prepare($conn, "SELECT id, password FROM users WHERE username = ?");
        mysqli_stmt_bind_param($stmt, "s", $username);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        if ($user = mysqli_fetch_assoc($result)) {
            if (password_verify($password, $user['password']) || $password === $user['password']) {
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['username'] = $username;
                header("Location: index.php");
                exit();
            } else {
                $error = "Password salah!";
            }
        } else {
            $error = "Username tidak ditemukan!";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="<?= $lang_code; ?>">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $lang['login']; ?></title>
    <link rel="stylesheet" href="assets/style.css">
</head>
<body>
    <div class="container">
        <div class="form-container">
            <h2><?= $lang['login']; ?></h2>
            <div class="lang-switch">
                Language: <a href="?lang=id">ID</a> | <a href="?lang=en">EN</a>
            </div>

            <?php if ($error): ?>
                <div class="error-msg"><?= $error; ?></div>
            <?php endif; ?>

            <form action="" method="POST">
                <div class="input-group">
                    <label><?= $lang['username']; ?></label>
                    <input type="text" name="username" placeholder="Enter username" required>
                </div>
                
                <div class="input-group">
                    <label><?= $lang['password']; ?></label>
                    <input type="password" name="password" placeholder="Enter password" required>
                </div>

                <a href="lupa_password.php" class="forgot-link"><?= $lang['forgot_password']; ?></a>

                <button type="submit" class="btn-primary"><?= $lang['login']; ?></button>
            </form>
        </div>

        <div class="side-banner">
            <h1>Hello, Friend!</h1>
            <p>Sistem Informasi Management Data Katalog Buku terproteksi otentikasi session dan enkripsi password.</p>
        </div>
    </div>
</body>
</html>
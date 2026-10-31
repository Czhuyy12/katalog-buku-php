<?php
require_once 'config/database.php';
require_once 'session_init.php';

$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username     = sanitize($_POST['username']);
    $input_key    = trim($_POST['secret_key']);
    $new_password = $_POST['new_password'];

    if (empty($username) || empty($input_key) || empty($new_password)) {
        $error = "Semua bidang wajib diisi!";
    } else {
        $stmt = mysqli_prepare($conn, "SELECT id, secret_key FROM users WHERE username = ?");
        mysqli_stmt_bind_param($stmt, "s", $username);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        if ($user = mysqli_fetch_assoc($result)) {
            if (password_verify($input_key, $user['secret_key']) || $input_key === $user['secret_key']) {
                $hashed_password = password_hash($new_password, PASSWORD_BCRYPT);

                $update_stmt = mysqli_prepare($conn, "UPDATE users SET password = ? WHERE id = ?");
                mysqli_stmt_bind_param($update_stmt, "si", $hashed_password, $user['id']);
                
                if (mysqli_stmt_execute($update_stmt)) {
                    $success = "Password berhasil diperbarui! Silakan login kembali.";
                } else {
                    $error = "Gagal memperbarui password.";
                }
            } else {
                $error = "Secret Key tidak valid!";
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
    <title><?= $lang['reset_password']; ?></title>
    <link rel="stylesheet" href="assets/style.css">
</head>
<body>
    <div class="container">
        <div class="form-container">
            <h2><?= $lang['reset_password']; ?></h2>
            <div class="lang-switch">
                Language: <a href="?lang=id">ID</a> | <a href="?lang=en">EN</a>
            </div>

            <?php if ($error): ?>
                <div class="error-msg"><?= $error; ?></div>
            <?php endif; ?>

            <?php if ($success): ?>
                <div class="success-msg"><?= $success; ?></div>
            <?php endif; ?>

            <form action="" method="POST">
                <div class="input-group">
                    <label><?= $lang['username']; ?></label>
                    <input type="text" name="username" placeholder="Masukkan username" required>
                </div>

                <div class="input-group">
                    <label><?= $lang['secret_key']; ?></label>
                    <input type="text" name="secret_key" placeholder="Masukkan Key Rahasia" required>
                </div>
                
                <div class="input-group">
                    <label><?= $lang['new_password']; ?></label>
                    <input type="password" name="new_password" placeholder="Masukkan password baru" required>
                </div>

                <button type="submit" class="btn-primary" style="margin-top: 10px;"><?= $lang['reset_password']; ?></button>
                <a href="login.php" class="forgot-link" style="text-align: center; margin-top: 15px;"><?= $lang['back_to_login']; ?></a>
            </form>
        </div>

        <div class="side-banner">
            <h1>Reset Access</h1>
            <p>Masukkan Secret Key terdaftar untuk mengganti password Anda secara aman.</p>
        </div>
    </div>
</body>
</html>
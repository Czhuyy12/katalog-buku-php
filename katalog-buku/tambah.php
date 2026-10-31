<?php
require_once 'config/database.php';
require_once 'session_init.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $judul    = sanitize($_POST['judul']);
    $penulis  = sanitize($_POST['penulis']);
    $penerbit = sanitize($_POST['penerbit']);
    $tahun    = filter_var($_POST['tahun_terbit'], FILTER_VALIDATE_INT);

    if (empty($judul) || empty($penulis) || empty($penerbit) || !$tahun) {
        $error = "Semua kolom wajib diisi dengan benar!";
    } else {
        $stmt = mysqli_prepare($conn, "INSERT INTO buku (judul, penulis, penerbit, tahun_terbit) VALUES (?, ?, ?, ?)");
        mysqli_stmt_bind_param($stmt, "sssi", $judul, $penulis, $penerbit, $tahun);
        
        if (mysqli_stmt_execute($stmt)) {
            header("Location: index.php");
            exit();
        } else {
            $error = "Gagal menyimpan data.";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="<?= $lang_code; ?>">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $lang['add_data']; ?></title>
    <link rel="stylesheet" href="assets/style.css">
</head>
<body>
    <div class="container">
        <div class="form-container">
            <h2><?= $lang['add_data']; ?></h2>
            <div class="lang-switch">
                Language: <a href="?lang=id">ID</a> | <a href="?lang=en">EN</a>
            </div>

            <?php if ($error): ?>
                <div class="error-msg"><?= $error; ?></div>
            <?php endif; ?>

            <form method="POST" action="">
                <div class="input-group">
                    <label><?= $lang['judul']; ?></label>
                    <input type="text" name="judul" required>
                </div>

                <div class="input-group">
                    <label><?= $lang['penulis']; ?></label>
                    <input type="text" name="penulis" required>
                </div>

                <div class="input-group">
                    <label><?= $lang['penerbit']; ?></label>
                    <input type="text" name="penerbit" required>
                </div>

                <div class="input-group">
                    <label><?= $lang['tahun']; ?></label>
                    <input type="number" name="tahun_terbit" required>
                </div>

                <button type="submit" class="btn-primary"><?= $lang['save']; ?></button>
                <a href="index.php" class="btn-secondary"><?= $lang['cancel']; ?></a>
            </form>
        </div>

        <div class="side-banner">
            <h1>Create Data</h1>
            <p>Tambahkan informasi buku baru ke dalam sistem katalog data.</p>
        </div>
    </div>
</body>
</html>
<?php
require_once 'config/database.php';
require_once 'session_init.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$id = filter_var($_GET['id'] ?? null, FILTER_VALIDATE_INT);
if (!$id) {
    header("Location: index.php");
    exit();
}

$stmt = mysqli_prepare($conn, "SELECT * FROM buku WHERE id = ?");
mysqli_stmt_bind_param($stmt, "i", $id);
mysqli_stmt_execute($stmt);
$buku = mysqli_fetch_assoc(mysqli_stmt_get_result($stmt));

if (!$buku) {
    header("Location: index.php");
    exit();
}

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $judul    = sanitize($_POST['judul']);
    $penulis  = sanitize($_POST['penulis']);
    $penerbit = sanitize($_POST['penerbit']);
    $tahun    = filter_var($_POST['tahun_terbit'], FILTER_VALIDATE_INT);

    if (empty($judul) || empty($penulis) || empty($penerbit) || !$tahun) {
        $error = "Semua bidang wajib diisi!";
    } else {
        $update_stmt = mysqli_prepare($conn, "UPDATE buku SET judul = ?, penulis = ?, penerbit = ?, tahun_terbit = ? WHERE id = ?");
        mysqli_stmt_bind_param($update_stmt, "sssii", $judul, $penulis, $penerbit, $tahun, $id);
        
        if (mysqli_stmt_execute($update_stmt)) {
            header("Location: index.php");
            exit();
        } else {
            $error = "Gagal memperbarui data.";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="<?= $lang_code; ?>">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $lang['edit_data']; ?></title>
    <link rel="stylesheet" href="assets/style.css">
</head>
<body>
    <div class="container">
        <div class="form-container">
            <h2><?= $lang['edit_data']; ?></h2>
            <div class="lang-switch">
                Language: <a href="?lang=id">ID</a> | <a href="?lang=en">EN</a>
            </div>

            <?php if ($error): ?>
                <div class="error-msg"><?= $error; ?></div>
            <?php endif; ?>

            <form method="POST" action="">
                <div class="input-group">
                    <label><?= $lang['judul']; ?></label>
                    <input type="text" name="judul" value="<?= sanitize($buku['judul']); ?>" required>
                </div>

                <div class="input-group">
                    <label><?= $lang['penulis']; ?></label>
                    <input type="text" name="penulis" value="<?= sanitize($buku['penulis']); ?>" required>
                </div>

                <div class="input-group">
                    <label><?= $lang['penerbit']; ?></label>
                    <input type="text" name="penerbit" value="<?= sanitize($buku['penerbit']); ?>" required>
                </div>

                <div class="input-group">
                    <label><?= $lang['tahun']; ?></label>
                    <input type="number" name="tahun_terbit" value="<?= sanitize($buku['tahun_terbit']); ?>" required>
                </div>

                <button type="submit" class="btn-primary"><?= $lang['save']; ?></button>
                <a href="index.php" class="btn-secondary"><?= $lang['cancel']; ?></a>
            </form>
        </div>

        <div class="side-banner">
            <h1>Update Data</h1>
            <p>Perbarui informasi detail katalog buku yang sudah terdaftar.</p>
        </div>
    </div>
</body>
</html>
<?php
require_once 'config/database.php';
require_once 'session_init.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$query = "SELECT * FROM buku ORDER BY id DESC";
$result = mysqli_query($conn, $query);
?>
<!DOCTYPE html>
<html lang="<?= $lang_code; ?>">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $lang['title']; ?></title>
    <link rel="stylesheet" href="assets/style.css">
</head>
<body>
    <div class="dashboard-container">
        <div class="top-bar">
            <h2><?= $lang['title']; ?></h2>
            <div class="user-info">
                <?= $lang['welcome']; ?>, <strong><?= sanitize($_SESSION['username']); ?></strong> |
                Language: <a href="?lang=id">ID</a> | <a href="?lang=en">EN</a> |
                <a href="logout.php"><?= $lang['logout']; ?></a>
            </div>
        </div>

        <div class="action-bar">
            <a href="tambah.php" class="btn-add">+ <?= $lang['add_data']; ?></a>
        </div>

        <div class="table-responsive">
            <table class="crud-table">
                <thead>
                    <tr>
                        <th>No</th>
                        <th><?= $lang['judul']; ?></th>
                        <th><?= $lang['penulis']; ?></th>
                        <th><?= $lang['penerbit']; ?></th>
                        <th><?= $lang['tahun']; ?></th>
                        <th><?= $lang['action']; ?></th>
                    </tr>
                </thead>
                <tbody>
                    <?php $no = 1; while ($row = mysqli_fetch_assoc($result)): ?>
                    <tr>
                        <td><?= $no++; ?></td>
                        <td><?= sanitize($row['judul']); ?></td>
                        <td><?= sanitize($row['penulis']); ?></td>
                        <td><?= sanitize($row['penerbit']); ?></td>
                        <td><?= sanitize($row['tahun_terbit']); ?></td>
                        <td>
                            <a href="edit.php?id=<?= $row['id']; ?>" class="btn-action-edit"><?= $lang['edit']; ?></a>
                            <a href="hapus.php?id=<?= $row['id']; ?>" class="btn-action-delete" onclick="return confirm('<?= $lang['confirm_delete']; ?>')"><?= $lang['delete']; ?></a>
                        </td>
                    </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>
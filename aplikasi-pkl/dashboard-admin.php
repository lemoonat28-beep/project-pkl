<?php
session_start();
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header("Location: login.php");
    exit;
}
include 'koneksi.php';

$query = mysqli_query($conn, "SELECT * FROM pekerja ORDER BY id DESC");
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - PT.UBL</title>
    <link rel="stylesheet" href="user.css">
    <link rel="stylesheet" href="admin.css">
</head>
<body>
    <header class="navbar">
        <h1>Admin Panel</h1>
        <div class="user-profile">
            <span>Halo, <?= htmlspecialchars($_SESSION['admin_nama'] ?? 'Admin'); ?></span>
            <a href="dashboard-user.php" class="btn-preview" target="_blank" style="margin-left:10px;">🌐 Preview User</a>
            <a href="logout.php" style="color:#fca5a5; font-weight:bold; margin-left:15px; text-decoration:none;">Logout</a>
        </div>
    </header>

    <div class="admin-container">
        <div class="header-section">
            <h2>Kelola Data Pekerja</h2>
            <a href="tambah.php" class="btn-tambah">+ Tambah Pekerja</a>
        </div>

        <table class="tabel-pekerja">
            <thead>
                <tr>
                    <th>Foto</th>
                    <th>Nama</th>
                    <th>Jabatan</th>
                    <th>Email</th>
                    <th>No. Telp</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php if (mysqli_num_rows($query) > 0) : ?>
                    <?php while ($row = mysqli_fetch_assoc($query)) : ?>
                    <tr>
                        <td><img src="<?= htmlspecialchars($row['foto']); ?>" class="img-thumb" alt="Foto" onerror="this.src='https://via.placeholder.com/45';"></td>
                        <td><strong><?= htmlspecialchars($row['nama_lengkap']); ?></strong> (<?= htmlspecialchars($row['nama_pendek']); ?>)</td>
                        <td><?= htmlspecialchars($row['role']); ?></td>
                        <td><?= htmlspecialchars($row['email']); ?></td>
                        <td><?= htmlspecialchars($row['no_telp']); ?></td>
                        <td><span style="background:#e0f2fe; color:#0284c7; padding:4px 8px; border-radius:4px; font-size:12px; font-weight:600;"><?= htmlspecialchars($row['status']); ?></span></td>
                        <td>
                            <a href="edit.php?id=<?= $row['id']; ?>" class="btn-edit">Edit</a>
                            <a href="hapus.php?id=<?= $row['id']; ?>" class="btn-hapus" onclick="return confirm('Hapus data ini?')">Hapus</a>
                        </td>
                    </tr>
                    <?php endwhile; ?>
                <?php else : ?>
                    <tr>
                        <td colspan="7" style="text-align: center; color: #888;">Belum ada data pekerja.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</body>
</html>
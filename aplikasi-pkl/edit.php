<?php
session_start();
if (!isset($_SESSION['admin_logged_in'])) { header("Location: login.php"); exit; }
include 'koneksi.php';

$id = $_GET['id'] ?? null;
if (!$id) { header("Location: dashboard-admin.php"); exit; }

$pekerja = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM pekerja WHERE id = '$id'"));
if (!$pekerja) { header("Location: dashboard-admin.php"); exit; }

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $namaPendek  = mysqli_real_escape_string($conn, $_POST['nama_pendek']);
    $namaLengkap = mysqli_real_escape_string($conn, $_POST['nama_lengkap']);
    $role        = mysqli_real_escape_string($conn, $_POST['role']);
    $alamat      = mysqli_real_escape_string($conn, $_POST['alamat']);
    $email       = mysqli_real_escape_string($conn, $_POST['email']);
    $noTelp      = mysqli_real_escape_string($conn, $_POST['no_telp']);
    $status      = mysqli_real_escape_string($conn, $_POST['status']);
    
    $fotoPath = $pekerja['foto'];

    if (isset($_FILES['foto_file']) && $_FILES['foto_file']['error'] === UPLOAD_ERR_OK) {
        $fileExtension = strtolower(pathinfo($_FILES['foto_file']['name'], PATHINFO_EXTENSION));
        if (in_array($fileExtension, ['jpg', 'jpeg', 'png', 'webp', 'gif'])) {
            $newFileName = time() . '_' . uniqid() . '.' . $fileExtension;
            if (!is_dir('uploads/')) { mkdir('uploads/', 0755, true); }
            if (move_uploaded_file($_FILES['foto_file']['tmp_name'], 'uploads/' . $newFileName)) {
                $fotoPath = 'uploads/' . $newFileName;
            }
        }
    }

    $sql = "UPDATE pekerja SET 
            nama_pendek='$namaPendek', nama_lengkap='$namaLengkap', role='$role', 
            alamat='$alamat', email='$email', no_telp='$noTelp', status='$status', foto='$fotoPath' 
            WHERE id='$id'";

    if (mysqli_query($conn, $sql)) {
        echo "<script>alert('Data berhasil diperbarui!'); window.location.href='dashboard-admin.php';</script>";
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Edit Pekerja - Admin</title>
    <link rel="stylesheet" href="user.css">
    <link rel="stylesheet" href="admin.css">
</head>
<body>
    <header class="navbar">
        <h1>Admin Panel</h1>
        <a href="dashboard-admin.php" class="btn-preview">← Kembali</a>
    </header>

    <div class="admin-container" style="max-width: 600px;">
        <h2>Edit Data Pekerja</h2>
        <form method="POST" enctype="multipart/form-data" style="margin-top:20px;">
            <div class="input-group"><label>Nama Panggilan</label><input type="text" name="nama_pendek" value="<?= htmlspecialchars($pekerja['nama_pendek']); ?>" required></div>
            <div class="input-group"><label>Nama Lengkap</label><input type="text" name="nama_lengkap" value="<?= htmlspecialchars($pekerja['nama_lengkap']); ?>" required></div>
            <div class="input-group"><label>Jabatan / Role</label><input type="text" name="role" value="<?= htmlspecialchars($pekerja['role']); ?>" required></div>
            <div class="input-group"><label>Alamat Domisili</label><input type="text" name="alamat" value="<?= htmlspecialchars($pekerja['alamat']); ?>" required></div>
            <div class="input-group"><label>Email</label><input type="email" name="email" value="<?= htmlspecialchars($pekerja['email']); ?>" required></div>
            <div class="input-group"><label>No. WhatsApp</label><input type="text" name="no_telp" value="<?= htmlspecialchars($pekerja['no_telp']); ?>" required></div>
            <div class="input-group">
                <label>Status</label>
                <select name="status" required>
                    <option value="Pekerja Tetap" <?= $pekerja['status'] == 'Pekerja Tetap' ? 'selected' : ''; ?>>Pekerja Tetap</option>
                    <option value="Kontrak" <?= $pekerja['status'] == 'Kontrak' ? 'selected' : ''; ?>>Kontrak</option>
                    <option value="Magang" <?= $pekerja['status'] == 'Magang' ? 'selected' : ''; ?>>Magang</option>
                </select>
            </div>
            <div class="input-group">
                <label>Foto Profil</label>
                <div class="dropzone" id="dropzone" onclick="document.getElementById('file-input').click()">
                    <img id="preview-img" src="<?= htmlspecialchars($pekerja['foto']); ?>" alt="Preview" style="margin:0 auto 10px auto;">
                    <p id="dropzone-text">📂 Tarik foto baru, atau <u>Klik untuk Memilih File</u></p>
                    <input type="file" id="file-input" name="foto_file" accept="image/*" style="display:none;" onchange="previewFile(this)">
                </div>
            </div>
            <div class="form-actions" style="margin-top:20px;">
                <a href="dashboard-admin.php" class="btn-batal">Batal</a>
                <button type="submit" class="btn-simpan">Simpan Perubahan</button>
            </div>
        </form>
    </div>

    <script>
        const dropzone = document.getElementById('dropzone');
        const fileInput = document.getElementById('file-input');
        ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(e => dropzone.addEventListener(e, ev => { ev.preventDefault(); ev.stopPropagation(); }));
        dropzone.addEventListener('drop', e => { fileInput.files = e.dataTransfer.files; previewFile(fileInput); });
        function previewFile(input) {
            const file = input.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = e => { document.getElementById('preview-img').src = e.target.result; }
                reader.readAsDataURL(file);
            }
        }
    </script>
</body>
</html>
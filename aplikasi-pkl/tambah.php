<?php
session_start();
if (!isset($_SESSION['admin_logged_in'])) { header("Location: login.php"); exit; }
include 'koneksi.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $namaPendek  = mysqli_real_escape_string($conn, $_POST['nama_pendek']);
    $namaLengkap = mysqli_real_escape_string($conn, $_POST['nama_lengkap']);
    $role        = mysqli_real_escape_string($conn, $_POST['role']);
    $alamat      = mysqli_real_escape_string($conn, $_POST['alamat']);
    $email       = mysqli_real_escape_string($conn, $_POST['email']);
    $password    = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $noTelp      = mysqli_real_escape_string($conn, $_POST['no_telp']);
    $status      = mysqli_real_escape_string($conn, $_POST['status']);

    $fotoPath = "https://via.placeholder.com/150";

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

    $sql = "INSERT INTO pekerja (nama_pendek, nama_lengkap, role, alamat, email, password, no_telp, status, foto) 
            VALUES ('$namaPendek', '$namaLengkap', '$role', '$alamat', '$email', '$password', '$noTelp', '$status', '$fotoPath')";

    if (mysqli_query($conn, $sql)) {
        echo "<script>alert('Pekerja berhasil ditambahkan!'); window.location.href='dashboard-admin.php';</script>";
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Tambah Pekerja - Admin</title>
    <link rel="stylesheet" href="user.css">
    <link rel="stylesheet" href="admin.css">
</head>
<body>
    <header class="navbar">
        <h1>Admin Panel</h1>
        <a href="dashboard-admin.php" class="btn-preview">← Kembali</a>
    </header>

    <div class="admin-container" style="max-width: 600px;">
        <h2>Tambah Pekerja Baru</h2>
        <form method="POST" enctype="multipart/form-data" style="margin-top:20px;">
            <div class="input-group"><label>Nama Panggilan</label><input type="text" name="nama_pendek" required></div>
            <div class="input-group"><label>Nama Lengkap</label><input type="text" name="nama_lengkap" required></div>
            <div class="input-group"><label>Jabatan / Role</label><input type="text" name="role" required></div>
            <div class="input-group"><label>Alamat Domisili</label><input type="text" name="alamat" required></div>
            <div class="input-group"><label>Email</label><input type="email" name="email" required></div>
            <div class="input-group">
                <label>Password Akun</label>
                <div class="password-wrapper">
                    <input type="password" id="pass-tambah" name="password" placeholder="••••••••" required>
                    <span class="toggle-password" onclick="togglePassword('pass-tambah', this)">👁️</span>
                </div>
            </div>
            <div class="input-group"><label>No. WhatsApp</label><input type="text" name="no_telp" required></div>
            <div class="input-group">
                <label>Status</label>
                <select name="status" required>
                    <option value="Pekerja Tetap">Pekerja Tetap</option>
                    <option value="Kontrak">Kontrak</option>
                    <option value="Magang">Magang</option>
                </select>
            </div>
            <div class="input-group">
                <label>Foto Profil</label>
                <div class="dropzone" id="dropzone" onclick="document.getElementById('file-input').click()">
                    <img id="preview-img" src="" alt="Preview" style="display:none; margin:0 auto 10px auto;">
                    <p id="dropzone-text">📂 Tarik & Lepas foto, atau <u>Klik untuk Memilih File</u></p>
                    <input type="file" id="file-input" name="foto_file" accept="image/*" style="display:none;" onchange="previewFile(this)">
                </div>
            </div>
            <div class="form-actions" style="margin-top:20px;">
                <a href="dashboard-admin.php" class="btn-batal">Batal</a>
                <button type="submit" class="btn-simpan">Simpan Pekerja</button>
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
                reader.onload = e => {
                    document.getElementById('preview-img').src = e.target.result;
                    document.getElementById('preview-img').style.display = 'block';
                    document.getElementById('dropzone-text').innerHTML = `File: <strong>${file.name}</strong>`;
                }
                reader.readAsDataURL(file);
            }
        }
        function togglePassword(inputId, icon) {
    const input = document.getElementById(inputId);
    if (input.type === 'password') {
        input.type = 'text';
        icon.textContent = '🙈';
    } else {
        input.type = 'password';
        icon.textContent = '👁️';
    }
}
    </script>
</body>
</html>
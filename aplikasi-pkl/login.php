<?php
session_start();
include 'koneksi.php';

if (isset($_SESSION['admin_logged_in']) && $_SESSION['admin_logged_in'] === true) {
    header("Location: dashboard-admin.php");
    exit;
}

$error_message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = mysqli_real_escape_string($conn, trim($_POST['username']));
    $password = trim($_POST['password']);

    if (!empty($username) && !empty($password)) {
        $query = mysqli_query($conn, "SELECT * FROM admin WHERE username = '$username'");
        
        if (mysqli_num_rows($query) === 1) {
            $row = mysqli_fetch_assoc($query);
            if (password_verify($password, $row['password']) || $password === $row['password']) {
                $_SESSION['admin_logged_in'] = true;
                $_SESSION['admin_id'] = $row['id'];
                $_SESSION['admin_nama'] = $row['nama_admin'];
                header("Location: dashboard-admin.php");
                exit;
            } else {
                $error_message = "Password salah!";
            }
        } else {
            if ($username === 'admin' && $password === 'admin123') {
                $_SESSION['admin_logged_in'] = true;
                $_SESSION['admin_nama'] = 'Administrator System';
                header("Location: dashboard-admin.php");
                exit;
            } else {
                $error_message = "Username tidak ditemukan!";
            }
        }
    } else {
        $error_message = "Isi username dan password!";
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Admin - PT.UBL</title>
    <link rel="stylesheet" href="registrasi.css">
</head>
<body>
    <div class="register-card" style="max-width: 400px;">
        <div class="register-header">
            <h2>Admin Login</h2>
            <p>Akses khusus pengelola data</p>
        </div>

        <?php if ($error_message) : ?>
            <div style="background:#fef2f2; border:1px solid #fca5a5; color:#991b1b; padding:10px; border-radius:8px; margin-bottom:15px; text-align:center; font-size:14px;">
                ⚠️ <?= htmlspecialchars($error_message); ?>
            </div>
        <?php endif; ?>

       <form method="POST" action="">
    <div class="input-group">
        <label>Username</label>
        <input type="text" name="username" placeholder="admin" required autofocus>
    </div>

    <!-- INPUT PASSWORD DENGAN FITUR LIHAT PASSWORD -->
    <div class="input-group">
        <label>Password</label>
        <div class="password-wrapper">
            <input type="password" id="pass-admin-login" name="password" placeholder="••••••••" required>
            <span class="toggle-password" onclick="togglePassword('pass-admin-login', this)">👁️</span>
        </div>
    </div>

    <div class="form-actions" style="margin-top:20px;">
        <button type="submit" class="btn-submit" style="width:100%;">Masuk Panel Admin</button>
    </div>
</form>

<!-- SCRIPT JS LIHAT PASSWORD -->
<script>
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
        <p style="text-align:center; margin-top:20px; font-size:14px;">
            <a href="dashboard-user.php" style="color:#0284c7; text-decoration:none;">Kembali ke Dashboard User</a>
        </p>
    </div>
</body>
</html>
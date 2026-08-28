<?php
session_start();
include 'koneksi.php';

if (isset($_SESSION['user_logged_in']) && $_SESSION['user_logged_in'] === true) {
    header("Location: dashboard-user.php");
    exit;
}

$error_message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email    = mysqli_real_escape_string($conn, trim($_POST['email']));
    $password = trim($_POST['password']);

    if (!empty($email) && !empty($password)) {
        $query = mysqli_query($conn, "SELECT * FROM pekerja WHERE email = '$email'");
        
        if (mysqli_num_rows($query) === 1) {
            $user = mysqli_fetch_assoc($query);
            if (password_verify($password, $user['password']) || $password === $user['password']) {
                $_SESSION['user_logged_in'] = true;
                $_SESSION['user_id']        = $user['id'];
                $_SESSION['user_nama']      = $user['nama_lengkap'];
                $_SESSION['user_foto']      = $user['foto'];
                
                header("Location: dashboard-user.php");
                exit;
            } else {
                $error_message = "Password yang Anda masukkan salah!";
            }
        } else {
            $error_message = "Email tidak terdaftar sebagai pekerja!";
        }
    } else {
        $error_message = "Harap isi email dan password!";
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Login - PT.UBL</title>
    <link rel="stylesheet" href="registrasi.css">
</head>
<body>
    <div class="register-card" style="max-width: 420px;">
        <div class="register-header">
            <h2>Portal Pekerja</h2>
            <p>Masukkan email dan password Anda</p>
        </div>

        <?php if ($error_message) : ?>
            <div style="background:#fef2f2; border:1px solid #fca5a5; color:#991b1b; padding:10px; border-radius:8px; margin-bottom:15px; text-align:center; font-size:14px;">
                ⚠️ <?= htmlspecialchars($error_message); ?>
            </div>
        <?php endif; ?>

       <form method="POST" action="">
    <div class="input-group">
        <label>Email Pekerja</label>
        <input type="email" name="email" placeholder="zean@gmail.com" required autofocus>
    </div>

    <!-- INPUT PASSWORD DENGAN FITUR LIHAT PASSWORD -->
    <div class="input-group">
        <label>Password</label>
        <div class="password-wrapper">
            <input type="password" id="pass-user-login" name="password" placeholder="••••••••" required>
            <span class="toggle-password" onclick="togglePassword('pass-user-login', this)">👁️</span>
        </div>
    </div>

    <div class="form-actions" style="margin-top: 20px;">
        <button type="submit" class="btn-submit" style="width: 100%;">Masuk System</button>
    </div>
</form>

<!-- SCRIPT JS LIHAT PASSWORD -->
<script>
function togglePassword(inputId, icon) {
    const input = document.getElementById(inputId);
    if (input.type === 'password') {
        input.type = 'text';
        icon.textContent = '🙈'; // Ikon mata tertutup saat terlihat
    } else {
        input.type = 'password';
        icon.textContent = '👁️'; // Ikon mata terbuka saat tersembunyi
    }
}
</script>
        <div style="text-align: center; margin-top: 20px; font-size: 14px; color: #64748b;">
            <p>Belum punya akun? <a href="register.php" style="color:#0284c7; font-weight:600; text-decoration:none;">Daftar Pekerja</a></p>
            <p style="margin-top: 8px;"><a href="login.php" style="color: #64748b; text-decoration:none;">Login sebagai Admin</a></p>
        </div>
    </div>
</body>
</html>
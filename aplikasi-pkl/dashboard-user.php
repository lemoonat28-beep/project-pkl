<?php
session_start();

if (!isset($_SESSION['user_logged_in']) || $_SESSION['user_logged_in'] !== true) {
    header("Location: user-login.php");
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
    <title>Dashboard User - PT.UBL</title>
    <link rel="stylesheet" href="user.css">
</head>
<body>

    <div id="layar-beranda" class="layar aktif">
        <div class="navbar">
            <h1>PT. UBL</h1>
            <div class="user-profile">
                <?php if (!empty($_SESSION['user_foto'])): ?>
                    <img src="<?= htmlspecialchars($_SESSION['user_foto']); ?>" style="width: 32px; height: 32px; border-radius: 50%; object-fit: cover;">
                <?php endif; ?>
                <span>Halo, <?= htmlspecialchars($_SESSION['user_nama']); ?></span>
                <a href="user-logout.php" style="color: #fca5a5; text-decoration: none; font-size: 13px; margin-left: 10px; font-weight: bold;">Logout</a>
            </div>
        </div>

        <h3>DAFTAR PEKERJA PT. UBL</h3>
        <h4>Klik pada kartu untuk melihat profil lengkap</h4>

        <div class="card-container">
            <?php if (mysqli_num_rows($query) > 0) : ?>
                <?php while ($row = mysqli_fetch_assoc($query)) : ?>
                    <div class="card" onclick="bukaDetail(<?= htmlspecialchars(json_encode($row)); ?>)">
                        <img src="<?= htmlspecialchars($row['foto']); ?>" alt="Foto" onerror="this.src='https://via.placeholder.com/90';">
                        <h2><?= htmlspecialchars($row['nama_pendek']); ?></h2>
                        <div class="role"><?= htmlspecialchars($row['role']); ?></div>
                        <span class="klik-detail">Lihat Profil &rarr;</span>
                    </div>
                <?php endwhile; ?>
            <?php else : ?>
                <p style="text-align: center; grid-column: span 4; color: #64748b;">Belum ada data pekerja.</p>
            <?php endif; ?>
        </div>

        <div class="marquee">
            <p>PT. UBL &nbsp;&bull;&nbsp; Mengembangkan Sumber Daya Manusia Unggul dan Profesional &nbsp;&bull;&nbsp; Selamat Bekerja!</p>
        </div>
    </div>

    <!-- DETAIL PROFIL -->
    <div id="layar-detail" class="layar">
        <div class="navbar-detail">
            <button class="btn-kembali" onclick="kembaliBeranda()">&larr; Kembali</button>
            <div class="judul-detail">Detail Profil Pekerja</div>
            <div></div>
        </div>

        <div class="desktop-content">
            <div class="profil-header-card">
                <img id="detail-foto" src="" alt="Foto Profil">
                <h2 id="detail-nama-pendek" style="color: #0369a1;">-</h2>
                <div class="badge" id="detail-status">-</div>
            </div>

            <div class="profil-body-card">
                <h3>Informasi Biodata</h3>
                <div class="grid-biodata">
                    <div class="item-biodata">
                        <label>Nama Lengkap</label>
                        <p id="detail-nama-lengkap">-</p>
                    </div>
                    <div class="item-biodata">
                        <label>Jabatan / Posisi</label>
                        <p id="detail-role">-</p>
                    </div>
                    <div class="item-biodata">
                        <label>Email</label>
                        <p id="detail-email">-</p>
                    </div>
                    <div class="item-biodata">
                        <label>No. WhatsApp</label>
                        <p id="detail-telp">-</p>
                    </div>
                    <div class="item-biodata" style="grid-column: span 2;">
                        <label>Alamat Domisili</label>
                        <p id="detail-alamat">-</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function bukaDetail(data) {
            document.getElementById('detail-foto').src = data.foto;
            document.getElementById('detail-nama-pendek').innerText = data.nama_pendek;
            document.getElementById('detail-nama-lengkap').innerText = data.nama_lengkap;
            document.getElementById('detail-role').innerText = data.role;
            document.getElementById('detail-status').innerText = data.status;
            document.getElementById('detail-email').innerText = data.email;
            document.getElementById('detail-telp').innerText = data.no_telp;
            document.getElementById('detail-alamat').innerText = data.alamat;

            document.getElementById('layar-beranda').classList.remove('aktif');
            document.getElementById('layar-detail').classList.add('aktif');
            window.scrollTo(0, 0);
        }

        function kembaliBeranda() {
            document.getElementById('layar-detail').classList.remove('aktif');
            document.getElementById('layar-beranda').classList.add('aktif');
            window.scrollTo(0, 0);
        }
    </script>
</body>
</html>
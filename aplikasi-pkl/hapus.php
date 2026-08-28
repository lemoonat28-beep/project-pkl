<?php
session_start();
if (!isset($_SESSION['admin_logged_in'])) { header("Location: login.php"); exit; }
include 'koneksi.php';

$id = $_GET['id'] ?? null;
if ($id) {
    $id = mysqli_real_escape_string($conn, $id);
    mysqli_query($conn, "DELETE FROM pekerja WHERE id = '$id'");
}
header("Location: dashboard-admin.php");
exit;
?>
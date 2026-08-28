<?php
session_start();
unset($_SESSION['user_logged_in']);
unset($_SESSION['user_id']);
unset($_SESSION['user_nama']);
unset($_SESSION['user_foto']);

header("Location: user-login.php");
exit;
?>
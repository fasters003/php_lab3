<?php
session_start();
session_destroy();

// Удаляем Cookie
setcookie('bg_color', '', time() - 3600, '/');
setcookie('font_color', '', time() - 3600, '/');
setcookie('remember_token', '', time() - 3600, '/');

header('Location: login.php');
exit;
?>
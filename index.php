<?php
require 'db.php';
session_start();

// АВТОЛОГИН: если нет сессии, но есть токен в Cookie
if (!isset($_SESSION['user_id']) && !empty($_COOKIE['remember_token'])) {
    $stmt = $pdo->prepare("SELECT * FROM users WHERE remember_token = ?");
    $stmt->execute([$_COOKIE['remember_token']]);
    $user = $stmt->fetch();
    
    if ($user) {
        $_SESSION['user_id'] = $user['id'];
        // Применяем настройки из БД в Cookie
        setcookie('bg_color', $user['bg_color'], time() + 86400 * 30, '/');
        setcookie('font_color', $user['font_color'], time() + 86400 * 30, '/');
    }
}

// Применение настроек
$bg = $_COOKIE['bg_color'] ?? '#ffffff';
$font = $_COOKIE['font_color'] ?? '#000000';
$isLoggedIn = isset($_SESSION['user_id']);
?>
<!DOCTYPE html>
<html>
<head>
    <title>Главная</title>
    <style>
        body { background-color: <?= $bg ?>; color: <?= $font ?>; font-family: Arial; }
    </style>
</head>
<body>
    <h1>Главная страница</h1>
    <?php if ($isLoggedIn): ?>
        <p>Вы авторизованы!</p>
        <a href="logout.php">Выйти</a>
    <?php else: ?>
        <p>Вы не авторизованы.</p>
        <a href="login.php">Войти</a> | <a href="register.php">Регистрация</a>
    <?php endif; ?>
</body>
</html>
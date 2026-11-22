<?php
require 'db.php';
session_start();
$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $stmt = $pdo->prepare("SELECT * FROM users WHERE username = ?");
    $stmt->execute([$_POST['username']]);
    $user = $stmt->fetch();

    if ($user && password_verify($_POST['password'], $user['password'])) {
        $_SESSION['user_id'] = $user['id'];
        
        // Сохраняем настройки в Cookie (на 30 дней)
        setcookie('bg_color', $user['bg_color'], time() + 86400 * 30, '/');
        setcookie('font_color', $user['font_color'], time() + 86400 * 30, '/');

        // Если стоит галочка "Запомнить меня"
        if (!empty($_POST['remember'])) {
            $token = bin2hex(random_bytes(32));
            $stmt = $pdo->prepare("UPDATE users SET remember_token = ? WHERE id = ?");
            $stmt->execute([$token, $user['id']]);
            setcookie('remember_token', $token, time() + 86400 * 30, '/');
        }
        header('Location: index.php');
        exit;
    } else {
        $message = "Неверный логин или пароль.";
    }
}
?>
<!DOCTYPE html>
<html>
<head><title>Вход</title></head>
<body>
    <h2>Вход</h2>
    <p><?= $message ?></p>
    <form method="POST">
        Логин: <input type="text" name="username" required><br><br>
        Пароль: <input type="password" name="password" required><br><br>
        <label><input type="checkbox" name="remember" value="1"> Запомнить меня</label><br><br>
        <button type="submit">Войти</button>
    </form>
</body>
</html>
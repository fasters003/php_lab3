<?php
require 'db.php';
$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT); // Хешируем пароль
    $bg_color = $_POST['bg_color'];
    $font_color = $_POST['font_color'];

    $stmt = $pdo->prepare("INSERT INTO users (username, password, bg_color, font_color) VALUES (?, ?, ?, ?)");
    if ($stmt->execute([$username, $password, $bg_color, $font_color])) {
        $message = "Регистрация успешна! <a href='login.php'>Войти</a>";
    } else {
        $message = "Ошибка регистрации.";
    }
}
?>
<!DOCTYPE html>
<html>
<head><title>Регистрация</title></head>
<body>
    <h2>Регистрация</h2>
    <p><?= $message ?></p>
    <form method="POST">
        Логин: <input type="text" name="username" required><br><br>
        Пароль: <input type="password" name="password" required><br><br>
        Цвет фона: <input type="color" name="bg_color" value="#ffffff"><br><br>
        Цвет шрифта: <input type="color" name="font_color" value="#000000"><br><br>
        <button type="submit">Зарегистрироваться</button>
    </form>
</body>
</html>
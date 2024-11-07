<?php
session_start(); // Начинаем сессию

// Проверка, авторизован ли пользователь
if (!isset($_SESSION['phone'])) {
    header("Location: login.php"); // Перенаправление на страницу входа
    exit;
}
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Главная страница</title>
</head>
<body>
<h1>Добро пожаловать!</h1>
<p>Вы успешно вошли на сайт.</p>
<a href="logout.php">Выйти</a>
</body>
</html>
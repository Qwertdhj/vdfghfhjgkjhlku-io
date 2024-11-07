<?php
session_start(); // Начинаем сессию

unset($_SESSION['phone']); // Удаляем номер телефона из сессии
header("Location: index.html"); // Перенаправление на страницу входа
exit;
?>
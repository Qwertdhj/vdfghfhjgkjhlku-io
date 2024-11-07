<?php
session_start(); // Начинаем сессию

// Проверка, был ли передан номер телефона
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['phone'])) {
    $phone = $_POST['phone'];

    // Подключение к базе данных
    try {
        $pdo = new PDO('mysql:host=localhost;dbname=xzone', 'root', '');
        $pdo = new PDO('mysql:host=localhost;dbname=xzone', 'root', '');
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
        // Проверяем, существует ли уже пользователь с таким номером телефона
        $stmt = $pdo->prepare("SELECT * FROM users WHERE phone_number = :phone");
        $stmt->execute([':phone' => $phone]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if ($user) { // Если пользователь найден
            if ($user['is_verified']) {
                header("Location: index.php"); // Перенаправление на главную страницу
                exit;
            } else {
                // Сохранение номера телефона в сессии
                $_SESSION['phone'] = $phone;
                
                // Отображение QR-код сканера
                include 'qr_scanner.php';
                exit;
            }
        } else { // Если пользователя нет, создаем новый аккаунт
            $stmt = $pdo->prepare("INSERT INTO users (phone_number) VALUES (:phone)");
            $stmt->execute([':phone' => $phone]);
            
            // Сохранение номера телефона в сессии
            $_SESSION['phone'] = $phone;
            
            // Отображение QR-код сканера
            include 'qr_scanner.php';
            exit;
        }
    } catch (PDOException $e) {
        echo "Ошибка подключения к базе данных: " . $e->getMessage();
    }
}
?>
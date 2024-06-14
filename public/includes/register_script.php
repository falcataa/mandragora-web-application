<?php
// Стартуем сессию для отображения сообщений об ошибках/успехах
ini_set('display_errors', 1);
error_reporting(E_ALL);
session_start();

// Проверяем, была ли отправлена форма
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    include 'config.php';  // Подключаем файл конфигурации БД

    $username = trim($_POST['username']);  // Получаем логин от пользователя
    $password = trim($_POST['password']);  // Получаем пароль
    $confirm_password = trim($_POST['confirm_password']);  // Получаем подтверждение пароля


    // Проверяем, что поля не пустые
    if (empty($username) || empty($password) || empty($confirm_password)) {
        $_SESSION['error'] = "Барлық өрістерді толтыру қажет.";
        header('Location: ../register.php');
        exit;
    }

    // Проверяем минимальную длину логина и пароля
    if (strlen($username) < 5 || strlen($password) < 6) {
        $_SESSION['error'] = "Логин кемінде 5 таңба, пароль кемінде 6 таңба болуы керек.";
        header('Location: ../register.php');
        exit;
    }

    // Проверяем, совпадают ли пароли
    if ($password !== $confirm_password) {
        $_SESSION['error'] = "Құпия сөздер бірдей емес.";
        header('Location: ../register.php');
        exit;
    }
    // Подключаемся к базе данных
    $mysqli = new mysqli(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_DATABASE);
    if ($mysqli->connect_error) {
        die("Ошибка подключения: " . $mysqli->connect_error);
    }
    // Проверяем, существует ли уже такой пользователь
    $sql = "SELECT id FROM users WHERE login = ?";
    $stmt = $mysqli->prepare($sql);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $stmt->store_result();
    if ($stmt->num_rows > 0) {
        $_SESSION['error'] = "Мұндай логинмен пайдаланушы бар.";
        header('Location: ../register.php');
        exit;
    }

    // Если пользователь уникален, хешируем пароль и сохраняем нового пользователя
    $password_hash = password_hash($password, PASSWORD_DEFAULT);

    $sql = "INSERT INTO users (login, password) VALUES (?, ?)";
    $stmt = $mysqli->prepare($sql);

    $stmt->bind_param("ss", $username, $password_hash);
    if ($stmt->execute()) {
        $_SESSION['success'] = "Тіркеу сәтті өтті. Енді кіріңіз.";
        header('Location: ../login.php');
        // ! перенаправить на каталог
        exit;
    } else {
        $_SESSION['error'] = "Тіркеу кезінде қате: " . $stmt->error;
        header('Location: ../register.php');
        exit;
    }

    $stmt->close();
    $mysqli->close();
}



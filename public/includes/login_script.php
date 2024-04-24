<?php
session_start();
include 'config.php';  // Подключаем файл конфигурации БД

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    // Подключаемся к базе данных
    $mysqli = new mysqli(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_DATABASE);
    if ($mysqli->connect_error) {
        die("Ошибка подключения: " . $mysqli->connect_error);
    }

    // Проверяем, существует ли пользователь с таким именем
    $sql = "SELECT id, password FROM users WHERE username = ?";
    $stmt = $mysqli->prepare($sql);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows == 1) {
        $stmt->bind_result($id, $hashed_password);
        $stmt->fetch();
        if (password_verify($password, $hashed_password)) {
            // Пароль верный, пользователь аутентифицирован
            $_SESSION['user_id'] = $id;
            $_SESSION['username'] = $username;
            header("Location: ../catalog.html");
            exit;
        } else {
            $_SESSION['error'] = "Неверный пароль.";
            header("Location: ../login.php");
            exit;
        }
    } else {
        $_SESSION['error'] = "Пользователь с таким логином не найден.";
        header("Location: ../login.php");
        exit;
    }

    $stmt->close();
    $mysqli->close();
}
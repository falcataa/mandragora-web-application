<?php
session_start();
include 'config.php'; // Подключаем файл конфигурации БД

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $new_password = $_POST['new_password'];
    $new_password_repeat = $_POST['new_password_repeat'];

    // Проверка на совпадение паролей
    if ($new_password !== $new_password_repeat) {
        $_SESSION['error'] = "Құпия сөздер бірдей емес.";
        header('Location: ../settings.php');
        exit;
    }

    // Валидация нового пароля
    if (strlen($new_password) < 6 || !preg_match("/[a-zA-Z]/", $new_password) || !preg_match("/\d/", $new_password)) {
        $_SESSION['error'] = "Құпия сөз кем дегенде 6 таңбадан тұруы керек және кем дегенде бір сан мен бір әріптен тұруы керек.";
        header('Location: ../settings.php');
        exit;
    }

    // Получение ID пользователя (предполагается, что ID пользователя хранится в $_SESSION после входа в систему)
    $user_id = $_SESSION['user_id']; // Убедитесь, что это ID вошедшего пользователя

    // Хеширование нового пароля
    $new_password_hash = password_hash($new_password, PASSWORD_DEFAULT);

    // Обновление пароля в базе данных
    $stmt = $mysqli->prepare("UPDATE users SET password = ? WHERE id = ?");
    $stmt->bind_param("si", $new_password_hash, $user_id);
    if ($stmt->execute()) {
        $_SESSION['success'] = "Құпия сөз сәтті жаңартылды.";
    } else {
        $_SESSION['error'] = "Құпия сөзді жаңарту қатесі: " . $stmt->error;
    }

    $stmt->close();
    $mysqli->close();
    header('Location: ../login.php');
    exit;
}
<?php
session_start();
require 'config.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $changes = [];
    $params = [];
    $types = '';

    // Сбор измененных данных и их типов
    $fields = [
        'first_name' => 's',
        'last_name' => 's',
        'email' => 's',
        'phone' => 's',
        'city' => 's',
        // Для изображений обработка отдельно
    ];

    foreach ($fields as $field => $type) {
        if (!empty($_POST[$field])) {
            $changes[] = "$field = ?";
            $params[] = $_POST[$field];
            $types .= $type;
        }
    }

    if (!empty($_FILES['image_url']['name'])) {
        $profile_image = $_FILES['image_url']['name'];
        $target = '../src/avatars/' . basename($profile_image);
        if (move_uploaded_file($_FILES['image_url']['tmp_name'], $target)) {
            $changes[] = "image_url = ?";
            $params[] = $profile_image;
            $types .= 's';
        }
    }


    if (!empty($changes) && !empty($params)) {
        $params[] = $_SESSION['user_id'];
        $types .= 'i';
        $sql = "UPDATE users SET " . implode(', ', $changes) . " WHERE id = ?";
        $stmt = $mysqli->prepare($sql);
        $stmt->bind_param($types, ...$params);
        if ($stmt->execute()) {
            $_SESSION['success'] = "Изменения сохранены успешно!";
        } else {
            $_SESSION['error'] = "Ошибка обновления данных: " . $stmt->error;
        }
        $stmt->close();
    } else {
        $_SESSION['error'] = "Нет данных для обновления.";
    }

    $mysqli->close();
    header('Location: ../settings.php');
    exit;
}
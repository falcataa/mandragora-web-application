<?php
session_start();
include 'includes/config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = $_POST['title'];
    $description = $_POST['description'];
    $user_id = $_SESSION['user_id']; // Убедитесь, что это правильный ID пользователя


    $target_file = ""; // Пустая строка для случаев, когда файл не загружен

    $file_uploaded = false;

    if (isset($_FILES["post_img"]["name"]) && $_FILES["post_img"]["error"] == 0) {
        $target_dir = "src/user_posts/";
        $target_file = $target_dir . basename($_FILES["post_img"]["name"]);
        $file_uploaded = move_uploaded_file($_FILES["post_img"]["tmp_name"], $target_file);
        if (!$file_uploaded) {
            $_SESSION['error'] = "Не удалось загрузить файл.";
        }
    }

    if (empty($title) && empty($description) && !$file_uploaded) {
        $_SESSION['error'] = "Необходимо заполнить хотя бы одно поле.";
        header('Location: profile.php');
        exit;
    }

    // SQL запрос на добавление нового поста
    $stmt = $mysqli->prepare("INSERT INTO posts (user_id, title, description, main_image_url) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("isss", $user_id, $title, $description, $target_file);
    if ($stmt->execute()) {
        $_SESSION['message'] = "Пост успешно добавлен.";
    } else {
        $_SESSION['error'] = "Ошибка при добавлении поста: " . $stmt->error;
    }

    $stmt->close();
    $mysqli->close();
    header('Location: profile.php'); // Возвращаемся на страницу профиля
    exit;
}
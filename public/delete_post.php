<?php
session_start();
include 'includes/config.php'; // Подключение конфигурации базы данных

if (!isset($_SESSION['user_id'])) {
    echo json_encode(['error' => 'Пользователь не авторизован']);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['post_id'])) {
    $post_id = intval($_POST['post_id']);
    $user_id = $_SESSION['user_id'];

    $stmt = $mysqli->prepare("DELETE FROM posts WHERE id = ? AND user_id = ?");
    $stmt->bind_param("ii", $post_id, $user_id);
    $stmt->execute();

    if ($stmt->affected_rows > 0) {
        echo json_encode(['success' => 'Пост удалён успешно']);
    } else {
        echo json_encode(['error' => 'Ошибка при удалении поста']);
    }
    $stmt->close();
    $mysqli->close();
    exit;
}
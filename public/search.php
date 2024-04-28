<?php
include 'includes/config.php'; // Подключение файла конфигурации базы данных

$search_term = $_GET['query']; // Получаем поисковый запрос из URL параметра

$response = [];

if (!empty($search_term)) {
    $stmt = $mysqli->prepare("SELECT id, title, main_image_url FROM plants WHERE title LIKE CONCAT('%', ?, '%')");
    $stmt->bind_param("s", $search_term);
    $stmt->execute();
    $result = $stmt->get_result();

    while ($row = $result->fetch_assoc()) {
        $response[] = [
            'id' => $row['id'],
            'title' => $row['title'],
            'image_url' => $row['main_image_url']
        ];
    }
    $stmt->close();
}

$mysqli->close();

echo json_encode($response); // Возвращаем результаты в формате JSON
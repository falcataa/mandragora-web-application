<?php
if (isset($_POST['delete'])) {
    $post_id = $_POST['post_id'];

    // Подключение к базе данных
    $dbh = new PDO('mysql:host=localhost;dbname=mandragora', 'dev', 'DarkhanBestProgrammerSuckHisDIck!!_27');

    $stmt = $dbh->query('SELECT image_url FROM transplantation WHERE plant_id = $post_id');
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        if (file_exists('uploads/' + $row['image_url'])) {
            if (unlink('uploads/' + $row['image_url'])) {
                echo "Файл успешно удален.";
            } else {
                echo "Ошибка при удалении файла.";
            }
        } else {
            echo "Файл не существует.";
        
        }
    }

    // Выполнение запроса DELETE
    $stmt = $dbh->prepare('DELETE FROM transplantation WHERE plant_id = :id');
    $stmt->bindParam(':id', $post_id);
    $stmt->execute();

    $stmt = $dbh->query('SELECT image_url FROM plant_imgs WHERE plant_id = $post_id');
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        if (file_exists('uploads/' + $row['image_url'])) {
            if (unlink('uploads/' + $row['image_url'])) {
                echo "Файл успешно удален.";
            } else {
                echo "Ошибка при удалении файла.";
            }
        } else {
            echo "Файл не существует.";
        
        }
    }

    // Выполнение запроса DELETE
    $stmt = $dbh->prepare('DELETE FROM plant_imgs WHERE plant_id = :id');
    $stmt->bindParam(':id', $post_id);
    $stmt->execute();


    // Выполнение запроса DELETE
    $stmt = $dbh->prepare('DELETE FROM plants WHERE id = :id');
    $stmt->bindParam(':id', $post_id);
    $stmt->execute();

    // Перенаправление обратно на страницу после удаления
    header("Location: admin.php?upload_status=Successfully deleted post with id: $post_id");
    exit;
}
?>

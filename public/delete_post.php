<?php
if (isset($_POST['delete'])) {
    $post_id = $_POST['post_id'];

    // Подключение к базе данных
    $dbh = new PDO('mysql:host=localhost;dbname=mandragora', 'dev', 'DarkhanBestProgrammerSuckHisDIck!!_27');

    // Выполнение запроса DELETE
    $stmt = $dbh->prepare('DELETE FROM transplantation WHERE plant_id = :id');
    $stmt->bindParam(':id', $post_id);
    $stmt->execute();

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

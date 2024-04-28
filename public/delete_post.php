<?php
if (isset($_POST['delete'])) {
    $post_id = $_POST['post_id'];

    // Подключение к базе данных
    $dbh = new PDO('mysql:host=localhost;dbname=mandragora', 'dev', 'DarkhanBestProgrammerSuckHisDIck!!_27');

    // Выполнение запроса DELETE
    $stmt = $dbh->prepare('DELETE FROM plants WHERE id = :id');
    $stmt->bindParam(':id', $post_id);
    $stmt->execute();

    // Перенаправление обратно на страницу после удаления
    header('Location: ' . $_SERVER['HTTP_REFERER']);
    exit;
}
?>

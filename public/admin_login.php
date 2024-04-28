<?php
session_start();

$db = new PDO('mysql:host=localhost;dbname=mandragora', 'dev', 'DarkhanBestProgrammerSuckHisDIck!!_27');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $login = trim(htmlspecialchars($_POST['login']));
    $password = $_POST['password'];

    $query = $db->prepare("SELECT login, password, image_url, first_name, last_name FROM users WHERE login = :login AND admin = 1");
    $query->bindParam(":login", $login);
    $query->execute();

    if ($query->rowCount() > 0) {
        $admin = $query->fetch(PDO::FETCH_ASSOC);

        if (password_verify($password, $admin['password'])) {
            $_SESSION['admin'] = $admin;
            header('Location: admin.php');
            exit;
        } else {
            echo 'Неправильный пароль';
        }
    } else {
        echo 'Неправильный логин';
    }
}
?>

<form method="POST">
    <input type="text" name="login" placeholder="Логин">
    <input type="password" name="password" placeholder="Пароль">
    <input type="submit" value="Войти">
</form>

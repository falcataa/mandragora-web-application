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
            $_SESSION['error'] = 'Неправильный пароль';
            header('Location: admin_login.php');
            exit;
        }
    } else {
        echo 'Неправильный логин';
    }
}
if (isset($_SESSION['error'])) {
    echo $_SESSION['error'];
    unset($_SESSION['error']);
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>Admin Login</title>
    <link rel="stylesheet" type="text/css" href="./css/admin-style.css">
</head>

<body>
    <section class="section-admin-login">
        <form method="POST" class="center-form section-login__form">
            <input class="login-input" type="text" name="login" placeholder="Логин">
            <input class="login-input" type="password" name="password" placeholder="Пароль">
            <input class="button" type="submit" value="Войти">
        </form>
    </section>

</body>

</html>
<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta property="og:title" content="Mandragora | растения" />
    <meta property="og:description" content="Дипломный проект | сделанный Акылбеком и Рабигой" />
    <meta name="description" content="Дипломный проект | сделанный Акылбеком и Рабигой" />
    <title>Mandragora</title>

    <link rel="stylesheet" type="text/css"
        href="https://cdn.jsdelivr.net/gh/cferdinandi/tabby@12.0.0/dist/css/tabby-ui.min.css" />
    <link rel="stylesheet" href="src/fonts/Gilroy/stylesheet.css" />
    <link rel="stylesheet" href="src/fonts/Inter/stylesheet.css" />
    <link rel="stylesheet" href="css/normalize.css" />
    <link rel="stylesheet" href="css/swiper-bundle.min.css" />
    <link rel="stylesheet" href="css/style.css" />
</head>
<?php
session_start(); // Начало сессии

include 'includes/config.php'; // Подключение файла конфигурации базы данных

// Проверяем, залогинен ли пользователь
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php'); // Перенаправляем на страницу входа, если пользователь не залогинен
    exit;
}

$user_id = $_SESSION['user_id']; // Получаем ID текущего пользователя из сессии

// Подготовка запроса для получения данных пользователя
$stmt = $mysqli->prepare("SELECT login, image_url FROM users WHERE id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

$stmt->close();
?>

<body>
    <header class="header">
        <div class="container">
            <div class="header__box">
                <a href="catalog.php" class="header__logo">Mandragora</a>

                <div class="header__right">
                    <form class="search-form">
                        <input type="search" class="search-form__input" placeholder="Найти растение" />
                    </form>
                    <div class="header__separator"></div>
                    <a href="profile.php" class="profile">
                        <div class="profile__img-wrapper">
                            <img src="<?php echo htmlspecialchars($user['image_url'] ?: 'src/img/avatar.webp') ?>"
                                alt="user" />
                        </div>
                        <div class="profile__name">
                            <?php echo htmlspecialchars($user['login']) ?>
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </header>

    <main class="main">
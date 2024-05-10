<?php
// Параметры подключения к базе данных
define('DB_SERVER', 'localhost'); // Адрес сервера базы данных, обычно localhost
define('DB_USERNAME', 'dev'); // Имя пользователя базы данных
define('DB_PASSWORD', 'DarkhanBestProgrammerSuckHisDIck!!_27'); // Пароль пользователя базы данных
define('DB_DATABASE', 'mandragora'); // Имя базы данных

// define('DB_SERVER', 'localhost'); // Адрес сервера базы данных, обычно localhost
// define('DB_USERNAME', 'root'); // Имя пользователя базы данных
// define('DB_PASSWORD', 'root'); // Пароль пользователя базы данных
// define('DB_DATABASE', 'user_registration'); // Имя базы данных

// Подключение к базе данных
$mysqli = new mysqli(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_DATABASE);

// Проверка подключения
if ($mysqli->connect_error) {
    die("Ошибка подключения: " . $mysqli->connect_error);
}

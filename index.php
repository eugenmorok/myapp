<?php
// index.php

// Подключаем файл инициализации
require 'bootstrap.php';

// Подключаем маршруты
require 'routes.php';

// Запускаем маршрутизацию
$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
dispatch($uri);
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>myapp</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <header>
        <nav>
            <ul>
                <li><a href="/">Главная</a></li>
                <li><a href="/about">О нас</a></li>
                <li><a href="/contact">Контакты</a></li>
                <li><a href="/admin">Логин</a></li>
            </ul>
        </nav>
    </header>

    <main>
        <?php
        // Здесь будет отображаться контент страниц (home, about, contact, admin)
        // В зависимости от маршрута, выбранного в routes.php
        ?>
    </main>

    <footer>
        <p>Contact us: info@myapp.com</p>
        <div class="social-links">
            <a href="#">Instagram</a>
            <a href="#">Twitter</a>
            <a href="#">Facebook</a>
        </div>
    </footer>
</body>
</html>
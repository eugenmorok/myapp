<?php
// index.php

// Подключаем файл инициализации
require 'bootstrap.php';

// Подключаем маршруты
require 'routes.php';

// Запускаем маршрутизацию
$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
dispatch($uri);
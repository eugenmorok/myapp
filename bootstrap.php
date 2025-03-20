<?php

// bootstrap.php

// Генерация CSRF-токена
function csrf_token() {
    if (empty($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }
    return $_SESSION['csrf_token'];
}

// Проверка CSRF-токена
function csrf_verify($token) {
    return isset($_SESSION['csrf_token']) && hash_equals($_SESSION['csrf_token'], $token);
}

// Загрузка .env файла
function loadEnv($path) {
    if (!file_exists($path)) {
        throw new Exception('.env file not found');
    }

    $lines = file($path, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    foreach ($lines as $line) {
        if (strpos(trim($line), '#') === 0) {
            continue; // Пропустить комментарии
        }

        list($name, $value) = explode('=', $line, 2);
        $name = trim($name);
        $value = trim($value);

        if (!array_key_exists($name, $_ENV)) {
            $_ENV[$name] = $value;
        }
    }
}

loadEnv(__DIR__ . '/.env');

// Автозагрузка классов
spl_autoload_register(function ($class) {
    if (file_exists("controllers/{$class}.php")) {
        require "controllers/{$class}.php";
    } elseif (file_exists("models/{$class}.php")) {
        require "models/{$class}.php";
    }
});

// Функция для рендеринга представлений
function view($view, $data = []) {
    extract($data);
    require "views/{$view}.php";
}

// Подключение к базе данных
function db() {
    static $pdo = null;

    if ($pdo === null) {
        $config = require 'config/database.php';

        try {
            $pdo = new PDO(
                "mysql:host={$config['host']};dbname={$config['dbname']};charset={$config['charset']}",
                $config['username'],
                $config['password']
            );
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            die("Ошибка подключения к базе данных: " . $e->getMessage());
        }
    }

    return $pdo;
}


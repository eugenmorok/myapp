<?php
// bootstrap.php

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
<?php
// controllers/HomeController.php

class HomeController {
    public function index() {
        // Получаем данные из базы данных
        $pdo = db();
        $stmt = $pdo->query("SELECT * FROM users");
        $users = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Передаем данные в представление
        view('home', ['title' => 'Главная страница', 'users' => $users]);
    }
}
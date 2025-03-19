<?php
// controllers/HomeController.php

class HomeController {
    public function index() {
        // Создаем экземпляр модели User
        $userModel = new User();

        // Получаем всех пользователей
        $users = $userModel->all();

        // Передаем данные в представление
        view('home', ['title' => 'Главная страница', 'users' => $users]);
    }
}
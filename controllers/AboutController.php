<?php
// controllers/AdminController.php

class AdminController {
    // Проверка CSRF-токена
    private function verifyCsrf() {
        session_start();
        $token = $_POST['csrf_token'] ?? '';
        if (!csrf_verify($token)) {
            die("Ошибка CSRF-токена");
        }
    }

    // Страница входа
    public function login() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->verifyCsrf(); // Проверка CSRF-токена

            $password = $_POST['password'] ?? '';
            $hash = $_ENV['ADMIN_PASSWORD_HASH'] ?? '';

            if ($password && $hash && password_verify($password, $hash)) {
                $_SESSION['admin_logged_in'] = true;
                header('Location: /admin/users');
                exit;
            } else {
                $error = "Неверный пароль!";
            }
        }

        view('admin/login', ['error' => $error ?? null]);
    }

    // Страница управления пользователями
    public function users() {
        $this->checkAuth(); // Проверка авторизации

        $userModel = new User();

        // Добавление пользователя
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_user'])) {
            $this->verifyCsrf(); // Проверка CSRF-токена

            $name = $_POST['name'] ?? '';
            $email = $_POST['email'] ?? '';
            if ($name && $email) {
                $userModel->create($name, $email);
            }
        }

        // Удаление пользователя
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_user'])) {
            $this->verifyCsrf(); // Проверка CSRF-токена

            $id = $_POST['user_id'] ?? 0;
            if ($id) {
                $userModel->delete($id);
            }
        }

        // Получение списка пользователей
        $users = $userModel->all();
        view('admin/users', ['users' => $users]);
    }

    // Остальные методы (logout) остаются без изменений
}

class AboutController {
    public function index() {
        view('about', ['title' => 'О нас']);
    }
}
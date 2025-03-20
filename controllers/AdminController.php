<?php
// controllers/AdminController.php

class AdminController {
    // Проверка авторизации
    private function checkAuth() {
        session_start();
        if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
            header('Location: /admin');
            exit;
        }
    }

    // Страница входа
    public function login() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $password = $_POST['password'] ?? '';
            $hash = $_ENV['ADMIN_PASSWORD_HASH'] ?? '';

            if ($password && $hash && password_verify($password, $hash)) {
                session_start();
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
            $name = $_POST['name'] ?? '';
            $email = $_POST['email'] ?? '';
            if ($name && $email) {
                $userModel->create($name, $email);
            }
        }

        // Удаление пользователя
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_user'])) {
            $id = $_POST['user_id'] ?? 0;
            if ($id) {
                $userModel->delete($id);
            }
        }

        // Получение списка пользователей
        $users = $userModel->all();
        view('admin/users', ['users' => $users]);
    }

    // Выход из админки
    public function logout() {
        session_start();
        session_destroy();
        header('Location: /admin');
        exit;
    }
}
<?php
// controllers/AdminController.php

class AdminController {
    // Проверка авторизации
    private function checkAuth() {
        session_start();
        if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
            header('Location: /admin/login');
            exit;
        }
    }

    // Страница входа
    public function login() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $password = $_POST['password'] ?? '';
            $hash = $_ENV['ADMIN_PASSWORD_HASH'] ?? '';

            if ($password && password_verify($password, $hash)) {
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
        $this->checkAuth();
        $user = new User();

   // Обработка POST-запросов
   if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['add_user'])) {
        $data = [
            'name' => $_POST['name'] ?? '',
            'email' => $_POST['email'] ?? '',
            'created_at' => date('Y-m-d H:i:s')
        ];
        
        if ($data['name'] && $data['email']) {
            $user->create($data);
        }
    }
    elseif (isset($_POST['delete_user'])) {
        $id = (int)($_POST['user_id'] ?? 0);
        if ($id > 0) {
            $user->delete($id);
        }
    }
    
    header('Location: /admin/users');
    exit;
}

// Получаем пользователей с сортировкой
$users = $user->order_by('created_at', 'DESC')->find_all();
view('admin/users', ['users' => $users]);
}

    // Страница редактирования пользователя
    public function edit($id) {
        $this->checkAuth();
        $user = new User();

        // Получение данных пользователя
        $userData = $user->find($id);
        if (!$userData) {
            header('Location: /admin/users');
            exit;
        }

        // Обработка формы
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_user'])) {
            $data = [
                'name' => $_POST['name'] ?? '',
                'email' => $_POST['email'] ?? '',
                'updated_at' => date('Y-m-d H:i:s')
            ];
            
            if ($data['name'] && $data['email']) {
                $user->update($id, $data);
                header('Location: /admin/users');
                exit;
            }
        }

        view('admin/edit_user', ['user' => $userData]);
    }

    // Выход из админки
    public function logout() {
        session_start();
        unset($_SESSION['admin_logged_in']);
        session_destroy();
        header('Location: /admin/login');
        exit;
    }
}
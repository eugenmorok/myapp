<?php
// routes.php

function dispatch($uri) {
    // Проверяем маршруты редактирования
    if (preg_match('#^/admin/users/edit/(\d+)$#', $uri, $matches)) {
        $controller = new AdminController();
        $controller->edit($matches[1]);
        return;
    }

    // Проверяем маршруты обновления (POST-запросы)
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && preg_match('#^/admin/users/update/(\d+)$#', $uri, $matches)) {
        $controller = new AdminController();
        $controller->update($matches[1]);
        return;
    }

    // Остальные маршруты
    switch ($uri) {
        case '/':
            $controller = new HomeController();
            $controller->index();
            break;
        case '/about':
            $controller = new AboutController();
            $controller->index();
            break;
        case '/contact':
            $controller = new ContactController();
            $controller->index();
            break;
        case '/admin':
        case '/admin/login':
            $controller = new AdminController();
            $controller->login();
            break;
        case '/admin/users':
            $controller = new AdminController();
            $controller->users();
            break;
        case '/admin/logout':
            $controller = new AdminController();
            $controller->logout();
            break;
        default:
            http_response_code(404);
            echo "404 Not Found";
            break;
    }
}
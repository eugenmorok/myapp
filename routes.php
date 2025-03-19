<?php
// routes.php

function dispatch($uri) {
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
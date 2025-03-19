<?php
// routes.php

// Функция для обработки маршрутов
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
        default:
            http_response_code(404);
            echo "404 Not Found4";
            break;
    }
}
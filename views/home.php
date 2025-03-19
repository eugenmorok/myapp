<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title><?= $title ?></title>
</head>
<body>
    <h1>Добро пожаловать на главную страницу!</h1>
    <nav>
        <a href="/">Главная</a> |
        <a href="/about">О нас</a> |
        <a href="/contact">Контакты</a>
    </nav>

    <h2>Список пользователей</h2>
    <ul>
        <?php foreach ($users as $user): ?>
            <li>
                <?= htmlspecialchars($user['name']) ?> 
                (<?= htmlspecialchars($user['email']) ?>)
            </li>
        <?php endforeach; ?>
    </ul>
</body>
</html>
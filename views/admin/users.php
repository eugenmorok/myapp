<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Управление пользователями</title>
</head>
<body>
    <h1>Управление пользователями</h1>
    <nav>
        <a href="/">Главная</a> |
        <a href="/admin/logout">Выйти</a>
    </nav>

    <h2>Добавить пользователя</h2>
    <form method="POST">
    <input type="hidden" name="csrf_token" value="<?= csrf_token() ?>">
    <label for="name">Имя:</label>
    <input type="text" name="name" id="name" required>
    <label for="email">Email:</label>
    <input type="email" name="email" id="email" required>
    <button type="submit" name="add_user">Добавить</button>
</form>

    <h2>Список пользователей</h2>
    <ul>
        <?php foreach ($users as $user): ?>
            <li>
                <?= htmlspecialchars($user['name']) ?> 
                (<?= htmlspecialchars($user['email']) ?>)
<!-- Для формы удаления -->
<form method="POST" style="display: inline;">
    <input type="hidden" name="csrf_token" value="<?= csrf_token() ?>">
    <input type="hidden" name="user_id" value="<?= $user['id'] ?>">
    <button type="submit" name="delete_user">Удалить</button>
</form>
            </li>
        <?php endforeach; ?>
    </ul>
</body>
</html>
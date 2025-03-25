<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Управление пользователями</title>
    <style>
        .user-item {
            margin: 10px 0;
            padding: 10px;
            border: 1px solid #ddd;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .user-actions form {
            display: inline-block;
            margin-left: 10px;
        }
    </style>
</head>
<body>
    <h1>Управление пользователями</h1>
    <nav>
        <a href="/">Главная</a> |
        <a href="/admin/logout">Выйти</a>
    </nav>

    <h2>Добавить пользователя</h2>
    <form method="POST" style="margin-bottom: 30px;">
        <input type="hidden" name="csrf_token" value="<?= csrf_token() ?>">
        <div style="margin-bottom: 10px;">
            <label for="name">Имя:</label>
            <input type="text" name="name" id="name" required style="padding: 5px;">
        </div>
        <div style="margin-bottom: 10px;">
            <label for="email">Email:</label>
            <input type="email" name="email" id="email" required style="padding: 5px;">
        </div>
        <button type="submit" name="add_user" style="padding: 5px 15px;">Добавить</button>
    </form>

    <h2>Список пользователей</h2>
    <?php if (empty($users)): ?>
        <p>Пользователи не найдены</p>
    <?php else: ?>
        <div class="user-list">
            <?php foreach ($users as $user): ?>
                <div class="user-item">
                    <div class="user-info">
                        <?= htmlspecialchars($user['name']) ?> 
                        (<?= htmlspecialchars($user['email']) ?>)
                    </div>
                    <div class="user-actions">
                        <!-- Форма редактирования -->
                        <form method="GET" action="/admin/users/edit/<?= $user['id'] ?>" style="display: inline;">
                            <button type="submit">Редактировать</button>
                        </form>
                        
                        <!-- Форма удаления -->
                        <form method="POST" style="display: inline;">
                            <input type="hidden" name="csrf_token" value="<?= csrf_token() ?>">
                            <input type="hidden" name="user_id" value="<?= $user['id'] ?>">
                            <button type="submit" name="delete_user" onclick="return confirm('Вы уверены?')">Удалить</button>
                        </form>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</body>
</html>
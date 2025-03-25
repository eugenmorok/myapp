<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Управление пользователями</title>
    <link href="/assets/css/admin.css" rel="stylesheet">
</head>
<body>
    <header class="admin-header">
        <div class="container">
            <h1 class="admin-title">Управление пользователями</h1>
            <nav class="admin-nav">
                <a href="/" class="nav-link">Главная</a>
                <a href="/admin/logout" class="nav-link">Выйти</a>
            </nav>
        </div>
    </header>

    <main class="admin-main container">
        <section class="user-form-section">
            <h2 class="section-title">Добавить пользователя</h2>
            <form method="POST" class="user-form">
                <input type="hidden" name="csrf_token" value="<?= csrf_token() ?>">
                <div class="form-group">
                    <label for="name" class="form-label">Имя:</label>
                    <input type="text" name="name" id="name" class="form-input" required>
                </div>
                <div class="form-group">
                    <label for="email" class="form-label">Email:</label>
                    <input type="email" name="email" id="email" class="form-input" required>
                </div>
                <button type="submit" name="add_user" class="form-button">Добавить</button>
            </form>
        </section>

        <section class="user-list-section">
            <h2 class="section-title">Список пользователей</h2>
            <?php if (empty($users)): ?>
                <p class="no-users">Пользователи не найдены</p>
            <?php else: ?>
                <div class="user-list">
                    <?php foreach ($users as $user): ?>
                        <div class="user-item">
                            <div class="user-info">
                                <span class="user-name"><?= htmlspecialchars($user['name']) ?></span>
                                <span class="user-email">(<?= htmlspecialchars($user['email']) ?>)</span>
                            </div>
                            <div class="user-actions">
                                <!-- Форма редактирования -->
                                <form method="GET" action="/admin/users/edit/<?= $user['id'] ?>" class="action-form">
                                    <input type="hidden" name="csrf_token" value="<?= csrf_token() ?>">
                                    <button type="submit" class="action-button edit-button">Редактировать</button>
                                </form>
                                
                                <!-- Форма удаления -->
                                <form method="POST" class="action-form">
                                    <input type="hidden" name="csrf_token" value="<?= csrf_token() ?>">
                                    <input type="hidden" name="user_id" value="<?= $user['id'] ?>">
                                    <button type="submit" name="delete_user" class="action-button delete-button" onclick="return confirm('Вы уверены?')">Удалить</button>
                                </form>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </section>
    </main>

    <footer class="admin-footer">
        <div class="container">
            <p class="footer-text">Contact us: <a href="mailto:info@myapp.com" class="footer-link">info@myapp.com</a></p>
            <div class="social-links">
                <a href="#" class="social-link">Instagram</a>
                <a href="#" class="social-link">Twitter</a>
                <a href="#" class="social-link">Facebook</a>
            </div>
        </div>
    </footer>
</body>
</html>
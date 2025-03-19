<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Вход в админку</title>
</head>
<body>
    <h1>Вход в админку</h1>
    <?php if (isset($error)): ?>
        <p style="color: red;"><?= htmlspecialchars($error) ?></p>
    <?php endif; ?>
    <form method="POST">
        <label for="password">Пароль:</label>
        <input type="password" name="password" id="password" required>
        <button type="submit">Войти</button>
    </form>
</body>
</html>
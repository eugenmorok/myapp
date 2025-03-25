<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Редактирование пользователя</title>
    <style>
        .edit-form {
            max-width: 500px;
            margin: 20px auto;
            padding: 20px;
            border: 1px solid #ddd;
        }
        .form-group {
            margin-bottom: 15px;
        }
        label {
            display: block;
            margin-bottom: 5px;
        }
        input[type="text"],
        input[type="email"] {
            width: 100%;
            padding: 8px;
        }
    </style>
</head>
<body>
    <h1>Редактирование пользователя</h1>
    <nav>
        <a href="/admin/users">← Назад к списку</a>
    </nav>

    <div class="edit-form">
        <form method="POST" action="/admin/users/update/<?= $user['id'] ?>">
            <input type="hidden" name="csrf_token" value="<?= csrf_token() ?>">
            
            <div class="form-group">
                <label for="name">Имя:</label>
                <input type="text" name="name" id="name" 
                       value="<?= htmlspecialchars($user['name']) ?>" required>
            </div>
            
            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" name="email" id="email" 
                       value="<?= htmlspecialchars($user['email']) ?>" required>
            </div>
            
            <button type="submit" style="padding: 8px 15px;">Сохранить изменения</button>
        </form>
    </div>
</body>
</html>
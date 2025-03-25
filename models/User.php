
<?php
/*
// models/User.php

class User {
    // Подключение к базе данных
    private $pdo;

    public function __construct() {
        $this->pdo = db(); // Используем функцию db() из bootstrap.php
    }

    // Получить всех пользователей
    public function all() {
        $stmt = $this->pdo->query("SELECT * FROM users");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Получить пользователя по ID
    public function find($id) {
        $stmt = $this->pdo->prepare("SELECT * FROM users WHERE id = :id");
        $stmt->execute(['id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Создать нового пользователя
    public function create($name, $email) {
        $stmt = $this->pdo->prepare("INSERT INTO users (name, email) VALUES (:name, :email)");
        $stmt->execute(['name' => $name, 'email' => $email]);
        return $this->pdo->lastInsertId();
    }

    // Обновить пользователя
    public function update($id, $name, $email) {
        $stmt = $this->pdo->prepare("UPDATE users SET name = :name, email = :email WHERE id = :id");
        $stmt->execute(['id' => $id, 'name' => $name, 'email' => $email]);
        return $stmt->rowCount();
    }

    // Удалить пользователя
    public function delete($id) {
        $stmt = $this->pdo->prepare("DELETE FROM users WHERE id = :id");
        $stmt->execute(['id' => $id]);
        return $stmt->rowCount();
        
    }
}
*/


// models/User.php

require_once __DIR__ . '/../core/ORM.php';

class User extends ORM {
    // Указываем таблицу и первичный ключ
    protected $table = 'users';
    protected $primary_key = 'id';

    // Дополнительные методы, специфичные для пользователей
    public function findByEmail($email) {
        return $this->where('email', '=', $email)->find();
    }

    // Можно добавить другие пользовательские методы
    public function getActiveUsers() {
        return $this->where('is_active', '=', 1)->find_all();
    }

    public function update($id, array $data) {
        $set = [];
        foreach ($data as $key => $value) {
            $set[] = "$key = :$key";
        }
        $set = implode(', ', $set);
    
        $data['id'] = $id;
    
        $stmt = $this->pdo->prepare("UPDATE {$this->table} SET $set WHERE id = :id");
        return $stmt->execute($data);
    }

}

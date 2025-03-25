<?php
// core/ORM.php

class ORM {
    protected $pdo;
    protected $table;
    protected $primary_key = 'id';
    protected $where_conditions = [];
    protected $order_by = '';
    protected $limit = '';

    public function __construct() {
        $this->pdo = db(); // Функция подключения к БД
    }

    // Базовые CRUD-методы:

    public function all() {
        $stmt = $this->pdo->query("SELECT * FROM {$this->table}");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function find($id) {
        $stmt = $this->pdo->prepare("SELECT * FROM {$this->table} WHERE {$this->primary_key} = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function create(array $data) {
        $columns = implode(', ', array_keys($data));
        $placeholders = ':' . implode(', :', array_keys($data));
        
        $stmt = $this->pdo->prepare("INSERT INTO {$this->table} ($columns) VALUES ($placeholders)");
        $stmt->execute($data);
        return $this->pdo->lastInsertId();
    }

    public function update($id, array $data) {
        $set = [];
        foreach ($data as $key => $value) {
            $set[] = "$key = :$key";
        }
        $set = implode(', ', $set);

        $data[$this->primary_key] = $id;

        $stmt = $this->pdo->prepare("UPDATE {$this->table} SET $set WHERE {$this->primary_key} = :{$this->primary_key}");
        return $stmt->execute($data);
    }

    public function delete($id) {
        $stmt = $this->pdo->prepare("DELETE FROM {$this->table} WHERE {$this->primary_key} = ?");
        return $stmt->execute([$id]);
    }

    // Методы для построения запросов:

    public function where($column, $operator, $value) {
        $this->where_conditions[] = compact('column', 'operator', 'value');
        return $this;
    }

    public function order_by($column, $direction = 'ASC') {
        $this->order_by = " ORDER BY $column $direction";
        return $this;
    }

    public function limit($count, $offset = 0) {
        $this->limit = " LIMIT $offset, $count";
        return $this;
    }

    public function find_all() {
        try {
            $sql = "SELECT * FROM {$this->table}";
            $params = [];
    
            if (!empty($this->where_conditions)) {
                $where = [];
                foreach ($this->where_conditions as $condition) {
                    $where[] = "{$condition['column']} {$condition['operator']} ?";
                    $params[] = $condition['value'];
                }
                $sql .= " WHERE " . implode(' AND ', $where);
            }
    
            if (!empty($this->order_by)) {
                $sql .= $this->order_by;
            }
    
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute($params);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            // Логируем ошибку и возвращаем пустой массив
            error_log("ORM Error: " . $e->getMessage());
            return [];
        }
    }

    // Сброс условий после выполнения запроса
    protected function reset() {
        $this->where_conditions = [];
        $this->order_by = '';
        $this->limit = '';
    }
}
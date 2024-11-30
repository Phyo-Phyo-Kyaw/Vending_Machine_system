<?php

class BaseRepository {
    protected $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function create($table, $data) {
        var_dump($data);
        $columns = implode(", ", array_keys($data));
        $placeholders = ":" . implode(", :", array_keys($data));
        $sql = "INSERT INTO {$table} ({$columns}) VALUES ({$placeholders})";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($data);
        return $this->pdo->lastInsertId();
    }

    public function getID($table, $id) {
        $sql = "SELECT * FROM {$table} WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(['id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function update($table, $data, $id) {
        $columns = implode(", ", array_map(fn($key) => "{$key} = :{$key}", array_keys($data)));
        $sql = "UPDATE {$table} SET {$columns} WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        $data['id'] = $id;
        return $stmt->execute($data);
    }

    public function delete($table, $id) {
        $sql = "DELETE FROM {$table} WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute(['id' => $id]);
    }

    public function getAll($table) {
        $sql = "SELECT * FROM {$table}";
        return $this->pdo->query($sql)->fetchAll(PDO::FETCH_ASSOC);
    }
}

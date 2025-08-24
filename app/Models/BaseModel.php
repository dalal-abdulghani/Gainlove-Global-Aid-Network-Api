<?php
namespace App\Models;

use App\Core\Database;
use PDO;

class BaseModel {
    protected $table;
    protected $db;

    public function __construct() {
        $this->db = Database::getInstance();
    }

    public function all() {
        $stmt = $this->db->query("SELECT * FROM {$this->table}");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function find($id) {
        $stmt = $this->db->prepare("SELECT * FROM {$this->table} WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function create(array $data) {
        $columns = implode(',', array_keys($data));
        $placeholders = implode(',', array_fill(0, count($data), '?'));
        $stmt = $this->db->prepare("INSERT INTO {$this->table} ($columns) VALUES ($placeholders)");
        return $stmt->execute(array_values($data));
    }

    public function update($id, array $data) {
        $fields = implode('=?, ', array_keys($data)) . '=?';
        $stmt = $this->db->prepare("UPDATE {$this->table} SET $fields WHERE id = ?");
        return $stmt->execute([...array_values($data), $id]);
    }

    public function delete($id) {
        $stmt = $this->db->prepare("DELETE FROM {$this->table} WHERE id = ?");
        return $stmt->execute([$id]);
    }
}

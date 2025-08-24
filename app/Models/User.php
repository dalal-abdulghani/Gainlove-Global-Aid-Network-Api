<?php
namespace App\Models;

class User extends BaseModel {
    protected $table = 'users';

    public function createUser($username, $password, $role = 'user') {
        $hashed = password_hash($password, PASSWORD_BCRYPT);
        return $this->create([
            'username' => $username,
            'password' => $hashed,
            'role' => $role
        ]);
    }

    public function findByUsername($username) {
        $stmt = $this->db->prepare("SELECT * FROM {$this->table} WHERE username = ?");
        $stmt->execute([$username]);
        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }
}

<?php
namespace App\Controllers;

use App\Core\Database;

class AuthController extends BaseController {
    public function login($data) {
        $username = $data['username'] ?? null;
        $password = $data['password'] ?? null;

        if (!$username || !$password) {
            return $this->respond(['message' => 'Username and password required'], 400);
        }

        $db = Database::getInstance();
        $stmt = $db->prepare("SELECT * FROM users WHERE username = ?");
        $stmt->execute([$username]);
        $user = $stmt->fetch(\PDO::FETCH_ASSOC);

        if (!$user || !password_verify($password, $user['password'])) {
            return $this->respond(['message' => 'Invalid credentials'], 401);
        }

        return $this->respond([
            'id' => $user['id'],
            'username' => $user['username'],
            'role' => $user['role'],
            'message' => 'Login successful'
        ]);
    }
}

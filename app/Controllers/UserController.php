<?php
namespace App\Controllers;

use App\Models\User;

class UserController extends BaseController {
    private $model;

    public function __construct() {
        $this->model = new User();
    }

    public function index() {
        $users = $this->model->all();
        $this->respond($users);
    }

    public function show($id) {
        $user = $this->model->find($id);
        if ($user) {
            $this->respond($user);
        } else {
            $this->respond(['message' => 'User not found'], 404);
        }
    }

    public function store($data) {
        $this->model->createUser($data['username'], $data['password'], $data['role'] ?? 'user');
        $this->respond(['message' => 'User created'], 201);
    }

    public function update($id, $data) {
        if (isset($data['password'])) {
            $data['password'] = password_hash($data['password'], PASSWORD_BCRYPT);
        }
        $this->model->update($id, $data);
        $this->respond(['message' => 'User updated']);
    }

    public function delete($id) {
        $this->model->delete($id);
        $this->respond(['message' => 'User deleted']);
    }
}

<?php
namespace App\Controllers;

use App\Models\Message;

class MessageController extends BaseController {
    private $model;

    public function __construct() {
        $this->model = new Message();
    }

    public function index() {
        $messages = $this->model->all();
        $this->respond($messages);
    }

    public function show($id) {
        $message = $this->model->find($id);
        if ($message) {
            $this->respond($message);
        } else {
            $this->respond(['message' => 'Message not found'], 404);
        }
    }

    public function store($data) {
        $this->model->createMessage($data['name'], $data['phone'], $data['email'], $data['question']);
        $this->respond(['message' => 'Message created'], 201);
    }

    public function update($id, $data) {
        $this->model->update($id, $data);
        $this->respond(['message' => 'Message updated']);
    }

    public function delete($id) {
        $this->model->delete($id);
        $this->respond(['message' => 'Message deleted']);
    }
}

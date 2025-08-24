<?php
namespace App\Controllers;

use App\Models\Program;

class ProgramController extends BaseController {
    private $model;

    public function __construct() {
        $this->model = new Program();
    }

    public function index() {
        $programs = $this->model->all();
        $this->respond($programs);
    }

    public function show($id) {
        $program = $this->model->find($id);
        if ($program) {
            $this->respond($program);
        } else {
            $this->respond(['message' => 'Program not found'], 404);
        }
    }

    public function store($data) {
        $this->model->createProgram($data['title'], $data['description'], $data['image']);
        $this->respond(['message' => 'Program created'], 201);
    }

    public function update($id, $data) {
        $this->model->update($id, $data);
        $this->respond(['message' => 'Program updated']);
    }

    public function delete($id) {
        $this->model->delete($id);
        $this->respond(['message' => 'Program deleted']);
    }
}

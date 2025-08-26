<?php
namespace App\Controllers;

use App\Models\Program;
use App\Core\Logger;

class ProgramController extends BaseController {
    private $model;

    public function __construct() {
        $this->model = new Program();
    }

    public function index() {
    try {
        $programs = $this->model->getLatest(3);
        $this->respond($programs);

    } catch (\Exception $e) {
        \App\Core\Logger::error("Failed to fetch programs: " . $e->getMessage());
        $this->respond(['message' => 'Server error'], 500);
    }
}


    public function show($id) {
        try {
            $program = $this->model->find($id);
            if ($program) {
                $this->respond($program);
            } else {
                $this->respond(['message' => 'Program not found'], 404);
            }
        } catch (\Exception $e) {
            Logger::error("Failed to fetch program ID $id: " . $e->getMessage());
            $this->respond(['message' => 'Server error'], 500);
        }
    }
public function store() {
    try {
        
        $errors = [];
        if (empty($_POST['title'])) $errors[] = 'Title is required';
        if (empty($_POST['description'])) $errors[] = 'Description is required';
        if (!isset($_FILES['image']) || $_FILES['image']['error'] !== UPLOAD_ERR_OK) {
            $errors[] = 'Valid image is required';
        }
        if ($errors) {
            $this->respond(['errors' => $errors], 422);
            return;
        }

        $uploadDir = __DIR__ . '/../../public/uploads/programs/';
        if (!is_dir($uploadDir)) mkdir($uploadDir, 0755, true);

        $filename = time() . '_' . basename($_FILES['image']['name']);
        $targetFile = $uploadDir . $filename;

        if (!move_uploaded_file($_FILES['image']['tmp_name'], $targetFile)) {
            throw new \Exception('Failed to upload image');
        }

        $imagePath = 'uploads/programs/' . $filename;

        $this->model->createProgram($_POST['title'], $_POST['description'], $imagePath);
        Logger::info("Program created: " . $_POST['title']);

        $this->respond(['message' => 'Program created'], 201);

    } catch (\Exception $e) {
        Logger::error("Failed to create program: " . $e->getMessage());
        $this->respond(['message' => 'Server error'], 500);
    }
}


    public function update($id, $data) {
        try {
            $updateData = [
                'title' => $data['title'] ?? null,
                'description' => $data['description'] ?? null,
            ];

            if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
                $uploadDir = __DIR__ . '/../../public/uploads/programs/';
                if (!is_dir($uploadDir)) mkdir($uploadDir, 0755, true);

                $filename = time() . '_' . basename($_FILES['image']['name']);
                $targetFile = $uploadDir . $filename;

                if (!move_uploaded_file($_FILES['image']['tmp_name'], $targetFile)) {
                    throw new \Exception('Failed to upload image');
                }

                $updateData['image'] = 'uploads/programs/' . $filename;
            }

            $this->model->update($id, $updateData);
            Logger::info("Program updated: ID $id");

            $this->respond(['message' => 'Program updated']);

        } catch (\Exception $e) {
            Logger::error("Failed to update program ID $id: " . $e->getMessage());
            $this->respond(['message' => 'Server error'], 500);
        }
    }

    public function delete($id) {
        try {
            $this->model->delete($id);
            Logger::info("Program deleted: ID $id");
            $this->respond(['message' => 'Program deleted']);
        } catch (\Exception $e) {
            Logger::error("Failed to delete program ID $id: " . $e->getMessage());
            $this->respond(['message' => 'Server error'], 500);
        }
    }
}

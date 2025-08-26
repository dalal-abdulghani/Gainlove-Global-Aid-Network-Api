<?php
namespace App\Controllers;

use App\Models\News;
use App\Core\Logger;

class NewsController extends BaseController {
    private $model;

    public function __construct() {
        $this->model = new News();
    }

    public function index() {
        try {
            $news = $this->model->getLatest(3);
            $this->respond($news);
        } catch (\Exception $e) {
            Logger::error("Failed to fetch news: " . $e->getMessage());
            $this->respond(['message' => 'Server error'], 500);
        }
    }

    public function show($id) {
        try {
            $item = $this->model->find($id);
            if ($item) {
                $this->respond($item);
            } else {
                $this->respond(['message' => 'News not found'], 404);
            }
        } catch (\Exception $e) {
            Logger::error("Failed to fetch news ID $id: " . $e->getMessage());
            $this->respond(['message' => 'Server error'], 500);
        }
    }

    public function store($data) {
        try {
            $errors = [];
            if (empty($data['title'])) $errors[] = 'Title is required';
            if (empty($data['date'])) $errors[] = 'Date is required';
            if (!isset($_FILES['image']) || $_FILES['image']['error'] !== UPLOAD_ERR_OK) {
                $errors[] = 'Valid image is required';
            }

            if ($errors) {
                $this->respond(['errors' => $errors], 422);
                return;
            }

            $uploadDir = __DIR__ . '/../../public/uploads/news/';
            if (!is_dir($uploadDir)) mkdir($uploadDir, 0755, true);

            $filename = time() . '_' . basename($_FILES['image']['name']);
            $targetFile = $uploadDir . $filename;

            if (!move_uploaded_file($_FILES['image']['tmp_name'], $targetFile)) {
                throw new \Exception('Failed to upload image');
            }

            $imagePath = 'uploads/news/' . $filename;

            $this->model->createNews($data['title'], $imagePath, $data['date']);
            Logger::info("News created: " . $data['title']);

            $this->respond(['message' => 'News created'], 201);

        } catch (\Exception $e) {
            Logger::error("Failed to create news: " . $e->getMessage());
            $this->respond(['message' => 'Server error'], 500);
        }
    }

    public function update($id, $data) {
        try {
            $updateData = [
                'title' => $data['title'] ?? null,
                'date' => $data['date'] ?? null
            ];

         
            if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
                $uploadDir = __DIR__ . '/../../public/uploads/news/';
                if (!is_dir($uploadDir)) mkdir($uploadDir, 0755, true);

                $filename = time() . '_' . basename($_FILES['image']['name']);
                $targetFile = $uploadDir . $filename;

                if (!move_uploaded_file($_FILES['image']['tmp_name'], $targetFile)) {
                    throw new \Exception('Failed to upload image');
                }

                $updateData['image'] = 'uploads/news/' . $filename;
            }

            $this->model->update($id, $updateData);
            Logger::info("News updated: ID $id");

            $this->respond(['message' => 'News updated']);

        } catch (\Exception $e) {
            Logger::error("Failed to update news ID $id: " . $e->getMessage());
            $this->respond(['message' => 'Server error'], 500);
        }
    }

    public function delete($id) {
        try {
            $this->model->delete($id);
            Logger::info("News deleted: ID $id");
            $this->respond(['message' => 'News deleted']);
        } catch (\Exception $e) {
            Logger::error("Failed to delete news ID $id: " . $e->getMessage());
            $this->respond(['message' => 'Server error'], 500);
        }
    }
}

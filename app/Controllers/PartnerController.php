<?php
namespace App\Controllers;

use App\Models\Partner;
use App\Core\Logger;

class PartnerController extends BaseController {
    private $model;

    public function __construct() {
        $this->model = new Partner();
    }

    public function index() {
        try {
            $partners = $this->model->all();
            $this->respond($partners);
        } catch (\Exception $e) {
            Logger::error("Failed to fetch partners: " . $e->getMessage());
            $this->respond(['message' => 'Server error'], 500);
        }
    }

    public function show($id) {
        try {
            $partner = $this->model->find($id);
            if ($partner) {
                $this->respond($partner);
            } else {
                $this->respond(['message' => 'Partner not found'], 404);
            }
        } catch (\Exception $e) {
            Logger::error("Failed to fetch partner ID $id: " . $e->getMessage());
            $this->respond(['message' => 'Server error'], 500);
        }
    }

    public function store($data) {
        try {
            if (!isset($_FILES['image']) || $_FILES['image']['error'] !== UPLOAD_ERR_OK) {
                $this->respond(['message' => 'Valid image is required'], 422);
                return;
            }

            $uploadDir = __DIR__ . '/../../public/uploads/partners/';
            if (!is_dir($uploadDir)) mkdir($uploadDir, 0755, true);

            $filename = time() . '_' . basename($_FILES['image']['name']);
            $targetFile = $uploadDir . $filename;

            if (!move_uploaded_file($_FILES['image']['tmp_name'], $targetFile)) {
                throw new \Exception('Failed to upload image');
            }

            $imagePath = 'uploads/partners/' . $filename;

            $this->model->createPartner($imagePath);
            Logger::info("Partner created: " . $imagePath);

            $this->respond(['message' => 'Partner created'], 201);

        } catch (\Exception $e) {
            Logger::error("Failed to create partner: " . $e->getMessage());
            $this->respond(['message' => 'Server error'], 500);
        }
    }

    public function update($id, $data) {
        try {
            $updateData = [];

            if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
                $uploadDir = __DIR__ . '/../../public/uploads/partners/';
                if (!is_dir($uploadDir)) mkdir($uploadDir, 0755, true);

                $filename = time() . '_' . basename($_FILES['image']['name']);
                $targetFile = $uploadDir . $filename;

                if (!move_uploaded_file($_FILES['image']['tmp_name'], $targetFile)) {
                    throw new \Exception('Failed to upload image');
                }

                $updateData['image'] = 'uploads/partners/' . $filename;
            }

            if ($updateData) {
                $this->model->update($id, $updateData);
                Logger::info("Partner updated: ID $id");
            }

            $this->respond(['message' => 'Partner updated']);

        } catch (\Exception $e) {
            Logger::error("Failed to update partner ID $id: " . $e->getMessage());
            $this->respond(['message' => 'Server error'], 500);
        }
    }

    public function delete($id) {
        try {
            $this->model->delete($id);
            Logger::info("Partner deleted: ID $id");
            $this->respond(['message' => 'Partner deleted']);
        } catch (\Exception $e) {
            Logger::error("Failed to delete partner ID $id: " . $e->getMessage());
            $this->respond(['message' => 'Server error'], 500);
        }
    }
}

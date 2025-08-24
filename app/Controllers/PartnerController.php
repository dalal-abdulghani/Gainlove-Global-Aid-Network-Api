<?php
namespace App\Controllers;

use App\Models\Partner;

class PartnerController extends BaseController {
    private $model;

    public function __construct() {
        $this->model = new Partner();
    }

    public function index() {
        $partners = $this->model->all();
        $this->respond($partners);
    }

    public function show($id) {
        $partner = $this->model->find($id);
        if ($partner) {
            $this->respond($partner);
        } else {
            $this->respond(['message' => 'Partner not found'], 404);
        }
    }

    public function store($data) {
        $this->model->createPartner($data['image']);
        $this->respond(['message' => 'Partner created'], 201);
    }

    public function update($id, $data) {
        $this->model->update($id, $data);
        $this->respond(['message' => 'Partner updated']);
    }

    public function delete($id) {
        $this->model->delete($id);
        $this->respond(['message' => 'Partner deleted']);
    }
}

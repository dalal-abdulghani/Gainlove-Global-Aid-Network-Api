<?php
namespace App\Controllers;

use App\Models\News;

class NewsController extends BaseController {
    private $model;

    public function __construct() {
        $this->model = new News();
    }

    public function index() {
        $news = $this->model->all();
        $this->respond($news);
    }

    public function show($id) {
        $item = $this->model->find($id);
        if ($item) {
            $this->respond($item);
        } else {
            $this->respond(['message' => 'News not found'], 404);
        }
    }

    public function store($data) {
        $this->model->createNews($data['title'], $data['image'], $data['date']);
        $this->respond(['message' => 'News created'], 201);
    }

    public function update($id, $data) {
        $this->model->update($id, $data);
        $this->respond(['message' => 'News updated']);
    }

    public function delete($id) {
        $this->model->delete($id);
        $this->respond(['message' => 'News deleted']);
    }
}

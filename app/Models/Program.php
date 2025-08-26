<?php
namespace App\Models;

class Program extends BaseModel {
    protected $table = 'programs';

    public function createProgram($title, $description, $image) {
        return $this->create([
            'title' => $title,
            'description' => $description,
            'image' => $image
        ]);
    }

    public function getLatest($limit = 3) {
    $stmt = $this->db->prepare("SELECT * FROM programs ORDER BY id DESC LIMIT :limit");
    $stmt->bindValue(':limit', (int)$limit, \PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetchAll(\PDO::FETCH_ASSOC);
}

}

<?php
namespace App\Models;

class News extends BaseModel {
    protected $table = 'news';

    public function createNews($title, $image, $date) {
        return $this->create([
            'title' => $title,
            'image' => $image,
            'date' => $date
        ]);
    }

    public function getLatest($limit = 3) {
    $stmt = $this->db->prepare("SELECT * FROM news ORDER BY id DESC LIMIT :limit");
    $stmt->bindValue(':limit', (int)$limit, \PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetchAll(\PDO::FETCH_ASSOC);
}

}

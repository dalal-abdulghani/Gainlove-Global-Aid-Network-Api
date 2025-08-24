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
}

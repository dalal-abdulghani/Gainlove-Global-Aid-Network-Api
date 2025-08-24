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
}

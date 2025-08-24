<?php
namespace App\Models;

class Partner extends BaseModel {
    protected $table = 'partners';

    public function createPartner($image) {
        return $this->create([
            'image' => $image
        ]);
    }
}

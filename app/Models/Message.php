<?php
namespace App\Models;

class Message extends BaseModel {
    protected $table = 'messages';

    public function createMessage($name, $phone, $email, $question) {
        return $this->create([
            'name' => $name,
            'phone' => $phone,
            'email' => $email,
            'question' => $question
        ]);
    }
}

<?php
namespace App\Controllers;

use App\Models\News;
use App\Core\Logger;
use App\Models\User;
use App\Models\Program;
use App\Models\Message;
use App\Models\Partner;


class DashboardController extends BaseController {
    private $newsModel;
    private $userModel;
    private $programModel;
    private $messageModel;
    private $partnerModel;

    public function __construct() {
        $this->newsModel = new News();
        $this->userModel = new User();
        $this->programModel = new Program();
        $this->messageModel = new Message();
        $this->partnerModel = new Partner();
    }

    public function index() {
        try {
            $news = $this->newsModel->getLatest(3);
            $usersCount = $this->userModel->countAll();
            $programsCount = $this->programModel->countAll();
            $messagesCount = $this->messageModel->countAll();
            $partnersCount = $this->partnerModel->countAll();

            $data = [
                'latest_news' => $news,
                'total_users' => $usersCount,
                'total_programs' => $programsCount,
                'total_messages' => $messagesCount,
                'total_partners' => $partnersCount,
            ];

            $this->respond($data);
        } catch (\Exception $e) {
            Logger::error("Failed to fetch dashboard data: " . $e->getMessage());
            $this->respond(['message' => 'Server error'], 500);
        }
    }   
}

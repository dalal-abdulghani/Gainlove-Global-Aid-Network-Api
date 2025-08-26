<?php
require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../config/config.php';

use App\Controllers\UserController;
use App\Controllers\ProgramController;
use App\Controllers\MessageController;
use App\Controllers\NewsController;
use App\Controllers\PartnerController;
use App\Controllers\AuthController;
use App\Controllers\DashboardController;

header("Access-Control-Allow-Origin: http://localhost:3000");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With");

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit();
}

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$method = $_SERVER['REQUEST_METHOD'];
$segments = array_values(array_filter(explode('/', $uri)));

switch ($segments[0] ?? '') {

    // -------- USERS --------
    case 'users':
        $controller = new UserController();
        $id = $segments[1] ?? null;

        if ($method === 'GET') $id ? $controller->show($id) : $controller->index();
        elseif ($method === 'POST') $controller->store(json_decode(file_get_contents('php://input'), true));
        elseif (($method === 'PUT' || $method === 'POST') && $id) {
            $data = $_POST ?: json_decode(file_get_contents('php://input'), true);
            $controller->update($id, $data);
        }
        elseif ($method === 'DELETE' && $id) $controller->delete($id);
        break;

    // -------- PROGRAMS --------
    case 'programs':
        $controller = new ProgramController();
        $id = $segments[1] ?? null;

        if ($method === 'GET') $id ? $controller->show($id) : $controller->index();
        elseif ($method === 'POST' && !$id) {
           
            $controller->store($_POST);
        }
        elseif (($method === 'POST' || $method === 'PUT') && $id) {
          
            $data = $_POST ?: json_decode(file_get_contents('php://input'), true);
            $controller->update($id, $data);
        }
        elseif ($method === 'DELETE' && $id) $controller->delete($id);
        break;

    // -------- MESSAGES --------
    case 'messages':
        $controller = new MessageController();
        $id = $segments[1] ?? null;

        if ($method === 'GET') $id ? $controller->show($id) : $controller->index();
        elseif (($method === 'POST' || $method === 'PUT') && !$id) {
            $input = $_POST ?: json_decode(file_get_contents('php://input'), true);
            $controller->store($input);
        } elseif (($method === 'PUT' || $method === 'POST') && $id) {
            $data = $_POST ?: json_decode(file_get_contents('php://input'), true);
            $controller->update($id, $data);
        } elseif ($method === 'DELETE' && $id) $controller->delete($id);
        break;

    // -------- NEWS --------
    case 'news':
        $controller = new NewsController();
        $id = $segments[1] ?? null;

        if ($method === 'GET') $id ? $controller->show($id) : $controller->index();
        elseif ($method === 'POST' && !$id) {
            $controller->store($_POST);
        } elseif (($method === 'PUT' || $method === 'POST') && $id) {
            $data = $_POST ?: json_decode(file_get_contents('php://input'), true);
            $controller->update($id, $data);
        } elseif ($method === 'DELETE' && $id) $controller->delete($id);
        break;

    // -------- PARTNERS --------
    case 'partners':
        $controller = new PartnerController();
        $id = $segments[1] ?? null;

        if ($method === 'GET') $id ? $controller->show($id) : $controller->index();
        elseif ($method === 'POST' && !$id) {
            $controller->store($_POST);
        } elseif (($method === 'PUT' || $method === 'POST') && $id) {
            $data = $_POST ?: json_decode(file_get_contents('php://input'), true);
            $controller->update($id, $data);
        } elseif ($method === 'DELETE' && $id) $controller->delete($id);
        break;

    // -------- AUTH --------
    case 'auth':
        $controller = new AuthController();
        if ($method === 'POST' && ($segments[1] ?? '') === 'login') {
            $controller->login(json_decode(file_get_contents('php://input'), true));
        } else {
            http_response_code(404);
            echo json_encode(['message' => 'Endpoint not found']);
        }
        break;

   
    case 'dashboard':
        $controller = new DashboardController();
        $id = $segments[1] ?? null;

        if ($method === 'GET') $id ? $controller->show($id) : $controller->index();
        elseif ($method === 'POST' && !$id) $controller->store($_POST);
        elseif (($method === 'PUT' || $method === 'POST') && $id) {
            $data = $_POST ?: json_decode(file_get_contents('php://input'), true);
            $controller->update($id, $data);
        } elseif ($method === 'DELETE' && $id) $controller->delete($id);
        break;

    default:
        http_response_code(404);
        echo json_encode(['message' => 'Endpoint not found']);
}

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

// ---- قراءة URI و METHOD ----
$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$method = $_SERVER['REQUEST_METHOD'];
$segments = array_values(array_filter(explode('/', $uri)));

// ---- ROUTES ----
switch ($segments[0] ?? '') {

    // -------- USERS --------
    case 'users':
        $controller = new UserController();
        $id = $segments[1] ?? null;

        if ($method === 'GET') $id ? $controller->show($id) : $controller->index();
        elseif ($method === 'POST') $controller->store($_POST);
        elseif ($method === 'PUT' && $id) {
            parse_str(file_get_contents("php://input"), $data);
            $controller->update($id, array_merge($data, $_POST));
        }
        elseif ($method === 'DELETE' && $id) $controller->delete($id);
        break;

    // -------- PROGRAMS --------
    case 'programs':
        $controller = new ProgramController();
        $id = $segments[1] ?? null;

        if ($method === 'GET') $id ? $controller->show($id) : $controller->index();
        elseif ($method === 'POST') $controller->store($_POST);
        elseif ($method === 'PUT' && $id) {
            parse_str(file_get_contents("php://input"), $data);
            $controller->update($id, array_merge($data, $_POST));
        }
        elseif ($method === 'DELETE' && $id) $controller->delete($id);
        break;

    // -------- MESSAGES --------
    case 'messages':
        $controller = new MessageController();
        $id = $segments[1] ?? null;

        if ($method === 'GET') $id ? $controller->show($id) : $controller->index();
        elseif ($method === 'POST') $controller->store($_POST);
        elseif ($method === 'PUT' && $id) {
            parse_str(file_get_contents("php://input"), $data);
            $controller->update($id, array_merge($data, $_POST));
        }
        elseif ($method === 'DELETE' && $id) $controller->delete($id);
        break;

    // -------- NEWS --------
    case 'news':
        $controller = new NewsController();
        $id = $segments[1] ?? null;

        if ($method === 'GET') $id ? $controller->show($id) : $controller->index();
        elseif ($method === 'POST') $controller->store($_POST);
        elseif ($method === 'PUT' && $id) {
            parse_str(file_get_contents("php://input"), $data);
            $controller->update($id, array_merge($data, $_POST));
        }
        elseif ($method === 'DELETE' && $id) $controller->delete($id);
        break;

    // -------- PARTNERS --------
    case 'partners':
        $controller = new PartnerController();
        $id = $segments[1] ?? null;

        if ($method === 'GET') $id ? $controller->show($id) : $controller->index();
        elseif ($method === 'POST') $controller->store($_POST);
        elseif ($method === 'PUT' && $id) {
            parse_str(file_get_contents("php://input"), $data);
            $controller->update($id, array_merge($data, $_POST));
        }
        elseif ($method === 'DELETE' && $id) $controller->delete($id);
        break;

    // -------- AUTH --------
    case 'auth':
        $controller = new AuthController();
        if ($method === 'POST' && ($segments[1] ?? '') === 'login') {
            $controller->login($_POST);
        } else {
            http_response_code(404);
            echo json_encode(['message'=>'Endpoint not found']);
        }
        break;

        // -------- AUTH --------
    case 'dashboard':
        $controller = new DashboardController();
        $id = $segments[1] ?? null;

        if ($method === 'GET') $id ? $controller->show($id) : $controller->index();
        elseif ($method === 'POST') $controller->store($_POST);
        elseif ($method === 'PUT' && $id) {
            parse_str(file_get_contents("php://input"), $data);
            $controller->update($id, array_merge($data, $_POST));
        }
        elseif ($method === 'DELETE' && $id) $controller->delete($id);
        break;


    default:
        http_response_code(404);
        echo json_encode(['message'=>'Endpoint not found']);
}

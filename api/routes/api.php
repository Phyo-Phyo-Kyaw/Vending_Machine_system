<?php
require_once '../controllers/ProductController.php';
require_once '../../DatabaseConnection.php';

$action = $_GET['action'] ?? '';
$id = $_GET['id'] ?? null;
$dbConnection = new DatabaseConnection();
$productController = new ProductController($dbConnection->getPDO());

$token = $_SERVER['HTTP_AUTHORIZATION'] ?? '';
if (!Auth::validateToken($token)) {
    http_response_code(403);
    echo json_encode(["message" => "Forbidden: Invalid token"]);
    exit;
}

switch ($action) {
    case 'getAll':
        $productController->getAllProducts();
        break;
    case 'get':
        if ($id) {
            $productController->getProduct($id);
        } else {
            http_response_code(400);
            echo json_encode(["message" => "Missing product ID."]);
        }
        break;
    case 'create':
        $productController->createProduct();
        break;
    case 'update':
        if ($id) {
            $productController->updateProduct($id);
        } else {
            http_response_code(400);
            echo json_encode(["message" => "Missing product ID."]);
        }
        break;
    case 'delete':
        if ($id) {
            $productController->deleteProduct($id);
        } else {
            http_response_code(400);
            echo json_encode(["message" => "Missing product ID."]);
        }
        break;
    default:
        http_response_code(400);
        echo json_encode(["message" => "Invalid action."]);
        break;
}

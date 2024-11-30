<?php
require_once '../DatabaseConnection.php';
require_once '../../includes/Auth.php';

class ProductController {
protected $pdo;

   
public function __construct($pdo) {
      $this->pdo = $pdo;
    }

    public function getAllProducts() {
        $sql = "SELECT * FROM products";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        $products = $stmt->fetchAll(PDO::FETCH_ASSOC);
        echo json_encode($products);
    }

    public function getProduct($id) {
        $sql = "SELECT * FROM products WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        $product = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($product) {
            echo json_encode($product);
        } else {
            http_response_code(404);
            echo json_encode(["message" => "Product not found."]);
        }
    }

    public function createProduct() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            http_response_code(405);
            echo json_encode(["message" => "Method Not Allowed"]);
            return;
        }

        $data = json_decode(file_get_contents("php://input"), true);
        if (!isset($data['name']) || !isset($data['price']) || !isset($data['quantity'])) {
            http_response_code(400);
            echo json_encode(["message" => "Missing required fields."]);
            return;
        }

        $sql = "INSERT INTO products (name, price, quantity) VALUES (:name, :price, :quantity)";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':name', $data['name']);
        $stmt->bindParam(':price', $data['price']);
        $stmt->bindParam(':quantity', $data['quantity']);
        if ($stmt->execute()) {
            echo json_encode(["message" => "Product created successfully."]);
        } else {
            http_response_code(500);
            echo json_encode(["message" => "Failed to create product."]);
        }
    }

    public function updateProduct($id) {
        $data = json_decode(file_get_contents("php://input"), true);
        if (!isset($data['name']) || !isset($data['price']) || !isset($data['quantity'])) {
            http_response_code(400);
            echo json_encode(["message" => "Missing required fields."]);
            return;
        }

        // Update in database
        $sql = "UPDATE products SET name = :name, price = :price, quantity = :quantity WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':name', $data['name']);
        $stmt->bindParam(':price', $data['price']);
        $stmt->bindParam(':quantity', $data['quantity']);
        $stmt->bindParam(':id', $id);

        if ($stmt->execute()) {
            echo json_encode(["message" => "Product updated successfully."]);
        } else {
            http_response_code(500);
            echo json_encode(["message" => "Failed to update product."]);
        }
    }

    public function deleteProduct($id) {
        $sql = "DELETE FROM products WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':id', $id);
        if ($stmt->execute()) {
            echo json_encode(["message" => "Product deleted successfully."]);
        } else {
            http_response_code(500);
            echo json_encode(["message" => "Failed to delete product."]);
        }
    }
}

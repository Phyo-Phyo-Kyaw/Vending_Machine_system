<?php
require 'DatabaseConnection.php';
require 'ProductRepository.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Create a new database connection and product repository
    $dbConnection = new DatabaseConnection();
    $productRepository = new ProductRepository($dbConnection->getPDO());

    if ($productRepository->delete('products',$id)) {
        header('Location: productLists.php?message=Product deleted successfully');
        exit;
    } else {
        header('Location: productLists.php?message=Error deleting product');
        exit;
    }
} else {
    header('Location: productLists.php?message=Invalid product ID');
    exit;
}
?>

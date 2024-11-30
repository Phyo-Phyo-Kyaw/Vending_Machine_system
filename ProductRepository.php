<?php
require 'BaseRepository.php';

class ProductRepository extends BaseRepository {
    
      public function updateProduct($id, $name, $price, $quantity) {
          $query = "UPDATE products SET name = :name, price = :price, quantity = :quantity WHERE id = :id";
          $stmt = $this->pdo->prepare($query);

          // Bind values to the query
          $stmt->bindParam(':id', $id, PDO::PARAM_INT);
          $stmt->bindParam(':name', $name, PDO::PARAM_STR);
          $stmt->bindParam(':price', $price, PDO::PARAM_STR);
          $stmt->bindParam(':quantity', $quantity, PDO::PARAM_INT);

          return $stmt->execute(); 
      }

      public function getProducts($page = 1, $sortBy = 'name', $sortOrder = 'ASC', $itemsPerPage = 10) {
          $offset = ($page - 1) * $itemsPerPage;
          $query = "SELECT * FROM products ORDER BY $sortBy $sortOrder LIMIT :offset, :itemsPerPage";
          $stmt = $this->pdo->prepare($query);
          $stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
          $stmt->bindParam(':itemsPerPage', $itemsPerPage, PDO::PARAM_INT);
          $stmt->execute();

          return $stmt->fetchAll(PDO::FETCH_ASSOC);
      }

      public function listProducts($page = 1, $sortBy = 'name', $sortOrder = 'ASC') {
              $totalProducts = count($this->getAll('products'));

              $itemsPerPage = 10;
              $totalPages = ceil($totalProducts / $itemsPerPage);

              $products = $this->getProducts($page, $sortBy, $sortOrder, $itemsPerPage);

              return [
                  'products' => $products,
                  'totalPages' => $totalPages,
                  'currentPage' => $page,
                  'sortBy' => $sortBy,
                  'sortOrder' => $sortOrder
              ];
          }

      public function updateProductQuantity($productId, $newQuantity) {
            $stmt = $this->pdo->prepare("UPDATE products SET quantity = :quantity WHERE id = :id");
            $stmt->bindParam(':quantity', $newQuantity);
            $stmt->bindParam(':id', $productId);
            return $stmt->execute();
      }


      public function purchaseProduct($productId, $quantity) {
            $product = $this->getId('products',$productId);
            var_dump($product);
              if (!$product) {
                  echo "Product not found.";
                  return;
              }

              if ($product['quantity'] < $quantity) {
                  echo "Not enough stock available.";
                  return;
              }

              // Calculate the total price
              $totalPrice = $product['price'] * $quantity;

              // Update the product quantity
              $newQuantity = $product['quantity'] - $quantity;
              $this->updateProductQuantity($productId, $newQuantity);

              // Log the transaction
              $this->logTransaction($productId, $quantity, $totalPrice);
            header('Location: productLists.php?message=Product Purchase successfully');
            //   echo "Purchase successful! You bought $quantity x {$product['name']} for $$totalPrice.";
          }

      // Method to log a transaction
      public function logTransaction($productId, $quantity, $totalPrice) {
            $user_id = 1;
            $stmt = $this->pdo->prepare("INSERT INTO transactions (user_id,product_id, quantity, total_price) VALUES (:user_id,:product_id, :quantity, :total_price)");
            $stmt->bindParam(':user_id', $user_id);
            $stmt->bindParam(':product_id', $productId);
            $stmt->bindParam(':quantity', $quantity);
            $stmt->bindParam(':total_price', $totalPrice);
            return $stmt->execute();
      }
}

<?php
require 'DatabaseConnection.php';
require 'ProductRepository.php';
session_start();
$dbConnection = new DatabaseConnection();
$productRepo = new ProductRepository($dbConnection->getPDO());

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
      $name = $_POST['name'];
      $price = $_POST['price'];
      $quantity = $_POST['quantity'];
      if (!is_numeric($price) || $price <= 0) {
            $errors[] = 'Price must be a positive number.';
      }

      if (!is_numeric($quantity) || $quantity <= 0) {
            $errors[] = 'Quantity must be a positive number.';
      }

       if (empty($errors)) {
            echo `<div class="alert alert-success">$errors</div>`;
      }

      $productRepo->create('products', [
            'name' => $name,
            'price' => $price,
            'quantity' => $quantity,
      ]);
     
      header('Location: productLists.php?message=Product created successfully');
}



?>
<!DOCTYPE html>
<html lang="en">
<head>
      <meta charset="UTF-8">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <title>Document</title>
      <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
      <div class="container mt-4">
            <h2>Create Product</h2>
            <!-- Display error messages -->
            <?php if (!empty($errors)): ?>
                  <div class="alert alert-danger">
                  <?php foreach ($errors as $error): ?>
                        <p><?php echo htmlspecialchars($error); ?></p>
                  <?php endforeach; ?>
                  </div>
            <?php endif; ?>
            <form action="createProduct.php" method="POST">
                  <div class="form-group">
                  <label for="name">Product Name</label>
                  <input type="text" class="form-control" id="name" name="name" required>
                  </div>
                  <div class="form-group">
                  <label for="price">Price</label>
                  <input type="number" class="form-control" 
                        id="price" name="price" min="0.01" step="0.01" 
                        oninput="if (this.value < 0.01) this.value = '';"
                        required>
                  </div>
                  <div class="form-group">
                  <label for="quantity">Quantity</label>
                  <input type="number" class="form-control" id="quantity" 
                        name="quantity" min="0" step="1" 
                        oninput="if (this.value < 1) this.value = '';" required>
                  </div>

                  <button type="submit" class="btn btn-primary">Save Product</button>
            </form>
      </div>
</body>
<script>
      document.getElementById('price').addEventListener('input', function (e) {
            if (e.target.value < 0.01) {
                  e.target.value = '';
            }
      });
      document.getElementById('quantity').addEventListener('input', function (e) {
            if (e.target.value < 1) {
                  e.target.value = '';
            }
      });
</script>

</html>


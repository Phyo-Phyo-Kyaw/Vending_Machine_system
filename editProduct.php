<?php
require 'DatabaseConnection.php';
require 'ProductRepository.php';

session_start();

// Redirect if not admin
// if ($_SESSION['role'] !== 'admin') {
//     header('Location: index.php');
//     exit;
// }

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    $dbConnection = new DatabaseConnection();
    $productRepository = new ProductRepository($dbConnection->getPDO());

    $product = $productRepository->getID('products',$id);

    if (!$product) {
        header('Location: productLists.php?message=Product not found');
        exit;
    }

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

      if ($productRepository->updateProduct($id, $name, $price, $quantity)) {
            header('Location: productLists.php?message=Product updated successfully');
            exit;
      } else {
            $error = "Error updating product. Please try again.";
      }

      if (empty($errors)) {
            echo `<div class="alert alert-success">$errors</div>`;
      }
    }
} else {
    header('Location: productLists.php?message=Invalid product ID');
    exit;
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Edit Product</title>
  <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="container mt-4">
    <h2>Edit Product</h2>

    <form method="POST" action="editProduct.php?id=<?php echo $product['id']; ?>">
        <div class="form-group">
            <label for="name">Product Name</label>
            <input type="text" class="form-control" id="name" name="name" value="<?php echo htmlspecialchars($product['name']); ?>" required>
        </div>
        <div class="form-group">
            <label for="price">Price</label>
            <input type="number" class="form-control" id="price" name="price" 
                  value="<?php echo htmlspecialchars($product['price']); ?>"
                  oninput="if (this.value < 0.01) this.value = '';"
                  required>
        </div>
        <div class="form-group">
            <label for="quantity">Quantity</label>
            <input type="number" class="form-control" id="quantity" name="quantity" 
                  value="<?php echo htmlspecialchars($product['quantity']); ?>"
                  oninput="if (this.value < 0.01) this.value = '';" required>
        </div>

        <button type="submit" class="btn btn-primary">Update Product</button>
    </form>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.2/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
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
</body>
</html>

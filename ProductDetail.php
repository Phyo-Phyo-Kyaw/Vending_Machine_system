<?php
$product = $controller->getProductById($_GET['id']); 
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Purchase Product</title>
  <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="container mt-4">
  <h2>Purchase Product</h2>

  <!-- Product details -->
  <div class="card">
    <div class="card-body">
      <h5 class="card-title"><?php echo htmlspecialchars($product['name']); ?></h5>
      <p><strong>Price:</strong> $<?php echo htmlspecialchars($product['price']); ?></p>
      <p><strong>Quantity Available:</strong> <?php echo htmlspecialchars($product['quantity']); ?></p>
    </div>
  </div>

  <form action="purchase.php" method="POST" class="mt-4">
    <input type="hidden" name="product_id" value="<?php echo $product['id']; ?>">
    
    <div class="form-group">
      <label for="quantity">Quantity to Purchase</label>
      <input type="number" name="quantity" id="quantity" class="form-control" min="1" max="<?php echo htmlspecialchars($product['quantity']); ?>" required>
    </div>
    
    <button type="submit" class="btn btn-success">Purchase</button>
  </form>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.2/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

</body>
</html>

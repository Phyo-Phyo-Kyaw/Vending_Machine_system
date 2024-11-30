<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Products List</title>
  <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<?php
require 'DatabaseConnection.php';
require 'ProductRepository.php';

session_start();

$dbConnection = new DatabaseConnection();
$productRepository = new ProductRepository($dbConnection->getPDO());

// $products = $productRepository->getAll('products');

$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$sortBy = isset($_GET['sort_by']) ? $_GET['sort_by'] : 'name';
$sortOrder = isset($_GET['sort_order']) ? $_GET['sort_order'] : 'ASC';

$result = $productRepository->listProducts($page, $sortBy, $sortOrder);
$products = $result['products'];
$totalPages = $result['totalPages'];
$currentPage = $result['currentPage'];
?>

<div class="container mt-4">
    <h2>Products List</h2>
      <div class="mb-3">
            <a href="createProduct.php" class="btn btn-primary">Add New Product</a>
      </div>

    <!-- Sort Links -->
    <div class="mb-3">
        <a href="?page=<?php echo $currentPage; ?>&sort_by=name&sort_order=<?php echo $sortOrder == 'ASC' ? 'DESC' : 'ASC'; ?>">Sort by Name</a> | 
        <a href="?page=<?php echo $currentPage; ?>&sort_by=price&sort_order=<?php echo $sortOrder == 'ASC' ? 'DESC' : 'ASC'; ?>">Sort by Price</a> | 
        <a href="?page=<?php echo $currentPage; ?>&sort_by=quantity&sort_order=<?php echo $sortOrder == 'ASC' ? 'DESC' : 'ASC'; ?>">Sort by Quantity</a>
    </div>

=    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Name</th>
                <th>Price</th>
                <th>Quantity</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($products as $product): ?>
            <tr>
                <td><?php echo htmlspecialchars($product['name']); ?></td>
                <td><?php echo htmlspecialchars($product['price']); ?></td>
                <td><?php echo htmlspecialchars($product['quantity']); ?></td>
                <td>
                    <a href="editProduct.php?id=<?php echo $product['id']; ?>" class="btn btn-warning btn-sm">Edit</a>
                    <a href="deleteProduct.php?id=<?php echo $product['id']; ?>" class="btn btn-danger btn-sm">Delete</a>
                    <a href="purchase.php?id=<?php echo $product['id']; ?>" class="btn btn-info btn-sm">Purchase</a>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <!-- Pagination -->
    <nav aria-label="Page navigation">
        <ul class="pagination">
            <?php if ($currentPage > 1): ?>
            <li class="page-item">
                <a class="page-link" href="?page=1&sort_by=<?php echo $sortBy; ?>&sort_order=<?php echo $sortOrder; ?>">First</a>
            </li>
            <li class="page-item">
                <a class="page-link" href="?page=<?php echo $currentPage - 1; ?>&sort_by=<?php echo $sortBy; ?>&sort_order=<?php echo $sortOrder; ?>">Previous</a>
            </li>
            <?php endif; ?>

            <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                <li class="page-item <?php echo $i == $currentPage ? 'active' : ''; ?>">
                    <a class="page-link" href="?page=<?php echo $i; ?>&sort_by=<?php echo $sortBy; ?>&sort_order=<?php echo $sortOrder; ?>"><?php echo $i; ?></a>
                </li>
            <?php endfor; ?>

            <?php if ($currentPage < $totalPages): ?>
            <li class="page-item">
                <a class="page-link" href="?page=<?php echo $currentPage + 1; ?>&sort_by=<?php echo $sortBy; ?>&sort_order=<?php echo $sortOrder; ?>">Next</a>
            </li>
            <li class="page-item">
                <a class="page-link" href="?page=<?php echo $totalPages; ?>&sort_by=<?php echo $sortBy; ?>&sort_order=<?php echo $sortOrder; ?>">Last</a>
            </li>
            <?php endif; ?>
        </ul>
    </nav>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.2/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

</body>
</html>
<script>
    function confirmDelete() {
        return confirm('Are you sure you want to delete this product?');
    }
</script>
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.2/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>

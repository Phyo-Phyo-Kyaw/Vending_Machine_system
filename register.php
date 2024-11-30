<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Register</title>
  <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<?php
require 'DatabaseConnection.php';
require 'UsersRepository.php';

session_start();

// Initialize Database and User Repository
$dbConnection = new DatabaseConnection();
$usersRepo = new UsersRepository($dbConnection->getPDO());

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name']?? 'User';
    $password = $_POST['password'];
    $email = $_POST['email'];
    $role = 'user'; 
    // Hash the password
    $passwordHash = password_hash($password, PASSWORD_BCRYPT);

    // Save the user
    $usersRepo->create('users', [
        'name' => $name,
        'email' => $email,
        'password' => $passwordHash,
        'role' => $role
    ]);

    echo "User registered successfully!";
}
?>
<div class="container mt-5">
  <h2>Register</h2>
  <form method="POST">
    <div class="form-group">
      <label for="name">Name</label>
      <input type="text" class="form-control" id="name" name="name" placeholder="Enter name" required>
    </div>
    <div class="form-group">
      <label for="email">Email address</label>
      <input type="email" class="form-control" id="email" name="email" placeholder="Enter email" required>
    </div>
    <div class="form-group">
      <label for="password">Password</label>
      <input type="password" class="form-control" id="password" name="password" placeholder="Enter password" required>
    </div>
    <button type="submit" class="btn btn-primary btn-block">Register</button>
  </form>
</div>


  <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.2/dist/umd/popper.min.js"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>

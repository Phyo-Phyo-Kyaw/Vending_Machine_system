<?php
session_start();
echo "hi";
// Check if the user is logged in
if (!isset($_SESSION['id'])) {
    header("Location: login.php"); 
    exit;
}

// Check the user's role
if ($_SESSION['role'] !== 'admin') {
    echo "Access Denied: You don't have permission to view this page.";
    exit;
}

echo "Welcome Admin!";
?>

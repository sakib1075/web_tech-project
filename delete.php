<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

include 'connect.php';

if (isset($_GET['id'])) {
    $delete_id = $_GET['id'];
    $delete_query = mysqli_query($conn, "DELETE FROM products WHERE id = $delete_id") or die("Query failed");

    if ($delete_query) {
        session_start();
        $_SESSION['delete_success'] = "Product deleted successfully";
    } else {
        $_SESSION['delete_error'] = "Error deleting product";
    }

    header('Location: view_product.php');
    exit(); 
} else {
    echo "Invalid request. Please provide a product ID to delete.";
}
?>


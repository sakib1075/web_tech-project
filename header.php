<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

include 'connect.php'; 
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>shopping Cart</title>
    <link rel ="stylesheet" href= "css/headerStyle.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA==" crossorigin="anonymous" referrerpolicy="no-referrer" />

</head>
<body>

    <header class = "header">
        <div class ="header_body">
            <a href="dashboard.php" class ="logo"> Daily Wear Online Shop</a>
            <nav class ="navbar">
            <a href="profile.php">Profile </a>
            <!-- <a href="product.php"> Manage Product </a> -->
            <a href="product.php"> Add Product</a>
            <a href="view_product.php"> View Product</a>
            <a href="shopping.php"> Shopit</a>
            <a href="logOut.php">Log Out</a>
            </nav>

            <?php
            $select_product = mysqli_query($conn, "Select * from cart") or die('query failed');
            $row_count = mysqli_num_rows($select_product);
            ?>
            <a href="cart.php" class="cart"><i class="fa-solid fa-cart-shopping" style="color: #214a91;"></i><span><sup><?php echo $row_count?></sup></span></a>
            <!-- <div id= "menu-btn" class= "fas fa-bars"></div> -->
            
        </div>
    </form>
    <script src="js/headerScript.js"></script> 
</body>
</html>

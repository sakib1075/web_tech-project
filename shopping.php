<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

include 'connect.php';
if(isset($_POST['add_to_cart'])){
    $products_name = $_POST['product_name'];
    $products_price = $_POST['product_price'];
    $products_image = $_POST['product_image'];
    $product_quantity = 1; // Assuming you set a default quantity or get it from somewhere

    $select_cart = mysqli_query($conn, "SELECT * FROM cart WHERE name = '$products_name'");

    if (mysqli_num_rows($select_cart) > 0){
        $display_message="Product already added to cart";
    } else {
        $insert_products = mysqli_query($conn, "INSERT INTO cart (name, price, image, quantity) VALUES ('$products_name', '$products_price', '$products_image', '$product_quantity')");
        $display_message="Product successfully added to cart";

    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shopit</title>
    <link rel ="stylesheet" href= "css/headerStyle.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA==" crossorigin="anonymous" referrerpolicy="no-referrer" />    
</head>

<body>
<?php include 'header.php'?>

<div class= "container">
<?php
if (isset($display_message)){
    echo "<div class='display_message'>
    <span>$display_message</span>
    <i class='fas fa-times' onClick='this.parentElement.style.display= `none`';></i>
</div>";
    }

?>
    <section class="products">
        <h1 class="heading"> Lets Shop </h1>
        <div class= "product_container">
        <?php
            $select_products = mysqli_query($conn, "Select * from products");
            if (mysqli_num_rows($select_products) > 0) {
                while ($fetch_product = mysqli_fetch_assoc($select_products)) {
            ?>
            <form method ="post" action="">
                <div class= "edit_form">
                    <img src="images/<?php echo $fetch_product['image'] ?>" alt="" style="width: 100px; height: 100px;">
                    <h3><?php echo $fetch_product['name'] ?> </h3>
                    <div class="price"> Price: <?php echo $fetch_product['price'] ?> tk </div>

                    <input type="hidden" name="product_name" value="<?php echo $fetch_product['name'] ?>">
                        <input type="hidden" name="product_price" value="<?php echo $fetch_product['price'] ?>">
                        <input type="hidden" name="product_image" value="<?php echo $fetch_product['image'] ?>">
                        <input type="submit" name="add_to_cart" class="submit_btn cart_btn" value="Add to Cart">
                </div>
            </form>
            <?php
                }
            } else {
                echo "<div class='empty_text'> No Products Available</div>";
            }
            ?>
        </div>
    </section>
    </div>
</body>
</html>

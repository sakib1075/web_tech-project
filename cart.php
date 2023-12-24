<?php

include 'connect.php'; 

if (isset($_POST['update_quantity'])) {
    $product_id = $_POST['product_id'];
    $new_quantity = $_POST['new_quantity'];
    $update_query = mysqli_query($conn, "UPDATE cart SET quantity = '$new_quantity' WHERE id = '$product_id'");
    if ($update_query){
        header('location:cart.php');
    }
}

if(isset($_GET['remove'])){
    $remove_id=$_GET['remove'];
    mysqli_query($conn,"Delete from `cart` where id=$remove_id ");
    header('location:cart.php');
}

if(isset($_GET['delete_all'])){
    mysqli_query($conn, "Delete from `cart`");
    header('location:cart.php');

}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cart</title>
    <link rel="stylesheet" href="css/headerStyle.css">
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>
<body>
    <?php include 'header.php'; ?>
    <div class="container">
        <section class="shopping_cart">
            <h1 class="heading">My Cart</h1>
            <table>
                <thead>
                    <th>S1 NO</th>
                    <th>Product Name</th>
                    <th>Product Image</th>
                    <th>Product Price</th>
                    <th>Product Quantity</th>
                    <th>Total Price</th>
                    <th>Action</th>
                </thead>
                <tbody>
                    <?php
                    $grand_total = 0;
                    $select_cart = mysqli_query($conn, "SELECT * FROM cart");
                    if (mysqli_num_rows($select_cart) > 0) {
                        $serial_number = 1;
                        while ($cart_item = mysqli_fetch_assoc($select_cart)) {
                            ?>
                            <tr>
                                <td><?php echo $serial_number; ?></td>
                                <td><?php echo $cart_item['name']; ?></td>
                                <td><img src="images/<?php echo $cart_item['image']; ?>" alt="" style="width: 50px; height: 50px;"></td>
                                <td><?php echo $cart_item['price']; ?></td>
                                <td>
                                    <form method="post" action="">
                                        <input type="hidden" name="product_id" value="<?php echo $cart_item['id']; ?>">
                                        <input type="number" name="new_quantity" value="<?php echo $cart_item['quantity']; ?>" min="1">
                                        <input type="submit" name="update_quantity" class="update_quantity" value="Update">
                                    </form>
                                </td>
                                <td><?php echo $cart_item['price'] * $cart_item['quantity']; ?> tk</td>
                                <td>
                                    <a href="cart.php?remove=<?php echo $cart_item['id'] ?>"onclick="return confirm('Are you sure, you want to delete this item')">
                                        <i class="fas fa-trash"></i> Remove
                                    </a>
                                </td>
                            </tr>
                            <?php
                            $grand_total = $grand_total+($cart_item['price'] * $cart_item['quantity']);
                            $serial_number++;
                        }
                    } else {
                        echo "<tr><td colspan='7' style='color: green; font-weight: bold;'>No items in the cart</td></tr>";

                    }
                    ?>
                </tbody>
            </table>

            <?php
if ($grand_total > 0) {
    echo "<div class='table_bottom'>
        <a href='shopping.php' class='bottom_btn'>Continue shopping</a>
        <h3 class='bottom_btn'>Grand total: <span> $grand_total </span> TK</h3>
        <a href='checkout.php' class='bottom_btn'>Proceed to checkout</a>
    </div>";
    ?>
    <a href="cart.php?delete_all" class="delete_all_btn">
        <i class="fas fa-trash"></i> Delete All
    </a>
    <?php
} else {
    echo "";
}
?>
    </section>
    </div>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="cart.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA==" crossorigin="anonymous" referrerpolicy="no-referrer" />

</body>
</html>

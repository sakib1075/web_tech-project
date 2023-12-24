<?php

include 'connect.php'; 
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
        $grand_total = $grand_total + ($cart_item['price'] * $cart_item['quantity']);
        $serial_number++;
    }
} else {
    echo "<tr><td colspan='7' style='color: green; font-weight: bold;'>No items in the cart</td></tr>";
}

if ($grand_total > 0) {
    echo "<div class='table_bottom'>
        <!-- Display total and action buttons -->
    </div>";
}

?>

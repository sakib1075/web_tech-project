<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

include 'connect.php';

session_start();

if (isset($_SESSION['delete_success'])) {
    echo "<div style='color: green; font-weight: bold;'>" . $_SESSION['delete_success'] . "</div>";
    unset($_SESSION['delete_success']);
}

if (isset($_SESSION['delete_error'])) {
    echo "<div style='color: red; font-weight: bold;'>" . $_SESSION['delete_error'] . "</div>";
    unset($_SESSION['delete_error']);
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Products</title>
    <link rel="stylesheet" href="css/headerStyle.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA==" crossorigin="anonymous" referrerpolicy="no-referrer" />

</head>

<body>
    <?php include 'header.php' ?>

    <div class="container">
    <h3 class="heading">View Product<h3>
        <section class="display_product">
            <?php
            $display_product = mysqli_query($conn, "SELECT * FROM products");
            $id = 1;
            if (mysqli_num_rows($display_product) > 0) {
                echo"<table>
                <thead>
                    <th>ID</th>
                    <th>Product Image</th>
                    <th>Product Name</th>
                    <th>Product Price</th>
                    <th>Action</th>
                </thead>
                <tbody>";
                        
                while ($row = mysqli_fetch_assoc($display_product)) {
                    ?>
                    <tr>
                    <td> <?php echo $id ?> </td>
                    <td><img src="images/<?php echo $row['image'] ?>" alt="<?php echo $row['name'] ?>"></td>
                    <td> <?php echo $row['name'] ?></td>
                    <td> <?php echo $row['price'] ?> </td>
                    <td><a href="edit.php?id=<?php echo $row['id'] ?>" class='update_product_btn'><i class='fas fa-edit'></i> Edit</a> |
                        <a href="delete.php?id=<?php echo $row['id'] ?>" class="delete_product_btn" onclick = "return confirm ('Are you sure you want to delete this product');`"><i class='fas fa-trash'></i> Delete</a>
                        </td>
                    </tr>
                    <?php
                            $id++;
                        }
                    } else {
                        echo "<div class='empty_text'> No Products Available </div>";
                    }
                    ?>
                </tbody>
            </table>
        </section>
    </div>
</body>

</html>

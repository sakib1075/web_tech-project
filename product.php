<?php

include('connect.php');

$display_message = '';

if (isset($_POST['add_product'])) {
    $product_name = $_POST['product_name'];
    $product_price = $_POST['product_price'];

    if (empty($product_name)) {
        $display_message = "Product name is required";
    } elseif (strlen($product_name) > 255) {
        $display_message = "Product name is too long";
    } else {
        if (!is_numeric($product_price) || $product_price < 0) {
            $display_message = "Invalid product price";
        } else {
            if (isset($_FILES['product_image']) && $_FILES['product_image']['error'] == 0) {
                $product_image = $_FILES['product_image']['name'];
                $product_image_temp_name = $_FILES['product_image']['tmp_name'];
                $product_image_folder = 'images/' . $product_image;

                $insert_query = mysqli_prepare($conn, "INSERT INTO products (name, price, image) VALUES (?, ?, ?)") or die("Insert query failed");
                mysqli_stmt_bind_param($insert_query, "sss", $product_name, $product_price, $product_image);
                $result = mysqli_stmt_execute($insert_query);

                if ($result) {
                    move_uploaded_file($product_image_temp_name, $product_image_folder);
                    $display_message = "Product inserted successfully";
                } else {
                    $display_message = "There is some error found";
                }
            } else {
                $display_message = "Product image is required";
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product</title>
    <link rel ="stylesheet" href= "css/headerStyle.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA==" crossorigin="anonymous" referrerpolicy="no-referrer" />

</head>

<body>

<?php include 'header.php' ?>

    <div class="container">
        <?php
        if (isset($display_message)) {
            echo "<div class='display_message'>
            <span>$display_message</span>
            <i class='fas fa-times' onclick='this.parentElement.style.display=`none`';></i>
        </div>";
        }
        ?>

        <section>
            <h3 class="heading">Add Product</h3>
            <form action="" class="add_product" method="post" enctype="multipart/form-data" onsubmit="return validateForm()">
                <input type="text" name="product_name" id="product_name" placeholder="Enter product name" class="input_fields">
                <span id="product_name_error" class="error"></span>

                <input type="number" name="product_price" min="0" id="product_price" placeholder="Enter product price" class="input_fields">
                <span id="product_price_error" class="error"></span>

                <input type="file" name="product_image" id="product_image" class="input_fields" accept="image/jpg, image/png, image/jpeg">
                <span id="product_image_error" class="error"></span>

                <input type="submit" name="add_product" class="submit_btn" value="Add Product">
            </form>
        </section>
    </div>

    <script>
        function validateForm() {
            var productName = document.getElementById("product_name").value;
            var productPrice = document.getElementById("product_price").value;
            var productImage = document.getElementById("product_image").value;

            document.getElementById("product_name_error").innerHTML = "";
            document.getElementById("product_price_error").innerHTML = "";
            document.getElementById("product_image_error").innerHTML = "";

            if (productName === "") {
                document.getElementById("product_name_error").innerHTML = "Product name is required";
                return false;
            }

            if (productName.length > 255) {
                document.getElementById("product_name_error").innerHTML = "Product name is too long";
                return false;
            }

            if (isNaN(productPrice) || productPrice < 0) {
                document.getElementById("product_price_error").innerHTML = "Invalid product price";
                return false;
            }

            if (productImage === "") {
                document.getElementById("product_image_error").innerHTML = "Product image is required";
                return false;
            }

            return true;
        }
    </script>

</body>
</html>
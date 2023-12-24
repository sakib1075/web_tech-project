<?php

include 'connect.php';

session_start();

if (isset($_SESSION['edit_success'])) {
    echo "<div style='color: green; font-weight: bold;'>" . $_SESSION['edit_success'] . "</div>";

    unset($_SESSION['edit_success']);
}

if (isset($_SESSION['edit_error'])) {
    echo "<div style='color: red; font-weight: bold;'>" . $_SESSION['edit_error'] . "</div>";

    unset($_SESSION['edit_error']);
}

if (isset($_POST['update_product'])) {
    $update_id = isset($_POST['update_id']) ? $_POST['update_id'] : '';
    $update_name = isset($_POST['update_name']) ? $_POST['update_name'] : '';
    $update_price = isset($_POST['update_price']) ? $_POST['update_price'] : '';

    $errors = [];

    if (empty($update_name)) {
        $errors[] = "Product name is required.";
    }

    if (!is_numeric($update_price) || $update_price < 0) {
        $errors[] = "Price must be a non-negative numeric value.";
    }

    if (empty($errors)) {
        $update_image = $_FILES['update_image']['name'];
        $update_image_tmp_name = $_FILES['update_image']['tmp_name'];
        $update_image_folder = 'images/' . $update_image;

        $update_product = mysqli_query($conn, "UPDATE products SET name ='$update_name', price='$update_price', image='$update_image' WHERE id=$update_id");

        if ($update_product) {
            move_uploaded_file($update_image_tmp_name, $update_image_folder);
            echo "Product updated successfully";
        } else {
            echo 'Error: ' . mysqli_error($conn);
        }
    } else {
        foreach ($errors as $error) {
            echo "<div style='color: red; font-weight: bold;'>$error</div>";
        }
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Product</title>
    <link rel="stylesheet" href="<YOUR_CSS_FILE_PATH>">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>

<body>
<?php include 'header.php' ?>
    <div class="container">
        <section class="edit_container">
            <h1 class="heading">Edit Product</h1>

            <?php
            if (isset($_GET['id'])) {
                $edit_id = $_GET['id'];

                $query = "SELECT * FROM products WHERE id = $edit_id";
                $result = mysqli_query($conn, $query);

                if ($result && mysqli_num_rows($result) > 0) {
                    $fetch_data = mysqli_fetch_assoc($result);
            ?>
                    <form action="edit.php?id=<?php echo $fetch_data['id']; ?>" method="post" enctype="multipart/form-data" class="update_product product_container" onsubmit="return validateForm()">
                        <img src="images/<?php echo $fetch_data['image'] ?>" alt="">
                        <input type="hidden" name="update_id" value="<?php echo $fetch_data['id']; ?>">
                        <input type="text" name="update_name" id="update_name" class="input_fields fields" value="<?php echo $fetch_data['name']; ?>">
                        <span id="update_name_error" class="error"></span>

                        <input type="number" name="update_price" id="update_price" class="input_fields fields" value="<?php echo $fetch_data['price']; ?>" min="0">
                        <span id="update_price_error" class="error"></span>

                        <input type="file" name="update_image" id="update_image" class="input_fields fields" accept="image/png, image/jpg, image/jpeg">
                        <span id="update_image_error" class="error"></span>

                        <div class="btns">
                            <input type="submit" class="edit_btn" name="update_product" value="Update">
                            <button type="button" id="cancel-edit" class="cancel_btn">Cancel</button>
                        </div>
                    </form>
            <?php
                }
            }
            ?>
        </section>
    </div>

    <script>
    function validateForm() {
        var updateName = document.getElementById("update_name").value;
        var updatePrice = document.getElementById("update_price").value;
        var updateImage = document.getElementById("update_image").value;

        document.getElementById("update_name_error").innerHTML = "";
        document.getElementById("update_price_error").innerHTML = "";
        document.getElementById("update_image_error").innerHTML = "";

        if (updateName === "") {
            document.getElementById("update_name_error").innerHTML = "Product name is required";
            return false;
        }

        // Check if updatePrice is not empty and is a valid number
        if (updatePrice === "" || isNaN(updatePrice) || updatePrice < 0) {
            document.getElementById("update_price_error").innerHTML = "Price must be a non-negative numeric value";
            return false;
        }

        if (updateImage === "") {
            document.getElementById("update_image_error").innerHTML = "Product image is required";
            return false;
        }

        return true;
    }

    document.getElementById("cancel-edit").addEventListener("click", function() {
            window.history.back();        
    });
</script>

</body>

</html>

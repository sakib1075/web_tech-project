<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

include 'Database.php';
session_start();

if (!isset($_SESSION["user"])) {
    header("Location: login.php");
    exit();
}

$userID = $_SESSION["user"]["id"];

$sql = "SELECT * FROM users WHERE id = $userID";
$result = mysqli_query($conn, $sql);
$user = mysqli_fetch_assoc($result);

if (!$user) {
    echo "<div class='alert alert-danger'>User not found</div>";
    exit();
}

$fullName = $user["full_name"];
$email = $user["email"];
$phoneNumber = $user["phoneNumber"];

if (isset($_POST["UpdateProfile"])) {
    $newFullName = isset($_POST["name"]) ? $_POST["name"] : '';
    $newEmail = isset($_POST["email"]) ? $_POST["email"] : '';
    $newPhoneNumber = isset($_POST["number"]) ? $_POST["number"] : '';

    if (!empty($newFullName)) {
        $stmt = mysqli_prepare($conn, "UPDATE users SET full_name=?, email=?, phoneNumber=? WHERE id=?");
        mysqli_stmt_bind_param($stmt, "sssi", $newFullName, $newEmail, $newPhoneNumber, $userID);

        if (mysqli_stmt_execute($stmt)) {
            $_SESSION["user"]["full_name"] = $newFullName;
            $_SESSION["user"]["email"] = $newEmail;
            $_SESSION["user"]["phoneNumber"] = $newPhoneNumber;
            echo "<div style='text-align: center; font-size: large; font-weight: bold; color: green;' class='alert alert-success'>Profile updated successfully</div>";
        } else {
            echo "<div class='alert alert-danger'>Error updating profile: " . mysqli_error($conn) . "</div>";
        }

        mysqli_stmt_close($stmt);
    } else {
        echo "<div class='alert alert-danger'>Please provide a name</div>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Profile</title>
    <style>
        .alert {
            color: red;
            margin-top: 10px;
        }
    </style>
    <script>
        function validateForm() {
            var name = document.forms["updateForm"]["name"].value;
            var email = document.forms["updateForm"]["email"].value;
            var number = document.forms["updateForm"]["number"].value;

            if (name === "") {
                alert("Name must be filled out");
                return false;
            }
            return true;
        }
    </script>
</head>
<body>
    <?php include 'header.php'; ?>
    <div class="container">
        <section class="edit_container">
            <h3 class="heading">Update Profile</h3>
            <form action="" class="update_product product_container" method="post" enctype="multipart/form-data">
                <div class="update-profile-fields update-fields">
                    <input type="text" name="name" class="input_fields fields" value="<?php echo $fullName; ?>" placeholder="Update Name">
                    <input type="email" name="email" class="input_fields fields" value="<?php echo $email; ?>" placeholder="Update Email">
                    <input type="number" name="number" value="<?php echo $phoneNumber; ?>" class="input_fields fields" placeholder="Update Phone Number">
                </div>
                <div class="btns">
                    <input type="submit" class="edit_btn" name="UpdateProfile" value="Update Profile">
                    <input type="submit" id="close-edit" value="Cancel" class="cancel_btn">
                </div>
            </form>
        </section>
    </div>
</body>
</html>

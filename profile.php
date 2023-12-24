<!-- <?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

include 'Database.php';
session_start();

if (!isset($_SESSION["user"])) {
    header("Location: login.php");
    exit();
}

$userID = $_SESSION["user"]["id"];

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
        } else {
            echo "<div class='alert alert-danger'>Error updating profile</div>";
        }

        mysqli_stmt_close($stmt);
    } else {
        echo "<div class='alert alert-danger'>Please provide a name</div>";
    }
}

if (isset($_POST["UpdatePassword"])) {
    $oldPassword = isset($_POST["old_password"]) ? $_POST["old_password"] : '';
    $newPassword = isset($_POST["new_password"]) ? $_POST["new_password"] : '';
    $confirmPassword = isset($_POST["confirm_password"]) ? $_POST["confirm_password"] : '';

    if (!empty($newPassword)) {
        if ($newPassword === $confirmPassword) {
            $stmt = mysqli_prepare($conn, "UPDATE users SET password=? WHERE id=?");
            $passwordHash = password_hash($newPassword, PASSWORD_DEFAULT);
            mysqli_stmt_bind_param($stmt, "si", $passwordHash, $userID);

            if (!mysqli_stmt_execute($stmt)) {
                echo "<div class='alert alert-danger'>Error updating password</div>";
            }

            mysqli_stmt_close($stmt);
        } else {
            echo "<div class='alert alert-danger'>New password and confirm password do not match</div>";
        }
    } else {
        echo "<div class='alert alert-danger'>Please provide a new password</div>";
    }
}

$sql = "SELECT * FROM users WHERE id = $userID";
$result = mysqli_query($conn, $sql);
$user = mysqli_fetch_assoc($result);

$fullName = $user["full_name"];
$email = $user["email"];
$phoneNumber = $user["phoneNumber"];
?> -->

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile</title>
    <link rel="stylesheet" href="css/headerStyle.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA==" crossorigin="anonymous" referrerpolicy="no-referrer" />

</head>
<body>
    <?php include 'header.php'; ?>

    <div class="container">
        <section class="edit_container">
            <h3 class="heading">Profile</h3>
            <form action="" class="update_product product_container" method="post" enctype="multipart/form-data">
                <div class="profile-fields update-fields">
                    <p>Name: <?php echo $fullName; ?></p>
                    <p>Email: <?php echo $email; ?></p>
                    <p>Phone Number: <?php echo $phoneNumber; ?></p>
                </div>

                <!-- <div class="update-profile-fields update-fields">
                    <input type="text" name="name" class="input_fields fields" value="<?php echo $fullName; ?>" placeholder="Update Name" required>
                    <input type="email" name="email" class="input_fields fields" value="<?php echo $email; ?>" placeholder="Update Email">
                    <input type="number" name="number" value="<?php echo $phoneNumber; ?>" class="input_fields fields" placeholder="Update Phone Number">
                </div>

                <div class="update-password-fields update-fields">
                    <input type="password" name="old_password" class="input_fields fields" placeholder="Old Password">
                    <input type="password" name="new_password" class="input_fields fields" placeholder="New Password">
                    <input type="password" name="confirm_password" class="input_fields fields" placeholder="Confirm Password">
                </div> -->

                <div class="btns">
                    <a href="update_profile.php" class="edit_btn">Update Profile</a>
                    <a href="update_password_html.php" class="edit_btn">Update Password</a>

                </div>
            </form>
        </section>
    </div>

    <!-- <script>
        function toggleFields(fieldClass) {
            var allFields = document.querySelectorAll('.update-fields');
            allFields.forEach(function (field) {
                field.style.display = 'none';
            });

            var selectedFields = document.querySelector('.' + fieldClass);
            if (selectedFields) {
                selectedFields.style.display = 'block';
            }
        }
    </script> -->
</body>
</html>

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

$displayMode = "basic"; 

if (isset($_POST["Update"])) {
    $newFullName = $_POST["name"];
    $newEmail = $_POST["email"];
    $oldPassword = $_POST["old_password"];
    $newPassword = $_POST["new_password"];
    $confirmPassword = $_POST["confirm_password"];
    $newPhoneNumber = $_POST["number"];

    if (isset($_FILES['profile_image']) && $_FILES['profile_image']['error'] == 0) {
        $profile_image = $_FILES['profile_image']['name'];
        $profile_image_temp_name = $_FILES['profile_image']['tmp_name'];
        $profile_image_folder = 'profile_images/' . $profile_image;

        move_uploaded_file($profile_image_temp_name, $profile_image_folder);

        $stmt = mysqli_prepare($conn, "UPDATE users SET profile_image=? WHERE id=?");
        mysqli_stmt_bind_param($stmt, "si", $profile_image_folder, $userID);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);

        $_SESSION["user"]["profile_image"] = $profile_image_folder;
    }

    if (!empty($newPassword)) {
        if ($newPassword === $confirmPassword) {
            $stmt = mysqli_prepare($conn, "UPDATE users SET full_name=?, email=?, password=?, phoneNumber=? WHERE id=?");
            $passwordHash = password_hash($newPassword, PASSWORD_DEFAULT);
            mysqli_stmt_bind_param($stmt, "ssssi", $newFullName, $newEmail, $passwordHash, $newPhoneNumber, $userID);
            mysqli_stmt_execute($stmt);
            mysqli_stmt_close($stmt);

            $_SESSION["user"]["full_name"] = $newFullName;
            $_SESSION["user"]["email"] = $newEmail;
            $_SESSION["user"]["phoneNumber"] = $newPhoneNumber;
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
$profile_image = $user["profile_image"]
?>

<!DOCTYPE html>
<html lang="en">

<head>
<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile</title>
    <link rel="stylesheet" href="css/headerStyle.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <style>
        .profile-image {
            max-width: 200px;
            max-height: 200px;
        }

        .profile-info {
            margin-top: 20px;
        }

        .profile-info p {
            margin-bottom: 10px;
        }
    </style>
</head>

<body>
    <div class="container">
        <section class="edit_container">
            <h3 class="heading">View Profile</h3>

            <input type="file" name="profile_image" id="profile_image" class="input_fields" accept="image/jpg, image/png, image/jpeg">
                <span id="profile_image_error" class="error"></span>

                <input type="text" name="name" class="input_fields fields" value="<?php echo $fullName; ?>" placeholder="Update Name">
                <input type="email" name="email" class="input_fields fields" value="<?php echo $email; ?>" placeholder="Update Email">
                <input type="password" name="old_password" class="input_fields fields" placeholder="Old Password"><br><br>
                <input type="password" name="new_password" class="input_fields fields" placeholder="New Password"><br><br>
                <input type="password" name="confirm_password" class="input_fields fields" placeholder="Confirm Password"><br><br>
                <input type="number" name="number" value="<?php echo $phoneNumber; ?>" class="input_fields fields" placeholder="Update Phone Number">

                <div class="btns">
                    <input type="submit" class="edit_btn" name="Update" value="Update">
                    <?php
                    // Display "View Profile" button only if in basic display mode
                    if ($displayMode === "basic") {
                        echo "<input type='submit' class='view_btn' name='ViewProfile' value='View Profile'>";
                    }
                    ?>
                    <input type="submit" id="close-edit" value="Cancel" class="cancel_btn">
        </section>
    </div>
</body>

</html>

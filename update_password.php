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

if (isset($_POST["UpdatePassword"])) {
    $oldPassword = isset($_POST["old_password"]) ? $_POST["old_password"] : '';
    $newPassword = isset($_POST["new_password"]) ? $_POST["new_password"] : '';
    $confirmPassword = isset($_POST["confirm_password"]) ? $_POST["confirm_password"] : '';

    if (!empty($newPassword)) {
        if ($newPassword === $confirmPassword) {
            $stmt = mysqli_prepare($conn, "UPDATE users SET password=? WHERE id=?");
            $passwordHash = password_hash($newPassword, PASSWORD_DEFAULT);
            mysqli_stmt_bind_param($stmt, "si", $passwordHash, $userID);

            if (mysqli_stmt_execute($stmt)) {
                echo "<div style='text-align: center; font-size: large; font-weight: bold; color: green;' class='alert alert-success'>Password updated successfully</div>";
            } else {
                echo "<div class='alert alert-danger'>Error updating password: " . mysqli_error($conn) . "</div>";
            }

            mysqli_stmt_close($stmt);
        } else {
            echo "<div class='alert alert-danger'>New password and confirm password do not match</div>";
        }
    } else {
        echo "<div class='alert alert-danger'>Please provide a new password</div>";
    }
}
?>

<?php
// get_profile.php

include 'Database.php';
session_start();

if (!isset($_SESSION["user"])) {
    header("Location: login.php");
    exit();
}

if (isset($_GET["userID"])) {
    $userID = $_GET["userID"];

    $sql = "SELECT * FROM users WHERE id = $userID";
    $result = mysqli_query($conn, $sql);
    $user = mysqli_fetch_assoc($result);

    $fullName = $user["full_name"];
    $email = $user["email"];
    $phoneNumber = $user["phoneNumber"];

    // Generate HTML content
    $htmlContent = "
        <p>Name: $fullName</p>
        <p>Email: $email</p>
        <p>Phone Number: $phoneNumber</p>
        <!-- Add any other details you want to display -->
    ";

    // Return the updated content as HTML
    echo $htmlContent;
}
?>

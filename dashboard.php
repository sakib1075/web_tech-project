<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

include 'Database.php';
session_start();

if (!isset($_SESSION["user"])) {
    header("Location: login.php");
}

if (isset($_POST["login"])) {
    $email = $_POST["email"];
    $password = $_POST["password"];
    require_once "Database.php";

    $sql = "SELECT * FROM users WHERE email = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "s", $email);
    mysqli_stmt_execute($stmt);

    $result = mysqli_stmt_get_result($stmt);
    $user = mysqli_fetch_assoc($result);

    if ($user) {
        if (password_verify($password, $user["password"])) {
            session_start(); 
            $_SESSION["user"] = $user;
            header("Location: dashboard.php");
            exit(); 
        } else {
            echo "<div class='alert alert-danger'>Password does not match</div>";
        }
    } else {
        echo "<div class='alert alert-danger'>Email does not match</div>";
    }
}

$fullName = $_SESSION["user"]["full_name"];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DashBoard</title>
    <style>
        body {
            background-image: url('/mysite/Project2/images/Best-Mens-Clothing-Stores-in-Sydney.jpg'); /* Add the path to your background image */
            background-size: cover;
            background-repeat: no-repeat;
            background-attachment: fixed;
            color: #aefeff; 
        }

        .contain {
            padding: 20px;
        } 

         .dashboard-content {
            background-color: #4fbdba;
            padding: 20px;
            border-radius: 10px;
            text-align: center;
        } 

        .button {
            background-color: #aefeff; 
            color: #072227; 
            padding: 10px 20px;
            text-decoration: none;
            border-radius: 5px;
            display: inline-block;
            margin-top: 10px;
            font-weight: bold;
        }
    </style>
    <link rel="stylesheet" href="css/headerStyle.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    
</head>
<body>
    <?php include 'header.php' ?>
    <div class="contain">
        <section class="dashboard-content">
            <h1 class="heading">Welcome, <?php echo $fullName; ?></h1>
            <a href="shopping.php" class="button">Go to Shopping</a>
            <a href="shopping.php" class="button">Men's Product</a>
            <a href="shopping.php" class="button">Women's Product</a>
            <a href="shopping.php" class="button">Child's Product</a>
            <a href="add_outlate.php" class="button">Add Outlet</a>
            <a href="#" class="button" onclick="showOutlate()">View Outlet</a>
        </section>
    </div>
    <br>
    <div id="txtHint" style="font-size: 20px;">Outlet info will be listed here...</div>
    <script>
        function showOutlate() {
            const xhttp = new XMLHttpRequest();
            xhttp.onload = function() {
                document.getElementById("txtHint").innerHTML = this.responseText;
            }
            xhttp.open("GET", "getOutlate.php");
            xhttp.send();
        }
    </script>
</body>
</html>
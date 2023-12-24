<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();
if (isset($_SESSION["user"])) {
    header("Location: dashboard.php");
    exit();
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
            if (isset($_POST['remember'])) {
                setcookie('emailid', $_POST['email'], time() + 10, "/");
                setcookie('password', $_POST['password'], time() + 10, "/");
            } else {
                setcookie('emailid', $_POST['email'], time() - 10, "/");
                setcookie('password', $_POST['password'], time() - 10, "/");
            }
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
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Log In</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<header>
    <h2 class="logo">Daily Wear</h2>
    <nav class="navigation">
        <a href="">About</a>
        <a href="">Services</a>
        <a href="">Contact</a>
        <button class="btnLogin-popup"> Login  </button>
    </nav>
</header>
    
<div class="wrapper">
    <span class="icon-close"><ion-icon name="close"></ion-icon></span>
    <div class="form-box login">
        <h2>Login</h2>

        <form action="login.php" method="post" onsubmit="return validateLogin()">
            <div class="input-box">
                <span class="icon"><ion-icon name="mail"></ion-icon></span>
                <input type="email" name="email" id="email" value="<?php if (isset($_COOKIE['emailid'])) echo $_COOKIE['emailid']; ?>">
                <label>Email</label>
                <span id="emailError" class="error"></span>
            </div>
            <div class="input-box">
                <span class="icon"><ion-icon name="lock-closed"></ion-icon></span>
                <input type="password" name="password" id="password" value="<?php if (isset($_COOKIE['password'])) echo $_COOKIE['password']; ?>">
                <label>Password</label>
                <span id="passwordError" class="error"></span>
            </div>
            <div class="remember-forgot">
                <label><input type="checkbox" name="remember" <?php if (isset($_COOKIE['emailid'])) echo 'checked'; ?>> Remember me </label>
                <a href="#">Forgot password? </a>
            </div>

            <input type="submit" name="login" class="btn" value="Login">

            <div class="login-register">
                <p>Do not have an account? <a href="Register.php" class="register-link">Sign Up</a></p>
            </div>
        </form>
    </div>
</div>

<script src="script.js"></script>
<script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
<script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>

<script type="text/javascript">
    function validateLogin() {
        var email = document.getElementById("email").value;
        var password = document.getElementById("password").value;

        document.getElementById("emailError").innerHTML = "";
        document.getElementById("passwordError").innerHTML = "";

        if (email.trim() === "") {
            document.getElementById("emailError").innerHTML = "** Please fill the email";
            return false;
        }

        if (password.trim() === "") {
            document.getElementById("passwordError").innerHTML = "** Please fill the password";
            return false;
        }

        return true;
    }
</script>

</body>
</html>


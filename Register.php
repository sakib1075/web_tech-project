<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();
if (isset($_SESSION["user"])) {
    header("Location: dashboard.php");
}

// use PHPMailer\PHPMailer\PHPMailer;
// use PHPMailer\PHPMailer\SMTP;
// use PHPMailer\PHPMailer\Exception;

// require 'vendor/autoload.php';

// function sendmail_verify($name, $email, $token)
// {
//     $mail = new PHPMailer(true);

//     // $mail->SMTPDebug = SMTP::DEBUG_SERVER;

//     $mail->isSMTP();
//     $mail->SMTPAuth = true;

//     $mail->Host = "smtp.example.com";
//     $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
//     $mail->Port = 587;

//     $mail->Username = "sakibur2276@gmail.com";
//     $mail->Password = "password";

//     $mail->setFrom("sakibur2276@gmail.com", $name);
//     $mail->addAddress($email);

//     $mail->Subject = "Email Verification";

//     $email_template ="<a href='http://localhost/mysite/Project2/verfiy-email.php?token=$token'> Click me </a>";

//     $mail->Body = $email_template;
//     $mail->send();

//     echo "sent message successfully!";
// }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
</head>
<body>

<?php
if (isset($_POST["submit"])) {
    $full_name = $_POST["name"];
    $password = $_POST["password"];
    $confirmPassword = $_POST["confirm_password"];
    $passwordHash = password_hash($password, PASSWORD_DEFAULT);
    $email = $_POST["email"];
    $gender = $_POST["gender"];
    $Dob = $_POST["Dob"];
    $phoneNumber = $_POST["number"];
    // $token = bin2hex(random_bytes(15));

    // sendmail_verify("$name", "$email", "$token");
    // echo "sent";


    $errors = array();

    if (empty($full_name) || empty($password) || empty($confirmPassword) || empty($email) || empty($gender) || empty($Dob) || empty($phoneNumber)) {
        array_push($errors, "All fields are required");
    }
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        array_push($errors, "Email is not valid");
    }
    if (strlen($password) < 8) {
        array_push($errors, "Password must be at least 8 characters long");
    }
    if ($password !== $confirmPassword) {
        array_push($errors, "Password does not match");
    }

    require_once "Database.php";
    $sql = "SELECT * FROM users WHERE email = ?";
    $stmt = mysqli_stmt_init($conn);
    $prepareStmt = mysqli_stmt_prepare($stmt, $sql);

    if ($prepareStmt) {
        mysqli_stmt_bind_param($stmt, "s", $email);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        $rowCount = mysqli_num_rows($result);

        if ($rowCount > 0) {
            array_push($errors, "Email already exists!");
        }

        if (count($errors) > 0) {
            foreach ($errors as  $error) {
                echo "<div class='alert alert-danger'>$error</div>";
            }
        } else {
            $sql = "INSERT INTO users (full_name, password, email, gender, Dob, phoneNumber, token, status) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
            $stmt = mysqli_stmt_init($conn);
            $prepareStmt = mysqli_stmt_prepare($stmt, $sql);

            if ($prepareStmt) {
                $status = 'inactive';
                mysqli_stmt_bind_param($stmt, 'ssssssss', $full_name, $passwordHash, $email, $gender, $Dob, $phoneNumber, $token, $status);
                mysqli_stmt_execute($stmt);

                echo "<div class='alert alert-success'>You are registered successfully.
                </div>";
                // $subject = "Email Activation";
                // $body = "Hi, $full_name. Click here to activate your account http://localhost/mysite/Project2/activate.php?token=$token";
                // $sender_email = "From: sakibur2276@gmail.com";

                // if (mail($email, $subject, $body, $sender_email)) {
                //     $_SESSION['msg'] = "Check your mail to activate your account $email";
                //     header('location:login.php');
                // } else {
                //     echo "Email sending failed";
                // }
            } else {
                die("Something went wrong");
            }
        }
    } else {
        die("Something went wrong");
    }
}
?>
<header>
    <h2 class="logo">Daily Wear</h2>
    <nav class="navigation">
        <a href="">About</a>
        <a href="">Services</a>
        <a href="">Contact</a>
        <button class="btnLogin-popup"> Register  </button>
    </nav>
</header>
<div class="container">
 <!-- <div class="reg"> -->
        <span class="icon-close"><ion-icon name="close"></ion-icon></span>
        <div class="form-box register">
        <h2>Registration</h2>

  <form action="Register.php" name ="forms" method="post" onsubmit="return validation()">

        <span class="error">* Required all Fields</span>

            <div class="input-box">
                <span class="icon"><ion-icon name="mail"></ion-icon></span>
                <input type="text" name="name" id="username"  value="" >
                <label>Name </label>
                <span id="usernameError" class="error"></span>
            </div>

            <div class="input-box">
                <span class="icon"><ion-icon name="mail"></ion-icon></span>
                <input type="password" name="password" id="password" value="">
                <label>Password </label>
                <span id="passwordError" class="error"></span>
            </div>

            <div class="input-box">
                <span class="icon"><ion-icon name="mail"></ion-icon></span>
                <input type="password" name="confirm_password" id="confirm_password"  value="">
                <label>Confirm Password </label>
                <span id="confirm_passwordError" class="error"></span>
            </div>
            <div class="input-box">
                <span class="icon"><ion-icon name="mail"></ion-icon></span>
                <input type="email" name="email" id="email" placeholder="Email" value=""> 
                <label>Email</label>
                <span id="emailError" class="error"></span>
            </div>
            
            <b>Gender&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;: </b>
                <input type="radio" name="gender" value="Male">Male
                <input type="radio" name="gender" value="Female">Female
                <input type="radio" name="gender" value="Other">Other
                <span id="genderError"></span>
                <br><br>

                <b>Date of Birth&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;:</b>
                 <input type="date" name="Dob" id="Dob">
            <div class="input-box">
                <span class="icon"><ion-icon name="mail"></ion-icon></span>
                <input type="number" name="number" id="number" placeholder="Phone Number">
                <label>Phone Number </label>
                <span id="numberError" class="error"></span>
            </div>
            <input type="submit" name="submit" class="btn" value="Resigter">
            <div class="links">
                Already have an account? <a href="login.php">LOG IN</a>
            </div>
   
    
    </form>
</div>
<script type="text/javascript">
    function validation() {
        var user = document.getElementById("username").value;
        var password = document.getElementById("password").value;
        var confirmPassword = document.getElementById("confirm_password").value;
        var email = document.getElementById("email").value;
        var gender = document.getElementsByName("gender");
        var genderSelected = false;

            for (var i = 0; i < gender.length; i++) {
                if (gender[i].checked) {
                    genderSelected = true;
                    break;
            }
        }
        var phoneNumber = document.getElementById("number").value;

        document.getElementById("usernameError").innerHTML = "";
        document.getElementById("passwordError").innerHTML = "";
        document.getElementById("confirm_passwordError").innerHTML = "";
        document.getElementById("emailError").innerHTML = "";
        document.getElementById("genderError").innerHTML = "";
        document.getElementById("numberError").innerHTML = "";

        if (user == "") {
            document.getElementById("usernameError").innerHTML = "** Please fill the username";
            return false;
        }
        if((user.length < 3) || (user.length > 20)){
            document.getElementById("usernameError").innerHTML = "** Please fill the username between 3 and 20";
            return false;
        }
        if(!isNaN(user)){
            document.getElementById("usernameError").innerHTML = "** Please enter characters only";
            return false;
        }

        if (password == "") {
            document.getElementById("passwordError").innerHTML = "** Please fill the password";
            return false;
        } 
        if((password.length < 8) || (password.length > 20)){
            document.getElementById("passwordError").innerHTML = "** Please fill the password between 8 and 20";
            return false;
        }
        if(password != confirmPassword){
            document.getElementById("confirm_passwordError").innerHTML = "** Passwords do not match";
            return false;
        }

        if (confirmPassword == "") {
            document.getElementById("confirm_passwordError").innerHTML = "** Please fill the confirm password";
            return false;
        }


        if (email == "") {
            document.getElementById("emailError").innerHTML = "** Please fill the email";
            return false;
        }
        if(email.indexOf('@') <= 0){
            document.getElementById("emailError").innerHTML = "** Please fill the email in proper format using '@'";
            return false;
        }
        if(email.charAt(email.length - 4) != '.' && email.charAt(email.length - 3) != '.'){
            document.getElementById("emailError").innerHTML = "** Please fill the email in proper format using '.'";
            return false;
        }

        if (!genderSelected) {
            document.getElementById("genderError").innerHTML = "** Please select a gender";
            return false;
        }

        if (phoneNumber == "") {
            document.getElementById("numberError").innerHTML = "** Please fill the number";
            return false;
        }
        if(phoneNumber.length != 11){
            document.getElementById("numberError").innerHTML = "** Phone number should be 11 digits";
            return false;
        }
        if(isNaN(phoneNumber)){
            document.getElementById("numberError").innerHTML = "** Phone number should contain only digits";
            return false;
        }

        return true; 
    }
</script>

</body>
</html>

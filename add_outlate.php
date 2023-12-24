<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

include 'outlet.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $sql = "INSERT INTO outlate (city, address, contact) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sss", $city, $address, $contact);

    $city = $_POST['city'];
    $address = $_POST['address'];
    $contact = $_POST['contact'];

    if ($stmt->execute()) {
        echo "Outlet added successfully!";
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Outlet</title>
</head>

<body>
<?php include 'header.php' ?>

    <h2>Add Outlet</h2>
    <form action="<?php echo $_SERVER["PHP_SELF"]; ?>" method="post">
        <label for="city">City:</label>
        <input type="text" name="city" required><br>

        <label for="address">Address:</label>
        <input type="text" name="address" required><br>

        <label for="contact">Contact:</label>
        <input type="text" name="contact" required><br>

        <input type="submit" value="Add Outlet">
    </form>
</body>

</html>

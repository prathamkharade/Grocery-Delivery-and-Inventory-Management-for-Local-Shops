<?php
$host = "localhost";
$user = "root";  // default for XAMPP
$pass = "";  // default for XAMPP
$db = "mydatabase";

// Create connection
$conn = new mysqli($host, $user, $pass, $db);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$shopId = $_COOKIE["shop_id"];

$name = $_POST['name'];
$price = $_POST['price'];
$quantity = $_POST['quantity'];
$totprice = $price * $quantity;
$prod_id = $_POST['prod_id'];

if (floor($quantity) != $quantity) {
    echo json_encode(['status' => 'error', 'message' => 'Quantity cannot be in decimal!']);
    exit();
}

$sql = "INSERT INTO Cart (name, price, quantity, totprice, prod_id) VALUES ('$name', $price, $quantity, $totprice, '$prod_id')";

if ($conn->query($sql) === TRUE) {
    echo json_encode(['status' => 'success']);
} else {
    echo json_encode(['status' => 'error', 'message' => $conn->error]);
}
?>

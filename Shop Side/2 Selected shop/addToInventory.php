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

$shop_id = $_COOKIE["shop_id"];

$name = $_POST['name'];
$price = $_POST['price'];
$quantity = $_POST['quantity'];
$prod_id = $_POST['prod_id'];
$man_date = $_POST['man_date'];

if (floor($quantity) != $quantity) {
    echo json_encode(['status' => 'error', 'message' => 'Quantity cannot be in decimal!']);
    exit();
}

$sql = "INSERT INTO Inventory (shop_id, prod_id, quantity, man_date) VALUES ('$shop_id', '$prod_id', $quantity, '$man_date')";

if ($conn->query($sql) === TRUE) {
    echo json_encode(['status' => 'success']);
} else {
    echo json_encode(['status' => 'error', 'message' => $conn->error]);
}
?>

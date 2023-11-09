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

// Truncate the 'Cart' table
$sql = "TRUNCATE TABLE Cart";
$result = $conn->query($sql);

$response = [];
if ($result) {
    $response['success'] = true;
} else {
    $response['success'] = false;
    $response['error'] = $conn->error;
}

header('Content-Type: application/json');
echo json_encode($response);
?>

<?php
header('Content-Type: application/json');
$host = "localhost";
$user = "root";  // default for XAMPP
$pass = "";  // default for XAMPP
$db = "mydatabase";
$conn = new mysqli($host, $user, $pass, $db);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$response = ['success' => false];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents("php://input"), true);
    $prod_id = $data['prod_id'] ?? '';

    if ($prod_id) {
        // Using a prepared statement to prevent SQL injections
        $stmt = $conn->prepare("DELETE FROM Inventory WHERE prod_id = ?");
        $stmt->bind_param("s", $prod_id); // "s" indicates the data type is string

        if ($stmt->execute()) {
            $response['success'] = true;
        }
        $stmt->close();
    }
}

echo json_encode($response);

$conn->close();  // Close the database connection
?>

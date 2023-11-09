<?php
$host = "localhost";
$user = "root";
$pass = "";
$db = "mydatabase";
$conn = new mysqli($host, $user, $pass, $db);

$response = ['success' => false];

$data = json_decode(file_get_contents("php://input"), true);
$cust_id = $data['cust_id'];
$shop_id = $data['shop_id'];

if (!$conn->connect_error) {
    // Fetch cust_name based on cust_id
    $stmt1 = $conn->prepare("SELECT name FROM Customer WHERE cust_id = ?");
    $stmt1->bind_param("s", $cust_id);
    $stmt1->execute();
    $res1 = $stmt1->get_result();
    $customer = $res1->fetch_assoc();
    $cust_name = $customer['name'];
    $stmt1->close();
    
    // Fetch shop_name based on shop_id
    $stmt2 = $conn->prepare("SELECT name FROM Shopkeeper WHERE shop_id = ?");
    $stmt2->bind_param("s", $shop_id);
    $stmt2->execute();
    $res2 = $stmt2->get_result();
    $shopkeeper = $res2->fetch_assoc();
    $shop_name = $shopkeeper['name'];
    $stmt2->close();

    // Calculate the total price of items in the cart
    $stmt3 = $conn->prepare("SELECT SUM(totprice) as total FROM Cart");
    $stmt3->execute();
    $res3 = $stmt3->get_result();
    $total = $res3->fetch_assoc();
    $totprice = $total['total'];
    $stmt3->close();

    // Generate a unique transaction ID (you might want to modify this based on your needs)
    $transactionid = uniqid();
    setcookie("transactionid", $transactionid, time() + 3600, "/");
    // Insert into the Buy table
    $stmt4 = $conn->prepare("INSERT INTO Buy (shop_id, cust_id, totprice, transdate, transactionid, shop_name, cust_name) VALUES (?, ?, ?, NOW(), ?, ?, ?)");
    $stmt4->bind_param("ssdsss", $shop_id, $cust_id, $totprice, $transactionid, $shop_name, $cust_name);
    if ($stmt4->execute()) {
        $response['success'] = true;
    }
    $stmt4->close();

    // Fetch cart items for the shop_id
    $stmt5 = $conn->prepare("SELECT name, quantity, prod_id FROM Cart");
    $stmt5->execute();
    $cartItems = $stmt5->get_result()->fetch_all(MYSQLI_ASSOC);
    $stmt5->close();

    foreach ($cartItems as $item) {
        // Update Inventory quantity based on prod_id and shop_id
        $stmt6 = $conn->prepare("UPDATE Inventory SET quantity = quantity - ? WHERE shop_id = ? AND prod_id = ?");
        $stmt6->bind_param("iss", $item['quantity'], $shop_id, $item['prod_id']);
        $stmt6->execute();
        $stmt6->close();
        
        // Check if quantity is zero and delete that row
        $stmt7 = $conn->prepare("DELETE FROM Inventory WHERE shop_id = ? AND prod_id = ? AND quantity = 0");
        $stmt7->bind_param("ss", $shop_id, $item['prod_id']);
        $stmt7->execute();
        $stmt7->close();
    }
}

echo json_encode($response);
?>

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

$transactionDetails = [];

// Check if the transactionid cookie exists
if(isset($_COOKIE['transactionid'])) {
    $transactionid = $_COOKIE['transactionid'];
    
    $stmt = $conn->prepare("SELECT * FROM Buy WHERE transactionid = ?");
    $stmt->bind_param("s", $transactionid);
    $stmt->execute();

    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
        $transactionDetails = $result->fetch_assoc();
    }
    $stmt->close();
}
?>


<!DOCTYPE html>
<html>
    <head>
        <title>Transaction</title>
        <link rel="stylesheet" href="style.css">
    </head>
    <body>
        <div class="container">
            <img src="white background.jpg" id="img1">
            <div class="trans">
                <img src="complete.gif" alt="Complete" height="150px" width="150px">
                <br>
                <h1>Your order is placed!</h1>
                <br>
                <h5>You will be recieving a confirmation email with order details.</h5>
                <br>
                <table>
                    <tr>
                        <td>Transaction ID</td>
                        <td><?= $transactionDetails['transactionid'] ?? 'N/A' ?></td>
                    </tr>
                    <tr>
                        <td>Customer Name</td>
                        <td><?= $transactionDetails['cust_name'] ?? 'N/A' ?></td>
                    </tr>
                    <tr>
                        <td>Shop Name</td>
                        <td><?= $transactionDetails['shop_name'] ?? 'N/A' ?></td>
                    </tr>
                    <tr>
                        <td>Transaction Date</td>
                        <td><?= $transactionDetails['transdate'] ?? 'N/A' ?></td>
                    </tr>
                    <tr>
                        <td>Total Cost</td>
                        <td><?= $transactionDetails['totprice'] ?? 'N/A' ?></td>
                    </tr>
                </table>
                <br><br>
                <button type="button" id="btn" onclick="logout()">Log Out</button>
            </div>
        </div>
        <script src="script.js"></script>
    </body>
</html>


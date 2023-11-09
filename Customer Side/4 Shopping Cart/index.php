<?php
$host = "localhost";
$user = "root";  // default for XAMPP
$pass = "";  // default for XAMPP
$db = "mydatabase";
$conn = new mysqli($host, $user, $pass, $db);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$totalCost = 0;
$totalSql = "SELECT SUM(totprice) as total FROM Cart";
$totalResult = $conn->query($totalSql);
if ($totalResult->num_rows > 0) {
    $data = $totalResult->fetch_assoc();
    $totalCost = $data['total'];
}

?>

<!DOCTYPE html>
<html>
    <head>
        <link rel="stylesheet" type="text/css" href="style.css">
    </head>
    <body>
        <div class="container">
            <nav class="navbar">
                <img src="cart.png" alt="Cart" height="100px" width="100px">
                <h1>Shopping Cart</h1>
            </nav>
            <div class="table-container">
                <table>
                    <thead>
                        <tr>
                            <th>Product</th>
                            <th>Price</th>
                            <th>Quantity</th>
                            <th>Delete</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            $sql = "SELECT name, totprice, quantity FROM Cart";
                            $result = $conn->query($sql);
                            if ($result->num_rows > 0) {
                                while ($row = $result->fetch_assoc()) {
                                    echo "<tr>
                                        <td>".$row['name']."</td>
                                        <td>".$row['totprice']."</td>
                                        <td>".$row['quantity']."</td>
                                        <td><button type='button' id='btn1' onclick='delet(\"".$row['name']."\")'></button></td>
                                        </tr>";
                                }
                            }
                        ?>
                    </tbody>
                </table>
            </div>
            <div class="payment">
                <div class="left">
                    <h2>Total Cost: </h2>
                    <?php echo "<h3 id='cost'>".$totalCost."</h3>"; ?>
                </div>
                <div  class="right">
                    <button type="button" id="btn2" onclick="payment()">Make Payment</button>
                </div>
            </div>
        </div>
        <script src="script.js"></script>
    </body>
</html>

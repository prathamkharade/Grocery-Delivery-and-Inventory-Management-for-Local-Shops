<?php
$host = "localhost";
$user = "root";  // default for XAMPP
$pass = "";  // default for XAMPP
$db = "mydatabase";
$conn = new mysqli($host, $user, $pass, $db);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
$shop_id = $_COOKIE['shop_id'];
$sql = "SELECT p.name, p.price, i.quantity, i.prod_id FROM Inventory i JOIN Product p ON i.prod_id = p.prod_id WHERE i.shop_id = '$shop_id'";
$result = $conn->query($sql);
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
                <h1>Inventory</h1>
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
                            if ($result->num_rows > 0) {
                                while ($row = $result->fetch_assoc()) {
                                    echo "<tr>
                                        <td>".$row['name']."</td>
                                        <td>".$row['price']."</td>
                                        <td>".$row['quantity']."</td>
                                        <td><button type='button' id='btn1' onclick='delet(\"".$row['prod_id']."\")'></button></td>
                                        </tr>";
                                }
                            }
                        ?>
                    </tbody>
                </table>
            </div>
            <div class="payment">
                <button type="button" id="btn2" onclick="logout()">Log Out</button>
            </div>
        </div>
        <script src="script.js"></script>
    </body>
</html>

<?php
// Connecting to the database
$servername = "localhost";
$username = "root"; // default username for XAMPP
$password = "";     // default password for XAMPP
$dbname = "mydatabase";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Retrieving the address cookie
if (isset($_COOKIE["address"])) {
    $address = $_COOKIE["address"];

    $sql = "SELECT * FROM Shopkeeper WHERE address = '$address'";
    $result = $conn->query($sql);
    
    if ($result->num_rows > 0) {
        $shops = [];
        while($row = $result->fetch_assoc()) {
            $shops[] = $row;
        }
    } else {
        echo "0 results";
    }
    $conn->close();
} else {
    echo "Address not set!";
    exit;
}
?>
<!DOCTYPE html>
<html>
    <head>
        <link rel="stylesheet" type="text/css" href="style.css">
        <script src="script.js"></script>
    </head>
    <body>
        <div class="container">
            <h1>Shops Near You</h1>
            <div class="table-container">
                <table>
                    <tr>
                        <th>Shop</th>
                        <th>Email</th>
                        <th>Contact</th>
                        <th>Visit</th>
                    </tr>
                    <?php foreach ($shops as $shop): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($shop['name']); ?></td>
                        <td><?php echo htmlspecialchars($shop['email']); ?></td>
                        <td><?php echo htmlspecialchars($shop['contact']); ?></td>
                        <td>
                            <button type="button" id="btn" onclick="next('<?php echo $shop['shop_id']; ?>', '<?php echo $shop['name']; ?>')"></button>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </table>
            </div>
        </div>
    </body>
</html>


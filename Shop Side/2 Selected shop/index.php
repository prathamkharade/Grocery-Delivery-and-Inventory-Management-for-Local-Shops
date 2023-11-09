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

// Fetching products based on shop_id by joining Product and Inventory tables
$sql = "SELECT Product.prod_id, Product.name, Product.category, Product.exp_per, Product.price FROM Product";

$result = $conn->query($sql);

$products = [];

while($row = $result->fetch_assoc()) {
    $products[] = [
        "name" => $row["name"],
        "price" => $row["price"],
        "category" => $row["category"],
        "exp_per" => $row["exp_per"],
        "prod_id" => $row["prod_id"]
    ];
}
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Add Product</title>
        <link rel="stylesheet" href="style.css">
    </head>
    <body>
        <div class="container">
            <nav class="navbar">
                <div class="left">
                    <img src="user.png" alt="User" height="50px" width="50px">
                    <h1 id="shopname"></h1>
                </div>
                <div class="right">
                    <button type="button" class="btn" onclick="viewinv()">View Inventory</button>
                    <button type="button" class="btn" onclick="logout()">Log Out</button>
                </div>
            </nav>
            <div class="bottom">
                <div class="select">
                    <h3>Select Category</h3>
                    <br><br>
                    <div class="rollcat">
                        <input type="radio" id="option1" name="category" value="All" onclick="selectcat()">  All
                        <br><br>
                        <input type="radio" id="option2" name="category" value="Bakery" onclick="selectcat()">  Bakery
                        <br><br>
                        <input type="radio" id="option3" name="category" value="Beverages" onclick="selectcat()">  Beverages
                        <br><br>
                        <input type="radio" id="option4" name="category" value="Canned Goods" onclick="selectcat()">  Canned Goods
                        <br><br>
                        <input type="radio" id="option4" name="category" value="Cleaners" onclick="selectcat()">  Cleaners
                        <br><br>
                        <input type="radio" id="option4" name="category" value="Dairy" onclick="selectcat()">  Dairy
                        <br><br>
                        <input type="radio" id="option4" name="category" value="Dry Goods" onclick="selectcat()">  Dry Goods
                        <br><br>
                        <input type="radio" id="option4" name="category" value="Meat" onclick="selectcat()">  Meat
                        <br><br>
                        <input type="radio" id="option4" name="category" value="Paper Goods" onclick="selectcat()">  Paper Goods
                        <br><br>
                        <input type="radio" id="option4" name="category" value="Personal Care" onclick="selectcat()">  Personal Care
                        <br><br>
                    </div>
                </div>
                <div class="side">
                    <div class="search1">
                        <input type="text" id="searchInput" placeholder="Search for products..." onkeyup="search()">
                        <button type="button" id="searchbtn" onclick="search()"></button>
                    </div>
                    <div class="menu">
                        <div class="table-container">
                            <table id="tableid">
                                <thead>
                                    <tr>
                                        <th>Name Of Product</th>
                                        <th>Manufacturing Date</th>
                                        <th>Expiry Period</th>
                                        <th>Quantity</th>
                                        <th>Add Item</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($products as $product): ?>
                                        <tr data-category="<?php echo htmlspecialchars($product['category']); ?>">
                                            <td><?php echo htmlspecialchars($product['name']); ?></td>
                                            <td><input type="date" id="man-date-<?php echo $product['prod_id']; ?>" name="man_date"></td>
                                            <td><?php echo htmlspecialchars($product['exp_per']); ?> days</td>
                                            <td><input type="number" id="quantity-<?php echo $product['prod_id']; ?>" name="quantity"></td>
                                            <td><button type="button" id="addbtn" onclick="addToInventory('<?php echo $product['prod_id']; ?>', '<?php echo $product['name']; ?>', <?php echo $product['price']; ?>)"></button></td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <script src="script.js"></script>
    </body>
</html>
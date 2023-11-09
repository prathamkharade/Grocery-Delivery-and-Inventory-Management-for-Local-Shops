<?php
$host = 'localhost';
$db   = 'mydatabase';
$user = 'root';  
$pass = '';      
$charset = 'utf8mb4';

$dsn = "mysql:host=$host;dbname=$db;charset=$charset";
$opt = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false,
];
$pdo = new PDO($dsn, $user, $pass, $opt);

// Fetch the latest cust_id
$stmt = $pdo->query("SELECT cust_id FROM Customer ORDER BY CAST(SUBSTRING(cust_id, 6) AS UNSIGNED) DESC LIMIT 1");

$row = $stmt->fetch();
$lastID = (int) str_replace("cust_", "", $row['cust_id']); 
$newID = "cust_" . ($lastID + 1);

$name = $_POST['name'];
$email = $_POST['Email'];
$address = $_POST['Address'];
$contact = $_POST['Contact'];
$password = $_POST['Password'];

$stmt = $pdo->prepare("INSERT INTO Customer (cust_id, name, email, password, address, contact) VALUES (?, ?, ?, ?, ?, ?)");
$stmt->execute([$newID, $name, $email, $password, $address, $contact]);

header('Location: index.html?section=login'); // Redirect to the login section after successful registration
?>

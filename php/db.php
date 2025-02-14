<?php
$host = "localhost";
$user = "root";
$pass = "";
$dbname = "complaint-management";
$port= 3307;

$options = [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
];

try {
    $conn = new PDO("mysql:host=$host;port=$port;dbname=$dbname", $user, $pass, $options);
} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}
?>
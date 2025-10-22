<?php
// config.php
$host     = "localhost";
$db_name  = "hiv";      // your database name
$username = "root";     // default XAMPP user
$password = "";         // default XAMPP password

// Create connection
$conn = new mysqli($host, $username, $password, $db_name);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Optional: set charset
$conn->set_charset("utf8mb4");
?>
<?php

$host = "localhost";
$db_name = "hivecare_db";
$username = "root"; // default
$password = "";     // default

$conn = new mysqli($host, $username, $password, $db_name);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}








?>
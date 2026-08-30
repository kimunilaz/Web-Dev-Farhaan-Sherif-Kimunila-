<?php
$host = "localhost";
$user = "root";
$pass = "";
$database = "xmen_roster";

$conn = new mysqli($host, $user, $pass, $database);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Use UTF-8 so names and other text are stored correctly.
$conn->set_charset("utf8mb4");

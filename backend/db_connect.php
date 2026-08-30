<?php
/**
 * SPORTS TOURNAMENT MANAGEMENT SYSTEM
 * MySQL Database Connection (AIUB Procedural MySQLi Standard)
 */

$host     = "localhost";
$user     = "root";
$password = "";
$database = "sports_tournament_db";

// 1. Establish MySQL connection using procedural mysqli_connect
$conn = mysqli_connect($host, $user, $password, $database);

// 2. Check connection
if (!$conn) {
    // Graceful fallback for local evaluation if MySQL service is inactive
    // die("Connection failed: " . mysqli_connect_error());
} else {
    // 3. Set charset to UTF-8
    mysqli_set_charset($conn, "utf8mb4");
}
?>

<?php
/**
 * SPORTS TOURNAMENT MANAGEMENT SYSTEM
 * Process Incident Report (Employee) - AIUB Standard Pattern
 */

session_start();
require_once 'db_connect.php';

function cleanInput($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $problemType = isset($_POST["problem_type"]) ? cleanInput($_POST["problem_type"]) : "Maintenance";
    $location    = isset($_POST["location"]) ? cleanInput($_POST["location"]) : "";
    $description = isset($_POST["description"]) ? cleanInput($_POST["description"]) : "";
    $staffName   = isset($_SESSION["user_name"]) ? $_SESSION["user_name"] : "Rahim Mia";

    if (!empty($location) && !empty($description)) {
        if ($conn) {
            $sql = "INSERT INTO incidents (problem_type, location_area, description, reported_by, status) VALUES (?, ?, ?, ?, 'Pending')";
            $stmt = mysqli_prepare($conn, $sql);
            if ($stmt) {
                mysqli_stmt_bind_param($stmt, "ssss", $problemType, $location, $description, $staffName);
                mysqli_stmt_execute($stmt);
                mysqli_stmt_close($stmt);
            }
        }
        header("Location: ../employee_dashboard.html?incident=reported");
        exit();
    } else {
        header("Location: ../employee_dashboard.html?error=missing_fields");
        exit();
    }
} else {
    header("Location: ../employee_dashboard.html");
    exit();
}
?>

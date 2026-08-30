<?php
/**
 * SPORTS TOURNAMENT MANAGEMENT SYSTEM
 * Process Team Registration (Coach) - AIUB Standard Pattern
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
    $teamName   = isset($_POST["team_name"]) ? cleanInput($_POST["team_name"]) : "";
    $coachEmail = isset($_POST["coach_email"]) ? cleanInput($_POST["coach_email"]) : "";
    $squadSize  = isset($_POST["squad_size"]) ? intval($_POST["squad_size"]) : 15;

    if (!empty($teamName) && filter_var($coachEmail, FILTER_VALIDATE_EMAIL)) {
        if ($conn) {
            $tournamentId = 1;
            $feeStatus = "Paid";
            $feeAmount = 50000.00;

            $sql = "INSERT INTO teams (tournament_id, team_name, coach_email, squad_size, fee_status, fee_amount) VALUES (?, ?, ?, ?, ?, ?)";
            $stmt = mysqli_prepare($conn, $sql);
            if ($stmt) {
                mysqli_stmt_bind_param($stmt, "issisd", $tournamentId, $teamName, $coachEmail, $squadSize, $feeStatus, $feeAmount);
                mysqli_stmt_execute($stmt);
                mysqli_stmt_close($stmt);
            }
        }
        header("Location: ../coach_dashboard.html?registered=success");
        exit();
    } else {
        header("Location: ../coach_dashboard.html?error=invalid_data");
        exit();
    }
} else {
    header("Location: ../coach_dashboard.html");
    exit();
}
?>

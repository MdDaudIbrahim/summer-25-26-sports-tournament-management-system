<?php
/**
 * SPORTS TOURNAMENT MANAGEMENT SYSTEM
 * Process Fan Match Prediction (Spectator) - AIUB Standard Pattern
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
    $prediction = isset($_POST["prediction"]) ? cleanInput($_POST["prediction"]) : "Abahani";
    $matchName  = "Abahani Ltd. vs Mohammedan SC";

    if ($conn && !empty($prediction)) {
        $sql = "INSERT INTO match_predictions (match_name, predicted_winner) VALUES (?, ?)";
        $stmt = mysqli_prepare($conn, $sql);
        if ($stmt) {
            mysqli_stmt_bind_param($stmt, "ss", $matchName, $prediction);
            mysqli_stmt_execute($stmt);
            mysqli_stmt_close($stmt);
        }
    }
    header("Location: ../spectator_dashboard.html?prediction=recorded");
    exit();
} else {
    header("Location: ../spectator_dashboard.html");
    exit();
}
?>

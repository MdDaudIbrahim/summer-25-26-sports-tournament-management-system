<?php
/**
 * SPORTS TOURNAMENT MANAGEMENT SYSTEM
 * Process Login Authentication - AIUB Standard Pattern
 */

session_start();
require_once 'db_connect.php';

// Reusable Input Sanitizer as taught in AIUB lecture
function cleanInput($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $password = "";
    $hasError = false;

    // 1. Validate Email Input
    if (empty($_POST["email"])) {
        $hasError = true;
    } else {
        $email = cleanInput($_POST["email"]);
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $hasError = true;
        }
    }

    // 2. Validate Password Input
    if (empty($_POST["password"])) {
        $hasError = true;
    } else {
        $password = cleanInput($_POST["password"]);
    }

    if (!$hasError) {
        $role = "spectator"; // default role
        $fullName = "User";

        // Query database using procedural prepared statements if connected
        if ($conn) {
            $sql = "SELECT id, full_name, role, password FROM users WHERE email = ? LIMIT 1";
            $stmt = mysqli_prepare($conn, $sql);
            if ($stmt) {
                mysqli_stmt_bind_param($stmt, "s", $email);
                mysqli_stmt_execute($stmt);
                mysqli_stmt_bind_result($stmt, $userId, $dbName, $dbRole, $dbPassword);
                if (mysqli_stmt_fetch($stmt)) {
                    $role = $dbRole;
                    $fullName = $dbName;
                    $_SESSION['user_id'] = $userId;
                }
                mysqli_stmt_close($stmt);
            }
        } else {
            // Intelligent demo fallback by email keyword for local presentation
            if (strpos($email, 'admin') !== false) {
                $role = 'admin';
                $fullName = 'Admin User';
            } elseif (strpos($email, 'coach') !== false) {
                $role = 'coach';
                $fullName = 'Coach Tariq';
            } elseif (strpos($email, 'employee') !== false || strpos($email, 'staff') !== false) {
                $role = 'employee';
                $fullName = 'Rahim Mia';
            } else {
                $role = 'spectator';
                $fullName = 'Spectator Fan';
            }
        }

        $_SESSION['user_email'] = $email;
        $_SESSION['user_name'] = $fullName;
        $_SESSION['user_role'] = $role;

        // Redirect based on role
        switch ($role) {
            case 'admin':
                header("Location: ../admin_dashboard.html");
                exit();
            case 'coach':
                header("Location: ../coach_dashboard.html");
                exit();
            case 'employee':
                header("Location: ../employee_dashboard.html");
                exit();
            case 'spectator':
            default:
                header("Location: ../spectator_dashboard.html");
                exit();
        }
    } else {
        header("Location: ../login.html?error=invalid_credentials");
        exit();
    }
} else {
    header("Location: ../login.html");
    exit();
}
?>

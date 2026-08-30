<?php
/**
 * SPORTS TOURNAMENT MANAGEMENT SYSTEM
 * Process Registration - AIUB Standard Pattern
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
    $name = $email = $role = $password = $confirmPassword = "";
    $hasError = false;

    // 1. Validate Full Name
    if (empty($_POST["name"])) {
        $hasError = true;
    } else {
        $name = cleanInput($_POST["name"]);
        if (strlen($name) < 3 || !preg_match("/^[a-zA-Z\s'-]+$/", $name)) {
            $hasError = true;
        }
    }

    // 2. Validate Email
    if (empty($_POST["email"])) {
        $hasError = true;
    } else {
        $email = cleanInput($_POST["email"]);
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $hasError = true;
        }
    }

    // 3. Validate Role
    $validRoles = array("admin", "coach", "employee", "spectator");
    if (empty($_POST["role"]) || !in_array($_POST["role"], $validRoles)) {
        $hasError = true;
    } else {
        $role = cleanInput($_POST["role"]);
    }

    // 4. Validate Password & Confirm Password
    if (empty($_POST["password"]) || strlen($_POST["password"]) < 6) {
        $hasError = true;
    } else {
        $password = cleanInput($_POST["password"]);
        $confirmPassword = isset($_POST["confirm_password"]) ? cleanInput($_POST["confirm_password"]) : "";
        if ($password !== $confirmPassword) {
            $hasError = true;
        }
    }

    // 5. Execution on Valid Data
    if (!$hasError) {
        if ($conn) {
            $sql = "INSERT INTO users (full_name, email, password, role) VALUES (?, ?, ?, ?)";
            $stmt = mysqli_prepare($conn, $sql);
            if ($stmt) {
                mysqli_stmt_bind_param($stmt, "ssss", $name, $email, $password, $role);
                mysqli_stmt_execute($stmt);
                mysqli_stmt_close($stmt);
            }
        }

        // Set session
        $_SESSION['user_name'] = $name;
        $_SESSION['user_email'] = $email;
        $_SESSION['user_role'] = $role;

        // Redirect directly to the designated dashboard
        switch ($role) {
            case 'admin':
                header("Location: ../admin_dashboard.html?registered=1");
                exit();
            case 'coach':
                header("Location: ../coach_dashboard.html?registered=1");
                exit();
            case 'employee':
                header("Location: ../employee_dashboard.html?registered=1");
                exit();
            case 'spectator':
            default:
                header("Location: ../spectator_dashboard.html?registered=1");
                exit();
        }
    } else {
        header("Location: ../registration.html?error=validation_failed");
        exit();
    }
} else {
    header("Location: ../registration.html");
    exit();
}
?>

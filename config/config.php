<?php
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_NAME', 'sports_tournament_db');

define('APP_NAME', 'Tournament Pro');
define('SESSION_TIMEOUT', 1800);

(function() {
    $scheme = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? 'https' : 'http';
    $host   = $_SERVER['HTTP_HOST'] ?? 'localhost';
    $docRoot = str_replace('\\', '/', realpath($_SERVER['DOCUMENT_ROOT'] ?? 'C:/xampp/htdocs'));
    $appDir  = str_replace('\\', '/', dirname(__DIR__));
    $sub     = str_replace($docRoot, '', $appDir);
    define('BASE_URL', $scheme . '://' . $host . $sub);
})();

if (session_status() === PHP_SESSION_NONE) {
    session_set_cookie_params([
        'lifetime' => 0,
        'path'     => '/',
        'httponly' => true,
        'samesite' => 'Lax',
    ]);
    session_start();
}

$conn = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);
if (!$conn) {
    die('Database connection failed: ' . mysqli_connect_error());
}
mysqli_set_charset($conn, 'utf8mb4');

$demoUsers = [
    ['admin', 'admin@tournamentpro.com', 'admin123', 'admin', 'Administrator'],
    ['coach1', 'coach@tournamentpro.com', 'coach123', 'coach', 'Coach Rahat'],
    ['employee1', 'employee@tournamentpro.com', 'emp123', 'employee', 'Staff Karim'],
    ['spectator1', 'fan@tournamentpro.com', 'spec123', 'spectator', 'Tanvir Ahmed (Spectator)']
];

foreach ($demoUsers as $du) {
    $ck = mysqli_query($conn, "SELECT id FROM users WHERE username = '{$du[0]}' LIMIT 1");
    if ($ck && mysqli_num_rows($ck) === 0) {
        $hash = password_hash($du[2], PASSWORD_DEFAULT);
        $stmt = mysqli_prepare($conn,
            "INSERT INTO users (username, email, password, role, full_name, status)
             VALUES (?, ?, ?, ?, ?, 'active')");
        mysqli_stmt_bind_param($stmt, 'sssss', $du[0], $du[1], $hash, $du[3], $du[4]);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
    }
}

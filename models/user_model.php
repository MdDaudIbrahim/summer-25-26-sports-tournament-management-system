<?php

function find_user_by_username($conn, $username) {
    $sql  = "SELECT * FROM users WHERE username = ? OR email = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, 'ss', $username, $username);
    mysqli_stmt_execute($stmt);
    $row  = mysqli_fetch_assoc(mysqli_stmt_get_result($stmt));
    mysqli_stmt_close($stmt);
    return $row;
}

function get_user($conn, $id) {
    $sql  = "SELECT id, full_name, username, email, role, status, created_at
             FROM users WHERE id = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, 'i', $id);
    mysqli_stmt_execute($stmt);
    $row  = mysqli_fetch_assoc(mysqli_stmt_get_result($stmt));
    mysqli_stmt_close($stmt);
    return $row;
}

function get_users($conn, $role = '') {
    if ($role === '') {
        $sql  = "SELECT id, full_name, username, email, role, status, created_at
                 FROM users ORDER BY id DESC";
        $stmt = mysqli_prepare($conn, $sql);
    } else {
        $sql  = "SELECT id, full_name, username, email, role, status, created_at
                 FROM users WHERE role = ? ORDER BY id DESC";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, 's', $role);
    }
    mysqli_stmt_execute($stmt);
    $rows = mysqli_fetch_all(mysqli_stmt_get_result($stmt), MYSQLI_ASSOC);
    mysqli_stmt_close($stmt);
    return $rows;
}

function search_users($conn, $term, $role = '') {
    $like = '%' . $term . '%';
    if ($role === '') {
        $sql  = "SELECT id, full_name, username, email, role, status, created_at
                 FROM users
                 WHERE full_name LIKE ? OR username LIKE ? OR email LIKE ?
                 ORDER BY id DESC";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, 'sss', $like, $like, $like);
    } else {
        $sql  = "SELECT id, full_name, username, email, role, status, created_at
                 FROM users
                 WHERE role = ? AND (full_name LIKE ? OR username LIKE ? OR email LIKE ?)
                 ORDER BY id DESC";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, 'ssss', $role, $like, $like, $like);
    }
    mysqli_stmt_execute($stmt);
    $rows = mysqli_fetch_all(mysqli_stmt_get_result($stmt), MYSQLI_ASSOC);
    mysqli_stmt_close($stmt);
    return $rows;
}

function username_exists($conn, $username, $excludeId = 0) {
    $sql  = "SELECT id FROM users WHERE username = ? AND id != ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, 'si', $username, $excludeId);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_store_result($stmt);
    $exists = mysqli_stmt_num_rows($stmt) > 0;
    mysqli_stmt_close($stmt);
    return $exists;
}

function email_exists($conn, $email, $excludeId = 0) {
    $sql  = "SELECT id FROM users WHERE email = ? AND id != ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, 'si', $email, $excludeId);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_store_result($stmt);
    $exists = mysqli_stmt_num_rows($stmt) > 0;
    mysqli_stmt_close($stmt);
    return $exists;
}

function create_user($conn, $full_name, $username, $email, $password, $role) {
        $hash = password_hash($password, PASSWORD_DEFAULT);
    $sql  = "INSERT INTO users (full_name, username, email, password, role)
             VALUES (?, ?, ?, ?, ?)";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, 'sssss', $full_name, $username, $email, $hash, $role);
    $ok   = mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
    return $ok;
}

function update_user($conn, $id, $full_name, $username, $email, $role, $status) {
    $sql  = "UPDATE users
             SET full_name = ?, username = ?, email = ?, role = ?, status = ?
             WHERE id = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, 'sssssi', $full_name, $username, $email, $role, $status, $id);
    $ok   = mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
    return $ok;
}

function update_password($conn, $id, $password) {
    $hash = password_hash($password, PASSWORD_DEFAULT);
    $stmt = mysqli_prepare($conn, "UPDATE users SET password = ? WHERE id = ?");
    mysqli_stmt_bind_param($stmt, 'si', $hash, $id);
    $ok   = mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
    return $ok;
}

function delete_user($conn, $id) {
    $stmt = mysqli_prepare($conn, "DELETE FROM users WHERE id = ?");
    mysqli_stmt_bind_param($stmt, 'i', $id);
    $ok   = mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
    return $ok;
}

function set_user_status($conn, $id, $status) {
    $stmt = mysqli_prepare($conn, "UPDATE users SET status = ? WHERE id = ?");
    mysqli_stmt_bind_param($stmt, 'si', $status, $id);
    $ok   = mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
    return $ok;
}

function get_system_stats($conn) {
    $stats = [
        'admins' => 0, 'coaches' => 0, 'employees' => 0, 'spectators' => 0,
        'suspended' => 0, 'tournaments' => 0, 'teams' => 0,
        'tickets' => 0, 'incidents' => 0,
    ];

    $res = mysqli_query($conn, "SELECT role, COUNT(*) AS total FROM users GROUP BY role");
    while ($row = mysqli_fetch_assoc($res)) {
        if ($row['role'] === 'admin')     $stats['admins']     = (int)$row['total'];
        if ($row['role'] === 'coach')     $stats['coaches']    = (int)$row['total'];
        if ($row['role'] === 'employee')  $stats['employees']  = (int)$row['total'];
        if ($row['role'] === 'spectator') $stats['spectators'] = (int)$row['total'];
    }

    $one = function ($conn, $sql) {
        $res = mysqli_query($conn, $sql);
        $row = mysqli_fetch_row($res);
        return (int)($row[0] ?? 0);
    };

    $stats['suspended']   = $one($conn, "SELECT COUNT(*) FROM users WHERE status = 'suspended'");
    $stats['tournaments'] = $one($conn, "SELECT COUNT(*) FROM tournaments");
    $stats['teams']       = $one($conn, "SELECT COUNT(*) FROM teams");
    $stats['tickets']     = $one($conn, "SELECT COUNT(*) FROM tickets");
    $stats['incidents']   = $one($conn, "SELECT COUNT(*) FROM incidents WHERE status = 'Pending'");

    return $stats;
}

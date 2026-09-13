<?php

function get_venues($conn) {
    $sql  = "SELECT id, venue_name, city, field_cleaning_pct, seating_pct FROM venues ORDER BY id DESC";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_execute($stmt);
    $rows = mysqli_fetch_all(mysqli_stmt_get_result($stmt), MYSQLI_ASSOC);
    mysqli_stmt_close($stmt);
    return $rows;
}

function get_venue($conn, $id) {
    $sql  = "SELECT id, venue_name, city, field_cleaning_pct, seating_pct FROM venues WHERE id = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, 'i', $id);
    mysqli_stmt_execute($stmt);
    $row  = mysqli_fetch_assoc(mysqli_stmt_get_result($stmt));
    mysqli_stmt_close($stmt);
    return $row;
}

function add_venue($conn, $venueName, $city) {
    $sql  = "INSERT INTO venues (venue_name, city) VALUES (?, ?)";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, 'ss', $venueName, $city);
    $ok   = mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
    return $ok;
}

function update_venue($conn, $id, $venueName, $city, $cleaningPct, $seatingPct) {
    $sql  = "UPDATE venues SET venue_name = ?, city = ?, field_cleaning_pct = ?, seating_pct = ? WHERE id = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, 'ssiii', $venueName, $city, $cleaningPct, $seatingPct, $id);
    $ok   = mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
    return $ok;
}

function delete_venue($conn, $id) {
    $stmt = mysqli_prepare($conn, "DELETE FROM venues WHERE id = ?");
    mysqli_stmt_bind_param($stmt, 'i', $id);
    $ok   = mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
    return $ok;
}

function get_equipment($conn) {
    $sql  = "SELECT id, item_name, quantity, status FROM equipment ORDER BY id DESC";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_execute($stmt);
    $rows = mysqli_fetch_all(mysqli_stmt_get_result($stmt), MYSQLI_ASSOC);
    mysqli_stmt_close($stmt);
    return $rows;
}

function get_equipment_item($conn, $id) {
    $sql  = "SELECT id, item_name, quantity, status FROM equipment WHERE id = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, 'i', $id);
    mysqli_stmt_execute($stmt);
    $row  = mysqli_fetch_assoc(mysqli_stmt_get_result($stmt));
    mysqli_stmt_close($stmt);
    return $row;
}

function add_equipment($conn, $itemName, $quantity, $status) {
    $sql  = "INSERT INTO equipment (item_name, quantity, status) VALUES (?, ?, ?)";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, 'sis', $itemName, $quantity, $status);
    $ok   = mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
    return $ok;
}

function update_equipment($conn, $id, $itemName, $quantity, $status) {
    $sql  = "UPDATE equipment SET item_name = ?, quantity = ?, status = ? WHERE id = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, 'sisi', $itemName, $quantity, $status, $id);
    $ok   = mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
    return $ok;
}

function delete_equipment($conn, $id) {
    $stmt = mysqli_prepare($conn, "DELETE FROM equipment WHERE id = ?");
    mysqli_stmt_bind_param($stmt, 'i', $id);
    $ok   = mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
    return $ok;
}

function get_tasks($conn) {
    $sql  = "SELECT id, task_title, is_urgent, is_completed, assigned_staff
             FROM preparation_tasks ORDER BY is_urgent DESC, id ASC";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_execute($stmt);
    $rows = mysqli_fetch_all(mysqli_stmt_get_result($stmt), MYSQLI_ASSOC);
    mysqli_stmt_close($stmt);
    return $rows;
}

function add_task($conn, $taskTitle, $isUrgent, $assignedStaff) {
    $sql  = "INSERT INTO preparation_tasks (task_title, is_urgent, assigned_staff) VALUES (?, ?, ?)";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, 'sis', $taskTitle, $isUrgent, $assignedStaff);
    $ok   = mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
    return $ok;
}

function toggle_task($conn, $id) {

    $stmt = mysqli_prepare($conn, "UPDATE preparation_tasks SET is_completed = 1 - is_completed WHERE id = ?");
    mysqli_stmt_bind_param($stmt, 'i', $id);
    $ok   = mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
    return $ok;
}

function delete_task($conn, $id) {
    $stmt = mysqli_prepare($conn, "DELETE FROM preparation_tasks WHERE id = ?");
    mysqli_stmt_bind_param($stmt, 'i', $id);
    $ok   = mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
    return $ok;
}

function get_incidents($conn) {
    $sql  = "SELECT id, problem_type, location_area, description, status, reported_by, created_at
             FROM incidents ORDER BY id DESC";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_execute($stmt);
    $rows = mysqli_fetch_all(mysqli_stmt_get_result($stmt), MYSQLI_ASSOC);
    mysqli_stmt_close($stmt);
    return $rows;
}

function add_incident($conn, $problemType, $locationArea, $description, $reportedBy) {
    $sql  = "INSERT INTO incidents (problem_type, location_area, description, reported_by)
             VALUES (?, ?, ?, ?)";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, 'ssss', $problemType, $locationArea, $description, $reportedBy);
    $ok   = mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
    return $ok;
}

function update_incident_status($conn, $id, $status) {
    $stmt = mysqli_prepare($conn, "UPDATE incidents SET status = ? WHERE id = ?");
    mysqli_stmt_bind_param($stmt, 'si', $status, $id);
    $ok   = mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
    return $ok;
}

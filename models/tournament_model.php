<?php

function get_tournaments($conn, $status = '') {
    if ($status === '') {
        $sql  = "SELECT id, tournament_name, tournament_type, status, start_date, end_date
                 FROM tournaments ORDER BY id DESC";
        $stmt = mysqli_prepare($conn, $sql);
    } else {
        $sql  = "SELECT id, tournament_name, tournament_type, status, start_date, end_date
                 FROM tournaments WHERE status = ? ORDER BY id DESC";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, 's', $status);
    }
    mysqli_stmt_execute($stmt);
    $rows = mysqli_fetch_all(mysqli_stmt_get_result($stmt), MYSQLI_ASSOC);
    mysqli_stmt_close($stmt);
    return $rows;
}

function get_tournament($conn, $id) {
    $sql  = "SELECT id, tournament_name, tournament_type, status, start_date, end_date
             FROM tournaments WHERE id = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, 'i', $id);
    mysqli_stmt_execute($stmt);
    $row  = mysqli_fetch_assoc(mysqli_stmt_get_result($stmt));
    mysqli_stmt_close($stmt);
    return $row;
}

function search_tournaments($conn, $term) {
    $like = '%' . $term . '%';
    $sql  = "SELECT id, tournament_name, tournament_type, status, start_date, end_date
             FROM tournaments
             WHERE tournament_name LIKE ? OR tournament_type LIKE ? OR status LIKE ?
             ORDER BY id DESC";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, 'sss', $like, $like, $like);
    mysqli_stmt_execute($stmt);
    $rows = mysqli_fetch_all(mysqli_stmt_get_result($stmt), MYSQLI_ASSOC);
    mysqli_stmt_close($stmt);
    return $rows;
}

function add_tournament($conn, $name, $type, $status, $start_date, $end_date) {
    $sql  = "INSERT INTO tournaments (tournament_name, tournament_type, status, start_date, end_date)
             VALUES (?, ?, ?, ?, ?)";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, 'sssss', $name, $type, $status, $start_date, $end_date);
    $ok   = mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
    return $ok;
}

function update_tournament($conn, $id, $name, $type, $status, $start_date, $end_date) {
    $sql  = "UPDATE tournaments
             SET tournament_name = ?, tournament_type = ?, status = ?,
                 start_date = ?, end_date = ?
             WHERE id = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, 'sssssi', $name, $type, $status, $start_date, $end_date, $id);
    $ok   = mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
    return $ok;
}

function delete_tournament($conn, $id) {
    $stmt = mysqli_prepare($conn, "DELETE FROM tournaments WHERE id = ?");
    mysqli_stmt_bind_param($stmt, 'i', $id);
    $ok   = mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
    return $ok;
}

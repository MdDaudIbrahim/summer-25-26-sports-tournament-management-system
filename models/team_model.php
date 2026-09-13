<?php

function get_teams($conn, $tournamentId = 0) {
    if ($tournamentId === 0) {
        $sql  = "SELECT t.id, t.team_name, t.coach_email, t.squad_size,
                        t.fee_status, t.fee_amount, t.tournament_id,
                        tn.tournament_name
                 FROM teams t
                 LEFT JOIN tournaments tn ON t.tournament_id = tn.id
                 ORDER BY t.id DESC";
        $stmt = mysqli_prepare($conn, $sql);
    } else {
        $sql  = "SELECT t.id, t.team_name, t.coach_email, t.squad_size,
                        t.fee_status, t.fee_amount, t.tournament_id,
                        tn.tournament_name
                 FROM teams t
                 LEFT JOIN tournaments tn ON t.tournament_id = tn.id
                 WHERE t.tournament_id = ?
                 ORDER BY t.id DESC";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, 'i', $tournamentId);
    }
    mysqli_stmt_execute($stmt);
    $rows = mysqli_fetch_all(mysqli_stmt_get_result($stmt), MYSQLI_ASSOC);
    mysqli_stmt_close($stmt);
    return $rows;
}

function get_teams_by_coach($conn, $coachEmail) {
    $sql  = "SELECT t.id, t.team_name, t.coach_email, t.squad_size,
                    t.fee_status, t.fee_amount, t.tournament_id,
                    tn.tournament_name
             FROM teams t
             LEFT JOIN tournaments tn ON t.tournament_id = tn.id
             WHERE t.coach_email = ?
             ORDER BY t.id DESC";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, 's', $coachEmail);
    mysqli_stmt_execute($stmt);
    $rows = mysqli_fetch_all(mysqli_stmt_get_result($stmt), MYSQLI_ASSOC);
    mysqli_stmt_close($stmt);
    return $rows;
}

function get_team($conn, $id) {
    $sql  = "SELECT t.id, t.team_name, t.coach_email, t.squad_size,
                    t.fee_status, t.fee_amount, t.tournament_id, t.coach_id,
                    tn.tournament_name
             FROM teams t
             LEFT JOIN tournaments tn ON t.tournament_id = tn.id
             WHERE t.id = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, 'i', $id);
    mysqli_stmt_execute($stmt);
    $row  = mysqli_fetch_assoc(mysqli_stmt_get_result($stmt));
    mysqli_stmt_close($stmt);
    return $row;
}

function search_teams($conn, $term) {
    $like = '%' . $term . '%';
    $sql  = "SELECT t.id, t.team_name, t.coach_email, t.squad_size,
                    t.fee_status, t.fee_amount, t.tournament_id,
                    tn.tournament_name
             FROM teams t
             LEFT JOIN tournaments tn ON t.tournament_id = tn.id
             WHERE t.team_name LIKE ? OR t.coach_email LIKE ? OR tn.tournament_name LIKE ?
             ORDER BY t.id DESC";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, 'sss', $like, $like, $like);
    mysqli_stmt_execute($stmt);
    $rows = mysqli_fetch_all(mysqli_stmt_get_result($stmt), MYSQLI_ASSOC);
    mysqli_stmt_close($stmt);
    return $rows;
}

function add_team($conn, $tournamentId, $coachId, $teamName, $coachEmail, $squadSize, $feeStatus, $feeAmount) {
    $sql  = "INSERT INTO teams (tournament_id, coach_id, team_name, coach_email, squad_size, fee_status, fee_amount)
             VALUES (?, ?, ?, ?, ?, ?, ?)";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, 'iississ',
        $tournamentId, $coachId, $teamName, $coachEmail, $squadSize, $feeStatus, $feeAmount);
    $ok   = mysqli_stmt_execute($stmt);
    $newId = mysqli_stmt_insert_id($stmt);
    mysqli_stmt_close($stmt);
    return $ok ? $newId : false;
}

function update_team($conn, $id, $teamName, $squadSize, $feeStatus) {
    $sql  = "UPDATE teams SET team_name = ?, squad_size = ?, fee_status = ? WHERE id = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, 'sisi', $teamName, $squadSize, $feeStatus, $id);
    $ok   = mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
    return $ok;
}

function pay_team_fee($conn, $id) {
    $sql  = "UPDATE teams SET fee_status = 'Paid' WHERE id = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, 'i', $id);
    $ok   = mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
    return $ok;
}

function delete_team($conn, $id) {
    $stmt = mysqli_prepare($conn, "DELETE FROM teams WHERE id = ?");
    mysqli_stmt_bind_param($stmt, 'i', $id);
    $ok   = mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
    return $ok;
}

<?php

function add_prediction($conn, $matchName, $predictedWinner) {
    $sql  = "INSERT INTO match_predictions (match_name, predicted_winner) VALUES (?, ?)";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, 'ss', $matchName, $predictedWinner);
    $ok   = mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
    return $ok;
}

function get_prediction_stats($conn, $matchName) {
    $sql  = "SELECT predicted_winner, COUNT(*) AS votes
             FROM match_predictions WHERE match_name = ?
             GROUP BY predicted_winner";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, 's', $matchName);
    mysqli_stmt_execute($stmt);
    $rows = mysqli_fetch_all(mysqli_stmt_get_result($stmt), MYSQLI_ASSOC);
    mysqli_stmt_close($stmt);
    return $rows;
}

function get_total_votes($conn, $matchName) {
    $sql  = "SELECT COUNT(*) AS total FROM match_predictions WHERE match_name = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, 's', $matchName);
    mysqli_stmt_execute($stmt);
    $row  = mysqli_fetch_assoc(mysqli_stmt_get_result($stmt));
    mysqli_stmt_close($stmt);
    return (int)($row['total'] ?? 0);
}

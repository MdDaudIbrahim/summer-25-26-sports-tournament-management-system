<?php

function get_players_by_team($conn, $teamId) {
    $sql  = "SELECT id, team_id, player_name, position,
                    matches_played, points, assists, rating, is_injured
             FROM players WHERE team_id = ? ORDER BY rating DESC";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, 'i', $teamId);
    mysqli_stmt_execute($stmt);
    $rows = mysqli_fetch_all(mysqli_stmt_get_result($stmt), MYSQLI_ASSOC);
    mysqli_stmt_close($stmt);
    return $rows;
}

function get_player($conn, $id) {
    $sql  = "SELECT id, team_id, player_name, position,
                    matches_played, points, assists, rating, is_injured
             FROM players WHERE id = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, 'i', $id);
    mysqli_stmt_execute($stmt);
    $row  = mysqli_fetch_assoc(mysqli_stmt_get_result($stmt));
    mysqli_stmt_close($stmt);
    return $row;
}

function add_player($conn, $teamId, $playerName, $position, $matches = 0, $points = 0, $assists = 0, $rating = 7.5, $isInjured = 0) {
    $sql  = "INSERT INTO players (team_id, player_name, position, matches_played, points, assists, rating, is_injured) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, 'issiiidi', $teamId, $playerName, $position, $matches, $points, $assists, $rating, $isInjured);
    $ok   = mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
    return $ok;
}

function update_player($conn, $id, $playerName, $position, $isInjured) {
    $sql  = "UPDATE players SET player_name = ?, position = ?, is_injured = ? WHERE id = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, 'ssii', $playerName, $position, $isInjured, $id);
    $ok   = mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
    return $ok;
}

function delete_player($conn, $id) {
    $stmt = mysqli_prepare($conn, "DELETE FROM players WHERE id = ?");
    mysqli_stmt_bind_param($stmt, 'i', $id);
    $ok   = mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
    return $ok;
}

function get_top_performers($conn, $teamId, $limit = 5) {
    $sql  = "SELECT player_name, position, points, assists, rating
             FROM players WHERE team_id = ? AND is_injured = 0
             ORDER BY rating DESC, points DESC LIMIT ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, 'ii', $teamId, $limit);
    mysqli_stmt_execute($stmt);
    $rows = mysqli_fetch_all(mysqli_stmt_get_result($stmt), MYSQLI_ASSOC);
    mysqli_stmt_close($stmt);
    return $rows;
}

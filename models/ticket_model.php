<?php

function get_tickets_by_user($conn, $userId, $limit = 10) {
    $sql  = "SELECT id, match_title, order_no, seat_category, ticket_count, payment_status, created_at
             FROM tickets WHERE user_id = ? ORDER BY id DESC LIMIT ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, 'ii', $userId, $limit);
    mysqli_stmt_execute($stmt);
    $rows = mysqli_fetch_all(mysqli_stmt_get_result($stmt), MYSQLI_ASSOC);
    mysqli_stmt_close($stmt);
    return $rows;
}

function get_all_tickets($conn) {
    $sql  = "SELECT t.id, t.match_title, t.order_no, t.seat_category,
                    t.ticket_count, t.payment_status, t.created_at,
                    u.full_name, u.username
             FROM tickets t
             LEFT JOIN users u ON t.user_id = u.id
             ORDER BY t.id DESC";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_execute($stmt);
    $rows = mysqli_fetch_all(mysqli_stmt_get_result($stmt), MYSQLI_ASSOC);
    mysqli_stmt_close($stmt);
    return $rows;
}

function add_ticket($conn, $userId, $matchTitle, $orderNo, $seatCategory, $ticketCount) {
    $sql  = "INSERT INTO tickets (user_id, match_title, order_no, seat_category, ticket_count, payment_status)
             VALUES (?, ?, ?, ?, ?, 'Paid')";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, 'isssi', $userId, $matchTitle, $orderNo, $seatCategory, $ticketCount);
    $ok   = mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
    return $ok;
}

function delete_ticket($conn, $id, $userId) {

    $stmt = mysqli_prepare($conn, "DELETE FROM tickets WHERE id = ? AND user_id = ?");
    mysqli_stmt_bind_param($stmt, 'ii', $id, $userId);
    $ok   = mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
    return $ok;
}

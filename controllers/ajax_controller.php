<?php

function ajax_controller($conn) {
    $action = $_GET['action'] ?? '';
    $term   = trim($_GET['q'] ?? '');

    if ($action === 'check_username') {
        $username = trim($_GET['username'] ?? '');
        if (!preg_match('/^[A-Za-z0-9_]{4,20}$/', $username)) {
            json_out(['ok' => false, 'message' => 'Use 4-20 letters, numbers or underscores.']);
        }
        json_out(username_exists($conn, $username)
            ? ['ok' => false, 'message' => 'That username is taken.']
            : ['ok' => true,  'message' => 'Username is available.']);
    }

    if (!is_logged_in()) {
        json_out(['error' => 'Please sign in first.'], 401);
    }

    $role = current_role();
    $user = current_user();
    $id   = (int)$user['id'];

    switch ($action) {

        case 'search_users':
            if ($role !== 'admin') break;
            $roleFilter = $_GET['role'] ?? '';
            if (!in_array($roleFilter, ['admin','coach','employee','spectator'], true)) {
                $roleFilter = '';
            }
            json_out($term === ''
                ? get_users($conn, $roleFilter)
                : search_users($conn, $term, $roleFilter));

        case 'stats':
            if ($role !== 'admin') break;
            json_out(get_system_stats($conn));

        case 'search_logs':
            if ($role !== 'admin') break;
            json_out($term === '' ? get_logs($conn, 15) : search_logs($conn, $term, 50));

        case 'search_tournaments':
            if ($role !== 'admin') break;
            json_out($term === ''
                ? get_tournaments($conn)
                : search_tournaments($conn, $term));

        case 'search_teams':
            if ($role !== 'coach' && $role !== 'admin') break;
            json_out($term === ''
                ? get_teams($conn)
                : search_teams($conn, $term));

        case 'prediction_stats':
            if ($role !== 'spectator') break;
            $matchName = $_GET['match'] ?? 'Abahani Ltd. vs Mohammedan SC';
            $stats     = get_prediction_stats($conn, $matchName);
            $total     = get_total_votes($conn, $matchName);
            json_out(['stats' => $stats, 'total' => $total]);
    }

    json_out(['error' => 'You are not allowed to use this endpoint.'], 403);
}

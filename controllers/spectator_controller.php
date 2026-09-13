<?php

function spectator_controller($conn) {
    $action = $_GET['action'] ?? 'schedules';
    $me     = current_user();
    $userId = (int)$me['id'];

    $error = '';

    if ($action === 'buy_ticket' && is_post()) {
        csrf_check();

        $matchTitle   = trim($_POST['match_title']   ?? '');
        $seatCategory = trim($_POST['seat_category'] ?? 'VIP Gallery');
        $ticketCount  = (int)($_POST['ticket_count'] ?? 2);

        $allowedSeats = ['VIP Gallery', 'Grand Stand', 'General Gallery'];

        if (is_blank($matchTitle)) {
            $error = 'Please select a match.';
        } elseif (!in_array($seatCategory, $allowedSeats, true)) {
            $error = 'Choose a valid seat category.';
        } elseif ($ticketCount < 1 || $ticketCount > 10) {
            $error = 'Ticket count must be between 1 and 10.';
        } else {

            $orderNo = 'BPL-' . date('Y') . '-' . rand(1000, 9999);

            if (add_ticket($conn, $userId, $matchTitle, $orderNo, $seatCategory, $ticketCount)) {
                log_activity($conn, 'Purchased ' . $ticketCount . ' ticket(s) for "' . $matchTitle . '"');
                set_flash('success', 'Ticket purchase successful! Order: ' . $orderNo . ' confirmed.');
                redirect('index.php?page=spectator&action=tickets');
            }
            $error = 'Could not process your ticket purchase.';
        }
    }

    if ($action === 'ticket_delete') {
        csrf_check();
        $id = (int)($_GET['id'] ?? 0);
        if ($id > 0 && delete_ticket($conn, $id, $userId)) {
            log_activity($conn, 'Cancelled ticket #' . $id);
            set_flash('success', 'Ticket booking cancelled and refunded.');
        } else {
            set_flash('error', 'Could not cancel that ticket.');
        }
        redirect('index.php?page=spectator&action=tickets');
    }

    if ($action === 'predict' && is_post()) {
        csrf_check();

        $matchName       = trim($_POST['match_name']       ?? 'Abahani Ltd. vs Mohammedan SC');
        $predictedWinner = trim($_POST['predicted_winner'] ?? '');

        $allowedWinners = ['Abahani', 'Mohammedan', 'Draw'];

        if (!in_array($predictedWinner, $allowedWinners, true)) {
            $error = 'Please select a valid prediction.';
        } else {
            if (add_prediction($conn, $matchName, $predictedWinner)) {
                log_activity($conn, 'Voted "' . $predictedWinner . '" in fan prediction poll');
                set_flash('success', 'Your prediction for "' . $predictedWinner . '" has been recorded!');
                redirect('index.php?page=spectator&action=predictions');
            }
            $error = 'Could not record your vote.';
        }
    }

    $myTickets = get_tickets_by_user($conn, $userId);

    $venues = get_venues($conn);

    $teams = get_teams($conn);

    $tournaments = get_tournaments($conn);

    $matchName    = 'Abahani Ltd. vs Mohammedan SC';
    $totalVotes   = get_total_votes($conn, $matchName);
    $predStats    = get_prediction_stats($conn, $matchName);

    $votes = ['Abahani' => 0, 'Mohammedan' => 0, 'Draw' => 0];
    foreach ($predStats as $row) {
        if (isset($votes[$row['predicted_winner']])) {
            $votes[$row['predicted_winner']] = (int)$row['votes'];
        }
    }
    $abahaniPct    = $totalVotes > 0 ? round(($votes['Abahani']    / $totalVotes) * 100) : 60;
    $mohammedanPct = $totalVotes > 0 ? round(($votes['Mohammedan'] / $totalVotes) * 100) : 30;
    $drawPct       = $totalVotes > 0 ? (100 - $abahaniPct - $mohammedanPct) : 10;

    $matchSchedules = [
        [
            'id' => 1,
            'time' => '4:00 PM',
            'date' => 'Today',
            'tournament' => 'Dhaka Premier League',
            'title' => 'Abahani Ltd. vs Mohammedan SC',
            'home' => 'Abahani Ltd.',
            'away' => 'Mohammedan SC',
            'venue' => 'Bangabandhu National Stadium',
            'city' => 'Dhaka',
            'status' => 'Live',
            'ticket_price' => 1500
        ],
        [
            'id' => 2,
            'time' => '4:00 PM',
            'date' => '15 Oct',
            'tournament' => 'Dhaka Premier League',
            'title' => 'Bashundhara Kings vs Sheikh Jamal',
            'home' => 'Bashundhara Kings',
            'away' => 'Sheikh Jamal',
            'venue' => 'Bangabandhu National Stadium',
            'city' => 'Dhaka',
            'status' => 'Upcoming',
            'ticket_price' => 800
        ],
        [
            'id' => 3,
            'time' => '7:00 PM',
            'date' => '18 Oct',
            'tournament' => 'Independence Cup',
            'title' => 'Police FC vs Rahmatganj MFS',
            'home' => 'Police FC',
            'away' => 'Rahmatganj MFS',
            'venue' => 'Sylhet International Stadium',
            'city' => 'Sylhet',
            'status' => 'Upcoming',
            'ticket_price' => 500
        ],
        [
            'id' => 4,
            'time' => '5:30 PM',
            'date' => '22 Oct',
            'tournament' => 'Independence Cup',
            'title' => 'Dhaka Dynamites vs Chittagong Abahani',
            'home' => 'Dhaka Dynamites',
            'away' => 'Chittagong Abahani',
            'venue' => 'Bangabandhu National Stadium',
            'city' => 'Dhaka',
            'status' => 'Scheduled',
            'ticket_price' => 600
        ],
    ];

    if ($action === 'tickets') {
        require __DIR__ . '/../views/spectator/tickets.php';
    } elseif ($action === 'predictions') {
        require __DIR__ . '/../views/spectator/predictions.php';
    } else {

        require __DIR__ . '/../views/spectator/schedules.php';
    }
}

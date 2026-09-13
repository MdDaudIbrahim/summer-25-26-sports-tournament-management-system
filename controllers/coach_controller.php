<?php

function coach_controller($conn) {
    $action = $_GET['action'] ?? 'registration';
    $me     = current_user();

    $error   = '';
    $editing = null;

    if ($action === 'team_add' && is_post()) {
        csrf_check();

        $teamName      = trim($_POST['team_name']      ?? '');
        $tournamentId  = (int)($_POST['tournament_id'] ?? 0);
        $squadSize     = (int)($_POST['squad_size']    ?? 15);
        $feeStatus     = $_POST['fee_status']          ?? 'Pending';

        $allowedFeeStatus = ['Pending', 'Paid'];

        if (is_blank($teamName)) {
            $error = 'Team name is required.';
        } elseif ($tournamentId <= 0) {
            $error = 'Please select a tournament.';
        } elseif (!in_array($feeStatus, $allowedFeeStatus, true)) {
            $error = 'Choose a valid fee status.';
        } elseif ($squadSize < 5 || $squadSize > 30) {
            $error = 'Squad size must be between 5 and 30.';
        } else {
            $coachEmail = $me['email'] ?? '';
            $newTeamId  = add_team($conn, $tournamentId, (int)$me['id'], $teamName,
                                   $coachEmail, $squadSize, $feeStatus, 50000.00);
            if ($newTeamId) {
                log_activity($conn, 'Registered team "' . $teamName . '" for tournament #' . $tournamentId);
                set_flash('success', 'Team "' . $teamName . '" registered successfully with fee status: ' . $feeStatus . '!');
                redirect('index.php?page=coach');
            }
            $error = 'Could not register the team.';
        }
    }

    if ($action === 'team_pay') {
        csrf_check();
        $id = (int)($_GET['id'] ?? 0);
        if ($id > 0 && pay_team_fee($conn, $id)) {
            log_activity($conn, 'Paid tournament registration fee of 50,000 BDT for team #' . $id);
            set_flash('success', 'Registration fee of 50,000.00 BDT successfully paid via Online Gateway!');
        } else {
            set_flash('error', 'Could not process the payment.');
        }
        redirect('index.php?page=coach');
    }

    if ($action === 'team_update' && is_post()) {
        csrf_check();

        $id        = (int)($_GET['id']            ?? 0);
        $teamName  = trim($_POST['team_name']      ?? '');
        $squadSize = (int)($_POST['squad_size']    ?? 15);
        $feeStatus = $_POST['fee_status']          ?? 'Pending';

        if (is_blank($teamName)) {
            $error = 'Team name is required.';
        } else {
            if (update_team($conn, $id, $teamName, $squadSize, $feeStatus)) {
                log_activity($conn, 'Updated team #' . $id . ': ' . $teamName);
                set_flash('success', 'Team registration updated.');
                redirect('index.php?page=coach');
            }
            $error = 'Could not update the team.';
        }
    }

    if ($action === 'team_edit' && !$editing) {
        $editing = get_team($conn, (int)($_GET['id'] ?? 0));
        if (!$editing) {
            set_flash('error', 'That team no longer exists.');
            redirect('index.php?page=coach');
        }
    }

    if ($action === 'team_delete') {
        csrf_check();
        $id = (int)($_GET['id'] ?? 0);
        if ($id > 0 && delete_team($conn, $id)) {
            log_activity($conn, 'Withdrew team registration #' . $id);
            set_flash('success', 'Team registration withdrawn.');
        } else {
            set_flash('error', 'Could not withdraw that team.');
        }
        redirect('index.php?page=coach');
    }

    if ($action === 'player_add' && is_post()) {
        csrf_check();

        $teamId     = (int)($_POST['team_id']      ?? 0);
        $playerName = trim($_POST['player_name']   ?? '');
        $position   = trim($_POST['position']      ?? '');
        $matches    = (int)($_POST['matches_played'] ?? 0);
        $points     = (int)($_POST['points'] ?? 0);
        $assists    = (int)($_POST['assists'] ?? 0);
        $rating     = (float)($_POST['rating'] ?? 7.5);
        $isInjured  = isset($_POST['is_injured']) ? 1 : 0;

        if (is_blank($playerName) || is_blank($position)) {
            $error = 'Fill in every field.';
        } elseif ($teamId <= 0) {
            $error = 'Invalid team selected.';
        } else {
            if (add_player($conn, $teamId, $playerName, $position, $matches, $points, $assists, $rating, $isInjured)) {
                log_activity($conn, 'Added player "' . $playerName . '" to team #' . $teamId);
                set_flash('success', 'Player "' . $playerName . '" added to squad successfully.');
                redirect('index.php?page=coach&action=performance');
            }
            $error = 'Could not add the player.';
        }
    }

    if ($action === 'player_update' && is_post()) {
        csrf_check();

        $id         = (int)($_GET['id']            ?? 0);
        $playerName = trim($_POST['player_name']   ?? '');
        $position   = trim($_POST['position']      ?? '');
        $isInjured  = isset($_POST['is_injured']) ? 1 : 0;

        if (update_player($conn, $id, $playerName, $position, $isInjured)) {
            log_activity($conn, 'Updated player #' . $id . ': ' . $playerName);
            set_flash('success', 'Player details updated.');
            redirect('index.php?page=coach&action=performance');
        }
        $error = 'Could not update that player.';
    }

    if ($action === 'player_delete') {
        csrf_check();
        $id = (int)($_GET['id'] ?? 0);
        if ($id > 0 && delete_player($conn, $id)) {
            log_activity($conn, 'Removed player #' . $id);
            set_flash('success', 'Player removed from squad.');
        } else {
            set_flash('error', 'Could not remove that player.');
        }
        redirect('index.php?page=coach&action=performance');
    }

    if ($action === 'save_strategy' && is_post()) {
        csrf_check();
        $formation = trim($_POST['formation'] ?? '4-3-3');
        $mentality = trim($_POST['mentality'] ?? 'High Press');
        $captain   = trim($_POST['captain']   ?? 'Jamal Bhuyan');
        $notes     = trim($_POST['notes']     ?? '');

        $_SESSION['coach_strategy'] = [
            'formation' => $formation,
            'mentality' => $mentality,
            'captain'   => $captain,
            'notes'     => $notes,
            'updated_at'=> date('Y-m-d H:i:s')
        ];
        log_activity($conn, 'Updated match strategy & formation (' . $formation . ')');
        set_flash('success', 'Match strategy and starting formation updated successfully!');
        redirect('index.php?page=coach&action=lineups');
    }

    $coachEmail  = $me['email'] ?? '';
    $myTeams     = get_teams_by_coach($conn, $coachEmail);
    $tournaments = get_tournaments($conn);

    $myPlayers = [];
    foreach ($myTeams as $t) {
        $myPlayers[$t['id']] = get_players_by_team($conn, $t['id']);
    }

    $selectedTeamId = (int)($_GET['team_id'] ?? 0);
    $activeTeam = null;
    if ($selectedTeamId > 0) {
        foreach ($myTeams as $t) {
            if ((int)$t['id'] === $selectedTeamId) {
                $activeTeam = $t;
                break;
            }
        }
    }
    if (!$activeTeam) {
        foreach ($myTeams as $t) {
            if (!empty($myPlayers[$t['id']])) {
                $activeTeam = $t;
                break;
            }
        }
    }
    if (!$activeTeam && !empty($myTeams)) {
        $activeTeam = $myTeams[0];
    }
    $teamPlayers = $activeTeam ? ($myPlayers[$activeTeam['id']] ?? []) : [];

    $totalSquad    = count($teamPlayers);
    $injuredCount  = 0;
    $topRating     = 0;
    $topRatedPlayer= null;
    $topScorer     = null;
    $topPoints     = -1;
    $topAssister   = null;
    $topAssists    = -1;

    foreach ($teamPlayers as $p) {
        if (!empty($p['is_injured'])) {
            $injuredCount++;
        }
        if ((float)$p['rating'] > $topRating) {
            $topRating = (float)$p['rating'];
            $topRatedPlayer = $p;
        }
        if ((int)$p['points'] > $topPoints) {
            $topPoints = (int)$p['points'];
            $topScorer = $p;
        }
        if ((int)$p['assists'] > $topAssists) {
            $topAssists = (int)$p['assists'];
            $topAssister = $p;
        }
    }

    $fitCount     = max(0, $totalSquad - $injuredCount);
    $readinessPct = $totalSquad > 0 ? round(($fitCount / $totalSquad) * 100) : 100;

    if (empty($_SESSION['coach_strategy'])) {
        $_SESSION['coach_strategy'] = [
            'formation' => '4-3-3',
            'mentality' => 'High Press & Quick Transitions',
            'captain'   => $teamPlayers[0]['player_name'] ?? 'Jamal Bhuyan',
            'notes'     => 'Focus on high defensive pressing, swift wing transitions, and maintaining compact defensive shapes during opposition possession.',
            'updated_at'=> date('Y-m-d H:i')
        ];
    }
    $strategy = $_SESSION['coach_strategy'];

    if ($action === 'performance') {
        require __DIR__ . '/../views/coach/performance.php';
    } elseif ($action === 'lineups') {
        require __DIR__ . '/../views/coach/lineups.php';
    } else {

        require __DIR__ . '/../views/coach/registration.php';
    }
}

<?php

function admin_controller($conn) {
    $action     = $_GET['action'] ?? 'dashboard';
    $me         = current_user();

    $error   = '';
    $editing = null;

    $roles    = ['admin', 'coach', 'employee', 'spectator'];
    $statuses = ['active', 'suspended'];

    if ($action === 'user_add' && is_post()) {
        csrf_check();

        $full_name = trim($_POST['full_name'] ?? '');
        $username  = trim($_POST['username']  ?? '');
        $email     = trim($_POST['email']     ?? '');
        $password  = $_POST['password']       ?? '';
        $role      = $_POST['role']           ?? '';

        if (is_blank($full_name) || is_blank($username) || is_blank($email) || is_blank($password)) {
            $error = 'Fill in every field.';
        } elseif (!in_array($role, $roles, true)) {
            $error = 'Choose a valid role.';
        } elseif (!preg_match('/^[A-Za-z0-9_]{4,20}$/', $username)) {
            $error = 'Username must be 4-20 letters, numbers or underscores.';
        } elseif (!valid_email($email)) {
            $error = 'Enter a valid email address.';
        } elseif (strlen($password) < 6) {
            $error = 'Password must be at least 6 characters.';
        } elseif (username_exists($conn, $username)) {
            $error = 'That username is already taken.';
        } elseif (email_exists($conn, $email)) {
            $error = 'That email is already registered.';
        } else {
            if (create_user($conn, $full_name, $username, $email, $password, $role)) {
                log_activity($conn, 'Admin created ' . $role . ' account: ' . $username);
                set_flash('success', 'Account created successfully.');
                redirect('index.php?page=admin');
            }
            $error = 'Could not create the account.';
        }
    }

    if ($action === 'user_update' && is_post()) {
        csrf_check();

        $id        = (int)($_GET['id'] ?? 0);
        $full_name = trim($_POST['full_name'] ?? '');
        $username  = trim($_POST['username']  ?? '');
        $email     = trim($_POST['email']     ?? '');
        $password  = $_POST['password']       ?? '';
        $role      = $_POST['role']           ?? '';
        $status    = $_POST['status']         ?? 'active';

        $editing = ['id' => $id, 'full_name' => $full_name, 'username' => $username,
                    'email' => $email, 'role' => $role, 'status' => $status];

        if (is_blank($full_name) || is_blank($username) || is_blank($email)) {
            $error = 'No field can be left empty. All fields are required.';
        } elseif (!in_array($role, $roles, true) || !in_array($status, $statuses, true)) {
            $error = 'Choose a valid role and status.';
        } elseif (!valid_email($email)) {
            $error = 'Enter a valid email address.';
        } elseif (username_exists($conn, $username, $id)) {
            $error = 'Another account already uses that username.';
        } elseif ($password !== '' && strlen($password) < 6) {
            $error = 'Password must be at least 6 characters (or leave blank to keep current).';
        } elseif ($id === (int)$me['id'] && ($role !== 'admin' || $status !== 'active')) {
            $error = 'You cannot remove your own admin access.';
        } else {
            if (update_user($conn, $id, $full_name, $username, $email, $role, $status)) {
                if ($password !== '') {
                    update_password($conn, $id, $password);
                }
                log_activity($conn, 'Updated account #' . $id . ' (' . $username . ')');
                set_flash('success', 'Account updated.');
                redirect('index.php?page=admin');
            }
            $error = 'Update failed.';
        }
    }

    if ($action === 'user_edit' && !$editing) {
        $editing = get_user($conn, (int)($_GET['id'] ?? 0));
        if (!$editing) {
            set_flash('error', 'That account no longer exists.');
            redirect('index.php?page=admin');
        }
    }

    if ($action === 'user_delete') {
        csrf_check();
        $id = (int)($_GET['id'] ?? 0);

        if ($id === (int)$me['id']) {
            set_flash('error', 'You cannot delete your own account.');
        } elseif ($id > 0 && delete_user($conn, $id)) {
            log_activity($conn, 'Deleted account #' . $id);
            set_flash('success', 'Account deleted.');
        } else {
            set_flash('error', 'Could not delete that account.');
        }
        redirect('index.php?page=admin&action=analytics');
    }

    if ($action === 'user_status') {
        csrf_check();
        $id     = (int)($_GET['id'] ?? 0);
        $status = $_GET['status'] ?? $_GET['to'] ?? '';

        if ($id === (int)$me['id']) {
            set_flash('error', 'You cannot suspend your own account.');
        } elseif (in_array($status, $statuses, true) && set_user_status($conn, $id, $status)) {
            log_activity($conn, 'Set account #' . $id . ' to ' . $status);
            set_flash('success', 'Account is now ' . $status . '.');
        } else {
            set_flash('error', 'Could not update that account.');
        }
        redirect('index.php?page=admin&action=analytics');
    }

    if ($action === 'tournament_add' && is_post()) {
        csrf_check();

        $name      = trim($_POST['t_name']     ?? '');
        $type      = trim($_POST['t_type']     ?? '');
        $tstatus   = trim($_POST['t_status']   ?? 'Upcoming');
        $startDate = trim($_POST['start_date'] ?? '');
        $endDate   = trim($_POST['end_date']   ?? '');

        $allowedTypes    = ['League', 'Knockout', 'Group+Knockout'];
        $allowedStatuses = ['Upcoming', 'Ongoing', 'Completed'];

        if (is_blank($name) || is_blank($type) || is_blank($startDate) || is_blank($endDate)) {
            $error = 'Fill in every field.';
        } elseif (!in_array($type, $allowedTypes, true)) {
            $error = 'Choose a valid tournament type.';
        } elseif (!in_array($tstatus, $allowedStatuses, true)) {
            $error = 'Choose a valid status.';
        } elseif ($startDate > $endDate) {
            $error = 'End date must be after start date.';
        } else {
            if (add_tournament($conn, $name, $type, $tstatus, $startDate, $endDate)) {
                log_activity($conn, 'Created tournament: ' . $name);
                set_flash('success', 'Tournament created successfully.');
                redirect('index.php?page=admin&action=tournaments');
            }
            $error = 'Could not create the tournament.';
        }
    }

    if ($action === 'tournament_delete') {
        csrf_check();
        $id = (int)($_GET['id'] ?? 0);
        if ($id > 0 && delete_tournament($conn, $id)) {
            log_activity($conn, 'Deleted tournament #' . $id);
            set_flash('success', 'Tournament deleted.');
        } else {
            set_flash('error', 'Could not delete that tournament.');
        }
        redirect('index.php?page=admin&action=tournaments');
    }

    if ($action === 'reschedule_match' && is_post()) {
        csrf_check();
        $newVenue = trim($_POST['new_venue'] ?? '');
        $newDate  = trim($_POST['new_date']  ?? '');
        $newTime  = trim($_POST['new_time']  ?? '');

        if (is_blank($newVenue) || is_blank($newDate) || is_blank($newTime)) {
            set_flash('error', 'Please provide a new venue, date, and kick-off time.');
        } else {
            $formattedTime = date("d M Y", strtotime($newDate)) . ', ' . date("h:i A", strtotime($newTime));
            $_SESSION['rescheduled_fixture'] = [
                'venue' => $newVenue,
                'time'  => $formattedTime,
                'resolved' => true
            ];
            log_activity($conn, 'Admin rescheduled match (Abahani vs Mohammedan) to ' . $newVenue . ' on ' . $formattedTime);
            set_flash('success', 'Match successfully rescheduled to ' . $newVenue . ' (' . $formattedTime . '). Venue conflict resolved.');
        }
        redirect('index.php?page=admin');
    }

    if ($action === 'reset_reschedule') {
        csrf_check();
        unset($_SESSION['rescheduled_fixture']);
        set_flash('info', 'Venue schedule reset to default.');
        redirect('index.php?page=admin');
    }

    if ($action === 'tournaments' || $action === 'tournament_add') {
        $tournaments = get_tournaments($conn);
        require __DIR__ . '/../views/admin/tournaments.php';
        return;
    }

    if ($action === 'analytics') {
        $roleFilter = $_GET['role'] ?? '';
        if (!in_array($roleFilter, $roles, true)) {
            $roleFilter = '';
        }
        $users       = get_users($conn, $roleFilter);
        $tournaments = get_tournaments($conn);
        $stats       = get_system_stats($conn);
        require __DIR__ . '/../views/admin/analytics.php';
        return;
    }

    if ($action === 'logs') {
        $searchQuery = trim($_GET['q'] ?? '');
        if (!empty($searchQuery)) {
            $logs = search_logs($conn, $searchQuery, 100);
        } else {
            $logs = get_logs($conn, 50);
        }
        require __DIR__ . '/../views/admin/logs.php';
        return;
    }

    $tournaments = get_tournaments($conn);
    require __DIR__ . '/../views/admin/dashboard.php';
}

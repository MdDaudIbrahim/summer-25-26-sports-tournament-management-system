<?php

function employee_controller($conn) {
    $action = $_GET['action'] ?? 'dashboard';
    $me     = current_user();

    $error   = '';
    $editing = null;

    if ($action === 'venue_add' && is_post()) {
        csrf_check();

        $venueName = trim($_POST['venue_name'] ?? '');
        $city      = trim($_POST['city']       ?? '');

        if (is_blank($venueName) || is_blank($city)) {
            $error = 'Fill in every field.';
        } else {
            if (add_venue($conn, $venueName, $city)) {
                log_activity($conn, 'Added venue: ' . $venueName . ', ' . $city);
                set_flash('success', 'Venue added successfully.');
                redirect('index.php?page=employee');
            }
            $error = 'Could not add the venue.';
        }
    }

    if ($action === 'venue_update' && is_post()) {
        csrf_check();

        $id          = (int)($_GET['id']             ?? 0);
        $venueName   = trim($_POST['venue_name']     ?? '');
        $city        = trim($_POST['city']           ?? '');
        $cleaningPct = (int)($_POST['cleaning_pct'] ?? 80);
        $seatingPct  = (int)($_POST['seating_pct']  ?? 100);

        if (is_blank($venueName) || is_blank($city)) {
            $error = 'No field can be left empty.';
        } elseif ($cleaningPct < 0 || $cleaningPct > 100 || $seatingPct < 0 || $seatingPct > 100) {
            $error = 'Percentage values must be between 0 and 100.';
        } else {
            if (update_venue($conn, $id, $venueName, $city, $cleaningPct, $seatingPct)) {
                log_activity($conn, 'Updated venue #' . $id . ': ' . $venueName);
                set_flash('success', 'Venue updated.');
                redirect('index.php?page=employee');
            }
            $error = 'Update failed.';
        }
    }

    if ($action === 'venue_edit' && !$editing) {
        $editing = get_venue($conn, (int)($_GET['id'] ?? 0));
        if (!$editing) {
            set_flash('error', 'That venue no longer exists.');
            redirect('index.php?page=employee');
        }
    }

    if ($action === 'venue_delete') {
        csrf_check();
        $id = (int)($_GET['id'] ?? 0);
        if ($id > 0 && delete_venue($conn, $id)) {
            log_activity($conn, 'Deleted venue #' . $id);
            set_flash('success', 'Venue removed.');
        } else {
            set_flash('error', 'Could not delete that venue.');
        }
        redirect('index.php?page=employee');
    }

    if ($action === 'task_add' && is_post()) {
        csrf_check();

        $taskTitle  = trim($_POST['task_title'] ?? '');
        $isUrgent   = isset($_POST['is_urgent']) ? 1 : 0;
        $staffName  = $me['full_name'] ?? 'Staff';

        if (is_blank($taskTitle)) {
            $error = 'Task title is required.';
        } else {
            if (add_task($conn, $taskTitle, $isUrgent, $staffName)) {
                log_activity($conn, 'Added task: ' . $taskTitle);
                set_flash('success', 'Task added to checklist.');
                redirect('index.php?page=employee&action=tasks');
            }
            $error = 'Could not add the task.';
        }
    }

    if ($action === 'task_toggle') {
        csrf_check();
        $id = (int)($_GET['id'] ?? 0);
        if ($id > 0 && toggle_task($conn, $id)) {
            log_activity($conn, 'Toggled task #' . $id);
            set_flash('success', 'Task status updated.');
        }
        redirect('index.php?page=employee&action=tasks');
    }

    if ($action === 'task_delete') {
        csrf_check();
        $id = (int)($_GET['id'] ?? 0);
        if ($id > 0 && delete_task($conn, $id)) {
            log_activity($conn, 'Deleted task #' . $id);
            set_flash('success', 'Task removed.');
        }
        redirect('index.php?page=employee&action=tasks');
    }

    if ($action === 'incident_add' && is_post()) {
        csrf_check();

        $problemType  = trim($_POST['problem_type']  ?? '');
        $locationArea = trim($_POST['location_area'] ?? '');
        $description  = trim($_POST['description']   ?? '');
        $staffName    = $me['full_name'] ?? 'Staff';

        $allowedTypes = ['Field Damage', 'Equipment Failure', 'Safety Hazard',
                         'Lighting Issue', 'Plumbing Issue', 'Seating Damage', 'Other'];

        if (is_blank($problemType) || is_blank($locationArea) || is_blank($description)) {
            $error = 'Fill in every field.';
        } elseif (!in_array($problemType, $allowedTypes, true)) {
            $error = 'Choose a valid problem type.';
        } else {
            if (add_incident($conn, $problemType, $locationArea, $description, $staffName)) {
                log_activity($conn, 'Reported incident: ' . $problemType . ' at ' . $locationArea);
                set_flash('success', 'Incident report submitted successfully.');
                redirect('index.php?page=employee&action=incidents');
            }
            $error = 'Could not submit the incident report.';
        }
    }

    if ($action === 'incident_status') {
        csrf_check();
        $id = (int)($_GET['id'] ?? 0);
        $status = $_GET['status'] ?? 'Resolved';
        $allowed = ['Pending', 'In Progress', 'Resolved'];
        if ($id > 0 && in_array($status, $allowed, true) && update_incident_status($conn, $id, $status)) {
            log_activity($conn, 'Updated incident #' . $id . ' to ' . $status);
            set_flash('success', 'Incident status updated to ' . $status . '.');
        }
        redirect('index.php?page=employee&action=incidents');
    }

    if ($action === 'equipment_add' && is_post()) {
        csrf_check();

        $itemName = trim($_POST['item_name'] ?? '');
        $quantity = (int)($_POST['quantity'] ?? 0);
        $status   = $_POST['equip_status']   ?? 'Available';

        $allowedStatus = ['Available', 'Low Stock', 'Out of Stock'];

        if (is_blank($itemName)) {
            $error = 'Item name is required.';
        } elseif ($quantity < 0) {
            $error = 'Quantity cannot be negative.';
        } elseif (!in_array($status, $allowedStatus, true)) {
            $error = 'Choose a valid status.';
        } else {
            if (add_equipment($conn, $itemName, $quantity, $status)) {
                log_activity($conn, 'Added equipment: ' . $itemName . ' (qty: ' . $quantity . ')');
                set_flash('success', 'Equipment added to inventory.');
                redirect('index.php?page=employee');
            }
            $error = 'Could not add equipment.';
        }
    }

    if ($action === 'equipment_delete') {
        csrf_check();
        $id = (int)($_GET['id'] ?? 0);
        if ($id > 0 && delete_equipment($conn, $id)) {
            log_activity($conn, 'Deleted equipment #' . $id);
            set_flash('success', 'Equipment removed.');
        }
        redirect('index.php?page=employee');
    }

    $venues    = get_venues($conn);
    $equipment = get_equipment($conn);
    $tasks     = get_tasks($conn);
    $incidents = get_incidents($conn);

    $totalCleaning = 0;
    $totalSeating = 0;
    foreach ($venues as $v) {
        $totalCleaning += (int)($v['field_cleaning_pct'] ?? 80);
        $totalSeating += (int)($v['seating_pct'] ?? 100);
    }
    $avgCleaning = count($venues) > 0 ? round($totalCleaning / count($venues)) : 85;
    $avgSeating = count($venues) > 0 ? round($totalSeating / count($venues)) : 95;

    $completedTasks = 0;
    $urgentTasks = 0;
    foreach ($tasks as $t) {
        if (!empty($t['is_completed'])) $completedTasks++;
        elseif (!empty($t['is_urgent'])) $urgentTasks++;
    }

    $pendingIncidents = 0;
    $resolvedIncidents = 0;
    foreach ($incidents as $inc) {
        if (($inc['status'] ?? '') === 'Resolved') $resolvedIncidents++;
        else $pendingIncidents++;
    }

    if ($action === 'tasks') {
        require __DIR__ . '/../views/employee/tasks.php';
    } elseif ($action === 'incidents') {
        require __DIR__ . '/../views/employee/incidents.php';
    } else {

        require __DIR__ . '/../views/employee/venues.php';
    }
}

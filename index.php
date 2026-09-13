<?php
require_once __DIR__ . '/config/config.php';
require_once __DIR__ . '/helpers/helpers.php';

require_once __DIR__ . '/models/user_model.php';
require_once __DIR__ . '/models/log_model.php';
require_once __DIR__ . '/models/tournament_model.php';
require_once __DIR__ . '/models/team_model.php';
require_once __DIR__ . '/models/player_model.php';
require_once __DIR__ . '/models/employee_model.php';
require_once __DIR__ . '/models/ticket_model.php';
require_once __DIR__ . '/models/prediction_model.php';

require_once __DIR__ . '/controllers/auth_controller.php';
require_once __DIR__ . '/controllers/admin_controller.php';
require_once __DIR__ . '/controllers/coach_controller.php';
require_once __DIR__ . '/controllers/employee_controller.php';
require_once __DIR__ . '/controllers/spectator_controller.php';
require_once __DIR__ . '/controllers/ajax_controller.php';

check_session_timeout();

$page = $_GET['page'] ?? 'login';

switch ($page) {
    case 'login':
        login_controller($conn);
        break;

    case 'register':
        register_controller($conn);
        break;

    case 'forgot_password':
        forgot_password_controller($conn);
        break;

    case 'logout':
        logout_controller($conn);
        break;

    case 'ajax':
        ajax_controller($conn);
        break;

    case 'admin':
        require_role('admin');
        admin_controller($conn);
        break;

    case 'coach':
        require_role('coach');
        coach_controller($conn);
        break;

    case 'employee':
        require_role('employee');
        employee_controller($conn);
        break;

    case 'spectator':
        require_role('spectator');
        spectator_controller($conn);
        break;

    default:
        redirect('index.php?page=login');
}

mysqli_close($conn);

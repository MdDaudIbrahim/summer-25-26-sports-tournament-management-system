<?php

function login_controller($conn) {
        if (is_logged_in()) {
        redirect('index.php?page=' . current_role());
    }

    $error  = '';
    $prefill = $_COOKIE['remember_user'] ?? '';

    if (is_post()) {
        csrf_check();

        $username = trim($_POST['username'] ?? '');
        $password = $_POST['password'] ?? '';
        $remember = isset($_POST['remember']);

                if (is_blank($username) || is_blank($password)) {
            $error = 'Enter both your username and password.';
        } else {
            $user = find_user_by_username($conn, $username);

                                    if (!$user || !password_verify($password, $user['password'])) {
                $error = 'Wrong username or password.';
            } elseif ($user['status'] === 'suspended') {
                $error = 'This account is suspended. Please contact the administrator.';
            } else {
                                session_regenerate_id(true);

                $_SESSION['user'] = [
                    'id'         => (int)$user['id'],
                    'full_name'  => $user['full_name'],
                    'username'   => $user['username'],
                    'email'      => $user['email'],
                    'role'       => $user['role'],
                    'created_at' => $user['created_at'],
                ];
                $_SESSION['last_active'] = time();

                if ($remember) {
                    setcookie('remember_user', $username, [
                        'expires'  => time() + 60 * 60 * 24 * 30,
                        'path'     => '/',
                        'httponly' => true,
                        'samesite' => 'Lax',
                    ]);
                } else {
                    setcookie('remember_user', '', time() - 3600, '/');
                }

                log_activity($conn, 'Signed in');
                redirect('index.php?page=' . $user['role']);
            }
        }
    }

    require __DIR__ . '/../views/auth/login.php';
}

function register_controller($conn) {
    if (is_logged_in()) {
        redirect('index.php?page=' . current_role());
    }

    $error = '';
    $old   = ['full_name' => '', 'username' => '', 'email' => '', 'role' => 'spectator'];

    if (is_post()) {
        csrf_check();

        $full_name = trim($_POST['full_name'] ?? '');
        $username  = trim($_POST['username']  ?? '');
        $email     = trim($_POST['email']     ?? '');
        $password  = $_POST['password']       ?? '';
        $confirm   = $_POST['confirm_password'] ?? '';
        $role      = $_POST['role']            ?? '';

        $old = compact('full_name', 'username', 'email', 'role');

        $allowedRoles = ['coach', 'employee', 'spectator'];

                if (is_blank($full_name) || is_blank($username) || is_blank($email) || is_blank($password)) {
            $error = 'Fill in every field.';
        } elseif (!in_array($role, $allowedRoles, true)) {
            $error = 'Choose a valid account type.';
        } elseif (strlen($full_name) < 3) {
            $error = 'Full name must be at least 3 characters.';
        } elseif (!preg_match('/^[A-Za-z0-9_]{4,20}$/', $username)) {
            $error = 'Username must be 4-20 letters, numbers or underscores.';
        } elseif (!valid_email($email)) {
            $error = 'Enter a valid email address.';
        } elseif (strlen($password) < 6) {
            $error = 'Password must be at least 6 characters.';
        } elseif ($password !== $confirm) {
            $error = 'The two passwords do not match.';
        } elseif (username_exists($conn, $username)) {
            $error = 'That username is already taken.';
        } elseif (email_exists($conn, $email)) {
            $error = 'That email is already registered.';
        } else {
            if (create_user($conn, $full_name, $username, $email, $password, $role)) {
                log_activity($conn, 'New ' . $role . ' account registered: ' . $username);
                set_flash('success', 'Account created successfully! You can sign in now.');
                redirect('index.php?page=login');
            }
            $error = 'Could not create the account. Please try again.';
        }
    }

    require __DIR__ . '/../views/auth/register.php';
}

function logout_controller($conn) {
    if (is_logged_in()) {
        log_activity($conn, 'Signed out');
    }
    $_SESSION = [];
    session_regenerate_id(true);
    session_destroy();
    setcookie('remember_user', '', time() - 3600, '/');
    session_start();
    set_flash('success', 'You have been signed out.');
    redirect('index.php?page=login');
}

function forgot_password_controller($conn) {
    if (is_logged_in()) {
        redirect('index.php?page=' . current_role());
    }

    $error = '';
    $prefillIdentifier = '';

    if (is_post()) {
        csrf_check();

        $identifier       = trim($_POST['identifier'] ?? '');
        $new_password     = $_POST['new_password'] ?? '';
        $confirm_password = $_POST['confirm_password'] ?? '';
        $prefillIdentifier = $identifier;

        if (is_blank($identifier) || is_blank($new_password) || is_blank($confirm_password)) {
            $error = 'Please fill in all fields.';
        } elseif (strlen($new_password) < 6) {
            $error = 'Password must be at least 6 characters.';
        } elseif ($new_password !== $confirm_password) {
            $error = 'Passwords do not match.';
        } else {
            $user = find_user_by_username($conn, $identifier);
            if (!$user) {
                $error = 'No account found with that username or email.';
            } elseif ($user['status'] === 'suspended') {
                $error = 'This account is suspended. Please contact the administrator.';
            } else {
                if (update_password($conn, (int)$user['id'], $new_password)) {
                    log_activity($conn, 'Password reset for account: ' . $user['username']);
                    set_flash('success', 'Password reset successfully! Please log in with your new password.');
                    redirect('index.php?page=login');
                } else {
                    $error = 'Could not update password. Please try again.';
                }
            }
        }
    }

    require __DIR__ . '/../views/auth/forgot_password.php';
}

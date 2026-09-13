<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Tournament Pro - Reset Password</title>
  <link rel="stylesheet" type="text/css" href="<?= BASE_URL ?>/assets/css/style.css">
  <link rel="stylesheet" type="text/css" href="<?= BASE_URL ?>/assets/css/components.css">
</head>
<body class="bg-auth-pattern">

  <main class="auth-card">
    <header class="brand-header">
      <div class="brand-logo-icon">
        <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
          <rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect>
          <path d="M7 11V7a5 5 0 0 1 10 0v4"></path>
        </svg>
      </div>
      <h1>Reset Password</h1>
      <p>Enter your account username or email and choose a new password</p>
    </header>

    <?php if (!empty($error)): ?>
      <div class="alert alert-danger" style="margin-bottom: 16px;">
        <span><?= esc($error) ?></span>
      </div>
    <?php endif; ?>

    <?php foreach (get_flash() as $flash): ?>
      <div class="alert alert-<?= esc($flash['type']) ?>" style="margin-bottom: 16px;">
        <span><?= esc($flash['message']) ?></span>
      </div>
    <?php endforeach; ?>

    <form action="index.php?page=forgot_password" method="POST" id="resetForm" novalidate>
      <?php csrf_field(); ?>

      <div class="form-group">
        <label for="identifier">Username or Registered Email</label>
        <div class="input-wrapper">
          <span class="input-icon">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
              <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"></path>
              <polyline points="22,6 12,13 2,6"></polyline>
            </svg>
          </span>
          <input type="text" id="identifier" name="identifier" class="form-control input-with-icon" value="<?= esc($prefillIdentifier ?? '') ?>" placeholder="e.g. coach1 or coach@tournamentpro.com" required autofocus>
        </div>
        <span class="error-msg" id="identifierError"></span>
      </div>

      <div class="form-group">
        <label for="new_password">New Password</label>
        <div class="input-wrapper">
          <span class="input-icon">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
              <rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect>
              <path d="M7 11V7a5 5 0 0 1 10 0v4"></path>
            </svg>
          </span>
          <input type="password" id="new_password" name="new_password" class="form-control input-with-icon" placeholder="At least 6 characters" required>
        </div>
        <span class="error-msg" id="newPasswordError"></span>
      </div>

      <div class="form-group">
        <label for="confirm_password">Confirm New Password</label>
        <div class="input-wrapper">
          <span class="input-icon">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
              <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path>
              <polyline points="22 4 12 14.01 9 11.01"></polyline>
            </svg>
          </span>
          <input type="password" id="confirm_password" name="confirm_password" class="form-control input-with-icon" placeholder="Re-type new password" required>
        </div>
        <span class="error-msg" id="confirmPasswordError"></span>
      </div>

      <button type="submit" class="btn btn-primary btn-full" style="padding: 12px; text-transform: uppercase; letter-spacing: 0.05em; margin-top: 8px;">
        Update Password
      </button>
    </form>

    <p class="text-center" style="margin-top: 24px; font-size: 13px;">
      Remember your password? 
      <a href="index.php?page=login" style="font-weight: 600;">Back to Log In</a>
    </p>
  </main>

  <script>
    document.getElementById('resetForm').addEventListener('submit', function(e) {
      var id = document.getElementById('identifier').value.trim();
      var p1 = document.getElementById('new_password').value;
      var p2 = document.getElementById('confirm_password').value;
      var valid = true;

      document.getElementById('identifierError').textContent = '';
      document.getElementById('newPasswordError').textContent = '';
      document.getElementById('confirmPasswordError').textContent = '';

      if (!id) {
        document.getElementById('identifierError').textContent = 'Please enter your username or email.';
        valid = false;
      }
      if (p1.length < 6) {
        document.getElementById('newPasswordError').textContent = 'Password must be at least 6 characters.';
        valid = false;
      }
      if (p1 !== p2) {
        document.getElementById('confirmPasswordError').textContent = 'Passwords do not match.';
        valid = false;
      }

      if (!valid) {
        e.preventDefault();
      }
    });
  </script>
</body>
</html>

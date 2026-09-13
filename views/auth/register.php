<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Tournament Pro - Registration</title>
  <!-- styles -->
  <link rel="stylesheet" type="text/css" href="<?= BASE_URL ?>/assets/css/style.css">
  <link rel="stylesheet" type="text/css" href="<?= BASE_URL ?>/assets/css/components.css">
</head>
<body class="bg-auth-pattern">

  <main class="auth-card">
    <!-- Brand Header -->
    <header class="brand-header">
      <div class="brand-logo-icon">
        <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
          <path d="M6 9H4.5a2.5 2.5 0 0 1 0-5H6"></path>
          <path d="M18 9h1.5a2.5 2.5 0 0 0 0-5H18"></path>
          <path d="M4 22h16"></path>
          <path d="M10 14.66V17c0 .55-.45 1-1 1H7v4h10v-4h-2c-.55 0-1-.45-1-1v-2.34"></path>
          <path d="M18 4H6v7a6 6 0 0 0 12 0V4z"></path>
        </svg>
      </div>
      <h1>Tournament Pro</h1>
      <p>Create your account</p>
    </header>

    <?php

if (!empty($error)): ?>
      <div class="alert alert-danger" style="margin-bottom: 16px;">
        <span><?= esc($error) ?></span>
      </div>
    <?php
endif; ?>

    <!-- Registration Form -->
    <form action="index.php?page=register" method="POST" id="registrationForm" novalidate>
      <?php
csrf_field(); ?>

      <!-- Full Name -->
      <div class="form-group">
        <label for="name">Full Name</label>
        <input type="text" id="name" name="full_name" class="form-control" value="<?= esc($old['full_name'] ?? '') ?>" placeholder="e.g. Jamal Bhuyan" required>
        <span class="error-msg" id="nameError"></span>
      </div>

      <!-- Username -->
      <div class="form-group">
        <label for="username">Username</label>
        <input type="text" id="username" name="username" class="form-control" value="<?= esc($old['username'] ?? '') ?>" placeholder="e.g. jamal10" required>
      </div>

      <!-- Email Address -->
      <div class="form-group">
        <label for="email">Email Address</label>
        <input type="email" id="email" name="email" class="form-control" value="<?= esc($old['email'] ?? '') ?>" placeholder="coach@tournamentpro.com" required>
        <span class="error-msg" id="emailError"></span>
      </div>

      <!-- Role Selection -->
      <div class="form-group">
        <label for="role">Role</label>
        <select id="role" name="role" class="form-control" required>
          <option value="" disabled <?= empty($old['role']) ? 'selected' : '' ?>>Select your role</option>
          <option value="coach" <?= (($old['role'] ?? '') === 'coach') ? 'selected' : '' ?>>Coach</option>
          <option value="employee" <?= (($old['role'] ?? '') === 'employee') ? 'selected' : '' ?>>Employee</option>
          <option value="spectator" <?= (($old['role'] ?? '') === 'spectator') ? 'selected' : '' ?>>Spectator</option>
        </select>
        <span class="error-msg" id="roleError"></span>
      </div>

      <!-- Password -->
      <div class="form-group">
        <label for="password">Password</label>
<<<<<<< HEAD
        <input type="password" id="password" name="password" class="form-control" placeholder="••••••••" maxlength="64" required>
        <span class="error-msg" id="passwordError"></span>
      </div>

      <!-- Confirm Password -->
      <div class="form-group">
        <label for="confirm_password">Confirm Password</label>
        <input type="password" id="confirm_password" name="confirm_password" class="form-control" placeholder="••••••••" maxlength="64" required>
        <span class="error-msg" id="confirmError"></span>
      </div>

      <!-- Terms and Conditions -->
      <div class="form-group" style="margin-bottom: 20px;">
        <label class="form-checkbox" for="terms">
          <input type="checkbox" id="terms" name="terms" required checked>
          <span>I agree to the <a href="javascript:void(0)" onclick="alert('Terms of Service: All sports tournament data and rules apply under standard fair play policy.')">Terms of Service</a> and <a href="javascript:void(0)" onclick="alert('Privacy Policy: User data is securely stored and never shared with third parties.')">Privacy Policy</a></span>
        </label>
        <span class="error-msg" id="termsError"></span>
      </div>

      <!-- Submit Button -->
      <button type="submit" name="submit_registration" class="btn btn-primary btn-full" style="padding: 12px; font-size: 14px;">
        Create Account 
        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
          <line x1="5" y1="12" x2="19" y2="12"></line>
          <polyline points="12 5 19 12 12 19"></polyline>
        </svg>
      </button>
    </form>

    <!-- Login Link -->
    <p class="text-center" style="margin-top: 20px; font-size: 13px;">
      Already have an account? 
      <a href="index.php?page=login" style="font-weight: 600;">Log in</a>
    </p>
  </main>

  <!-- Local JavaScript Validation -->
  <script src="<?= BASE_URL ?>/assets/js/validation.js"></script>
</body>
</html>

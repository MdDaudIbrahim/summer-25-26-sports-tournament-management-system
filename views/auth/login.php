<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Tournament Pro - Log In</title>
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
      <p>Log in to manage your leagues</p>
    </header>

    <?php

if (!empty($error)): ?>
      <div class="alert alert-danger" style="margin-bottom: 16px;">
        <span><?= esc($error) ?></span>
      </div>
    <?php
endif; ?>

    <?php
foreach (get_flash() as $flash): ?>
      <div class="alert alert-<?= esc($flash['type']) ?>" style="margin-bottom: 16px;">
        <span><?= esc($flash['message']) ?></span>
      </div>
    <?php
endforeach; ?>

    <!-- Login Form -->
    <form action="index.php?page=login" method="POST" id="loginForm" novalidate>
      <?php
csrf_field(); ?>

      <!-- Username / Email Field -->
      <div class="form-group">
        <label for="email">Username or Email</label>
        <div class="input-wrapper">
          <span class="input-icon">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
              <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"></path>
              <polyline points="22,6 12,13 2,6"></polyline>
            </svg>
          </span>
          <input type="text" id="email" name="username" class="form-control input-with-icon" value="<?= esc($prefill ?? '') ?>" placeholder="admin or admin@tournamentpro.com" required autofocus>
        </div>
        <span class="error-msg" id="emailError"></span>
      </div>

      <!-- Password Field -->
      <div class="form-group">
        <label for="password">Password</label>
        <div class="input-wrapper">
          <span class="input-icon">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
              <rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect>
              <path d="M7 11V7a5 5 0 0 1 10 0v4"></path>
            </svg>
          </span>
          <input type="password" id="password" name="password" class="form-control input-with-icon" placeholder="••••••••" maxlength="64" required>
        </div>
        <span class="error-msg" id="passwordError"></span>
      </div>

      <!-- Remember Me & Forgot Password -->
      <div class="flex items-center justify-between" style="margin-bottom: 20px;">
        <label class="form-checkbox" for="remember">
          <input type="checkbox" id="remember" name="remember">
          <span>Remember me</span>
        </label>
        <a href="index.php?page=forgot_password" style="font-size: 12px; font-weight: 600;">Forgot password?</a>
      </div>

      <!-- Submit Button -->
      <button type="submit" class="btn btn-primary btn-full" style="padding: 12px; text-transform: uppercase; letter-spacing: 0.05em;">
        Log In
      </button>
    </form>

    <!-- Registration Link -->
    <p class="text-center" style="margin-top: 24px; font-size: 13px;">
      Don't have an account? 
      <a href="index.php?page=register" style="font-weight: 600;">Sign up</a>
    </p>

  </main>

  <script src="<?= BASE_URL ?>/assets/js/validation.js"></script>
</body>
</html>

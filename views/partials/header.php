<?php

$navUser = current_user();
$role = $navUser['role'] ?? 'spectator';

$avatarClass = 'avatar-initial-blue';
if ($role === 'employee') {
    $avatarClass = 'avatar-initial-green';
} elseif ($role === 'spectator') {
    $avatarClass = 'avatar-initial-purple';
} elseif ($role === 'coach') {
    $avatarClass = 'avatar-initial-amber';
}
$userInitial = strtoupper(substr($navUser['full_name'] ?? $navUser['username'] ?? 'U', 0, 2));
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= esc($pageTitle ?? APP_NAME) ?> &mdash; <?= esc(APP_NAME) ?></title>
    <!-- styles -->
    <link rel="stylesheet" type="text/css" href="<?= BASE_URL ?>/assets/css/style.css?v=<?= time() ?>">
    <link rel="stylesheet" type="text/css" href="<?= BASE_URL ?>/assets/css/components.css?v=<?= time() ?>">
    <link rel="stylesheet" type="text/css" href="<?= BASE_URL ?>/assets/css/dashboard.css?v=<?= time() ?>">
</head>
<body class="dashboard-layout">

  <!-- Sidebar Navigation -->
  <aside class="sidebar">
    <!-- Brand Header -->
    <div class="sidebar-brand">
      <div class="sidebar-brand-logo">
        <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
          <path d="M6 9H4.5a2.5 2.5 0 0 1 0-5H6"></path>
          <path d="M18 9h1.5a2.5 2.5 0 0 0 0-5H18"></path>
          <path d="M4 22h16"></path>
          <path d="M10 14.66V17c0 .55-.45 1-1 1H7v4h10v-4h-2c-.55 0-1-.45-1-1v-2.34"></path>
          <path d="M18 4H6v7a6 6 0 0 0 12 0V4z"></path>
        </svg>
      </div>
      <div class="sidebar-brand-text">
        <h2><?= esc(APP_NAME) ?></h2>
        <p><?= esc(role_label($role)) ?> Panel</p>
      </div>
    </div>

    <!-- Navigation Links -->
    <nav class="sidebar-nav">
      <?php
if ($role === 'admin'): ?>
        <a href="index.php?page=admin" class="nav-item <?= (($_GET['page'] ?? '') === 'admin' && (empty($_GET['action']) || $_GET['action'] === 'dashboard' || $_GET['action'] === 'live')) ? 'active' : '' ?>">
          <span class="nav-icon">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="2"></circle><path d="M16.24 7.76a6 6 0 0 1 0 8.49m-8.48-.01a6 6 0 0 1 0-8.49m11.31-2.82a10 10 0 0 1 0 14.14m-14.14 0a10 10 0 0 1 0-14.14"></path></svg>
          </span>
          Live Tournaments
        </a>
        <a href="index.php?page=admin&action=tournaments" class="nav-item <?= (($_GET['action'] ?? '') === 'tournaments') ? 'active' : '' ?>">
          <span class="nav-icon">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M6 9H4.5a2.5 2.5 0 0 1 0-5H6"></path><path d="M18 9h1.5a2.5 2.5 0 0 0 0-5H18"></path><path d="M4 22h16"></path><path d="M18 4H6v7a6 6 0 0 0 12 0V4z"></path></svg>
          </span>
          Tournaments
        </a>
        <a href="index.php?page=admin&action=analytics" class="nav-item <?= (($_GET['action'] ?? '') === 'analytics') ? 'active' : '' ?>">
          <span class="nav-icon">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="18" y1="20" x2="18" y2="10"></line><line x1="12" y1="20" x2="12" y2="4"></line><line x1="6" y1="20" x2="6" y2="14"></line></svg>
          </span>
          Tournament Analytics
        </a>

      <?php
elseif ($role === 'coach'): ?>
        <a href="index.php?page=coach" class="nav-item <?= (($_GET['page'] ?? '') === 'coach' && (empty($_GET['action']) || $_GET['action'] === 'registration' || $_GET['action'] === 'dashboard')) ? 'active' : '' ?>">
          <span class="nav-icon">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline><line x1="16" y1="13" x2="8" y2="13"></line><line x1="16" y1="17" x2="8" y2="17"></line><polyline points="10 9 9 9 8 9"></polyline></svg>
          </span>
          Team Registration &amp; Fees
        </a>
        <a href="index.php?page=coach&action=performance" class="nav-item <?= (($_GET['action'] ?? '') === 'performance') ? 'active' : '' ?>">
          <span class="nav-icon">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="18" y1="20" x2="18" y2="10"></line><line x1="12" y1="20" x2="12" y2="4"></line><line x1="6" y1="20" x2="6" y2="14"></line></svg>
          </span>
          Player Performance
        </a>
        <a href="index.php?page=coach&action=lineups" class="nav-item <?= (($_GET['action'] ?? '') === 'lineups') ? 'active' : '' ?>">
          <span class="nav-icon">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polygon points="12 2 2 7 12 12 22 7 12 2"></polygon><polyline points="2 17 12 22 22 17"></polyline><polyline points="2 12 12 17 22 12"></polyline></svg>
          </span>
          Lineups &amp; Strategies
        </a>

      <?php
elseif ($role === 'employee'): ?>
        <a href="index.php?page=employee" class="nav-item <?= (($_GET['page'] ?? '') === 'employee' && (empty($_GET['action']) || $_GET['action'] === 'venues' || $_GET['action'] === 'dashboard')) ? 'active' : '' ?>">
          <span class="nav-icon">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 21h18"></path><path d="M5 21V7l7-4 7 4v14"></path></svg>
          </span>
          Venues &amp; Equipment
        </a>
        <a href="index.php?page=employee&action=tasks" class="nav-item <?= (($_GET['action'] ?? '') === 'tasks') ? 'active' : '' ?>">
          <span class="nav-icon">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="9 11 12 14 22 4"></polyline><path d="M21 12v7a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11"></path></svg>
          </span>
          Match Preparation &amp; Tasks
        </a>
        <a href="index.php?page=employee&action=incidents" class="nav-item <?= (($_GET['action'] ?? '') === 'incidents') ? 'active' : '' ?>">
          <span class="nav-icon">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"></path><line x1="12" y1="9" x2="12" y2="13"></line><line x1="12" y1="17" x2="12.01" y2="17"></line></svg>
          </span>
          Incidents &amp; Maintenance
        </a>

      <?php
elseif ($role === 'spectator'): ?>
        <a href="index.php?page=spectator" class="nav-item <?= (($_GET['page'] ?? '') === 'spectator' && (empty($_GET['action']) || $_GET['action'] === 'schedules' || $_GET['action'] === 'dashboard')) ? 'active' : '' ?>">
          <span class="nav-icon">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect><line x1="16" y1="2" x2="16" y2="6"></line><line x1="8" y1="2" x2="8" y2="6"></line><line x1="3" y1="10" x2="21" y2="10"></line></svg>
          </span>
          Schedules, Venues &amp; Teams
        </a>
        <a href="index.php?page=spectator&action=tickets" class="nav-item <?= (($_GET['action'] ?? '') === 'tickets') ? 'active' : '' ?>">
          <span class="nav-icon">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M2 9a3 3 0 0 1 0 6v2a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2v-2a3 3 0 0 1 0-6V7a2 2 0 0 0-2-2H4a2 2 0 0 0-2 2z"></path></svg>
          </span>
          Purchase Tickets &amp; Payments
        </a>
        <a href="index.php?page=spectator&action=predictions" class="nav-item <?= (($_GET['action'] ?? '') === 'predictions') ? 'active' : '' ?>">
          <span class="nav-icon">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"></circle><polygon points="10 8 16 12 10 16 10 8"></polygon></svg>
          </span>
          Fan Voting &amp; Predictions
        </a>
      <?php
endif; ?>
    </nav>

    <!-- Clean Sidebar Footer (No bloated buttons) -->
    <div class="sidebar-footer">
      <div style="font-size: 11px; color: var(--sidebar-text-dim); text-align: center; padding: 6px 0;">
        <?= esc(APP_NAME) ?> &bull; <?= esc(ucfirst($role)) ?>
      </div>
    </div>
  </aside>

  <!-- Top Navigation Bar (Clean & Human-Made) -->
  <header class="top-navbar">
    <div class="top-nav-left">
      <div class="page-brand-title"><?= esc(APP_NAME) ?></div>
      <span style="color: var(--border-dark); margin: 0 4px;">&bull;</span>
      <span style="font-size: 13px; color: var(--text-secondary);"><?= esc(role_label($role)) ?> Panel</span>
    </div>

    <div class="top-nav-right">
      <!-- Simple & Natural Profile Menu -->
      <div class="user-profile-menu">
        <span style="font-size: 13px; color: var(--text-secondary);">Logged in as:</span>
        <strong class="user-name"><?= esc($navUser['full_name'] ?? $navUser['username']) ?></strong>
        <a href="index.php?page=logout" class="btn btn-sm btn-outline logout-link" style="padding: 4px 10px; font-size: 12px; margin-left: 6px;">Log Out</a>
      </div>
    </div>
  </header>

  <!-- Main Content Canvas -->
  <main class="main-canvas">
    <?php
foreach (get_flash() as $flash): ?>
      <div class="alert <?= ($flash['type'] === 'success') ? 'alert-success' : 'alert-danger' ?>" style="margin-bottom: 16px;">
        <span><?= esc($flash['message']) ?></span>
      </div>
    <?php
endforeach; ?>

    <?php
if (!empty($error)): ?>
      <div class="alert alert-danger" style="margin-bottom: 16px;">
        <span><?= esc($error) ?></span>
      </div>
    <?php
endif; ?>

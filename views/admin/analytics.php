<?php

$pageTitle   = 'Tournament Analytics Dashboard';
$pageHeading = 'Tournament Analytics';
$pageSub     = 'System metrics, regional participation analytics, and user account distributions';
require __DIR__ . '/../partials/header.php';
?>

<!-- Page Header Bar -->
<div class="page-title-bar">
  <div>
    <h1>Tournament Analytics Dashboard</h1>
    <p>Platform metrics, regional participation analysis, and user account distributions</p>
  </div>
  <div class="flex gap-2">
    <button class="btn btn-outline btn-sm" onclick="window.print();">
      <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="6 9 6 2 18 2 18 9"></polyline><path d="M6 18H4a2 2 0 0 1-2-2v-5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2h-2"></path><rect x="6" y="14" width="12" height="8"></rect></svg>
      Print Analytics Report
    </button>
  </div>
</div>

<!-- System Metrics Overview (6 Grid Items) -->
<div class="card" style="margin-bottom: 20px;">
  <div class="card-header">
    <div>
      <h3 style="margin: 0; font-size: 16px;">Platform Statistics</h3>
      <span style="font-size: 12px; color: var(--text-secondary);">Overall summary of database records</span>
    </div>
  </div>
  <div style="display: grid; grid-template-columns: repeat(6, 1fr); gap: 12px;">
    <div style="background: #f8fafc; border: 1px solid var(--border-color); padding: 14px; border-radius: var(--radius-sm); text-align: center;">
      <span style="font-size: 12px; color: var(--text-secondary); display: block; margin-bottom: 4px;">Tournaments</span>
      <strong style="font-size: 22px; color: var(--text-primary);"><?= (int)$stats['tournaments'] ?></strong>
    </div>
    <div style="background: #f8fafc; border: 1px solid var(--border-color); padding: 14px; border-radius: var(--radius-sm); text-align: center;">
      <span style="font-size: 12px; color: var(--text-secondary); display: block; margin-bottom: 4px;">Teams</span>
      <strong style="font-size: 22px; color: var(--text-primary);"><?= (int)$stats['teams'] ?></strong>
    </div>
    <div style="background: #f8fafc; border: 1px solid var(--border-color); padding: 14px; border-radius: var(--radius-sm); text-align: center;">
      <span style="font-size: 12px; color: var(--text-secondary); display: block; margin-bottom: 4px;">Coaches</span>
      <strong style="font-size: 22px; color: var(--text-primary);"><?= (int)$stats['coaches'] ?></strong>
    </div>
    <div style="background: #f8fafc; border: 1px solid var(--border-color); padding: 14px; border-radius: var(--radius-sm); text-align: center;">
      <span style="font-size: 12px; color: var(--text-secondary); display: block; margin-bottom: 4px;">Employees</span>
      <strong style="font-size: 22px; color: var(--text-primary);"><?= (int)$stats['employees'] ?></strong>
    </div>
    <div style="background: #f8fafc; border: 1px solid var(--border-color); padding: 14px; border-radius: var(--radius-sm); text-align: center;">
      <span style="font-size: 12px; color: var(--text-secondary); display: block; margin-bottom: 4px;">Spectators</span>
      <strong style="font-size: 22px; color: var(--text-primary);"><?= (int)$stats['spectators'] ?></strong>
    </div>
    <div style="background: #f8fafc; border: 1px solid var(--border-color); padding: 14px; border-radius: var(--radius-sm); text-align: center;">
      <span style="font-size: 12px; color: var(--text-secondary); display: block; margin-bottom: 4px;">Suspended</span>
      <strong style="font-size: 22px; color: var(--live-red);"><?= (int)$stats['suspended'] ?></strong>
    </div>
  </div>
</div>

<!-- accounts & chart -->
<div class="grid-12">

  <!-- user accounts -->
  <div class="col-8">
    <div class="card" id="userAccountsSection">
      <div class="card-header">
        <div>
          <h3 style="margin: 0; font-size: 16px;">Registered User Accounts</h3>
          <span style="font-size: 12px; color: var(--text-secondary);">Manage and review system users</span>
        </div>
        <span style="font-size: 12px; color: var(--text-secondary);">
          Total: <?= count($users) ?> Accounts
        </span>
      </div>

      <div class="table-responsive">
        <table class="data-table">
          <thead>
            <tr>
              <th>Name / Username</th>
              <th>Email</th>
              <th>Role</th>
              <th>Status</th>
              <th style="text-align: right;">Actions</th>
            </tr>
          </thead>
          <tbody>
            <?php
foreach ($users as $u): ?>
              <tr>
                <td>
                  <strong><?= esc($u['full_name']) ?></strong><br>
                  <span style="font-size: 11px; color: var(--text-muted);">@<?= esc($u['username']) ?></span>
                </td>
                <td style="font-size: 13px;"><?= esc($u['email']) ?></td>
                <td>
                  <span class="badge" style="background: var(--bg-surface-high); font-size: 11px;"><?= esc(ucfirst($u['role'])) ?></span>
                </td>
                <td>
                  <?php
if ($u['status'] === 'active'): ?>
                    <span class="badge badge-success">Active</span>
                  <?php
else: ?>
                    <span class="badge badge-error">Suspended</span>
                  <?php
endif; ?>
                </td>
                <td style="text-align: right;">
                  <div class="flex gap-2 justify-end" style="justify-content: flex-end;">
                    <?php
if ($u['id'] !== $navUser['id']): ?>
                      <a href="index.php?page=admin&action=user_status&id=<?= (int)$u['id'] ?>&status=<?= $u['status'] === 'active' ? 'suspended' : 'active' ?>&csrf_token=<?= esc($_SESSION['csrf_token'] ?? '') ?>"
                         class="btn btn-outline btn-sm" style="font-size: 11px; padding: 3px 8px;"><?= $u['status'] === 'active' ? 'Suspend' : 'Activate' ?></a>
                      <a href="index.php?page=admin&action=user_delete&id=<?= (int)$u['id'] ?>&csrf_token=<?= esc($_SESSION['csrf_token'] ?? '') ?>"
                         onclick="return confirm('Delete account <?= esc($u['username']) ?>?');"
                         class="btn btn-outline btn-sm" style="font-size: 11px; padding: 3px 8px; color: var(--live-red); border-color: var(--live-red);">Delete</a>
                    <?php
else: ?>
                      <span style="font-size: 11px; color: var(--text-muted); padding: 4px 8px;">(You)</span>
                    <?php
endif; ?>
                  </div>
                </td>
              </tr>
            <?php
endforeach; ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>

  <!-- column: regional participation chart -->
  <div class="col-4 flex flex-col gap-4">

    <!-- Participation Analysis Bar Chart Card -->
    <div class="card">
      <div class="card-header">
        <div>
          <h3 style="margin: 0; font-size: 16px;">Regional Participation</h3>
          <span style="font-size: 12px; color: var(--text-secondary);">Distribution by division</span>
        </div>
      </div>

      <!-- Pure CSS Bar Chart -->
      <div class="chart-widget">
        <div class="chart-grid-line" style="top: 25%;"></div>
        <div class="chart-grid-line" style="top: 50%;"></div>
        <div class="chart-grid-line" style="top: 75%;"></div>

        <!-- Bars -->
        <div class="chart-bar-group">
          <div class="chart-bar" style="height: 40%;" title="Dhaka: 40%"></div>
        </div>
        <div class="chart-bar-group">
          <div class="chart-bar highlight" style="height: 85%;" title="Chittagong: 85%"></div>
        </div>
        <div class="chart-bar-group">
          <div class="chart-bar" style="height: 30%;" title="Sylhet: 30%"></div>
        </div>
        <div class="chart-bar-group">
          <div class="chart-bar" style="height: 55%;" title="Khulna: 55%"></div>
        </div>
        <div class="chart-bar-group">
          <div class="chart-bar" style="height: 20%;" title="Barisal: 20%"></div>
        </div>
      </div>

      <!-- Chart Axis Labels -->
      <div class="chart-labels">
        <span>DHA</span>
        <span>CTG</span>
        <span>SYL</span>
        <span>KHU</span>
        <span>BAR</span>
      </div>
    </div>

    <!-- Tournament Formats Distribution Card -->
    <div class="card">
      <div class="card-header">
        <h3>Tournament Formats</h3>
      </div>
      <div style="display: flex; flex-direction: column; gap: 10px;">
        <div>
          <div class="flex justify-between" style="font-size: 12px; margin-bottom: 4px;">
            <span>League Format</span>
            <strong>60%</strong>
          </div>
          <div class="progress-bar-bg" style="height: 8px;">
            <div class="progress-bar-fill fill-blue" style="width: 60%;"></div>
          </div>
        </div>
        <div>
          <div class="flex justify-between" style="font-size: 12px; margin-bottom: 4px;">
            <span>Knockout Format</span>
            <strong>30%</strong>
          </div>
          <div class="progress-bar-bg" style="height: 8px;">
            <div class="progress-bar-fill fill-green" style="width: 30%;"></div>
          </div>
        </div>
        <div>
          <div class="flex justify-between" style="font-size: 12px; margin-bottom: 4px;">
            <span>Group + Knockout</span>
            <strong>10%</strong>
          </div>
          <div class="progress-bar-bg" style="height: 8px;">
            <div class="progress-bar-fill" style="width: 10%; background: #F59E0B;"></div>
          </div>
        </div>
      </div>
    </div>

  </div>

</div>

<?php
require __DIR__ . '/../partials/footer.php'; ?>

<?php

$pageTitle   = 'System Activity Log';
$pageHeading = 'Activity Log';
$pageSub     = 'Real-time audit trail of administrative actions, user logins, and updates';
require __DIR__ . '/../partials/header.php';
?>

<!-- Page Header Bar -->
<div class="page-title-bar">
  <div>
    <h1>System Activity &amp; Audit Log</h1>
    <p>Real-time audit trail of administrative actions, user logins, and updates</p>
  </div>
  <div>
    <form action="index.php" method="GET" style="display: flex; gap: 8px; margin: 0;">
      <input type="hidden" name="page" value="admin">
      <input type="hidden" name="action" value="logs">
      <div class="top-search-box" style="width: 280px;">
        <span class="top-search-icon">
          <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>
        </span>
        <input type="text" name="q" class="top-search-input" value="<?= esc($searchQuery ?? '') ?>" placeholder="Search logs (e.g. login, admin)...">
      </div>
      <button type="submit" class="btn btn-primary btn-sm">Filter</button>
      <?php
if (!empty($searchQuery)): ?>
        <a href="index.php?page=admin&action=logs" class="btn btn-outline btn-sm">Reset</a>
      <?php
endif; ?>
    </form>
  </div>
</div>

<!-- KPI Cards -->
<div class="grid-12" style="margin-bottom: 20px;">

  <div class="col-4">
    <div class="card" style="text-align: center; padding: 16px;">
      <span style="font-size: 11px; font-weight: 700; text-transform: uppercase; color: var(--text-muted); display: block; margin-bottom: 4px;">Audit Events Tracked</span>
      <strong style="font-size: 26px; color: var(--accent-blue); display: block;"><?= count($logs) ?></strong>
      <span style="font-size: 11px; color: var(--text-secondary);">Database Records</span>
    </div>
  </div>

  <div class="col-4">
    <div class="card" style="text-align: center; padding: 16px;">
      <span style="font-size: 11px; font-weight: 700; text-transform: uppercase; color: var(--text-muted); display: block; margin-bottom: 4px;">Audit Security Status</span>
      <strong style="font-size: 26px; color: #10B981; display: block;">Protected</strong>
      <span class="badge badge-success" style="font-size: 10px; margin-top: 4px;">Tamper-Resistant</span>
    </div>
  </div>

  <div class="col-4">
    <div class="card" style="text-align: center; padding: 16px;">
      <span style="font-size: 11px; font-weight: 700; text-transform: uppercase; color: var(--text-muted); display: block; margin-bottom: 4px;">Latest Action Logged</span>
      <strong style="font-size: 16px; color: var(--text-primary); display: block; padding-top: 4px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;">
        <?= !empty($logs[0]['action']) ? esc($logs[0]['action']) : 'No activity yet' ?>
      </strong>
      <span style="font-size: 11px; color: var(--text-muted);">
        <?= !empty($logs[0]['created_at']) ? date("d M Y, h:i A", strtotime($logs[0]['created_at'])) : '---' ?>
      </span>
    </div>
  </div>

</div>

<!-- Activity Table -->
<div class="card">
  <div class="card-header">
    <div class="flex items-center gap-2">
      <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="color: var(--accent-blue);"><line x1="18" y1="20" x2="18" y2="10"></line><line x1="12" y1="20" x2="12" y2="4"></line><line x1="6" y1="20" x2="6" y2="14"></line></svg>
      <h3>System Audit Trail</h3>
    </div>
    <span class="badge" style="background: var(--bg-surface-low); color: var(--text-secondary);">
      Showing <?= count($logs) ?> entries
    </span>
  </div>

  <div class="table-responsive">
    <table class="data-table">
      <thead>
        <tr>
          <th style="width: 180px;">Timestamp</th>
          <th>Actor / User</th>
          <th>Role</th>
          <th>Action / Description</th>
          <th style="text-align: right;">IP Address</th>
        </tr>
      </thead>
      <tbody>
        <?php
if (!empty($logs)): ?>
          <?php
foreach ($logs as $log): 
              $actionText = $log['action'];
              $isDelete = stripos($actionText, 'delete') !== false || stripos($actionText, 'remove') !== false;
              $isCreate = stripos($actionText, 'create') !== false || stripos($actionText, 'add') !== false || stripos($actionText, 'register') !== false;
              $isLogin  = stripos($actionText, 'sign') !== false || stripos($actionText, 'login') !== false;
          ?>
            <tr>
              <td style="font-size: 12px; color: var(--text-muted); white-space: nowrap;">
                <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="margin-right: 4px; vertical-align: middle;"><circle cx="12" cy="12" r="10"></circle><polyline points="12 6 12 12 16 14"></polyline></svg>
                <?= date("M d, Y h:i A", strtotime($log['created_at'])) ?>
              </td>
              <td>
                <div class="flex items-center gap-2">
                  <div class="avatar-circle avatar-initial-blue" style="width: 24px; height: 24px; font-size: 10px;">
                    <?= strtoupper(substr($log['username'] ?? 'U', 0, 1)) ?>
                  </div>
                  <strong><?= esc($log['username']) ?></strong>
                </div>
              </td>
              <td>
                <span class="badge" style="background: var(--bg-surface-high); font-size: 11px;">
                  <?= esc(ucfirst($log['role'])) ?>
                </span>
              </td>
              <td>
                <?php
if ($isDelete): ?>
                  <span class="badge badge-error" style="margin-right: 6px; font-size: 10px;">DELETE</span>
                <?php
elseif ($isCreate): ?>
                  <span class="badge badge-success" style="margin-right: 6px; font-size: 10px;">CREATE</span>
                <?php
elseif ($isLogin): ?>
                  <span class="badge" style="background: rgba(30, 64, 175, 0.1); color: var(--accent-blue); margin-right: 6px; font-size: 10px;">AUTH</span>
                <?php
else: ?>
                  <span class="badge" style="background: var(--bg-surface-high); margin-right: 6px; font-size: 10px;">SYSTEM</span>
                <?php
endif; ?>
                <span style="font-size: 13px; color: var(--text-primary);"><?= esc($log['action']) ?></span>
              </td>
              <td style="text-align: right; font-size: 12px; font-family: monospace; color: var(--text-muted);">
                <?= esc($log['ip']) ?>
              </td>
            </tr>
          <?php
endforeach; ?>
        <?php
else: ?>
          <tr>
            <td colspan="5" class="text-center" style="padding: 24px; color: var(--text-muted);">No activity logs matched your criteria.</td>
          </tr>
        <?php
endif; ?>
      </tbody>
    </table>
  </div>
</div>

<?php
require __DIR__ . '/../partials/footer.php'; ?>

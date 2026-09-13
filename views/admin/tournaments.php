<?php

$pageTitle   = 'Tournaments Management';
$pageHeading = 'Tournaments';
$pageSub     = 'Create and manage tournaments, schedules, and league brackets';
require __DIR__ . '/../partials/header.php';

$ongoingCount   = 0;
$upcomingCount  = 0;
$completedCount = 0;
foreach ($tournaments as $t) {
    if ($t['status'] === 'Ongoing') $ongoingCount++;
    elseif ($t['status'] === 'Upcoming') $upcomingCount++;
    elseif ($t['status'] === 'Completed') $completedCount++;
}
?>

<!-- Page Header Bar -->
<div class="page-title-bar">
  <div>
    <h1>Tournament Management</h1>
    <p>Create and monitor tournaments, schedules, and league brackets</p>
  </div>
  <div>
    <a href="#newTournamentBox" class="btn btn-sm btn-primary">
      + Add Tournament
    </a>
  </div>
</div>

<!-- 4 KPI Metrics Cards -->
<div class="kpi-grid">
  <div class="kpi-card">
    <span class="kpi-title">Total Tournaments</span>
    <div class="kpi-value-row">
      <span class="kpi-value"><?= count($tournaments) ?></span>
    </div>
    <span class="kpi-desc">Registered in System</span>
  </div>

  <div class="kpi-card">
    <span class="kpi-title">Ongoing Leagues</span>
    <div class="kpi-value-row">
      <span class="kpi-value" style="color: #10B981;"><?= $ongoingCount ?></span>
    </div>
    <span class="kpi-desc">Currently in progress</span>
  </div>

  <div class="kpi-card">
    <span class="kpi-title">Upcoming Events</span>
    <div class="kpi-value-row">
      <span class="kpi-value" style="color: var(--accent-blue);"><?= $upcomingCount ?></span>
    </div>
    <span class="kpi-desc">Scheduled for future</span>
  </div>

  <div class="kpi-card">
    <span class="kpi-title">Completed</span>
    <div class="kpi-value-row">
      <span class="kpi-value"><?= $completedCount ?></span>
    </div>
    <span class="kpi-desc">Finished championships</span>
  </div>
</div>

<!-- tournaments & form -->
<div class="grid-12">

  <!-- tournaments table -->
  <div class="col-8">
    <div class="card">
      <div class="card-header">
        <h3>Active Tournaments List</h3>
        <span style="font-size: 12px; color: var(--text-secondary);">
          Total: <?= count($tournaments) ?>
        </span>
      </div>

      <div class="table-responsive">
        <table class="data-table">
          <thead>
            <tr>
              <th>Tournament Name</th>
              <th>Type</th>
              <th>Status</th>
              <th>Duration</th>
              <th style="text-align: right;">Action</th>
            </tr>
          </thead>
          <tbody>
            <?php
if (!empty($tournaments)): ?>
              <?php
foreach ($tournaments as $tRow): ?>
                <tr>
                  <td>
                    <strong><?= esc($tRow['tournament_name']) ?></strong>
                  </td>
                  <td>
                    <span class="badge" style="background: var(--bg-surface-high);"><?= esc($tRow['tournament_type']) ?></span>
                  </td>
                  <td>
                    <?php
if ($tRow['status'] === 'Ongoing'): ?>
                      <span class="badge badge-success">
                        <span style="width: 6px; height: 6px; background: #166534; border-radius: 50%;"></span>
                        Ongoing
                      </span>
                    <?php
elseif ($tRow['status'] === 'Completed'): ?>
                      <span class="badge" style="background: var(--bg-surface-high); color: var(--text-secondary);">Completed</span>
                    <?php
else: ?>
                      <span class="badge badge-warning">Upcoming</span>
                    <?php
endif; ?>
                  </td>
                  <td style="font-size: 12px; color: var(--text-muted);">
                    <?= date("M d", strtotime($tRow['start_date'])) ?> &mdash; <?= date("M d, Y", strtotime($tRow['end_date'])) ?>
                  </td>
                  <td style="text-align: right;">
                    <a href="index.php?page=admin&action=tournament_delete&id=<?= (int)$tRow['id'] ?>&csrf_token=<?= esc($_SESSION['csrf_token'] ?? '') ?>"
                       onclick="return confirm('Are you sure you want to delete this tournament?');"
                       class="btn btn-outline btn-sm" style="color: var(--live-red); border-color: var(--live-red); font-size: 11px;">
                      Delete
                    </a>
                  </td>
                </tr>
              <?php
endforeach; ?>
            <?php
else: ?>
              <tr>
                <td colspan="5" class="text-center" style="padding: 24px; color: var(--text-muted);">No tournaments found in database. Create one using the form on the right.</td>
              </tr>
            <?php
endif; ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>

  <!-- add tournament form -->
  <div class="col-4" id="newTournamentBox">
    <div class="card">
      <div class="card-header">
        <div class="flex items-center gap-2">
          <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="color: var(--accent-blue);"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg>
          <h3>Add New Tournament</h3>
        </div>
      </div>

      <form action="index.php?page=admin&action=tournament_add" method="POST">
        <?php
csrf_field(); ?>

        <div class="form-group" style="margin-bottom: 14px;">
          <label for="t_name">Tournament Name</label>
          <input type="text" id="t_name" name="t_name" class="form-control" placeholder="e.g. Bangladesh Premier League 2026" required>
        </div>

        <div class="form-group" style="margin-bottom: 14px;">
          <label for="t_type">Tournament Type</label>
          <select id="t_type" name="t_type" class="form-control" required>
            <option value="League">League</option>
            <option value="Knockout">Knockout</option>
            <option value="Group+Knockout">Group + Knockout</option>
          </select>
        </div>

        <div class="form-group" style="margin-bottom: 14px;">
          <label for="t_status">Status</label>
          <select id="t_status" name="t_status" class="form-control">
            <option value="Upcoming">Upcoming</option>
            <option value="Ongoing">Ongoing</option>
            <option value="Completed">Completed</option>
          </select>
        </div>

        <div class="form-group" style="margin-bottom: 14px;">
          <label for="start_date">Start Date</label>
          <input type="date" id="start_date" name="start_date" class="form-control" value="<?= date('Y-m-d') ?>" required>
        </div>

        <div class="form-group" style="margin-bottom: 20px;">
          <label for="end_date">End Date</label>
          <input type="date" id="end_date" name="end_date" class="form-control" value="<?= date('Y-m-d', strtotime('+30 days')) ?>" required>
        </div>

        <button type="submit" name="create_tournament" class="btn btn-primary btn-full" style="padding: 12px; font-weight: 700;">
          <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" style="margin-right: 4px; vertical-align: middle;"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg>
          Save Tournament to Database
        </button>
      </form>
    </div>
  </div>

</div>

<?php
require __DIR__ . '/../partials/footer.php'; ?>

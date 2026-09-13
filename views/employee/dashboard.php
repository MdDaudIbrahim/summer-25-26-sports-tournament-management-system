<?php

$pageTitle   = 'Employee Dashboard';
$pageHeading = 'Employee Panel';
$pageSub     = 'Manage venues, tasks, equipment and incidents';
require __DIR__ . '/../partials/header.php';

$completedTasks = 0;
foreach ($tasks as $t) {
    if (!empty($t['is_completed'])) $completedTasks++;
}
?>

<!-- Page Header Bar -->
<div class="page-title-bar">
  <div>
    <h1>Dashboard</h1>
    <p>Today's Preparation &amp; Task List</p>
  </div>
  <div>
    <span class="badge" style="background: var(--bg-surface-low); color: var(--text-primary); padding: 8px 14px; font-size: 13px; font-weight: 700; border: 1px solid var(--border-color);">
      <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="margin-right: 4px; vertical-align: middle;"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect><line x1="16" y1="2" x2="16" y2="6"></line><line x1="8" y1="2" x2="8" y2="6"></line><line x1="3" y1="10" x2="21" y2="10"></line></svg>
      <?= date("d F, Y") ?>
    </span>
  </div>
</div>

<!-- Bento Grid Top Row: 3 Equal Columns -->
<div class="grid-12" style="margin-bottom: 20px;">

  <!-- Card 1: Venue Readiness -->
  <div class="col-4">
    <div class="card" style="height: 100%;">
      <div class="card-header">
        <div class="flex items-center gap-2">
          <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="color: var(--accent-blue);"><path d="M3 21h18"></path><path d="M5 21V7l7-4 7 4v14"></path></svg>
          <h3>Venue Readiness</h3>
        </div>
        <span class="badge badge-warning">In Progress</span>
      </div>

      <div class="progress-group">
        <div class="progress-header">
          <span style="color: var(--text-secondary);">Field Cleaning</span>
          <strong style="color: var(--text-primary);"><?= (int)($venues[0]['field_cleaning_pct'] ?? 85) ?>%</strong>
        </div>
        <div class="progress-bar-bg">
          <div class="progress-bar-fill fill-blue" style="width: <?= (int)($venues[0]['field_cleaning_pct'] ?? 85) ?>%;"></div>
        </div>
      </div>

      <div class="progress-group" style="margin-bottom: 0;">
        <div class="progress-header">
          <span style="color: var(--text-secondary);">Seating Arrangement</span>
          <strong style="color: var(--text-primary);"><?= (int)($venues[0]['seating_pct'] ?? 100) ?>%</strong>
        </div>
        <div class="progress-bar-bg">
          <div class="progress-bar-fill fill-green" style="width: <?= (int)($venues[0]['seating_pct'] ?? 100) ?>%;"></div>
        </div>
      </div>
    </div>
  </div>

  <!-- Card 2: Equipment Inventory (From Database) -->
  <div class="col-4">
    <div class="card" style="height: 100%;">
      <div class="card-header">
        <div class="flex items-center gap-2">
          <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="color: var(--accent-blue);"><rect x="2" y="7" width="20" height="14" rx="2" ry="2"></rect><path d="M16 21V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16"></path></svg>
          <h3>Equipment Inventory</h3>
        </div>
        <span class="badge badge-success">Available</span>
      </div>

      <div class="inventory-grid">
        <?php
foreach ($equipment as $eq): ?>
          <div class="inventory-box">
            <div class="inventory-num"><?= str_pad((string)$eq['quantity'], 2, '0', STR_PAD_LEFT) ?></div>
            <div class="inventory-label"><?= esc($eq['item_name']) ?></div>
          </div>
        <?php
endforeach; ?>
        <?php
if (empty($equipment)): ?>
          <div class="inventory-box">
            <div class="inventory-num">12</div>
            <div class="inventory-label">Basketballs</div>
          </div>
          <div class="inventory-box">
            <div class="inventory-num">04</div>
            <div class="inventory-label">Nets</div>
          </div>
        <?php
endif; ?>
      </div>
    </div>
  </div>

  <!-- Card 3: Live Match Status -->
  <div class="col-4">
    <div class="card" style="height: 100%;">
      <div class="card-header">
        <div class="flex items-center gap-2">
          <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="color: var(--live-red);"><circle cx="12" cy="12" r="2"></circle><path d="M16.24 7.76a6 6 0 0 1 0 8.49m-8.48-.01a6 6 0 0 1 0-8.49m11.31-2.82a10 10 0 0 1 0 14.14m-14.14 0a10 10 0 0 1 0-14.14"></path></svg>
          <h3>Live Match Status</h3>
        </div>
        <div class="flex items-center gap-1">
          <span class="pulse-dot"></span>
          <span class="badge badge-error" style="padding: 2px 6px; font-size: 10px;">LIVE</span>
        </div>
      </div>

      <div style="background-color: var(--bg-surface-low); border-radius: var(--radius-md); padding: 14px; display: flex; align-items: center; justify-content: space-between; text-align: center;">
        <div>
          <span style="font-size: 11px; color: var(--text-muted); display: block; margin-bottom: 2px;">Team A</span>
          <strong style="font-size: 24px; color: var(--text-primary);">45</strong>
        </div>

        <div>
          <span class="badge" style="background: var(--bg-surface-high); font-size: 10px; margin-bottom: 4px; display: inline-block;">2nd Quarter</span>
          <strong style="font-size: 18px; color: var(--accent-blue); display: block;">04:12</strong>
        </div>

        <div>
          <span style="font-size: 11px; color: var(--text-muted); display: block; margin-bottom: 2px;">Team B</span>
          <strong style="font-size: 24px; color: var(--text-primary);">38</strong>
        </div>
      </div>
    </div>
  </div>

</div>

<!-- Bento Grid Row 2: Task List & Incident Report -->
<div class="grid-12" style="margin-bottom: 20px;">

  <!-- task checklist -->
  <div class="col-8" id="taskListSection">
    <div class="card" style="height: 100%;">
      <div class="card-header">
        <div class="flex items-center gap-2">
          <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="9 11 12 14 22 4"></polyline><path d="M21 12v7a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11"></path></svg>
          <h3>Task List (Match Preparation from DB)</h3>
        </div>
        <span class="badge" style="background: var(--bg-surface-low); color: var(--text-secondary); border: 1px solid var(--border-color);" id="taskCounter">
          <?= $completedTasks ?>/<?= count($tasks) ?> Completed
        </span>
      </div>

      <ul class="task-list">
        <?php
foreach ($tasks as $t): ?>
          <li class="task-item <?= !empty($t['is_completed']) ? 'completed' : '' ?> <?= !empty($t['is_urgent']) ? 'is-urgent' : '' ?>">
            <a href="index.php?page=employee&action=task_toggle&id=<?= (int)$t['id'] ?>&csrf_token=<?= esc($_SESSION['csrf_token'] ?? '') ?>"
               style="display: flex; align-items: center; gap: 10px; text-decoration: none; color: inherit; width: 100%;">
              <input type="checkbox" class="task-checkbox" <?= !empty($t['is_completed']) ? 'checked' : '' ?> id="task_<?= $t['id'] ?>" onclick="window.location.href=this.parentElement.href;">
              <span class="task-text" <?= !empty($t['is_urgent']) ? 'style="font-weight: 700;"' : '' ?>>
                <?= esc($t['task_title']) ?>
              </span>
              <?php
if (!empty($t['is_urgent'])): ?>
                <span class="badge badge-error" style="margin-left: auto;">Urgent</span>
              <?php
endif; ?>
            </a>
          </li>
        <?php
endforeach; ?>
      </ul>

      <!-- Add New Task Form -->
      <form action="index.php?page=employee&action=task_add" method="POST" style="margin-top: 16px; display: flex; gap: 10px;">
        <?php
csrf_field(); ?>
        <input type="text" name="task_title" class="form-control" placeholder="New preparation task description..." required style="flex: 1;">
        <label class="form-checkbox" style="align-self: center; white-space: nowrap;">
          <input type="checkbox" name="is_urgent" value="1">
          <span>Urgent</span>
        </label>
        <button type="submit" class="btn btn-primary btn-sm">+ Add</button>
      </form>
    </div>
  </div>

  <!-- incident form -->
  <div class="col-4" id="incidentReportSection">
    <div class="card">
      <div class="card-header">
        <div class="flex items-center gap-2">
          <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="color: var(--status-warning-text);"><path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"></path><line x1="12" y1="9" x2="12" y2="13"></line><line x1="12" y1="17" x2="12.01" y2="17"></line></svg>
          <h3>Incident or Problem Report</h3>
        </div>
      </div>

      <form action="index.php?page=employee&action=incident_report" method="POST" id="incidentForm">
        <?php
csrf_field(); ?>
        <div class="form-group" style="margin-bottom: 12px;">
          <label for="problem_type">Problem Type</label>
          <select id="problem_type" name="problem_type" class="form-control">
            <option value="Maintenance">Maintenance</option>
            <option value="Equipment Fault">Equipment Fault</option>
            <option value="Security">Security</option>
            <option value="Medical">Medical</option>
          </select>
        </div>

        <div class="form-group" style="margin-bottom: 12px;">
          <label for="location_area">Location / Venue</label>
          <input type="text" id="location_area" name="location_area" class="form-control" placeholder="e.g. Gallery Section B" required>
        </div>

        <div class="form-group" style="margin-bottom: 12px;">
          <label for="priority">Priority</label>
          <select id="priority" name="priority" class="form-control">
            <option value="Normal">Normal</option>
            <option value="High">High</option>
            <option value="Critical">Critical</option>
          </select>
        </div>

        <div class="form-group" style="margin-bottom: 16px;">
          <label for="description">Description</label>
          <textarea id="description" name="description" class="form-control" rows="3" placeholder="Explain the issue..." required></textarea>
        </div>

        <button type="submit" name="submit_incident" class="btn btn-primary btn-full" style="padding: 10px;">
          Submit Incident Report
        </button>
      </form>
    </div>
  </div>

</div>

<!-- row 3: venues & equipment management -->
<div class="grid-12" id="venuesSection">

  <div class="col-8">
    <div class="card">
      <div class="card-header">
        <h3>Managed Venues</h3>
        <span class="badge" style="background: var(--bg-surface-low); color: var(--text-secondary);">
          Total: <?= count($venues) ?>
        </span>
      </div>

      <div class="table-responsive">
        <table class="data-table">
          <thead>
            <tr>
              <th>#</th>
              <th>Venue Name</th>
              <th>City</th>
              <th>Field Clean</th>
              <th>Seating</th>
              <th style="text-align: right;">Actions</th>
            </tr>
          </thead>
          <tbody>
            <?php
foreach ($venues as $i => $v): ?>
              <tr>
                <td><?= $i + 1 ?></td>
                <td><strong><?= esc($v['venue_name']) ?></strong></td>
                <td><?= esc($v['city']) ?></td>
                <td><?= (int)$v['field_cleaning_pct'] ?>%</td>
                <td><?= (int)$v['seating_pct'] ?>%</td>
                <td style="text-align: right;">
                  <a href="index.php?page=employee&action=venue_delete&id=<?= (int)$v['id'] ?>&csrf_token=<?= esc($_SESSION['csrf_token'] ?? '') ?>"
                     onclick="return confirm('Delete venue <?= esc($v['venue_name']) ?>?');"
                     class="btn btn-outline btn-sm" style="font-size: 11px; color: var(--live-red); border-color: var(--live-red);">Delete</a>
                </td>
              </tr>
            <?php
endforeach; ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>

  <div class="col-4">
    <div class="card">
      <div class="card-header">
        <h3>Add New Venue</h3>
      </div>
      <form action="index.php?page=employee&action=venue_add" method="POST">
        <?php
csrf_field(); ?>
        <div class="form-group" style="margin-bottom: 12px;">
          <label for="venue_name">Venue Name</label>
          <input type="text" id="venue_name" name="venue_name" class="form-control" placeholder="e.g. Bangabandhu National" required>
        </div>
        <div class="form-group" style="margin-bottom: 16px;">
          <label for="city">City</label>
          <input type="text" id="city" name="city" class="form-control" placeholder="e.g. Dhaka" required>
        </div>
        <button type="submit" class="btn btn-primary btn-full" style="padding: 10px;">
          Add Venue
        </button>
      </form>
    </div>
  </div>

</div>

<?php
require __DIR__ . '/../partials/footer.php'; ?>

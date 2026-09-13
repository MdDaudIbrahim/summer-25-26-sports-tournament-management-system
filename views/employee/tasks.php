<?php

$pageTitle   = 'Match Preparation & Tasks';
$pageHeading = 'Employee Panel';
$pageSub     = 'Organize match day preparations, ground staff tasks, and checklist milestones';
require __DIR__ . '/../partials/header.php';

$totalTaskCount = count($tasks);
$prepPct = $totalTaskCount > 0 ? round(($completedTasks / $totalTaskCount) * 100) : 0;
?>

<!-- header -->
<div class="page-title-bar">
  <div>
    <h1>Match Preparation &amp; Task Management</h1>
    <p>Pre-match checklists, ground operations, referee gear prep, and stadium milestones.</p>
  </div>
  <div>
    <a href="#addTaskBox" class="btn btn-sm btn-primary">
      + Add Task
    </a>
  </div>
</div>

<!-- kpi cards -->
<div class="kpi-grid">
  <div class="kpi-card">
    <span class="kpi-title">Total Tasks</span>
    <div class="kpi-value-row">
      <span class="kpi-value"><?= $totalTaskCount ?></span>
    </div>
    <span class="kpi-desc">Checklist items for match day</span>
  </div>

  <div class="kpi-card">
    <span class="kpi-title">Completed Milestones</span>
    <div class="kpi-value-row">
      <span class="kpi-value" style="color: #10B981;"><?= $completedTasks ?></span>
    </div>
    <span class="kpi-desc">Verified and inspected</span>
  </div>

  <div class="kpi-card">
    <span class="kpi-title">Urgent Tasks</span>
    <div class="kpi-value-row">
      <span class="kpi-value" style="color: <?= $urgentTasks > 0 ? 'var(--live-red)' : 'var(--text-primary)' ?>;"><?= $urgentTasks ?></span>
    </div>
    <span class="kpi-desc">Requires immediate ground staff</span>
  </div>

  <div class="kpi-card">
    <span class="kpi-title">Preparation Readiness</span>
    <div class="kpi-value-row">
      <span class="kpi-value" style="color: var(--accent-blue);"><?= $prepPct ?>%</span>
    </div>
    <span class="kpi-desc"><?= $completedTasks ?> of <?= $totalTaskCount ?> milestones done</span>
  </div>
</div>

<!-- tasks checklist & add form -->
<div class="grid-12" style="margin-bottom: 24px;">

  <!-- checklist -->
  <div class="col-7">
    <div class="card" id="taskListSection">
      <div class="card-header">
        <h3>Match Day Preparation Check-list</h3>
        <span style="font-size: 12px; color: var(--text-secondary);"><?= $completedTasks ?>/<?= $totalTaskCount ?> Done</span>
      </div>

      <div style="display: flex; flex-direction: column; gap: 10px; margin-top: 6px;">
        <?php
if (!empty($tasks)): ?>
          <?php
foreach ($tasks as $t): 
            $isDone   = !empty($t['is_completed']);
            $isUrgent = !empty($t['is_urgent']);
          ?>
            <div style="display: flex; align-items: center; justify-content: space-between; padding: 12px 14px; background: #ffffff; border: 1px solid var(--border-color); border-radius: var(--radius-sm);">

              <div class="flex items-center gap-3">
                <a href="index.php?page=employee&action=task_toggle&id=<?= (int)$t['id'] ?>&csrf_token=<?= esc($_SESSION['csrf_token'] ?? '') ?>"
                   style="width: 20px; height: 20px; border-radius: 4px; border: 1px solid <?= $isDone ? '#10B981' : 'var(--border-dark)' ?>; background: <?= $isDone ? '#10B981' : '#ffffff' ?>; display: flex; align-items: center; justify-content: center; text-decoration: none; color: #ffffff; font-size: 12px; font-weight: 700;">
                  <?= $isDone ? '&check;' : '' ?>
                </a>
                <div>
                  <span style="font-size: 13px; font-weight: 600; color: var(--text-primary);">
                    <?= esc($t['task_title']) ?>
                  </span>
                  <div style="font-size: 12px; color: var(--text-secondary); margin-top: 2px;">
                    Assigned: <?= esc($t['assigned_staff'] ?? 'Staff') ?>
                  </div>
                </div>
              </div>

              <div class="flex items-center gap-2">
                <?php
if ($isUrgent && !$isDone): ?>
                  <span class="badge badge-danger">Urgent</span>
                <?php
elseif ($isDone): ?>
                  <span class="badge badge-success">Completed</span>
                <?php
else: ?>
                  <span class="badge badge-neutral">Pending</span>
                <?php
endif; ?>

                <a href="index.php?page=employee&action=task_delete&id=<?= (int)$t['id'] ?>&csrf_token=<?= esc($_SESSION['csrf_token'] ?? '') ?>"
                   style="color: var(--text-muted); font-size: 16px; text-decoration: none; padding: 2px 6px;"
                   onclick="return confirm('Remove task?');">&times;</a>
              </div>
            </div>
          <?php
endforeach; ?>
        <?php
else: ?>
          <p style="text-align: center; color: var(--text-muted); padding: 24px;">No preparation tasks listed. Add a task on the right.</p>
        <?php
endif; ?>
      </div>
    </div>
  </div>

  <!-- add task form -->
  <div class="col-5" id="addTaskBox">
    <div class="card">
      <div class="card-header">
        <div class="flex items-center gap-2">
          <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="color: var(--accent-blue);"><polyline points="9 11 12 14 22 4"></polyline><path d="M21 12v7a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11"></path></svg>
          <h3>Add Preparation Task</h3>
        </div>
      </div>

      <?php
if (!empty($error)): ?>
        <div class="alert alert-danger" style="margin-bottom: 14px; font-size: 13px; padding: 10px;">
          <?= esc($error) ?>
        </div>
      <?php
endif; ?>

      <form action="index.php?page=employee&action=task_add" method="POST">
        <?php
csrf_field(); ?>

        <div class="form-group">
          <label for="task_title">Preparation Task Description *</label>
          <input type="text" id="task_title" name="task_title" class="form-control" placeholder="e.g. Test PA sound system &amp; emergency exits" required>
        </div>

        <div class="form-group">
          <label for="assigned_staff">Assigned Staff Unit</label>
          <input type="text" id="assigned_staff" name="assigned_staff" class="form-control" value="Ground Staff" placeholder="e.g. Ground Staff, Referee Crew">
        </div>

        <div class="form-group" style="padding-top: 4px;">
          <label class="form-checkbox" for="is_urgent">
            <input type="checkbox" id="is_urgent" name="is_urgent" value="1">
            <span style="font-weight: 600; color: var(--live-red);">Mark as Urgent High-Priority</span>
          </label>
        </div>

        <button type="submit" class="btn btn-primary" style="width: 100%; margin-top: 8px; display: flex; align-items: center; justify-content: center; gap: 8px;">
          <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"></polyline></svg>
          <span>Add Task to Preparation List</span>
        </button>
      </form>
    </div>
  </div>

</div>

<!-- readiness protocols -->
<div class="grid-12">
  <div class="col-12">
    <div class="card">
      <div class="card-header">
        <div class="flex items-center gap-2">
          <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="color: #10B981;"><circle cx="12" cy="12" r="10"></circle><polyline points="12 6 12 12 14 14"></polyline></svg>
          <h3>Standard Match Day Readiness Protocol</h3>
        </div>
      </div>

      <div style="display: grid; grid-template-columns: repeat(4, 1fr); gap: 16px;">
        <div style="padding: 14px; background: var(--bg-surface-low); border-radius: var(--radius-md); border-top: 3px solid var(--accent-blue);">
          <strong style="font-size: 13px; color: var(--text-primary); display: block;">1. Dressing Rooms</strong>
          <p style="font-size: 11px; color: var(--text-secondary); margin: 6px 0 0; line-height: 1.5;">
            Stock sealed water bottles, ice packs, first aid medical kits, and verify air conditioning.
          </p>
        </div>

        <div style="padding: 14px; background: var(--bg-surface-low); border-radius: var(--radius-md); border-top: 3px solid #10B981;">
          <strong style="font-size: 13px; color: var(--text-primary); display: block;">2. Scoreboard &amp; Clocks</strong>
          <p style="font-size: 11px; color: var(--text-secondary); margin: 6px 0 0; line-height: 1.5;">
            Sync official match timer, LED scoreboard display, and backup handheld stopwatches.
          </p>
        </div>

        <div style="padding: 14px; background: var(--bg-surface-low); border-radius: var(--radius-md); border-top: 3px solid #F59E0B;">
          <strong style="font-size: 13px; color: var(--text-primary); display: block;">3. Official Match Balls</strong>
          <p style="font-size: 11px; color: var(--text-secondary); margin: 6px 0 0; line-height: 1.5;">
            Check ball air pressure (8.5 - 15.6 psi), referee whistles, and linesmen corner flags.
          </p>
        </div>

        <div style="padding: 14px; background: var(--bg-surface-low); border-radius: var(--radius-md); border-top: 3px solid #6366f1;">
          <strong style="font-size: 13px; color: var(--text-primary); display: block;">4. Turnstiles &amp; VIP</strong>
          <p style="font-size: 11px; color: var(--text-secondary); margin: 6px 0 0; line-height: 1.5;">
            Ensure spectator turnstile barcode scanners are calibrated and VIP gallery seats sanitized.
          </p>
        </div>
      </div>
    </div>
  </div>
</div>

<?php
require __DIR__ . '/../partials/footer.php'; ?>

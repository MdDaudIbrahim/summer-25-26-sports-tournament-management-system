<?php

$pageTitle   = 'Incidents & Maintenance';
$pageHeading = 'Employee Panel';
$pageSub     = 'Log stadium facility issues, track maintenance tickets, and resolve operational problems';
require __DIR__ . '/../partials/header.php';

$inProgressIncidents = 0;
foreach ($incidents as $inc) {
    if (($inc['status'] ?? '') === 'In Progress') $inProgressIncidents++;
}
?>

<!-- Page Header Bar -->
<div class="page-title-bar">
  <div>
    <h1>Incidents &amp; Maintenance Reporting</h1>
    <p>Facility incident tickets, electrical &amp; turf maintenance logs, and emergency repair tracking.</p>
  </div>
  <div>
    <a href="#reportIncidentBox" class="btn btn-sm btn-primary">
      + Report Issue
    </a>
  </div>
</div>

<!-- 4 KPI Metrics Cards -->
<div class="kpi-grid">
  <div class="kpi-card">
    <span class="kpi-title">Total Incidents</span>
    <div class="kpi-value-row">
      <span class="kpi-value"><?= count($incidents) ?></span>
    </div>
    <span class="kpi-desc">Registered in system</span>
  </div>

  <div class="kpi-card">
    <span class="kpi-title">Pending Inspection</span>
    <div class="kpi-value-row">
      <span class="kpi-value" style="color: <?= $pendingIncidents > 0 ? 'var(--live-red)' : 'var(--text-primary)' ?>;"><?= $pendingIncidents ?></span>
    </div>
    <span class="kpi-desc">Requires maintenance review</span>
  </div>

  <div class="kpi-card">
    <span class="kpi-title">In Progress Repairs</span>
    <div class="kpi-value-row">
      <span class="kpi-value" style="color: var(--accent-blue);"><?= $inProgressIncidents ?></span>
    </div>
    <span class="kpi-desc">Technicians assigned on site</span>
  </div>

  <div class="kpi-card">
    <span class="kpi-title">Resolved Tickets</span>
    <div class="kpi-value-row">
      <span class="kpi-value" style="color: #10B981;"><?= $resolvedIncidents ?></span>
    </div>
    <span class="kpi-desc">Fully restored and verified</span>
  </div>
</div>

<!-- incident log & form -->
<div class="grid-12">

  <!-- incident log -->
  <div class="col-7">
    <div class="card" id="incidentReportSection">
      <div class="card-header">
        <h3>Facility Incident &amp; Maintenance Tickets</h3>
        <span style="font-size: 12px; color: var(--text-secondary);"><?= count($incidents) ?> Tickets</span>
      </div>

      <div class="table-responsive">
        <table class="data-table">
          <thead>
            <tr>
              <th>Issue &amp; Location</th>
              <th>Description</th>
              <th>Status</th>
              <th style="text-align: right;">Action</th>
            </tr>
          </thead>
          <tbody>
            <?php
if (!empty($incidents)): ?>
              <?php
foreach ($incidents as $inc): 
                $st = $inc['status'] ?? 'Pending';
                $stClass = ($st === 'Resolved') ? 'badge-success' : (($st === 'In Progress') ? 'badge-blue' : 'badge-warning');
              ?>
                <tr>
                  <td>
                    <strong style="font-size: 13px; color: var(--text-primary); display: block;">
                      <?= esc($inc['problem_type']) ?>
                    </strong>
                    <span style="font-size: 11px; color: var(--text-muted);"><?= esc($inc['location_area']) ?></span>
                  </td>
                  <td>
                    <p style="font-size: 12px; color: var(--text-secondary); margin: 0; max-width: 240px; line-height: 1.4;">
                      <?= esc($inc['description']) ?>
                    </p>
                    <span style="font-size: 10px; color: var(--text-muted); display: block; margin-top: 2px;">
                      Reported by: <?= esc($inc['reported_by'] ?? 'Staff') ?>
                    </span>
                  </td>
                  <td>
                    <span class="badge <?= $stClass ?>"><?= esc($st) ?></span>
                  </td>
                  <td style="text-align: right;">
                    <?php
if ($st === 'Pending'): ?>
                      <a href="index.php?page=employee&action=incident_status&id=<?= (int)$inc['id'] ?>&status=In+Progress&csrf_token=<?= esc($_SESSION['csrf_token'] ?? '') ?>"
                         class="btn btn-sm btn-outline"
                         style="font-size: 11px; padding: 3px 8px; color: var(--accent-blue); border-color: var(--accent-blue);">
                        Start Repair
                      </a>
                    <?php
elseif ($st === 'In Progress'): ?>
                      <a href="index.php?page=employee&action=incident_status&id=<?= (int)$inc['id'] ?>&status=Resolved&csrf_token=<?= esc($_SESSION['csrf_token'] ?? '') ?>"
                         class="btn btn-sm btn-primary"
                         style="font-size: 11px; padding: 3px 8px; background: #10B981; border-color: #10B981;">
                        &check; Resolve
                      </a>
                    <?php
else: ?>
                      <span style="font-size: 11px; color: #10B981; font-weight: 600;">
                        &check; Completed
                      </span>
                    <?php
endif; ?>
                  </td>
                </tr>
              <?php
endforeach; ?>
            <?php
else: ?>
              <tr>
                <td colspan="4" class="text-center" style="padding: 24px; color: var(--text-muted);">
                  No incident reports logged. Submit a report on the right.
                </td>
              </tr>
            <?php
endif; ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>

  <!-- report form -->
  <div class="col-5" id="reportIncidentBox">
    <div class="card">
      <div class="card-header">
        <div class="flex items-center gap-2">
          <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="color: var(--live-red);"><path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"></path><line x1="12" y1="9" x2="12" y2="13"></line><line x1="12" y1="17" x2="12.01" y2="17"></line></svg>
          <h3>Report Incident or Maintenance</h3>
        </div>
      </div>

      <?php
if (!empty($error)): ?>
        <div class="alert alert-danger" style="margin-bottom: 14px; font-size: 13px; padding: 10px;">
          <?= esc($error) ?>
        </div>
      <?php
endif; ?>

      <form action="index.php?page=employee&action=incident_add" method="POST">
        <?php
csrf_field(); ?>

        <div class="form-group">
          <label for="problem_type">Problem Category *</label>
          <select id="problem_type" name="problem_type" class="form-control" required>
            <option value="Lighting Issue">Lighting &amp; Floodlight Issue</option>
            <option value="Field Damage">Turf / Field Damage</option>
            <option value="Seating Damage">Seating &amp; Gallery Damage</option>
            <option value="Equipment Failure">Scoreboard / Equipment Failure</option>
            <option value="Plumbing Issue">Plumbing / Dressing Room Leak</option>
            <option value="Safety Hazard">Safety &amp; Crowd Barrier Hazard</option>
            <option value="Other">Other Operational Issue</option>
          </select>
        </div>

        <div class="form-group">
          <label for="location_area">Location / Stadium Area *</label>
          <input type="text" id="location_area" name="location_area" class="form-control" placeholder="e.g. Gallery Section B, Row 4" required>
        </div>

        <div class="form-group">
          <label for="description">Detailed Problem Description *</label>
          <textarea id="description" name="description" class="form-control" rows="4" placeholder="Explain the maintenance issue or safety hazard..." required></textarea>
        </div>

        <button type="submit" class="btn btn-primary" style="width: 100%; margin-top: 8px; display: flex; align-items: center; justify-content: center; gap: 8px;">
          <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"></polyline></svg>
          <span>Submit Incident Report to System</span>
        </button>
      </form>
    </div>

    <!-- Emergency Escalation Notice -->
    <div class="card" style="margin-top: 16px; border-left: 3px solid #F59E0B; padding: 14px;">
      <div style="display: flex; align-items: center; gap: 8px; margin-bottom: 4px;">
        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="color: #F59E0B;"><circle cx="12" cy="12" r="10"></circle><line x1="12" y1="8" x2="12" y2="12"></line><line x1="12" y1="16" x2="12.01" y2="16"></line></svg>
        <strong style="font-size: 12px; color: var(--text-primary);">Emergency Escalation</strong>
      </div>
      <p style="font-size: 11px; color: var(--text-secondary); margin: 0; line-height: 1.5;">
        Urgent electrical or structural hazards that may cause match delays must also be verbally reported to the chief stadium operations manager immediately.
      </p>
    </div>
  </div>

</div>

<?php
require __DIR__ . '/../partials/footer.php'; ?>

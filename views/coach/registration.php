<?php

$pageTitle   = 'Team Registration & Fee Payment';
$pageHeading = 'Coach Panel';
$pageSub     = 'Register teams for tournaments and manage registration fees';
require __DIR__ . '/../partials/header.php';

$totalPaidAmount = 0;
$pendingInvoices = 0;
foreach ($myTeams as $t) {
    if (($t['fee_status'] ?? '') === 'Paid') {
        $totalPaidAmount += (float)($t['fee_amount'] ?? 50000);
    } else {
        $pendingInvoices++;
    }
}
?>

<!-- Page Header Bar -->
<div class="page-title-bar">
  <div>
    <h1>Team Registration &amp; Fee Payment</h1>
    <p>Official squad registration portal, tournament entry records, and fee payment gateway.</p>
  </div>
  <div>
    <button class="btn btn-sm btn-primary" style="padding: 8px 18px;" onclick="document.getElementById('registerTeamBox')?.scrollIntoView({behavior: 'smooth'})">
      + Register New Team
    </button>
  </div>
</div>

<!-- 4 KPI Metrics Cards -->
<div class="kpi-grid" style="margin-bottom: 24px;">
  <div class="kpi-card">
    <span class="kpi-title">Registered Teams</span>
    <div class="kpi-value-row">
      <span class="kpi-value"><?= count($myTeams) ?></span>
      <span class="badge badge-success">Active Squads</span>
    </div>
    <span class="kpi-desc">Teams under your management</span>
  </div>

  <div class="kpi-card">
    <span class="kpi-title">Total Fees Paid</span>
    <div class="kpi-value-row">
      <span class="kpi-value" style="color: var(--status-success-text);"><?= number_format($totalPaidAmount) ?> <small style="font-size: 14px; font-weight: normal;">BDT</small></span>
      <span class="badge badge-success">Cleared</span>
    </div>
    <span class="kpi-desc">Official championship entries</span>
  </div>

  <div class="kpi-card">
    <span class="kpi-title">Pending Invoices</span>
    <div class="kpi-value-row">
      <span class="kpi-value" style="color: <?= $pendingInvoices > 0 ? 'var(--status-warning-text)' : 'var(--text-primary)' ?>;"><?= $pendingInvoices ?></span>
      <span class="badge <?= $pendingInvoices > 0 ? 'badge-warning' : 'badge-neutral' ?>">
        <?= $pendingInvoices > 0 ? 'Action Required' : 'All Clear' ?>
      </span>
    </div>
    <span class="kpi-desc">Awaiting fee confirmation</span>
  </div>

  <div class="kpi-card">
    <span class="kpi-title">Open Tournaments</span>
    <div class="kpi-value-row">
      <span class="kpi-value"><?= count($tournaments) ?></span>
      <span class="badge badge-blue">Eligible</span>
    </div>
    <span class="kpi-desc">Available for squad registration</span>
  </div>
</div>

<!-- teams & registration -->
<div class="grid-12">

  <!-- registered teams -->
  <div class="col-7">
    <div class="card">
      <div class="card-header">
        <div class="flex items-center gap-2">
          <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="color: var(--accent-blue);"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline><line x1="16" y1="13" x2="8" y2="13"></line><line x1="16" y1="17" x2="8" y2="17"></line><polyline points="10 9 9 9 8 9"></polyline></svg>
          <h3>My Registered Teams &amp; Fee Status</h3>
        </div>
        <span class="badge" style="background: var(--bg-surface-low); color: var(--text-secondary);">
          <?= count($myTeams) ?> Records
        </span>
      </div>

      <div class="table-responsive">
        <table class="data-table">
          <thead>
            <tr>
              <th>Tournament / Team</th>
              <th>Squad Size</th>
              <th>Fee Amount</th>
              <th>Status</th>
              <th style="text-align: right;">Payment / Action</th>
            </tr>
          </thead>
          <tbody>
            <?php
if (!empty($myTeams)): ?>
              <?php
foreach ($myTeams as $t): 
                $isPaid = ($t['fee_status'] ?? '') === 'Paid';
              ?>
                <tr>
                  <td>
                    <strong><?= esc($t['team_name']) ?></strong>
                    <div style="font-size: 11px; color: var(--text-muted); margin-top: 2px;">
                      <?= esc($t['tournament_name'] ?? 'Championship') ?>
                    </div>
                  </td>
                  <td>
                    <span class="badge badge-neutral"><?= (int)($t['squad_size'] ?? 15) ?> Players</span>
                  </td>
                  <td>
                    <strong><?= number_format((float)($t['fee_amount'] ?? 50000), 2) ?> BDT</strong>
                  </td>
                  <td>
                    <?php
if ($isPaid): ?>
                      <span class="badge badge-success">
                        <svg width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" style="margin-right: 3px;"><polyline points="20 6 9 17 4 12"></polyline></svg>
                        Paid
                      </span>
                    <?php
else: ?>
                      <span class="badge badge-warning">
                        <svg width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" style="margin-right: 3px;"><circle cx="12" cy="12" r="10"></circle><line x1="12" y1="8" x2="12" y2="12"></line><line x1="12" y1="16" x2="12.01" y2="16"></line></svg>
                        Pending
                      </span>
                    <?php
endif; ?>
                  </td>
                  <td style="text-align: right;">
                    <div class="flex items-center justify-end gap-2">
                      <?php
if (!$isPaid): ?>
                        <a href="index.php?page=coach&action=team_pay&id=<?= (int)$t['id'] ?>&csrf_token=<?= esc($_SESSION['csrf_token'] ?? '') ?>"
                           class="btn btn-sm btn-primary"
                           style="background: #10B981; border-color: #10B981; font-size: 11px; padding: 4px 10px;"
                           onclick="return confirm('Pay 50,000 BDT registration fee for <?= esc($t['team_name']) ?>?');">
                          Pay Fee Now
                        </a>
                      <?php
else: ?>
                        <span style="font-size: 11px; color: var(--status-success-text); font-weight: 600;">
                          &check; Invoice Cleared
                        </span>
                      <?php
endif; ?>

                      <a href="index.php?page=coach&action=team_delete&id=<?= (int)$t['id'] ?>&csrf_token=<?= esc($_SESSION['csrf_token'] ?? '') ?>"
                         class="btn btn-sm btn-outline"
                         style="color: var(--live-red); border-color: var(--live-red); font-size: 11px; padding: 4px 8px;"
                         onclick="return confirm('Withdraw team <?= esc($t['team_name']) ?>?');">
                        Withdraw
                      </a>
                    </div>
                  </td>
                </tr>
              <?php
endforeach; ?>
            <?php
else: ?>
              <tr>
                <td colspan="5" class="text-center" style="padding: 24px; color: var(--text-muted);">
                  You have not registered any team yet. Register below.
                </td>
              </tr>
            <?php
endif; ?>
          </tbody>
        </table>
      </div>
    </div>

    <!-- Payment Gateway Guidelines Card -->
    <div class="card" style="margin-top: 16px; border-left: 4px solid var(--accent-blue);">
      <div class="card-header">
        <h4 style="margin: 0; font-size: 14px; display: flex; align-items: center; gap: 8px;">
          <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="color: var(--accent-blue);"><circle cx="12" cy="12" r="10"></circle><line x1="12" y1="16" x2="12" y2="12"></line><line x1="12" y1="8" x2="12.01" y2="8"></line></svg>
          Registration Fee &amp; Payment Guidelines
        </h4>
      </div>
      <p style="font-size: 12px; color: var(--text-secondary); line-height: 1.6; margin: 0;">
        All teams must clear the official <strong>50,000 BDT</strong> tournament entrance fee prior to fixture draws. You can settle payments directly using the <strong>Pay Fee Now</strong> button (simulating bKash / Nagad / Bank Clearance) or submit with instant clearance during team creation.
      </p>
    </div>
  </div>

  <!-- register team form -->
  <div class="col-5" id="registerTeamBox">
    <div class="card">
      <div class="card-header">
        <div class="flex items-center gap-2">
          <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="color: var(--status-success-text);"><path d="M16 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path><circle cx="8.5" cy="7" r="4"></circle><line x1="20" y1="8" x2="20" y2="14"></line><line x1="23" y1="11" x2="17" y2="11"></line></svg>
          <h3>Register Team for Tournament</h3>
        </div>
      </div>

      <?php
if (!empty($error)): ?>
        <div class="alert alert-danger" style="margin-bottom: 14px; font-size: 13px; padding: 10px;">
          <?= esc($error) ?>
        </div>
      <?php
endif; ?>

      <form action="index.php?page=coach&action=team_add" method="POST">
        <?php
csrf_field(); ?>

        <div class="form-group">
          <label for="tournament_id">Target Tournament *</label>
          <select name="tournament_id" id="tournament_id" class="form-control" required>
            <option value="">-- Select Tournament --</option>
            <?php
foreach ($tournaments as $tn): ?>
              <option value="<?= (int)$tn['id'] ?>">
                <?= esc($tn['tournament_name']) ?> (<?= esc($tn['status']) ?>)
              </option>
            <?php
endforeach; ?>
          </select>
        </div>

        <div class="form-group">
          <label for="team_name">Team Name *</label>
          <input type="text" id="team_name" name="team_name" class="form-control" placeholder="e.g. Abahani Titans" required>
        </div>

        <div class="form-group">
          <label for="squad_size">Roster Squad Size (5 - 30)</label>
          <input type="number" id="squad_size" name="squad_size" class="form-control" value="15" min="5" max="30" required>
        </div>

        <div class="form-group">
          <label>Official Entry Fee</label>
          <div style="background: var(--bg-surface-low); padding: 10px 14px; border-radius: var(--radius-md); font-weight: 700; color: var(--text-primary); font-size: 15px; border: 1px solid var(--border-color);">
            50,000.00 BDT
          </div>
        </div>

        <div class="form-group">
          <label for="fee_status">Payment Option *</label>
          <select name="fee_status" id="fee_status" class="form-control" required>
            <option value="Paid">Pay Now (Instant Gateway Clearance)</option>
            <option value="Pending">Pay Later (Mark Pending)</option>
          </select>
          <small style="color: var(--text-muted); font-size: 11px; margin-top: 4px; display: block;">
            You can also clear pending invoices anytime from the table.
          </small>
        </div>

        <button type="submit" class="btn btn-primary" style="width: 100%; margin-top: 10px; display: flex; align-items: center; justify-content: center; gap: 8px;">
          <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"></polyline></svg>
          <span>Register Team &amp; Confirm Entry</span>
        </button>
      </form>
    </div>
  </div>

</div>

<?php
require __DIR__ . '/../partials/footer.php'; ?>

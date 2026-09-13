<?php

$pageTitle   = 'Match Schedules, Venues & Teams';
$pageHeading = 'Spectator Hub';
$pageSub     = 'Explore official match schedules, tournament venues, and competing teams';
require __DIR__ . '/../partials/header.php';
?>

<!-- Page Header Bar -->
<div class="page-title-bar">
  <div>
    <h1>Match Schedules, Venues &amp; Teams</h1>
    <p>Official championship fixtures, registered stadiums, and participating team squads</p>
  </div>
  <div>
    <a href="index.php?page=spectator&action=tickets" class="btn btn-primary btn-sm">
      Book Match Ticket
    </a>
  </div>
</div>

<!-- 4 KPI Metrics Cards -->
<div class="kpi-grid">
  <div class="kpi-card">
    <span class="kpi-title">Scheduled Matches</span>
    <div class="kpi-value-row">
      <span class="kpi-value"><?= count($matchSchedules) ?></span>
    </div>
    <span class="kpi-desc">Official championship matches</span>
  </div>

  <div class="kpi-card">
    <span class="kpi-title">Official Venues</span>
    <div class="kpi-value-row">
      <span class="kpi-value" style="color: #166534;"><?= count($venues) ?></span>
    </div>
    <span class="kpi-desc">Verified match-ready stadiums</span>
  </div>

  <div class="kpi-card">
    <span class="kpi-title">Competing Teams</span>
    <div class="kpi-value-row">
      <span class="kpi-value" style="color: var(--accent-blue);"><?= count($teams) ?></span>
    </div>
    <span class="kpi-desc">Registered tournament squads</span>
  </div>

  <div class="kpi-card">
    <span class="kpi-title">Active Live Match</span>
    <div class="kpi-value-row">
      <span class="kpi-value" style="color: var(--live-red);">1</span>
    </div>
    <span class="kpi-desc">Second Half in progress</span>
  </div>
</div>

<!-- Live Match Spotlight Card -->
<div class="card" style="margin-bottom: 24px;">
  <div class="card-header">
    <div>
      <h3 style="margin: 0; font-size: 16px;">Live Match Spotlight</h3>
      <span style="font-size: 12px; color: var(--text-secondary);">Dhaka Premier League &bull; Bangabandhu National Stadium</span>
    </div>
    <span class="badge badge-error">72' Live Ongoing</span>
  </div>

  <div style="background: #f8fafc; border: 1px solid var(--border-color); border-radius: var(--radius-sm); padding: 18px 24px; margin-bottom: 14px;">
    <div style="display: flex; justify-content: space-between; align-items: center;">
      <div>
        <strong style="font-size: 16px; color: var(--text-primary); display: block;">Abahani Ltd.</strong>
        <span style="font-size: 12px; color: var(--text-secondary);">Home Team</span>
      </div>
      <div style="text-align: center;">
        <span style="font-size: 28px; font-weight: 800; color: var(--text-primary); letter-spacing: 4px;">2 &ndash; 1</span>
        <span style="display: block; font-size: 12px; color: var(--live-red); font-weight: 600; margin-top: 2px;">Second Half</span>
      </div>
      <div style="text-align: right;">
        <strong style="font-size: 16px; color: var(--text-primary); display: block;">Mohammedan SC</strong>
        <span style="font-size: 12px; color: var(--text-secondary);">Away Team</span>
      </div>
    </div>
  </div>

  <div class="flex justify-between items-center">
    <span style="font-size: 13px; color: var(--text-secondary);">Live commentary and score tracking active</span>
    <a href="index.php?page=spectator&action=predictions" class="btn btn-primary btn-sm">
      Vote in Fan Prediction Poll &rarr;
    </a>
  </div>
</div>

<!-- schedule table -->
<div class="grid-12" style="margin-bottom: 24px;">
  <div class="col-12">
    <div class="card">
      <div class="card-header">
        <div>
          <h3 style="margin: 0; font-size: 16px;">Official Tournament Match Schedules</h3>
          <span style="font-size: 12px; color: var(--text-secondary);">All scheduled championship fixtures</span>
        </div>
        <span style="font-size: 12px; color: var(--text-secondary);">
          <?= count($matchSchedules) ?> Matches Listed
        </span>
      </div>

      <div class="table-responsive">
        <table class="data-table">
          <thead>
            <tr>
              <th>Date &amp; Time</th>
              <th>Tournament</th>
              <th>Match Fixture</th>
              <th>Venue &amp; City</th>
              <th>Status</th>
              <th style="text-align: right;">Tickets</th>
            </tr>
          </thead>
          <tbody>
            <?php
foreach ($matchSchedules as $m): 
              $isLive = ($m['status'] === 'Live');
            ?>
              <tr>
                <td>
                  <div class="flex items-center gap-2">
                    <div class="match-time-badge" style="min-width: 58px; text-align: center; padding: 4px 6px;">
                      <span class="match-time-date" style="font-size: 10px; font-weight: 700; color: var(--accent-blue);"><?= esc($m['date']) ?></span>
                      <span class="match-time-hour" style="font-size: 11px; font-weight: 600;"><?= esc($m['time']) ?></span>
                    </div>
                  </div>
                </td>
                <td>
                  <span class="badge badge-neutral"><?= esc($m['tournament']) ?></span>
                </td>
                <td>
                  <div class="flex items-center gap-2">
                    <strong style="color: var(--text-primary); font-size: 13px;"><?= esc($m['title']) ?></strong>
                  </div>
                </td>
                <td>
                  <div style="font-size: 13px; color: var(--text-primary);"><?= esc($m['venue']) ?></div>
                  <span style="font-size: 11px; color: var(--text-muted);"><?= esc($m['city']) ?></span>
                </td>
                <td>
                  <?php
if ($isLive): ?>
                    <span class="badge badge-danger">
                      <span class="pulse-dot" style="width: 5px; height: 5px; background: currentColor;"></span>
                      Live Match
                    </span>
                  <?php
elseif ($m['status'] === 'Upcoming'): ?>
                    <span class="badge badge-blue">Upcoming</span>
                  <?php
else: ?>
                    <span class="badge badge-neutral">Scheduled</span>
                  <?php
endif; ?>
                </td>
                <td style="text-align: right;">
                  <a href="index.php?page=spectator&action=tickets" class="btn btn-sm btn-primary" style="font-size: 11px; padding: 4px 10px; text-decoration: none;">
                    Buy Ticket
                  </a>
                </td>
              </tr>
            <?php
endforeach; ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>

<!-- venues & teams -->
<div class="grid-12">

  <!-- venues -->
  <div class="col-6">
    <div class="card" style="height: 100%;">
      <div class="card-header">
        <div class="flex items-center gap-2">
          <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="color: #10B981;"><path d="M3 21h18"></path><path d="M5 21V7l7-4 7 4v14"></path></svg>
          <h3>Tournament Stadiums &amp; Venues</h3>
        </div>
        <span class="badge badge-success"><?= count($venues) ?> Venues</span>
      </div>

      <div style="display: flex; flex-direction: column; gap: 12px; margin-top: 6px;">
        <?php
foreach ($venues as $v): ?>
          <div style="padding: 14px; background: var(--bg-surface-low); border-radius: var(--radius-md); border-left: 3px solid #10B981; display: flex; justify-content: space-between; align-items: center;">
            <div>
              <strong style="font-size: 14px; color: var(--text-primary); display: block;">
                <?= esc($v['venue_name']) ?>
              </strong>
              <span style="font-size: 12px; color: var(--text-secondary);">
                City: <strong><?= esc($v['city']) ?></strong> &bull; Seating Readiness: <?= (int)($v['seating_pct'] ?? 100) ?>%
              </span>
            </div>
            <span class="badge badge-success" style="font-size: 11px;">
              &check; Match Ready
            </span>
          </div>
        <?php
endforeach; ?>

        <?php
if (empty($venues)): ?>
          <p style="text-align: center; color: var(--text-muted); padding: 20px;">No venues registered yet.</p>
        <?php
endif; ?>
      </div>
    </div>
  </div>

  <!-- teams -->
  <div class="col-6">
    <div class="card" style="height: 100%;">
      <div class="card-header">
        <div class="flex items-center gap-2">
          <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="color: var(--accent-blue);"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path><circle cx="9" cy="7" r="4"></circle><path d="M23 21v-2a4 4 0 0 0-3-3.87"></path><path d="M16 3.13a4 4 0 0 1 0 7.75"></path></svg>
          <h3>Competing Teams Directory</h3>
        </div>
        <span class="badge badge-blue"><?= count($teams) ?> Teams</span>
      </div>

      <div style="display: flex; flex-direction: column; gap: 12px; margin-top: 6px;">
        <?php
foreach ($teams as $tm): 
          $initial = strtoupper(substr($tm['team_name'], 0, 1));
        ?>
          <div style="padding: 12px 14px; background: var(--bg-surface-low); border-radius: var(--radius-md); display: flex; justify-content: space-between; align-items: center;">
            <div class="flex items-center gap-3">
              <div class="avatar-circle avatar-initial-blue" style="width: 32px; height: 32px; font-size: 13px;">
                <?= $initial ?>
              </div>
              <div>
                <strong style="font-size: 13px; color: var(--text-primary); display: block;">
                  <?= esc($tm['team_name']) ?>
                </strong>
                <span style="font-size: 11px; color: var(--text-muted);">
                  Tournament: <?= esc($tm['tournament_name'] ?? 'Championship') ?> &bull; Roster: <?= (int)($tm['squad_size'] ?? 15) ?> Players
                </span>
              </div>
            </div>
            <span class="badge badge-success" style="font-size: 10px;">
              Active Squad
            </span>
          </div>
        <?php
endforeach; ?>

        <?php
if (empty($teams)): ?>
          <p style="text-align: center; color: var(--text-muted); padding: 20px;">No teams registered yet.</p>
        <?php
endif; ?>
      </div>
    </div>
  </div>

</div>

<?php
require __DIR__ . '/../partials/footer.php'; ?>

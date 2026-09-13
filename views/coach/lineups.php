<?php

$pageTitle   = 'Match Lineups & Strategies';
$pageHeading = 'Coach Panel';
$pageSub     = 'Configure starting lineups, tactical formations, and match strategies';
require __DIR__ . '/../partials/header.php';

$team = $activeTeam;
$teamName = $team['team_name'] ?? 'Dhaka Dynamites';
$players = $teamPlayers;

$fitPlayers = [];
$injuredPlayers = [];
foreach ($players as $p) {
    if (!empty($p['is_injured'])) {
        $injuredPlayers[] = $p;
    } else {
        $fitPlayers[] = $p;
    }
}

$starters = array_slice($fitPlayers, 0, 5);
$bench = array_merge(array_slice($fitPlayers, 5), $injuredPlayers);
?>

<!-- Page Header Bar -->
<div class="page-title-bar">
  <div>
    <h1>Match Lineups &amp; Tactical Strategies</h1>
    <p><?= esc($teamName) ?> &bull; Active starting formation, tactical game plan, and squad readiness.</p>
  </div>
  <div>
    <button class="sidebar-cta-btn" style="width: auto; padding: 8px 18px;" onclick="document.getElementById('strategyFormBox')?.scrollIntoView({behavior: 'smooth'})">
      <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polygon points="12 2 2 7 12 12 22 7 12 2"></polygon><polyline points="2 17 12 22 22 17"></polyline><polyline points="2 12 12 17 22 12"></polyline></svg>
      Update Tactical Strategy
    </button>
  </div>
</div>

<!-- 4 Tactical KPI Cards -->
<div class="kpi-grid" style="margin-bottom: 24px;">
  <div class="kpi-card">
    <span class="kpi-title">Active Formation</span>
    <div class="kpi-value-row">
      <span class="kpi-value"><?= esc($strategy['formation'] ?? '4-3-3') ?></span>
      <span class="badge badge-blue">Starting Shape</span>
    </div>
    <span class="kpi-desc">Field structural setup</span>
  </div>

  <div class="kpi-card">
    <span class="kpi-title">Playing Mentality</span>
    <div class="kpi-value-row">
      <span class="kpi-value" style="font-size: 17px; line-height: 1.2;"><?= esc(substr($strategy['mentality'] ?? 'High Press', 0, 16)) ?></span>
      <span class="badge badge-success">Active</span>
    </div>
    <span class="kpi-desc">Tactical gameplay directive</span>
  </div>

  <div class="kpi-card">
    <span class="kpi-title">Match Captain</span>
    <div class="kpi-value-row">
      <span class="kpi-value" style="font-size: 18px; color: var(--accent-blue);"><?= esc(substr($strategy['captain'] ?? 'Jamal Bhuyan', 0, 15)) ?></span>
      <span class="badge badge-neutral">(C) Armband</span>
    </div>
    <span class="kpi-desc">On-pitch leadership</span>
  </div>

  <div class="kpi-card">
    <span class="kpi-title">Squad Readiness</span>
    <div class="kpi-value-row">
      <span class="kpi-value" style="color: var(--status-success-text);">100%</span>
      <span class="badge badge-success">Match Ready</span>
    </div>
    <span class="kpi-desc"><?= count($starters) ?> Starters &bull; <?= count($bench) ?> Bench</span>
  </div>
</div>

<!-- lineup & strategy -->
<div class="grid-12">

  <!-- lineup pitch -->
  <div class="col-8">
    <div class="card">
      <div class="card-header">
        <div class="flex items-center gap-2">
          <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="color: var(--accent-blue);"><polygon points="12 2 2 7 12 12 22 7 12 2"></polygon><polyline points="2 17 12 22 22 17"></polyline><polyline points="2 12 12 17 22 12"></polyline></svg>
          <h3 style="font-size: 15px;">Next Match Starting Lineup (<?= esc($strategy['formation']) ?>)</h3>
        </div>
        <span class="badge badge-success">&check; Starting 5 Confirmed</span>
      </div>

      <!-- 5 Player Lineup Grid Display -->
      <div class="lineup-grid" style="margin-bottom: 20px;">
        <?php
$count = 0;
        foreach ($starters as $p): 
            $count++;
            $initial = strtoupper(substr($p['player_name'], 0, 1));
            $isCapt = (($strategy['captain'] ?? '') === $p['player_name']);
        ?>
          <div class="player-card" style="<?= $isCapt ? 'border-color: #F59E0B; background: rgba(245, 158, 11, 0.05);' : '' ?>">
            <?php
if ($isCapt): ?>
              <span class="badge badge-warning" style="position: absolute; top: 6px; left: 6px; font-size: 9px; padding: 2px 5px;">
                CAPTAIN
              </span>
            <?php
endif; ?>

            <div class="player-avatar" style="<?= $isCapt ? 'color: #F59E0B;' : '' ?>">
              <?= $initial ?>
            </div>
            <span class="player-name"><?= esc($p['player_name']) ?></span>
            <span style="font-size: 10px; color: var(--text-muted);"><?= esc($p['position']) ?></span>
            <span class="badge badge-success" style="margin-top: 6px; font-size: 10px; padding: 2px 6px;">
              <?= number_format((float)($p['rating'] ?? 7.5), 1) ?> ★
            </span>
          </div>
        <?php
endforeach; ?>

        <?php
if (count($starters) < 5): ?>
          <?php
for ($i = count($starters); $i < 5; $i++): ?>
            <div class="player-card" style="border-style: dashed;">
              <div class="player-avatar" style="color: var(--text-muted);">+</div>
              <span class="player-name" style="color: var(--text-muted);">Open Starter Slot</span>
              <span style="font-size: 10px; color: var(--text-muted);">Sub Ready</span>
            </div>
          <?php
endfor; ?>
        <?php
endif; ?>
      </div>

      <!-- Tactical Instructions Banner -->
      <div class="tactical-note" style="margin-top: 14px;">
        <div class="tactical-note-header">
          <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"></path><line x1="12" y1="9" x2="12" y2="13"></line><line x1="12" y1="17" x2="12.01" y2="17"></line></svg>
          <span>Active Game Plan Directive:</span>
        </div>
        <div class="tactical-note-body" style="font-size: 13px; line-height: 1.6;">
          <?= esc($strategy['notes'] ?? 'Focus on high defensive pressing and swift wing transitions.') ?>
        </div>
        <div style="font-size: 11px; color: var(--text-muted); margin-top: 8px;">
          Last updated by Coach: <?= esc($strategy['updated_at'] ?? date('Y-m-d H:i')) ?>
        </div>
      </div>
    </div>
  </div>

  <!-- strategies & formation -->
  <div class="col-4" id="strategyFormBox">
    <div class="card">
      <div class="card-header">
        <div class="flex items-center gap-2">
          <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="color: var(--accent-blue);"><path d="M12 20h9"></path><path d="M16.5 3.5a2.121 2.121 0 0 1 3 3L7 19l-4 1 1-4L16.5 3.5z"></path></svg>
          <h3>Tactical Strategy Setup</h3>
        </div>
      </div>

      <form action="index.php?page=coach&action=save_strategy" method="POST">
        <?php
csrf_field(); ?>

        <div class="form-group">
          <label for="formation">Team Formation *</label>
          <select id="formation" name="formation" class="form-control" required>
            <option value="4-3-3" <?= (($strategy['formation'] ?? '') === '4-3-3') ? 'selected' : '' ?>>4-3-3 (Attacking Width)</option>
            <option value="4-4-2" <?= (($strategy['formation'] ?? '') === '4-4-2') ? 'selected' : '' ?>>4-4-2 (Classic Two Strikers)</option>
            <option value="4-2-3-1" <?= (($strategy['formation'] ?? '') === '4-2-3-1') ? 'selected' : '' ?>>4-2-3-1 (Midfield Dominance)</option>
            <option value="3-5-2" <?= (($strategy['formation'] ?? '') === '3-5-2') ? 'selected' : '' ?>>3-5-2 (Wing-Back Overload)</option>
            <option value="Futsal 2-2-1" <?= (($strategy['formation'] ?? '') === 'Futsal 2-2-1') ? 'selected' : '' ?>>Futsal 2-2-1 (Compact 5-a-side)</option>
          </select>
        </div>

        <div class="form-group">
          <label for="mentality">Tactical Mentality *</label>
          <select id="mentality" name="mentality" class="form-control" required>
            <option value="High Press & Quick Transitions" <?= (($strategy['mentality'] ?? '') === 'High Press & Quick Transitions') ? 'selected' : '' ?>>High Press &amp; Quick Transitions</option>
            <option value="Possession Control & Short Passes" <?= (($strategy['mentality'] ?? '') === 'Possession Control & Short Passes') ? 'selected' : '' ?>>Possession Control &amp; Short Passes</option>
            <option value="Counter-Attack & Direct Play" <?= (($strategy['mentality'] ?? '') === 'Counter-Attack & Direct Play') ? 'selected' : '' ?>>Counter-Attack &amp; Direct Play</option>
            <option value="Low Block & Compact Defence" <?= (($strategy['mentality'] ?? '') === 'Low Block & Compact Defence') ? 'selected' : '' ?>>Low Block &amp; Compact Defence</option>
          </select>
        </div>

        <div class="form-group">
          <label for="captain">Team Captain *</label>
          <select id="captain" name="captain" class="form-control" required>
            <?php
foreach ($players as $p): ?>
              <option value="<?= esc($p['player_name']) ?>" <?= (($strategy['captain'] ?? '') === $p['player_name']) ? 'selected' : '' ?>>
                <?= esc($p['player_name']) ?> (<?= esc($p['position']) ?>)
              </option>
            <?php
endforeach; ?>
          </select>
        </div>

        <div class="form-group">
          <label for="notes">Tactical Instructions &amp; Strategy Notes</label>
          <textarea id="notes" name="notes" class="form-control" rows="4" placeholder="Enter instructions for passing lanes, defensive shape, set piece strategies..." required><?= esc($strategy['notes'] ?? '') ?></textarea>
        </div>

        <button type="submit" class="btn btn-primary" style="width: 100%; display: flex; align-items: center; justify-content: center; gap: 8px;">
          <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"></polyline></svg>
          <span>Save Match Strategy &amp; Lineup</span>
        </button>
      </form>
    </div>
  </div>

</div>

<!-- bench & reserves -->
<div class="grid-12" style="margin-top: 24px;">
  <div class="col-12">
    <div class="card">
      <div class="card-header">
        <div class="flex items-center gap-2">
          <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="color: var(--text-secondary);"><rect x="3" y="3" width="7" height="7"></rect><rect x="14" y="3" width="7" height="7"></rect><rect x="14" y="14" width="7" height="7"></rect><rect x="3" y="14" width="7" height="7"></rect></svg>
          <h3>Reserves &amp; Substitution Bench</h3>
        </div>
        <span class="badge" style="background: var(--bg-surface-low); color: var(--text-secondary);">
          <?= count($bench) ?> Reserves Available
        </span>
      </div>

      <div class="table-responsive">
        <table class="data-table">
          <thead>
            <tr>
              <th>Player</th>
              <th>Position</th>
              <th>Rating</th>
              <th>Fitness Status</th>
              <th>Role</th>
              <th style="text-align: right;">Readiness</th>
            </tr>
          </thead>
          <tbody>
            <?php
if (!empty($bench)): ?>
              <?php
foreach ($bench as $b): 
                $isInjured = !empty($b['is_injured']);
              ?>
                <tr>
                  <td>
                    <div class="flex items-center gap-2">
                      <div class="avatar-circle <?= $isInjured ? 'avatar-initial-red' : 'avatar-initial-purple' ?>" style="width: 28px; height: 28px; font-size: 11px;">
                        <?= strtoupper(substr($b['player_name'], 0, 2)) ?>
                      </div>
                      <strong><?= esc($b['player_name']) ?></strong>
                    </div>
                  </td>
                  <td><?= esc($b['position']) ?></td>
                  <td>
                    <strong><?= number_format((float)($b['rating'] ?? 7.0), 1) ?></strong>
                  </td>
                  <td>
                    <?php
if ($isInjured): ?>
                      <span class="badge badge-danger">Injured</span>
                    <?php
else: ?>
                      <span class="badge badge-success">&check; Fit</span>
                    <?php
endif; ?>
                  </td>
                  <td>
                    <?= $isInjured ? 'Medical Recovery' : 'Tactical Impact Sub' ?>
                  </td>
                  <td style="text-align: right;">
                    <?php
if ($isInjured): ?>
                      <span style="font-size: 11px; color: var(--live-red); font-weight: 600;">Unavailable</span>
                    <?php
else: ?>
                      <span class="badge badge-blue">Ready to Sub</span>
                    <?php
endif; ?>
                  </td>
                </tr>
              <?php
endforeach; ?>
            <?php
else: ?>
              <tr>
                <td colspan="6" class="text-center" style="padding: 20px; color: var(--text-muted);">
                  All squad players are currently in the starting 5 lineup.
                </td>
              </tr>
            <?php
endif; ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>

<?php
require __DIR__ . '/../partials/footer.php'; ?>

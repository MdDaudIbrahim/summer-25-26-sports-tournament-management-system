<?php

$pageTitle   = 'Coach Dashboard';
$pageHeading = 'Coach Panel';
$pageSub     = 'Manage team lineup, roster and performance analytics';
require __DIR__ . '/../partials/header.php';

$team = $myTeams[0] ?? null;
$teamName = $team['team_name'] ?? 'Dhaka Dynamites';
$tournamentName = 'Bangabandhu National Championship';
$feeStatus = $team['fee_status'] ?? 'Paid';
$feeAmount = number_format($team['fee_amount'] ?? 50000, 2);
$players = $team ? ($myPlayers[$team['id']] ?? []) : [];
?>

<!-- Page Header Bar -->
<div class="page-title-bar">
  <div>
    <h1>Coach Dashboard</h1>
    <p><?= esc($teamName) ?> &bull; <?= esc($tournamentName) ?></p>
  </div>
  <div>
    <button class="sidebar-cta-btn" style="width: auto; padding: 8px 16px;" onclick="document.getElementById('addPlayerFormBox')?.scrollIntoView({behavior: 'smooth'})">
      + Add Player
    </button>
  </div>
</div>

<!-- Bento Grid Layout -->
<div class="grid-12">

  <!-- row left: registration & fee status -->
  <div class="col-4 flex flex-col">
    <div class="card flex-1 flex flex-col justify-between">
      <div>
        <div class="card-header">
          <div class="flex items-center gap-2">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="color: var(--accent-blue);"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline><line x1="16" y1="13" x2="8" y2="13"></line><line x1="16" y1="17" x2="8" y2="17"></line><polyline points="10 9 9 9 8 9"></polyline></svg>
            <h3>Tournament Registration</h3>
          </div>
        </div>

        <p style="font-size: 14px; margin-bottom: 8px; font-weight: 600;"><?= esc($tournamentName) ?></p>
        <div class="flex items-center gap-2" style="margin-bottom: 20px;">
          <span style="width: 8px; height: 8px; background-color: #10B981; border-radius: 50%;"></span>
          <span style="font-size: 13px; font-weight: 600; color: #10B981;">Registered</span>
        </div>
      </div>

      <!-- Fee Status Box -->
      <div style="background-color: var(--bg-surface-low); padding: 14px; border-radius: var(--radius-md); display: flex; justify-content: space-between; align-items: center;">
        <div>
          <span style="font-size: 10px; font-weight: 700; text-transform: uppercase; color: var(--text-muted); display: block; margin-bottom: 2px;">Fee Status</span>
          <strong style="font-size: 16px; color: var(--text-primary);"><?= $feeAmount ?> BDT</strong>
        </div>
        <span class="badge badge-success" style="font-size: 12px; padding: 4px 10px;"><?= esc($feeStatus) ?></span>
      </div>
    </div>
  </div>

  <!-- row right: next match starting 5 lineup -->
  <div class="col-8" id="lineupSection">
    <div class="card">
      <div class="card-header">
        <div class="flex items-center gap-2">
          <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="color: var(--accent-blue);"><polygon points="12 2 2 7 12 12 22 7 12 2"></polygon><polyline points="2 17 12 22 22 17"></polyline><polyline points="2 12 12 17 22 12"></polyline></svg>
          <h3>Next Match - Starting 5 Lineup</h3>
        </div>
        <span class="badge badge-success">Match Ready</span>
      </div>

      <!-- 5 Player Lineup Grid -->
      <div class="lineup-grid">
        <?php
$count = 0;
        foreach ($players as $p): 
            if ($count >= 5) break;
            $count++;
            $initial = strtoupper(substr($p['player_name'], 0, 1));
        ?>
          <div class="player-card" <?php
if (!empty($p['is_injured'])) echo 'style="border-color: rgba(239, 68, 68, 0.4);"'; ?>>
            <?php
if (!empty($p['is_injured'])): ?>
              <span class="injury-badge">
                <span class="pulse-dot" style="width: 5px; height: 5px; background: #FFFFFF;"></span>
                INJ
              </span>
            <?php
endif; ?>
            <div class="player-avatar" <?php
if (!empty($p['is_injured'])) echo 'style="color: var(--live-red); opacity: 0.8;"'; ?>>
              <?= $initial ?>
            </div>
            <span class="player-name"><?= esc($p['player_name']) ?></span>
            <span style="font-size: 10px; color: var(--text-muted);"><?= esc($p['position']) ?></span>
          </div>
        <?php
endforeach; ?>

        <?php
if (count($players) < 5): ?>
          <?php
for ($i = count($players); $i < 5; $i++): ?>
            <div class="player-card" style="border-style: dashed;">
              <div class="player-avatar" style="color: var(--text-muted);">+</div>
              <span class="player-name" style="color: var(--text-muted);">Open Slot</span>
            </div>
          <?php
endfor; ?>
        <?php
endif; ?>
      </div>

      <!-- Tactical Notes Banner -->
      <div class="tactical-note">
        <div class="tactical-note-header">
          <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"></path><line x1="12" y1="9" x2="12" y2="13"></line><line x1="12" y1="17" x2="12.01" y2="17"></line></svg>
          <span>Tactical Notes</span>
        </div>
        <div class="tactical-note-body">
          Focus on zonal marking and swift transition attacks. Keep ball possession during defensive transitions.
        </div>
      </div>
    </div>
  </div>

  <!-- row: player performance table -->
  <div class="col-12" id="performanceSection">
    <div class="card">
      <div class="card-header">
        <div class="flex items-center gap-2">
          <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="color: var(--text-secondary);"><line x1="18" y1="20" x2="18" y2="10"></line><line x1="12" y1="20" x2="12" y2="4"></line><line x1="6" y1="20" x2="6" y2="14"></line></svg>
          <h3>Player Performance Analytics (From MySQL Database)</h3>
        </div>
        <span class="badge" style="background: var(--bg-surface-low); color: var(--text-secondary);">
          Total Squad: <?= count($players) ?>
        </span>
      </div>

      <div class="table-responsive">
        <table class="data-table">
          <thead>
            <tr>
              <th>Player</th>
              <th>Position</th>
              <th>Matches</th>
              <th>Points</th>
              <th>Assists</th>
              <th>Rating</th>
              <th style="text-align: right;">Actions</th>
            </tr>
          </thead>
          <tbody>
            <?php
if (!empty($players)): ?>
              <?php
foreach ($players as $p): ?>
                <tr>
                  <td>
                    <div class="flex items-center gap-3">
                      <div class="avatar-circle avatar-initial-blue">
                        <?= strtoupper(substr($p['player_name'], 0, 2)) ?>
                      </div>
                      <div>
                        <strong><?= esc($p['player_name']) ?></strong>
                        <?php
if (!empty($p['is_injured'])): ?>
                          <span style="color: var(--live-red); font-size: 11px; font-weight: 700;">(Injured)</span>
                        <?php
endif; ?>
                      </div>
                    </div>
                  </td>
                  <td><?= esc($p['position']) ?></td>
                  <td><?= (int)($p['matches_played'] ?? 0) ?></td>
                  <td><strong><?= (int)($p['points'] ?? 0) ?></strong></td>
                  <td><?= (int)($p['assists'] ?? 0) ?></td>
                  <td>
                    <div class="flex items-center gap-2">
                      <strong style="color: <?= (($p['rating'] ?? 7.5) >= 8.0) ? 'var(--status-success-text)' : 'var(--accent-blue)'; ?>;">
                        <?= number_format((float)($p['rating'] ?? 7.5), 1) ?>
                      </strong>
                      <div class="progress-bar-bg" style="width: 70px; height: 6px;">
                        <div class="progress-bar-fill <?= (($p['rating'] ?? 7.5) >= 8.0) ? 'fill-green' : 'fill-blue'; ?>" style="width: <?= min(100, (float)($p['rating'] ?? 7.5) * 10) ?>%;"></div>
                      </div>
                    </div>
                  </td>
                  <td style="text-align: right;">
                    <a href="index.php?page=coach&action=player_delete&id=<?= (int)$p['id'] ?>&csrf_token=<?= esc($_SESSION['csrf_token'] ?? '') ?>"
                       onclick="return confirm('Remove player <?= esc($p['player_name']) ?>?');"
                       class="btn btn-outline btn-sm" style="color: var(--live-red); border-color: var(--live-red); font-size: 11px;">Remove</a>
                  </td>
                </tr>
              <?php
endforeach; ?>
            <?php
else: ?>
              <tr>
                <td colspan="7" class="text-center" style="padding: 20px; color: var(--text-muted);">No players found for this team. Add players below.</td>
              </tr>
            <?php
endif; ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>

  <!-- add player form -->
  <div class="col-12" id="addPlayerFormBox">
    <div class="card">
      <div class="card-header">
        <h3>Add New Player to Squad (Database Insertion)</h3>
      </div>
      <form action="index.php?page=coach&action=player_add" method="POST">
        <?php
csrf_field(); ?>
        <input type="hidden" name="team_id" value="<?= (int)($team['id'] ?? 1) ?>">
        <div style="display: grid; grid-template-columns: repeat(4, 1fr); gap: 12px; margin-bottom: 12px;">
          <div class="form-group" style="margin-bottom: 0;">
            <label for="player_name">Player Name</label>
            <input type="text" id="player_name" name="player_name" class="form-control" placeholder="e.g. Jamal Bhuyan" required>
          </div>
          <div class="form-group" style="margin-bottom: 0;">
            <label for="position">Position</label>
            <input type="text" id="position" name="position" class="form-control" placeholder="e.g. Midfielder / Forward" required>
          </div>
          <div class="form-group" style="margin-bottom: 0;">
            <label for="matches_played">Matches</label>
            <input type="number" id="matches_played" name="matches_played" class="form-control" value="0" min="0">
          </div>
          <div class="form-group" style="margin-bottom: 0;">
            <label for="points">Points / Goals</label>
            <input type="number" id="points" name="points" class="form-control" value="0" min="0">
          </div>
        </div>

        <div style="display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 12px; margin-bottom: 16px; align-items: center;">
          <div class="form-group" style="margin-bottom: 0;">
            <label for="assists">Assists</label>
            <input type="number" id="assists" name="assists" class="form-control" value="0" min="0">
          </div>
          <div class="form-group" style="margin-bottom: 0;">
            <label for="rating">Rating (1.0 - 10.0)</label>
            <input type="number" step="0.1" id="rating" name="rating" class="form-control" value="7.5" min="1.0" max="10.0">
          </div>
          <div class="form-group" style="margin-bottom: 0; padding-top: 18px;">
            <label class="form-checkbox" for="is_injured">
              <input type="checkbox" id="is_injured" name="is_injured" value="1">
              <span>Mark as Injured</span>
            </label>
          </div>
        </div>

        <button type="submit" name="add_player" class="btn btn-primary">
          <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg>
          Add Player to Database
        </button>
      </form>
    </div>
  </div>

</div>

<?php
require __DIR__ . '/../partials/footer.php'; ?>

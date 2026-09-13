<?php

$pageTitle   = 'Player Performance Analytics';
$pageHeading = 'Coach Panel';
$pageSub     = 'Track player performance, statistics, and squad fitness';
require __DIR__ . '/../partials/header.php';

$team = $activeTeam;
$teamName = $team['team_name'] ?? 'My Squad';
$players = $teamPlayers;
?>

<!-- Page Header Bar -->
<div class="page-title-bar">
  <div>
    <h1>Player Performance Tracking</h1>
    <p><?= esc($teamName) ?> &bull; Individual match statistics, efficiency ratings, and fitness readiness.</p>
  </div>
  <div>
    <button class="btn btn-sm btn-primary" style="padding: 8px 18px;" onclick="document.getElementById('addPlayerFormBox')?.scrollIntoView({behavior: 'smooth'})">
      + Add Player to Squad
    </button>
  </div>
</div>

<!-- 4 Performance KPI Cards -->
<div class="kpi-grid" style="margin-bottom: 24px;">
  <div class="kpi-card">
    <span class="kpi-title">Total Squad</span>
    <div class="kpi-value-row">
      <span class="kpi-value"><?= $totalSquad ?></span>
      <span class="badge badge-neutral">Active Roster</span>
    </div>
    <span class="kpi-desc">Players registered in squad</span>
  </div>

  <div class="kpi-card">
    <span class="kpi-title">Top Rated Player</span>
    <div class="kpi-value-row">
      <span class="kpi-value" style="color: var(--accent-blue);">
        <?= $topRatedPlayer ? number_format((float)$topRatedPlayer['rating'], 1) : '0.0' ?>
      </span>
      <span class="badge badge-success"><?= $topRatedPlayer ? esc(substr($topRatedPlayer['player_name'], 0, 14)) : 'N/A' ?></span>
    </div>
    <span class="kpi-desc">Highest match efficiency</span>
  </div>

  <div class="kpi-card">
    <span class="kpi-title">Top Scorer (Points/Goals)</span>
    <div class="kpi-value-row">
      <span class="kpi-value" style="color: var(--status-success-text);">
        <?= $topScorer ? (int)$topScorer['points'] : 0 ?>
      </span>
      <span class="badge badge-blue"><?= $topScorer ? esc(substr($topScorer['player_name'], 0, 14)) : 'N/A' ?></span>
    </div>
    <span class="kpi-desc">Most points scored this season</span>
  </div>

  <div class="kpi-card">
    <span class="kpi-title">Squad Fitness Index</span>
    <div class="kpi-value-row">
      <span class="kpi-value" style="color: <?= $injuredCount > 0 ? 'var(--status-warning-text)' : 'var(--status-success-text)' ?>;">
        <?= $readinessPct ?>%
      </span>
      <span class="badge <?= $injuredCount > 0 ? 'badge-warning' : 'badge-success' ?>">
        <?= $injuredCount ?> Injured
      </span>
    </div>
    <span class="kpi-desc"><?= $fitCount ?> match-ready players</span>
  </div>
</div>

<!-- player analytics table -->
<div class="grid-12" style="margin-bottom: 24px;">
  <div class="col-12">
    <div class="card">
      <div class="card-header">
        <div class="flex items-center gap-2">
          <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="color: var(--accent-blue);"><line x1="18" y1="20" x2="18" y2="10"></line><line x1="12" y1="20" x2="12" y2="4"></line><line x1="6" y1="20" x2="6" y2="14"></line></svg>
          <h3>Squad Performance Analytics Table</h3>
        </div>
        <span class="badge" style="background: var(--bg-surface-low); color: var(--text-secondary);">
          <?= count($players) ?> Players Evaluated
        </span>
      </div>

      <div class="table-responsive">
        <table class="data-table">
          <thead>
            <tr>
              <th>Player Name</th>
              <th>Position</th>
              <th>Matches</th>
              <th>Points / Goals</th>
              <th>Assists</th>
              <th>Performance Rating</th>
              <th>Fitness Status</th>
              <th style="text-align: right;">Action</th>
            </tr>
          </thead>
          <tbody>
            <?php
if (!empty($players)): ?>
              <?php
foreach ($players as $p): 
                $rating = (float)($p['rating'] ?? 7.0);
                $isInjured = !empty($p['is_injured']);
              ?>
                <tr>
                  <td>
                    <div class="flex items-center gap-3">
                      <div class="avatar-circle <?= $isInjured ? 'avatar-initial-red' : 'avatar-initial-blue' ?>">
                        <?= strtoupper(substr($p['player_name'], 0, 2)) ?>
                      </div>
                      <div>
                        <strong><?= esc($p['player_name']) ?></strong>
                        <?php
if ($isInjured): ?>
                          <span style="color: var(--live-red); font-size: 11px; font-weight: 700; margin-left: 4px;">[Sidelined]</span>
                        <?php
endif; ?>
                      </div>
                    </div>
                  </td>
                  <td>
                    <span class="badge badge-neutral"><?= esc($p['position']) ?></span>
                  </td>
                  <td><?= (int)($p['matches_played'] ?? 0) ?></td>
                  <td>
                    <strong style="color: var(--text-primary); font-size: 14px;"><?= (int)($p['points'] ?? 0) ?></strong>
                  </td>
                  <td><?= (int)($p['assists'] ?? 0) ?></td>
                  <td>
                    <div class="flex items-center gap-2">
                      <strong style="width: 28px; color: <?= ($rating >= 8.0) ? 'var(--status-success-text)' : 'var(--accent-blue)'; ?>;">
                        <?= number_format($rating, 1) ?>
                      </strong>
                      <div class="progress-bar-bg" style="width: 80px; height: 6px;">
                        <div class="progress-bar-fill <?= ($rating >= 8.0) ? 'fill-green' : 'fill-blue'; ?>" style="width: <?= min(100, $rating * 10) ?>%;"></div>
                      </div>
                    </div>
                  </td>
                  <td>
                    <?php
if ($isInjured): ?>
                      <span class="badge badge-danger">
                        <span class="pulse-dot" style="width: 5px; height: 5px; background: currentColor;"></span>
                        Injured
                      </span>
                    <?php
else: ?>
                      <span class="badge badge-success">
                        &check; Match Fit
                      </span>
                    <?php
endif; ?>
                  </td>
                  <td style="text-align: right;">
                    <a href="index.php?page=coach&action=player_delete&id=<?= (int)$p['id'] ?>&csrf_token=<?= esc($_SESSION['csrf_token'] ?? '') ?>"
                       onclick="return confirm('Remove player <?= esc($p['player_name']) ?> from squad?');"
                       class="btn btn-outline btn-sm" style="color: var(--live-red); border-color: var(--live-red); font-size: 11px;">
                      Remove
                    </a>
                  </td>
                </tr>
              <?php
endforeach; ?>
            <?php
else: ?>
              <tr>
                <td colspan="8" class="text-center" style="padding: 24px; color: var(--text-muted);">
                  No players found in this squad. Add your first player below!
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

<!-- performers & add form -->
<div class="grid-12">

  <!-- top performers -->
  <div class="col-6">
    <div class="card" style="height: 100%;">
      <div class="card-header">
        <div class="flex items-center gap-2">
          <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="color: #F59E0B;"><circle cx="12" cy="8" r="7"></circle><polyline points="8.21 13.89 7 23 12 20 17 23 15.79 13.88"></polyline></svg>
          <h3>Squad Top Performers Spotlight</h3>
        </div>
      </div>

      <div style="display: flex; flex-direction: column; gap: 14px; margin-top: 6px;">
        <?php
$sortedByRating = $players;
        usort($sortedByRating, function($a, $b) {
            return (float)$b['rating'] <=> (float)$a['rating'];
        });
        $spotlight = array_slice($sortedByRating, 0, 3);
        $rank = 1;
        foreach ($spotlight as $sp):
        ?>
          <div style="display: flex; align-items: center; justify-content: space-between; padding: 12px 14px; background: var(--bg-surface-low); border-radius: var(--radius-md); border-left: 3px solid <?= $rank === 1 ? '#F59E0B' : ($rank === 2 ? '#3B82F6' : '#10B981') ?>;">
            <div class="flex items-center gap-3">
              <div style="width: 26px; height: 26px; border-radius: 50%; background: <?= $rank === 1 ? 'rgba(245, 158, 11, 0.15)' : 'rgba(59, 130, 246, 0.15)' ?>; color: <?= $rank === 1 ? '#F59E0B' : '#3B82F6' ?>; display: flex; align-items: center; justify-content: center; font-weight: 700; font-size: 12px;">
                #<?= $rank++ ?>
              </div>
              <div>
                <strong style="font-size: 14px; display: block;"><?= esc($sp['player_name']) ?></strong>
                <span style="font-size: 11px; color: var(--text-muted);"><?= esc($sp['position']) ?> &bull; <?= (int)$sp['matches_played'] ?> Matches</span>
              </div>
            </div>

            <div class="flex items-center gap-3">
              <div style="text-align: right;">
                <span style="font-size: 11px; color: var(--text-muted); display: block;">Goals / Assists</span>
                <strong style="font-size: 13px; color: var(--text-primary);"><?= (int)$sp['points'] ?>G / <?= (int)$sp['assists'] ?>A</strong>
              </div>
              <span class="badge badge-success" style="font-size: 12px; padding: 4px 8px;">
                <?= number_format((float)$sp['rating'], 1) ?> ★
              </span>
            </div>
          </div>
        <?php
endforeach; ?>

        <?php
if (empty($spotlight)): ?>
          <p style="color: var(--text-muted); font-size: 13px; text-align: center; padding: 20px;">
            No performance records yet.
          </p>
        <?php
endif; ?>
      </div>
    </div>
  </div>

  <!-- add player form -->
  <div class="col-6" id="addPlayerFormBox">
    <div class="card">
      <div class="card-header">
        <div class="flex items-center gap-2">
          <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="color: var(--status-success-text);"><path d="M16 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path><circle cx="8.5" cy="7" r="4"></circle><line x1="20" y1="8" x2="20" y2="14"></line><line x1="23" y1="11" x2="17" y2="11"></line></svg>
          <h3>Add Player to Squad Roster</h3>
        </div>
      </div>

      <form action="index.php?page=coach&action=player_add" method="POST">
        <?php
csrf_field(); ?>
        <input type="hidden" name="team_id" value="<?= (int)($team['id'] ?? 1) ?>">

        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 12px; margin-bottom: 12px;">
          <div class="form-group" style="margin-bottom: 0;">
            <label for="player_name">Player Name *</label>
            <input type="text" id="player_name" name="player_name" class="form-control" placeholder="e.g. Jamal Bhuyan" required>
          </div>
          <div class="form-group" style="margin-bottom: 0;">
            <label for="position">Field Position *</label>
            <select id="position" name="position" class="form-control" required>
              <option value="Forward">Forward</option>
              <option value="Midfielder">Midfielder</option>
              <option value="Defender">Defender</option>
              <option value="Goalkeeper">Goalkeeper</option>
              <option value="Winger">Winger</option>
              <option value="Center Back">Center Back</option>
            </select>
          </div>
        </div>

        <div style="display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 12px; margin-bottom: 12px;">
          <div class="form-group" style="margin-bottom: 0;">
            <label for="matches_played">Matches</label>
            <input type="number" id="matches_played" name="matches_played" class="form-control" value="0" min="0">
          </div>
          <div class="form-group" style="margin-bottom: 0;">
            <label for="points">Points / Goals</label>
            <input type="number" id="points" name="points" class="form-control" value="0" min="0">
          </div>
          <div class="form-group" style="margin-bottom: 0;">
            <label for="assists">Assists</label>
            <input type="number" id="assists" name="assists" class="form-control" value="0" min="0">
          </div>
        </div>

        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 12px; margin-bottom: 16px; align-items: center;">
          <div class="form-group" style="margin-bottom: 0;">
            <label for="rating">Rating (1.0 - 10.0)</label>
            <input type="number" step="0.1" id="rating" name="rating" class="form-control" value="7.5" min="1.0" max="10.0">
          </div>
          <div class="form-group" style="margin-bottom: 0; padding-top: 20px;">
            <label class="form-checkbox" for="is_injured">
              <input type="checkbox" id="is_injured" name="is_injured" value="1">
              <span>Mark as Sidelined / Injured</span>
            </label>
          </div>
        </div>

        <button type="submit" class="btn btn-primary" style="width: 100%;">
          <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg>
          Add Player to Squad Database
        </button>
      </form>
    </div>
  </div>

</div>

<?php
require __DIR__ . '/../partials/footer.php'; ?>

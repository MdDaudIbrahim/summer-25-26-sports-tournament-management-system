<?php

$pageTitle   = 'Fan Voting & Match Predictions';
$pageHeading = 'Spectator Hub';
$pageSub     = 'Vote in live spectator polls, predict match winners, and climb the fan leaderboard';
require __DIR__ . '/../partials/header.php';
?>

<!-- Page Header Bar -->
<div class="page-title-bar">
  <div>
    <h1>Fan Voting &amp; Match Predictions</h1>
    <p>Predict match winners, participate in community polls, and earn fan points</p>
  </div>
  <div>
    <a href="#predictionPollBox" class="btn btn-primary btn-sm">
      Vote in Live Poll
    </a>
  </div>
</div>

<!-- 4 KPI Metrics Cards -->
<div class="kpi-grid">
  <div class="kpi-card">
    <span class="kpi-title">Total Fan Votes</span>
    <div class="kpi-value-row">
      <span class="kpi-value"><?= $totalVotes ?></span>
    </div>
    <span class="kpi-desc">Recorded in MySQL database</span>
  </div>

  <div class="kpi-card">
    <span class="kpi-title">Fan Consensus</span>
    <div class="kpi-value-row">
      <span class="kpi-value" style="color: var(--accent-blue);"><?= $abahaniPct ?>%</span>
    </div>
    <span class="kpi-desc">Favors Abahani Limited</span>
  </div>

  <div class="kpi-card">
    <span class="kpi-title">Fan Rank</span>
    <div class="kpi-value-row">
      <span class="kpi-value" style="color: #d97706;">#1</span>
    </div>
    <span class="kpi-desc">Top predictor this season</span>
  </div>

  <div class="kpi-card">
    <span class="kpi-title">Prediction Accuracy</span>
    <div class="kpi-value-row">
      <span class="kpi-value" style="color: #166534;">85%</span>
    </div>
    <span class="kpi-desc">Based on past match results</span>
  </div>
</div>

<!-- prediction & leaderboard -->
<div class="grid-12">

  <!-- prediction poll -->
  <div class="col-7" id="predictionPollBox">
    <div class="card">
      <div class="card-header">
        <div>
          <h3 style="margin: 0; font-size: 16px;">Featured Match Fan Poll</h3>
          <span style="font-size: 12px; color: var(--text-secondary);">Today's Premier League fixture</span>
        </div>
        <span class="badge badge-error">Poll Active</span>
      </div>

      <!-- Match Banner Inside Poll -->
      <div style="background: var(--bg-surface-low); padding: 16px; border-radius: var(--radius-md); margin-bottom: 20px; border: 1px solid var(--border-color);">
        <div style="display: flex; justify-content: space-between; align-items: center;">
          <div>
            <strong style="font-size: 15px; color: var(--text-primary); display: block;"><?= esc($matchName) ?></strong>
            <span style="font-size: 12px; color: var(--text-secondary);">Bangabandhu National Stadium &bull; 2nd Half (72')</span>
          </div>
          <span class="badge badge-blue">Live Score: 2 - 1</span>
        </div>
      </div>

      <!-- Live Voting Percentage Progress Bars -->
      <div style="margin-bottom: 24px;">
        <h4 style="font-size: 13px; text-transform: uppercase; color: var(--text-muted); margin-bottom: 12px; letter-spacing: 0.5px;">
          Live Spectator Voting Distribution (<?= $totalVotes ?> Total Votes)
        </h4>

        <!-- Abahani -->
        <div style="margin-bottom: 12px;">
          <div style="display: flex; justify-content: space-between; font-size: 13px; margin-bottom: 4px;">
            <strong style="color: var(--text-primary);">Abahani Ltd. to Win</strong>
            <span style="font-weight: 700; color: var(--accent-blue);"><?= $abahaniPct ?>% (<?= $votes['Abahani'] ?> votes)</span>
          </div>
          <div class="progress-bar-bg" style="height: 8px; width: 100%;">
            <div class="progress-bar-fill fill-blue" style="width: <?= $abahaniPct ?>%;"></div>
          </div>
        </div>

        <!-- Mohammedan -->
        <div style="margin-bottom: 12px;">
          <div style="display: flex; justify-content: space-between; font-size: 13px; margin-bottom: 4px;">
            <strong style="color: var(--text-primary);">Mohammedan SC to Win</strong>
            <span style="font-weight: 700; color: #10B981;"><?= $mohammedanPct ?>% (<?= $votes['Mohammedan'] ?> votes)</span>
          </div>
          <div class="progress-bar-bg" style="height: 8px; width: 100%;">
            <div class="progress-bar-fill fill-green" style="width: <?= $mohammedanPct ?>%;"></div>
          </div>
        </div>

        <!-- Draw -->
        <div style="margin-bottom: 12px;">
          <div style="display: flex; justify-content: space-between; font-size: 13px; margin-bottom: 4px;">
            <strong style="color: var(--text-primary);">Match Ends in a Draw</strong>
            <span style="font-weight: 700; color: var(--text-secondary);"><?= $drawPct ?>% (<?= $votes['Draw'] ?> votes)</span>
          </div>
          <div class="progress-bar-bg" style="height: 8px; width: 100%;">
            <div class="progress-bar-fill" style="background: #94a3b8; width: <?= $drawPct ?>%;"></div>
          </div>
        </div>
      </div>

      <!-- Interactive Voting Form -->
      <form action="index.php?page=spectator&action=predict" method="POST" style="border-top: 1px solid var(--border-color); padding-top: 18px;">
        <?php
csrf_field(); ?>
        <input type="hidden" name="match_name" value="<?= esc($matchName) ?>">

        <label style="font-size: 13px; font-weight: 700; color: var(--text-primary); margin-bottom: 12px; display: block;">
          Select Your Prediction:
        </label>

        <div style="display: flex; flex-direction: column; gap: 10px; margin-bottom: 18px;">
          <label style="display: flex; align-items: center; gap: 10px; padding: 10px 14px; background: var(--bg-surface-low); border-radius: var(--radius-md); cursor: pointer; border: 1px solid var(--border-color);">
            <input type="radio" name="predicted_winner" value="Abahani" required checked>
            <span style="font-size: 13px; font-weight: 600; color: var(--text-primary);">Abahani Ltd.</span>
          </label>

          <label style="display: flex; align-items: center; gap: 10px; padding: 10px 14px; background: var(--bg-surface-low); border-radius: var(--radius-md); cursor: pointer; border: 1px solid var(--border-color);">
            <input type="radio" name="predicted_winner" value="Mohammedan">
            <span style="font-size: 13px; font-weight: 600; color: var(--text-primary);">Mohammedan SC</span>
          </label>

          <label style="display: flex; align-items: center; gap: 10px; padding: 10px 14px; background: var(--bg-surface-low); border-radius: var(--radius-md); cursor: pointer; border: 1px solid var(--border-color);">
            <input type="radio" name="predicted_winner" value="Draw">
            <span style="font-size: 13px; font-weight: 600; color: var(--text-primary);">Match Draw</span>
          </label>
        </div>

        <button type="submit" class="btn btn-primary btn-full" style="padding: 10px;">
          Submit Prediction
        </button>
      </form>
    </div>
  </div>

  <!-- leaderboard -->
  <div class="col-5">

    <!-- Leaderboard Card -->
    <div class="card">
      <div class="card-header">
        <div>
          <h3 style="margin: 0; font-size: 16px;">Fan Leaderboard</h3>
          <span style="font-size: 12px; color: var(--text-secondary);">Top predictors this season</span>
        </div>
      </div>

      <div style="display: flex; flex-direction: column; gap: 10px; margin-top: 6px;">
        <div style="display: flex; justify-content: space-between; align-items: center; padding: 10px 12px; background: rgba(245, 158, 11, 0.08); border-left: 3px solid #F59E0B; border-radius: var(--radius-sm);">
          <div class="flex items-center gap-3">
            <strong style="color: #F59E0B; font-size: 14px;">#1</strong>
            <div>
              <strong style="font-size: 13px; color: var(--text-primary);"><?= esc($navUser['full_name'] ?? 'Tanvir Ahmed') ?> (You)</strong>
              <span style="font-size: 11px; color: var(--text-muted); display: block;">Rank: Gold Predictor</span>
            </div>
          </div>
          <span class="badge badge-success" style="font-size: 11px;">450 PTS</span>
        </div>

        <div style="display: flex; justify-content: space-between; align-items: center; padding: 10px 12px; background: var(--bg-surface-low); border-radius: var(--radius-sm);">
          <div class="flex items-center gap-3">
            <strong style="color: var(--text-muted); font-size: 14px;">#2</strong>
            <div>
              <strong style="font-size: 13px; color: var(--text-primary);">Sakib Al Hasan</strong>
              <span style="font-size: 11px; color: var(--text-muted); display: block;">Silver Fan</span>
            </div>
          </div>
          <span class="badge badge-neutral" style="font-size: 11px;">380 PTS</span>
        </div>

        <div style="display: flex; justify-content: space-between; align-items: center; padding: 10px 12px; background: var(--bg-surface-low); border-radius: var(--radius-sm);">
          <div class="flex items-center gap-3">
            <strong style="color: var(--text-muted); font-size: 14px;">#3</strong>
            <div>
              <strong style="font-size: 13px; color: var(--text-primary);">Coach Rahat</strong>
              <span style="font-size: 11px; color: var(--text-muted); display: block;">Tactical Guru</span>
            </div>
          </div>
          <span class="badge badge-neutral" style="font-size: 11px;">320 PTS</span>
        </div>
      </div>
    </div>

    <!-- Upcoming Fixture Polls Card -->
    <div class="card" style="margin-top: 18px;">
      <div class="card-header">
        <div class="flex items-center gap-2">
          <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="color: var(--accent-blue);"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect><line x1="16" y1="2" x2="16" y2="6"></line><line x1="8" y1="2" x2="8" y2="6"></line><line x1="3" y1="10" x2="21" y2="10"></line></svg>
          <h3>Upcoming Match Polls</h3>
        </div>
      </div>

      <div style="display: flex; flex-direction: column; gap: 10px; margin-top: 4px;">
        <div style="padding: 10px 12px; background: var(--bg-surface-low); border-radius: var(--radius-md);">
          <span style="font-size: 10px; color: var(--accent-blue); font-weight: 700; text-transform: uppercase;">Next Fixture Poll &bull; 15 Oct</span>
          <strong style="font-size: 13px; color: var(--text-primary); display: block; margin: 2px 0;">Bashundhara Kings vs Sheikh Jamal</strong>
          <span style="font-size: 11px; color: var(--text-secondary);">Who will score the opening goal? Poll opens in 2 days.</span>
        </div>

        <div style="padding: 10px 12px; background: var(--bg-surface-low); border-radius: var(--radius-md);">
          <span style="font-size: 10px; color: var(--accent-blue); font-weight: 700; text-transform: uppercase;">Upcoming Fixture Poll &bull; 18 Oct</span>
          <strong style="font-size: 13px; color: var(--text-primary); display: block; margin: 2px 0;">Police FC vs Rahmatganj MFS</strong>
          <span style="font-size: 11px; color: var(--text-secondary);">Match winner voting opens on Friday morning.</span>
        </div>
      </div>
    </div>

  </div>

</div>

<?php
require __DIR__ . '/../partials/footer.php'; ?>

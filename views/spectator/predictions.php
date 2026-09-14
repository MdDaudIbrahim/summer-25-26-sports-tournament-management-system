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
      <span class="kpi-value"><?= (int)$totalVotes ?></span>
    </div>
    <span class="kpi-desc">Recorded in MySQL database</span>
  </div>

  <div class="kpi-card">
    <span class="kpi-title">Abahani Limited</span>
    <div class="kpi-value-row">
      <span class="kpi-value" style="color: var(--accent-blue);"><?= (int)$votes['Abahani'] ?></span>
      <span style="font-size: 13px; color: var(--text-muted); margin-left: 6px;">(<?= $abahaniPct ?>%)</span>
    </div>
    <span class="kpi-desc">Favored to win</span>
  </div>

  <div class="kpi-card">
    <span class="kpi-title">Mohammedan SC</span>
    <div class="kpi-value-row">
      <span class="kpi-value" style="color: #10B981;"><?= (int)$votes['Mohammedan'] ?></span>
      <span style="font-size: 13px; color: var(--text-muted); margin-left: 6px;">(<?= $mohammedanPct ?>%)</span>
    </div>
    <span class="kpi-desc">Favored to win</span>
  </div>

  <div class="kpi-card">
    <span class="kpi-title">Match Draw</span>
    <div class="kpi-value-row">
      <span class="kpi-value" style="color: #64748b;"><?= (int)$votes['Draw'] ?></span>
      <span style="font-size: 13px; color: var(--text-muted); margin-left: 6px;">(<?= $drawPct ?>%)</span>
    </div>
    <span class="kpi-desc">Equal points predicted</span>
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
            <span style="font-size: 12px; color: var(--text-secondary);">Bangabandhu National Stadium &bull; Dhaka Premier League</span>
          </div>
          <span class="badge badge-blue">Official Poll</span>
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

  <!-- right column: live community votes stream & context -->
  <div class="col-5">

    <!-- Recent Fan Votes Live from MySQL -->
    <div class="card">
      <div class="card-header">
        <div class="flex items-center gap-2">
          <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="color: var(--accent-blue);"><circle cx="12" cy="12" r="10"></circle><polyline points="12 6 12 12 16 14"></polyline></svg>
          <div>
            <h3 style="margin: 0; font-size: 16px;">Recent Community Votes</h3>
            <span style="font-size: 12px; color: var(--text-secondary);">Live stream from database</span>
          </div>
        </div>
      </div>

      <div style="display: flex; flex-direction: column; gap: 10px; margin-top: 6px;">
        <?php if (!empty($recentVotes)): ?>
          <?php foreach ($recentVotes as $rv): 
            $teamColor = '#1e3a8a';
            $badgeBg   = 'rgba(30, 58, 138, 0.1)';
            if ($rv['predicted_winner'] === 'Mohammedan') {
                $teamColor = '#10B981';
                $badgeBg   = 'rgba(16, 185, 129, 0.1)';
            } elseif ($rv['predicted_winner'] === 'Draw') {
                $teamColor = '#64748b';
                $badgeBg   = 'rgba(100, 116, 139, 0.1)';
            }
          ?>
            <div style="display: flex; justify-content: space-between; align-items: center; padding: 10px 12px; background: var(--bg-surface-low); border-radius: var(--radius-sm); border-left: 3px solid <?= $teamColor ?>;">
              <div>
                <strong style="font-size: 13px; color: var(--text-primary); display: block;">
                  <?= esc($rv['predicted_winner']) ?>
                </strong>
                <span style="font-size: 11px; color: var(--text-muted);">
                  <?= date('d M, h:i A', strtotime($rv['voted_at'])) ?>
                </span>
              </div>
              <span class="badge" style="background: <?= $badgeBg ?>; color: <?= $teamColor ?>; font-size: 11px;">
                Recorded
              </span>
            </div>
          <?php endforeach; ?>
        <?php else: ?>
          <p style="font-size: 13px; color: var(--text-muted); margin: 10px 0; text-align: center;">
            No community votes recorded yet.
          </p>
        <?php endif; ?>
      </div>
    </div>

    <!-- Match Information Card -->
    <div class="card" style="margin-top: 18px;">
      <div class="card-header">
        <div class="flex items-center gap-2">
          <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="color: var(--accent-blue);"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"></path></svg>
          <h3 style="margin: 0; font-size: 16px;">Poll Security &amp; Information</h3>
        </div>
      </div>

      <div style="font-size: 13px; color: var(--text-secondary); line-height: 1.6; padding-top: 4px;">
        <div style="margin-bottom: 8px;">
          <strong style="color: var(--text-primary);">Tournament:</strong> Dhaka Premier League (DPL)
        </div>
        <div style="margin-bottom: 8px;">
          <strong style="color: var(--text-primary);">Venue:</strong> Bangabandhu National Stadium, Dhaka
        </div>
        <div>
          <strong style="color: var(--text-primary);">Real-time Integrity:</strong> Each spectator prediction is validated and saved directly into MySQL. Vote counts and percentages re-calculate dynamically on every submission.
        </div>
      </div>
    </div>

  </div>

</div>

<?php
require __DIR__ . '/../partials/footer.php'; ?>

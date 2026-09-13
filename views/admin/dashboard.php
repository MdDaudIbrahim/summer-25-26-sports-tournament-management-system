<?php

$pageTitle   = 'Monitor Live Tournaments';
$pageHeading = 'Live Tournaments';
$pageSub     = 'Real-time match scoring, scoreboard simulator, and venue clash detection';

$rescheduleData = $_SESSION['rescheduled_fixture'] ?? null;
$clashResolved  = !empty($rescheduleData['resolved']);
$fixtureVenue   = $rescheduleData['venue'] ?? 'Bangabandhu Stadium';
$fixtureTime    = $rescheduleData['time']  ?? 'Today, 16:00';

require __DIR__ . '/../partials/header.php';
?>

<!-- Page Header Bar -->
<div class="page-title-bar">
  <div>
    <h1>Live Match Monitoring</h1>
    <p>Real-time match scoring, fixtures, and venue schedule monitoring</p>
  </div>
</div>

<!-- Main Grid Layout -->
<div class="grid-12">

  <!-- column: live match & fixtures -->
  <div class="col-8 flex flex-col gap-4">

<?php
$liveTournamentName = !empty($tournaments) ? $tournaments[0]['tournament_name'] : 'National League';
foreach ($tournaments as $t) {
    if ($t['status'] === 'Ongoing') {
        $liveTournamentName = $t['tournament_name'];
        break;
    }
}
?>
    <!-- Live Match Monitor Card -->
    <div class="card">
      <div class="card-header">
        <div>
          <h3 style="margin: 0; font-size: 16px;">Current Ongoing Match</h3>
          <span style="font-size: 12px; color: var(--text-secondary);"><?= esc($liveTournamentName) ?></span>
        </div>
        <span class="badge badge-error" style="font-weight: 600;">72' Live Ongoing</span>
      </div>

      <!-- Scoreboard Box -->
      <div style="background: #f8fafc; border: 1px solid var(--border-color); border-radius: var(--radius-sm); padding: 18px 24px; margin-bottom: 14px;">
        <div style="display: flex; justify-content: space-between; align-items: center;">

          <!-- Home Team (Left) -->
          <div style="flex: 1;">
            <div style="font-size: 16px; font-weight: 700; color: var(--text-primary);">Abahani Limited</div>
            <div style="font-size: 12px; color: var(--text-secondary); margin-bottom: 6px;">Home Team</div>
            <button type="button" class="btn btn-outline btn-sm" id="btnGoalTeamA" style="font-size: 11px; padding: 3px 9px;">
              + Goal (Abahani)
            </button>
          </div>

          <!-- Score Display Center -->
          <div style="text-align: center; padding: 0 20px;">
            <div style="font-size: 32px; font-weight: 800; color: var(--text-primary); letter-spacing: 4px;">
              <span id="teamAScore">2</span> &ndash; <span id="teamBScore">1</span>
            </div>
            <div id="matchStatusText" style="font-size: 12px; font-weight: 600; color: var(--live-red); margin-top: 4px;">
              Second Half &bull; 72 Mins
            </div>
          </div>

          <!-- Away Team (Right) -->
          <div style="flex: 1; text-align: right;">
            <div style="font-size: 16px; font-weight: 700; color: var(--text-primary);">Mohammedan SC</div>
            <div style="font-size: 12px; color: var(--text-secondary); margin-bottom: 6px;">Away Team</div>
            <button type="button" class="btn btn-outline btn-sm" id="btnGoalTeamB" style="font-size: 11px; padding: 3px 9px;">
              + Goal (Mohammedan)
            </button>
          </div>

        </div>
      </div>

      <!-- Quick Action Buttons -->
      <div class="flex justify-between items-center">
        <span style="font-size: 13px; color: var(--text-secondary);">Venue: <strong style="color: var(--text-primary);">Bangabandhu National Stadium</strong></span>
        <button type="button" class="btn btn-primary btn-sm" id="updateScoreBtn">+ Update Score Live</button>
      </div>
    </div>

    <!-- Live Score Update Modal Dialog -->
    <div id="scoreModalBackdrop" style="display: none; position: fixed; inset: 0; background: rgba(15, 23, 42, 0.5); z-index: 9999; align-items: center; justify-content: center;">
      <div class="card" style="width: 400px; max-width: 95%; background: #ffffff; border-radius: var(--radius-sm); padding: 20px; box-shadow: 0 10px 25px rgba(0,0,0,0.15);">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 16px; padding-bottom: 10px; border-bottom: 1px solid var(--border-color);">
          <h3 style="margin: 0; font-size: 16px;">Update Match Score</h3>
          <button type="button" id="closeScoreModalBtn" style="background: none; border: none; font-size: 22px; cursor: pointer; color: var(--text-secondary); line-height: 1;">&times;</button>
        </div>

        <!-- Team Scores Grid -->
        <div style="display: grid; grid-template-columns: 1fr auto 1fr; gap: 12px; align-items: center; margin-bottom: 18px; text-align: center;">
          <div>
            <strong style="font-size: 13px; color: var(--text-primary); display: block; margin-bottom: 6px;">Abahani Ltd.</strong>
            <div style="display: flex; align-items: center; justify-content: center; gap: 6px;">
              <button type="button" class="btn btn-outline btn-sm" id="modalDecA" style="padding: 3px 9px; font-weight: 700;">-</button>
              <input type="number" id="modalScoreA" class="form-control" style="width: 50px; text-align: center; font-size: 16px; font-weight: 700; padding: 4px;" min="0">
              <button type="button" class="btn btn-outline btn-sm" id="modalIncA" style="padding: 3px 9px; font-weight: 700;">+</button>
            </div>
          </div>

          <div style="font-size: 20px; font-weight: 700; color: var(--text-muted);">&ndash;</div>

          <div>
            <strong style="font-size: 13px; color: var(--text-primary); display: block; margin-bottom: 6px;">Mohammedan SC</strong>
            <div style="display: flex; align-items: center; justify-content: center; gap: 6px;">
              <button type="button" class="btn btn-outline btn-sm" id="modalDecB" style="padding: 3px 9px; font-weight: 700;">-</button>
              <input type="number" id="modalScoreB" class="form-control" style="width: 50px; text-align: center; font-size: 16px; font-weight: 700; padding: 4px;" min="0">
              <button type="button" class="btn btn-outline btn-sm" id="modalIncB" style="padding: 3px 9px; font-weight: 700;">+</button>
            </div>
          </div>
        </div>

        <!-- Match Minute / Status Input -->
        <div style="margin-bottom: 20px;">
          <label style="font-size: 12px; font-weight: 600; color: var(--text-secondary); display: block; margin-bottom: 4px;">Match Status / Time</label>
          <input type="text" id="modalStatusInput" class="form-control" style="font-size: 13px;" placeholder="Second Half &bull; 72 Mins">
        </div>

        <!-- Modal Action Buttons -->
        <div style="display: flex; justify-content: flex-end; gap: 8px;">
          <button type="button" class="btn btn-outline btn-sm" id="cancelScoreModalBtn">Cancel</button>
          <button type="button" class="btn btn-primary btn-sm" id="saveScoreModalBtn">Save Score</button>
        </div>
      </div>
    </div>

    <!-- Live Matches Schedule Card -->
    <div class="card">
      <div class="card-header">
        <div>
          <h3 style="margin: 0; font-size: 16px;">Today's Match Fixtures</h3>
          <span style="font-size: 12px; color: var(--text-secondary);">Scheduled matches across all tournaments</span>
        </div>
      </div>

      <div class="table-responsive">
        <table class="data-table">
          <thead>
            <tr>
              <th>Match Fixture</th>
              <th>Tournament</th>
              <th>Venue</th>
              <th>Status / Time</th>
            </tr>
          </thead>
          <tbody>
            <?php

            $pairings = [
                ['home' => 'Abahani Limited', 'away' => 'Mohammedan SC', 'venue' => $fixtureVenue, 'time' => "72' Live", 'is_live' => true],
                ['home' => 'Bashundhara Kings', 'away' => 'Sheikh Jamal', 'venue' => 'Sylhet District Stadium', 'time' => 'Today, 18:00', 'is_live' => false],
                ['home' => 'Police FC', 'away' => 'Rahmatganj MFS', 'venue' => 'Bangabandhu National Stadium', 'time' => 'Tomorrow, 16:00', 'is_live' => false],
                ['home' => 'Dhaka Dynamites', 'away' => 'Chittagong Kings', 'venue' => 'Sylhet District Stadium', 'time' => '18 Oct, 17:30', 'is_live' => false],
                ['home' => 'Arambagh KS', 'away' => 'Brothers Union', 'venue' => 'Bir Shreshtha Stadium', 'time' => '22 Oct, 15:30', 'is_live' => false],
            ];

            if (!empty($tournaments)):
                $idx = 0;
                foreach ($tournaments as $tn):
                    $p = $pairings[$idx % count($pairings)];
                    $isOngoing = ($tn['status'] === 'Ongoing');
                    $isFirst = ($idx === 0);
                    $isLiveMatch = ($isOngoing || ($isFirst && !$clashResolved));
                    $venueDisplay = ($idx === 0) ? $fixtureVenue : $p['venue'];
                    $timeDisplay = ($idx === 0) ? ($clashResolved ? $fixtureTime : "72' Live") : ($isOngoing ? "Today, 18:00" : "Tomorrow, 16:00");
                    $statusHtml = ($idx === 0 && !$clashResolved) 
                        ? '<span style="color: var(--live-red); font-weight: 600;">72\' Live</span>' 
                        : '<span style="color: var(--text-secondary);">' . esc($timeDisplay) . '</span>';
            ?>
              <tr>
                <td><strong><?= esc($p['home']) ?> vs <?= esc($p['away']) ?></strong></td>
                <td>
                  <strong><?= esc($tn['tournament_name']) ?></strong>
                  <span class="badge badge-sm" style="font-size: 10px; margin-left: 4px;"><?= esc($tn['status']) ?></span>
                </td>
                <td><?= esc($venueDisplay) ?></td>
                <td><?= $statusHtml ?></td>
              </tr>
            <?php
$idx++;
                endforeach;
            else: 
            ?>
              <tr>
                <td><strong>Abahani Limited vs Mohammedan SC</strong></td>
                <td>Premier League</td>
                <td><?= esc($fixtureVenue) ?></td>
                <td><span style="color: var(--live-red); font-weight: 600;">72' Live</span></td>
              </tr>
            <?php
endif; ?>
          </tbody>
        </table>
      </div>
    </div>

  </div>

  <!-- column: venue alerts & readiness -->
  <div class="col-4 flex flex-col gap-4">

    <!-- Venue Schedule & Clash Alert Card -->
    <div class="card">
      <div class="card-header">
        <h3 style="margin: 0; font-size: 16px;">Venue Schedule &amp; Alerts</h3>
      </div>

      <?php
if ($clashResolved): ?>
        <!-- Conflict Resolved Box -->
        <div style="background: #f0fdf4; border: 1px solid #bbf7d0; border-left: 4px solid #16a34a; padding: 12px 14px; border-radius: var(--radius-sm); margin-bottom: 14px;">
          <div style="display: flex; justify-content: space-between; align-items: flex-start;">
            <div>
              <strong style="display: block; font-size: 13px; color: #166534; margin-bottom: 2px;">Conflict Resolved</strong>
              <span style="font-size: 12px; color: #14532d; line-height: 1.4; display: block;">
                Abahani vs Mohammedan moved to <strong><?= esc($fixtureVenue) ?></strong>.
              </span>
            </div>
            <a href="index.php?page=admin&action=reset_reschedule&csrf_token=<?= esc($_SESSION['csrf_token'] ?? '') ?>" style="font-size: 11px; color: var(--text-secondary); text-decoration: underline; white-space: nowrap; margin-left: 8px;">Reset</a>
          </div>
        </div>
      <?php
else: ?>
        <!-- Clean Clash Warning Box -->
        <div style="background: #fffbeb; border: 1px solid #fef3c7; border-left: 4px solid #f59e0b; padding: 12px 14px; border-radius: var(--radius-sm); margin-bottom: 14px;">
          <strong style="display: block; font-size: 13px; color: #92400e; margin-bottom: 3px;">Schedule Conflict Alert</strong>
          <span style="font-size: 12px; color: #78350f; line-height: 1.4; display: block;">
            Two matches are scheduled at Bangabandhu Stadium today at 4:00 PM.
          </span>
        </div>
      <?php
endif; ?>

      <!-- Schedule List Items -->
      <div style="display: flex; flex-direction: column; gap: 10px;">
        <div style="padding: 10px 12px; background: #ffffff; border: 1px solid var(--border-color); border-radius: var(--radius-sm);">
          <div class="flex justify-between items-center" style="margin-bottom: 4px;">
            <strong style="font-size: 13px; color: var(--text-primary);"><?= esc($fixtureVenue) ?></strong>
            <span style="font-size: 11px; color: var(--text-secondary);"><?= esc($fixtureTime) ?></span>
          </div>
          <p style="font-size: 12px; color: var(--text-secondary); margin-bottom: 6px;">Abahani vs Mohammedan SC</p>
          <button type="button" id="openRescheduleModalBtn" style="background: none; border: none; padding: 0; font-size: 12px; color: var(--accent-blue); cursor: pointer; font-weight: 500;">
            Reschedule Match &rarr;
          </button>
        </div>

        <div style="padding: 10px 12px; background: #ffffff; border: 1px solid var(--border-color); border-radius: var(--radius-sm);">
          <div class="flex justify-between items-center" style="margin-bottom: 4px;">
            <strong style="font-size: 13px; color: var(--text-primary);">Sylhet District Stadium</strong>
            <span style="font-size: 11px; color: var(--text-secondary);">Tomorrow, 15:00</span>
          </div>
          <p style="font-size: 12px; color: var(--text-secondary); margin: 0;">Sylhet Thunder vs Chittagong Kings</p>
        </div>
      </div>
    </div>

    <!-- Active Venues Operational Status -->
    <div class="card">
      <div class="card-header">
        <h3 style="margin: 0; font-size: 16px;">Venue Readiness</h3>
      </div>

      <div style="display: flex; flex-direction: column; gap: 12px; padding: 2px 0;">
        <div style="display: flex; justify-content: space-between; align-items: center; padding-bottom: 10px; border-bottom: 1px solid var(--border-color);">
          <div>
            <strong style="font-size: 13px; color: var(--text-primary); display: block;">Bangabandhu Stadium</strong>
            <span style="font-size: 12px; color: var(--text-secondary);">Pitch maintenance ongoing</span>
          </div>
          <span style="font-size: 12px; font-weight: 600; color: #2563eb; background: #eff6ff; padding: 3px 8px; border-radius: 4px;">85% Ready</span>
        </div>
        <div style="display: flex; justify-content: space-between; align-items: center;">
          <div>
            <strong style="font-size: 13px; color: var(--text-primary); display: block;">Sylhet District Stadium</strong>
            <span style="font-size: 12px; color: var(--text-secondary);">Operational &amp; verified</span>
          </div>
          <span style="font-size: 12px; font-weight: 600; color: #166534; background: #f0fdf4; padding: 3px 8px; border-radius: 4px;">100% Ready</span>
        </div>
      </div>
    </div>

  </div>

</div>

<!-- Reschedule Match Modal Dialog -->
<div id="rescheduleModalBackdrop" style="display: none; position: fixed; inset: 0; background: rgba(15, 23, 42, 0.5); z-index: 9999; align-items: center; justify-content: center;">
  <div class="card" style="width: 440px; max-width: 95%; background: #ffffff; border-radius: var(--radius-sm); padding: 22px; box-shadow: 0 10px 25px rgba(0,0,0,0.15);">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 16px; padding-bottom: 10px; border-bottom: 1px solid var(--border-color);">
      <div>
        <h3 style="margin: 0; font-size: 16px;">Reschedule Match Fixture</h3>
        <span style="font-size: 12px; color: var(--text-secondary);">Resolve venue conflict or change kick-off time</span>
      </div>
      <button type="button" id="closeRescheduleModalBtn" style="background: none; border: none; font-size: 22px; cursor: pointer; color: var(--text-secondary); line-height: 1;">&times;</button>
    </div>

    <form action="index.php?page=admin&action=reschedule_match" method="POST" id="rescheduleForm">
      <?php
csrf_field(); ?>

      <div style="margin-bottom: 14px; padding: 10px 12px; background: var(--bg-surface-low); border: 1px solid var(--border-color); border-radius: var(--radius-sm);">
        <strong style="font-size: 13px; color: var(--text-primary); display: block;">Abahani Limited vs Mohammedan SC</strong>
        <span style="font-size: 12px; color: var(--text-secondary);">Tournament: Dhaka Premier League</span>
      </div>

      <div class="form-group" style="margin-bottom: 14px;">
        <label for="new_venue" style="font-size: 12px; font-weight: 600; margin-bottom: 4px; display: block;">Select New Venue</label>
        <select id="new_venue" name="new_venue" class="form-control" required style="font-size: 13px;">
          <option value="Sylhet District Stadium" <?= ($fixtureVenue === 'Sylhet District Stadium') ? 'selected' : '' ?>>Sylhet District Stadium (Available)</option>
          <option value="Bir Shreshtha Shaheed Shipahi Stadium" <?= ($fixtureVenue === 'Bir Shreshtha Shaheed Shipahi Stadium') ? 'selected' : '' ?>>Bir Shreshtha Shaheed Shipahi Stadium, Dhaka</option>
          <option value="Zahur Ahmed Chowdhury Stadium" <?= ($fixtureVenue === 'Zahur Ahmed Chowdhury Stadium') ? 'selected' : '' ?>>Zahur Ahmed Chowdhury Stadium, Chittagong</option>
          <option value="Rajshahi Divisional Stadium" <?= ($fixtureVenue === 'Rajshahi Divisional Stadium') ? 'selected' : '' ?>>Rajshahi Divisional Stadium</option>
          <option value="Bangabandhu National Stadium" <?= ($fixtureVenue === 'Bangabandhu National Stadium') ? 'selected' : '' ?>>Bangabandhu National Stadium (Evening Slot)</option>
        </select>
      </div>

      <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 10px; margin-bottom: 18px;">
        <div>
          <label for="new_date" style="font-size: 12px; font-weight: 600; margin-bottom: 4px; display: block;">New Match Date</label>
          <input type="date" id="new_date" name="new_date" class="form-control" value="<?= date('Y-m-d') ?>" required style="font-size: 13px;">
        </div>
        <div>
          <label for="new_time" style="font-size: 12px; font-weight: 600; margin-bottom: 4px; display: block;">Kick-Off Time</label>
          <input type="time" id="new_time" name="new_time" class="form-control" value="18:30" required style="font-size: 13px;">
        </div>
      </div>

      <div style="display: flex; justify-content: flex-end; gap: 8px;">
        <button type="button" class="btn btn-outline btn-sm" id="cancelRescheduleModalBtn">Cancel</button>
        <button type="submit" class="btn btn-primary btn-sm">Confirm Reschedule</button>
      </div>
    </form>
  </div>
</div>

<?php
require __DIR__ . '/../partials/footer.php'; ?>

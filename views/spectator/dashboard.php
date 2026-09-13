<?php

$pageTitle   = 'Spectator Dashboard';
$pageHeading = 'Spectator Hub';
$pageSub     = 'Upcoming fixtures, online ticket booking and fan polls';
require __DIR__ . '/../partials/header.php';
?>

<!-- Live Match Card -->
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
    <span style="font-size: 13px; color: var(--text-secondary);">Gates open &bull; Active match admission</span>
    <a href="index.php?page=spectator&action=predictions" class="btn btn-primary btn-sm">
      Vote in Fan Prediction Poll &rarr;
    </a>
  </div>
</div>

<!-- Bento Grid Section -->
<div class="grid-12">

  <!-- Left Column (Span 8) -->
  <div class="col-8 flex flex-col gap-4">

    <!-- Upcoming Matches Card (With Live DB Ticket Booking) -->
    <div class="card" id="upcomingMatches">
      <div class="card-header">
        <div class="flex items-center gap-2">
          <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="color: var(--accent-blue);"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect><line x1="16" y1="2" x2="16" y2="6"></line><line x1="8" y1="2" x2="8" y2="6"></line><line x1="3" y1="10" x2="21" y2="10"></line></svg>
          <h3>Upcoming Matches &amp; Ticket Booking</h3>
        </div>
        <a href="index.php?page=spectator&action=schedules" style="font-size: 13px; font-weight: 600;">View All</a>
      </div>

      <!-- Match Item 1 -->
      <div class="match-row-item">
        <div class="flex items-center gap-3">
          <div class="match-time-badge">
            <span class="match-time-date">15 Oct</span>
            <span class="match-time-hour">4:00 PM</span>
          </div>
          <div>
            <strong style="font-size: 14px; color: var(--text-primary);">Bashundhara Kings vs Sheikh Jamal</strong>
            <span style="display: block; font-size: 12px; color: var(--text-secondary);">Bangabandhu National Stadium</span>
          </div>
        </div>
        <form action="index.php?page=spectator&action=buy_ticket" method="POST" style="margin: 0;">
          <?php
csrf_field(); ?>
          <input type="hidden" name="match_title" value="Bashundhara Kings vs Sheikh Jamal">
          <input type="hidden" name="seat_category" value="VIP Gallery">
          <input type="hidden" name="ticket_count" value="2">
          <button type="submit" class="btn btn-primary btn-sm">Buy Ticket (2)</button>
        </form>
      </div>

      <!-- Match Item 2 -->
      <div class="match-row-item">
        <div class="flex items-center gap-3">
          <div class="match-time-badge">
            <span class="match-time-date">18 Oct</span>
            <span class="match-time-hour">7:00 PM</span>
          </div>
          <div>
            <strong style="font-size: 14px; color: var(--text-primary);">Police FC vs Rahmatganj</strong>
            <span style="display: block; font-size: 12px; color: var(--text-secondary);">Bangabandhu National Stadium</span>
          </div>
        </div>
        <form action="index.php?page=spectator&action=buy_ticket" method="POST" style="margin: 0;">
          <?php
csrf_field(); ?>
          <input type="hidden" name="match_title" value="Police FC vs Rahmatganj">
          <input type="hidden" name="seat_category" value="VIP Gallery">
          <input type="hidden" name="ticket_count" value="2">
          <button type="submit" class="btn btn-primary btn-sm">Buy Ticket (2)</button>
        </form>
      </div>
    </div>

    <!-- Ticket Purchase Status Card (From MySQL Database) -->
    <div class="card" id="bookedTicketsSection">
      <div class="card-header">
        <div class="flex items-center gap-2">
          <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="color: var(--accent-blue);"><rect x="2" y="5" width="20" height="14" rx="2"></rect><line x1="2" y1="10" x2="22" y2="10"></line></svg>
          <h3>Your Tickets (From Database)</h3>
        </div>
        <span class="badge badge-success"><?= count($myTickets) ?> Active</span>
      </div>

      <?php
if (!empty($myTickets)): ?>
        <?php
foreach ($myTickets as $ticket): ?>
          <div style="background-color: var(--bg-surface-low); border-left: 4px solid #10B981; border-radius: var(--radius-md); padding: 16px; display: flex; justify-content: space-between; align-items: center; margin-bottom: 10px;">
            <div>
              <span class="badge badge-success" style="margin-bottom: 6px;">Payment <?= esc($ticket['payment_status'] ?? 'Paid') ?></span>
              <strong style="display: block; font-size: 15px; color: var(--text-primary);">
                <?= esc($ticket['match_title']) ?> (<?= esc($ticket['seat_category']) ?>)
              </strong>
              <span style="font-size: 12px; color: var(--text-secondary);">
                Order No: <?= esc($ticket['order_no']) ?> &bull; <?= (int)$ticket['ticket_count'] ?> Ticket(s)
              </span>
            </div>
            <div class="flex gap-2">
              <button class="btn btn-outline btn-sm" onclick="alert('Ticket PDF generated for Order: <?= esc($ticket['order_no']) ?>')">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path><polyline points="7 10 12 15 17 10"></polyline><line x1="12" y1="15" x2="12" y2="3"></line></svg>
                Download
              </button>
              <a href="index.php?page=spectator&action=ticket_delete&id=<?= (int)$ticket['id'] ?>&csrf_token=<?= esc($_SESSION['csrf_token'] ?? '') ?>"
                 onclick="return confirm('Cancel this ticket?');"
                 class="btn btn-outline btn-sm" style="color: var(--live-red); border-color: var(--live-red);">Cancel</a>
            </div>
          </div>
        <?php
endforeach; ?>
      <?php
else: ?>
        <div style="background-color: var(--bg-surface-low); border-left: 4px solid #10B981; border-radius: var(--radius-md); padding: 16px; display: flex; justify-content: space-between; align-items: center;">
          <div>
            <span class="badge badge-success" style="margin-bottom: 6px;">No Tickets Purchased Yet</span>
            <strong style="display: block; font-size: 15px; color: var(--text-primary);">Book a match ticket above to view your passes here.</strong>
          </div>
        </div>
      <?php
endif; ?>
    </div>

  </div>

  <!-- Right Column (Span 4) -->
  <div class="col-4 flex flex-col gap-4">

    <!-- Favorite Teams Card -->
    <div class="card">
      <div class="card-header">
        <div class="flex items-center gap-2">
          <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="color: var(--accent-blue);"><path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"></path></svg>
          <h3>Favorite Teams</h3>
        </div>
      </div>

      <div style="display: flex; flex-direction: column; gap: 8px; margin-bottom: 12px;">
        <div style="display: flex; align-items: center; justify-content: space-between; padding: 10px; background: var(--bg-surface-low); border: 1px solid var(--border-color); border-radius: var(--radius-md);">
          <div class="flex items-center gap-3">
            <div class="avatar-circle" style="background: #000000;">A</div>
            <strong style="font-size: 13px;">Abahani Ltd.</strong>
          </div>
          <svg width="16" height="16" viewBox="0 0 24 24" fill="#EAB308" stroke="#EAB308" stroke-width="1"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon></svg>
        </div>

        <div style="display: flex; align-items: center; justify-content: space-between; padding: 10px; background: var(--bg-surface-low); border: 1px solid var(--border-color); border-radius: var(--radius-md);">
          <div class="flex items-center gap-3">
            <div class="avatar-circle" style="background: var(--text-secondary);">M</div>
            <strong style="font-size: 13px;">Mohammedan SC</strong>
          </div>
          <svg width="16" height="16" viewBox="0 0 24 24" fill="#EAB308" stroke="#EAB308" stroke-width="1"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon></svg>
        </div>
      </div>

      <button class="btn btn-outline btn-full btn-sm" style="border-style: dashed;" onclick="alert('Team added to favorites!')">+ Add Team</button>
    </div>

    <!-- Fan Prediction Poll Card (With Real Live MySQL Vote Percentages) -->
    <div class="card flex-1" id="predictionSection">
      <div class="card-header">
        <div class="flex items-center gap-2">
          <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="color: var(--accent-blue);"><circle cx="12" cy="12" r="10"></circle><path d="M9.09 9a3 3 0 0 1 5.83 1c0 2-3 3-3 3"></path><line x1="12" y1="17" x2="12.01" y2="17"></line></svg>
          <h3>Match Prediction Poll (Live DB)</h3>
        </div>
        <span class="badge badge-warning"><?= (int)$totalVotes ?> Votes</span>
      </div>

      <p style="font-size: 13px; margin-bottom: 12px;">Who will win today's match?</p>

      <form action="index.php?page=spectator&action=predict" method="POST" id="predictionForm">
        <?php
csrf_field(); ?>
        <input type="hidden" name="match_name" value="<?= esc($matchName) ?>">
        <label class="prediction-option" for="pred_abahani">
          <div class="flex items-center gap-2">
            <input type="radio" id="pred_abahani" name="predicted_winner" value="Abahani" checked>
            <strong style="font-size: 13px;">Abahani Ltd.</strong>
          </div>
          <span style="font-size: 12px; font-weight: 700; color: var(--text-secondary);"><?= (int)$abahaniPct ?>%</span>
        </label>

        <label class="prediction-option" for="pred_mohammedan">
          <div class="flex items-center gap-2">
            <input type="radio" id="pred_mohammedan" name="predicted_winner" value="Mohammedan">
            <strong style="font-size: 13px;">Mohammedan SC</strong>
          </div>
          <span style="font-size: 12px; font-weight: 700; color: var(--text-secondary);"><?= (int)$mohammedanPct ?>%</span>
        </label>

        <label class="prediction-option" for="pred_draw">
          <div class="flex items-center gap-2">
            <input type="radio" id="pred_draw" name="predicted_winner" value="Draw">
            <strong style="font-size: 13px;">Draw</strong>
          </div>
          <span style="font-size: 12px; font-weight: 700; color: var(--text-secondary);"><?= (int)$drawPct ?>%</span>
        </label>

        <button type="submit" class="btn btn-primary btn-full btn-sm" style="margin-top: 10px;">
          Submit Prediction Vote
        </button>
      </form>
    </div>

  </div>
</div>

<?php
require __DIR__ . '/../partials/footer.php'; ?>

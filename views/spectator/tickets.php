<?php

$pageTitle   = 'Match Tickets & Payments';
$pageHeading = 'Spectator Hub';
$pageSub     = 'Purchase tournament match tickets, select seating category, and make digital payments';
require __DIR__ . '/../partials/header.php';

$totalTicketsCount = 0;
$totalSpentAmount = 0;
foreach ($myTickets as $t) {
    $count = (int)($t['ticket_count'] ?? 1);
    $totalTicketsCount += $count;
    $rate = (($t['seat_category'] ?? '') === 'VIP Gallery') ? 1500 : ((($t['seat_category'] ?? '') === 'Grand Stand') ? 800 : 300);
    $totalSpentAmount += ($count * $rate);
}
?>

<!-- Page Header Bar -->
<div class="page-title-bar">
  <div>
    <h1>Match Tickets &amp; Online Payment</h1>
    <p>Book match seats, choose seating category, and complete digital ticket payments</p>
  </div>
  <div>
    <a href="#buyTicketBox" class="btn btn-primary btn-sm">
      + Book New Ticket
    </a>
  </div>
</div>

<!-- 4 KPI Metrics Cards -->
<div class="kpi-grid">
  <div class="kpi-card">
    <span class="kpi-title">My Booked Passes</span>
    <div class="kpi-value-row">
      <span class="kpi-value"><?= $totalTicketsCount ?></span>
    </div>
    <span class="kpi-desc">Verified stadium admission</span>
  </div>

  <div class="kpi-card">
    <span class="kpi-title">Total Payments</span>
    <div class="kpi-value-row">
      <span class="kpi-value" style="color: #166534;"><?= number_format($totalSpentAmount) ?> <small style="font-size: 13px; font-weight: normal;">BDT</small></span>
    </div>
    <span class="kpi-desc">Processed via digital gateway</span>
  </div>

  <div class="kpi-card">
    <span class="kpi-title">Orders Placed</span>
    <div class="kpi-value-row">
      <span class="kpi-value" style="color: var(--accent-blue);"><?= count($myTickets) ?></span>
    </div>
    <span class="kpi-desc">Confirmed booking orders</span>
  </div>

  <div class="kpi-card">
    <span class="kpi-title">Stadium Entry Pass</span>
    <div class="kpi-value-row">
      <span class="kpi-value" style="color: #166534;">Valid</span>
    </div>
    <span class="kpi-desc">Verified entry pass</span>
  </div>
</div>

<!-- tickets & form -->
<div class="grid-12">

  <!-- tickets -->
  <div class="col-7">
    <div class="card" id="bookedTicketsSection">
      <div class="card-header">
        <div class="flex items-center gap-2">
          <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="color: var(--accent-blue);"><rect x="2" y="5" width="20" height="14" rx="2"></rect><line x1="2" y1="10" x2="22" y2="10"></line></svg>
          <h3>My Purchased Tickets &amp; Passes</h3>
        </div>
        <span class="badge badge-success"><?= count($myTickets) ?> Active</span>
      </div>

      <div class="table-responsive">
        <table class="data-table">
          <thead>
            <tr>
              <th>Order / Match</th>
              <th>Seat Category</th>
              <th>Passes</th>
              <th>Status</th>
              <th style="text-align: right;">Action</th>
            </tr>
          </thead>
          <tbody>
            <?php
if (!empty($myTickets)): ?>
              <?php
foreach ($myTickets as $tk): 
                $rate = (($tk['seat_category'] ?? '') === 'VIP Gallery') ? 1500 : ((($tk['seat_category'] ?? '') === 'Grand Stand') ? 800 : 300);
                $total = $rate * (int)($tk['ticket_count'] ?? 1);
              ?>
                <tr>
                  <td>
                    <strong style="font-size: 13px; color: var(--text-primary); display: block;">
                      <?= esc($tk['match_title']) ?>
                    </strong>
                    <div style="font-size: 11px; color: var(--text-muted); margin-top: 2px;">
                      Order: <span style="font-family: monospace; font-weight: 700; color: var(--accent-blue);"><?= esc($tk['order_no']) ?></span>
                    </div>
                  </td>
                  <td>
                    <span class="badge <?= ($tk['seat_category'] === 'VIP Gallery') ? 'badge-blue' : 'badge-neutral' ?>">
                      <?= esc($tk['seat_category']) ?>
                    </span>
                    <div style="font-size: 11px; color: var(--text-muted); margin-top: 2px;">
                      <?= number_format($total) ?> BDT
                    </div>
                  </td>
                  <td>
                    <strong><?= (int)($tk['ticket_count'] ?? 1) ?> Ticket(s)</strong>
                  </td>
                  <td>
                    <span class="badge badge-success">
                      &check; <?= esc($tk['payment_status'] ?? 'Paid') ?>
                    </span>
                  </td>
                  <td style="text-align: right;">
                    <a href="index.php?page=spectator&action=ticket_delete&id=<?= (int)$tk['id'] ?>&csrf_token=<?= esc($_SESSION['csrf_token'] ?? '') ?>"
                       class="btn btn-outline btn-sm"
                       style="color: var(--live-red); border-color: var(--live-red); font-size: 11px; padding: 4px 8px;"
                       onclick="return confirm('Cancel ticket <?= esc($tk['order_no']) ?>?');">
                      Cancel
                    </a>
                  </td>
                </tr>
              <?php
endforeach; ?>
            <?php
else: ?>
              <tr>
                <td colspan="5" class="text-center" style="padding: 24px; color: var(--text-muted);">
                  No tickets purchased yet. Use the booking form on the right to reserve match seats.
                </td>
              </tr>
            <?php
endif; ?>
          </tbody>
        </table>
      </div>
    </div>

    <!-- Digital E-Pass Visual Showcase Card -->
    <?php
if (!empty($myTickets)): 
      $latest = $myTickets[0];
    ?>
      <div class="card" style="margin-top: 20px; background: linear-gradient(135deg, #0f1f4b 0%, #1e3a8a 100%); color: #FFFFFF; border: none; box-shadow: var(--shadow-md);">
        <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 16px;">
          <div>
            <span style="font-size: 10px; font-weight: 700; text-transform: uppercase; letter-spacing: 1px; color: #93c5fd;">OFFICIAL E-TICKET PASS</span>
            <h3 style="font-size: 16px; margin: 4px 0 2px; color: #FFFFFF;"><?= esc($latest['match_title']) ?></h3>
            <span style="font-size: 12px; color: #cbd5e1;">Holder: <strong><?= esc($navUser['full_name'] ?? 'Spectator') ?></strong></span>
          </div>
          <span class="badge" style="background: rgba(16, 185, 129, 0.25); color: #6ee7b7; border: 1px solid rgba(16, 185, 129, 0.4); font-size: 11px;">
            GATE ADMIT: <?= (int)$latest['ticket_count'] ?> PERSON(S)
          </span>
        </div>

        <div style="display: flex; justify-content: space-between; align-items: center; padding-top: 14px; border-top: 1px dashed rgba(255, 255, 255, 0.2);">
          <div>
            <span style="font-size: 10px; color: #94a3b8; display: block;">SEAT SECTION</span>
            <strong style="font-size: 14px; color: #FFFFFF;"><?= esc($latest['seat_category']) ?></strong>
          </div>
          <div>
            <span style="font-size: 10px; color: #94a3b8; display: block;">BOOKING REF</span>
            <strong style="font-family: monospace; font-size: 14px; color: #93c5fd;"><?= esc($latest['order_no']) ?></strong>
          </div>
          <div style="background: #FFFFFF; padding: 4px 8px; border-radius: 4px; color: #0f172a; font-family: monospace; font-size: 11px; letter-spacing: 2px;">
            |||| || | |||| ||
          </div>
        </div>
      </div>
    <?php
endif; ?>
  </div>

  <!-- buy ticket form -->
  <div class="col-5" id="buyTicketBox">
    <div class="card">
      <div class="card-header">
        <div class="flex items-center gap-2">
          <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="color: var(--accent-blue);"><path d="M2 9a3 3 0 0 1 0 6v2a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2v-2a3 3 0 0 1 0-6V7a2 2 0 0 0-2-2H4a2 2 0 0 0-2 2z"></path></svg>
          <h3>Purchase Match Ticket &amp; Pay</h3>
        </div>
      </div>

      <?php
if (!empty($error)): ?>
        <div class="alert alert-danger" style="margin-bottom: 14px; font-size: 13px; padding: 10px;">
          <?= esc($error) ?>
        </div>
      <?php
endif; ?>

      <form action="index.php?page=spectator&action=buy_ticket" method="POST">
        <?php
csrf_field(); ?>

        <div class="form-group">
          <label for="match_title">Select Match Fixture *</label>
          <select name="match_title" id="match_title" class="form-control" required>
            <option value="">-- Choose Match --</option>
            <option value="Abahani Ltd. vs Mohammedan SC" selected>Abahani Ltd. vs Mohammedan SC (Live Today)</option>
            <option value="Bashundhara Kings vs Sheikh Jamal">Bashundhara Kings vs Sheikh Jamal (15 Oct)</option>
            <option value="Police FC vs Rahmatganj MFS">Police FC vs Rahmatganj MFS (18 Oct)</option>
            <option value="Dhaka Dynamites vs Chittagong Abahani">Dhaka Dynamites vs Chittagong Abahani (22 Oct)</option>
          </select>
        </div>

        <div class="form-group">
          <label for="seat_category">Seating Category *</label>
          <select name="seat_category" id="seat_category" class="form-control" required>
            <option value="VIP Gallery" selected>VIP Gallery &mdash; 1,500 BDT</option>
            <option value="Grand Stand">Grand Stand &mdash; 800 BDT</option>
            <option value="General Gallery">General Gallery &mdash; 300 BDT</option>
          </select>
        </div>

        <div class="form-group">
          <label for="ticket_count">Number of Tickets (1 - 10) *</label>
          <input type="number" id="ticket_count" name="ticket_count" class="form-control" value="2" min="1" max="10" required>
        </div>

        <div class="form-group">
          <label for="payment_method">Payment Gateway *</label>
          <select id="payment_method" name="payment_method" class="form-control" required>
            <option value="bKash">bKash Online Payment</option>
            <option value="Nagad">Nagad Direct Pay</option>
            <option value="Card">Visa / Mastercard / DBBL Nexus</option>
          </select>
          <small style="color: var(--text-muted); font-size: 11px; margin-top: 4px; display: block;">
            Instant clearance: E-ticket pass generated immediately upon payment.
          </small>
        </div>

        <button type="submit" class="btn btn-primary" style="width: 100%; margin-top: 10px; display: flex; align-items: center; justify-content: center; gap: 8px;">
          <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"></polyline></svg>
          <span>Pay &amp; Confirm Ticket Purchase</span>
        </button>
      </form>
    </div>

    <!-- Security & Guarantee Notice -->
    <div class="card" style="margin-top: 16px; border-left: 3px solid #10B981; padding: 14px;">
      <div style="display: flex; align-items: center; gap: 8px; margin-bottom: 4px;">
        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="color: #10B981;"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"></path></svg>
        <strong style="font-size: 12px; color: var(--text-primary);">Secure Official Ticketing</strong>
      </div>
      <p style="font-size: 11px; color: var(--text-secondary); margin: 0; line-height: 1.5;">
        All ticket purchases are encrypted and registered directly with the tournament committee. Show digital barcode at turnstile entrance.
      </p>
    </div>
  </div>

</div>

<?php
require __DIR__ . '/../partials/footer.php'; ?>

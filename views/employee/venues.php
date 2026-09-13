<?php

$pageTitle   = 'Venues & Equipment Management';
$pageHeading = 'Employee Panel';
$pageSub     = 'Manage tournament stadiums, field maintenance, and sports equipment inventory';
require __DIR__ . '/../partials/header.php';
?>

<!-- Page Header Bar -->
<div class="page-title-bar">
  <div>
    <h1>Venues &amp; Equipment Management</h1>
    <p>Stadium facilities, seating capacity, pitch cleanliness, and sports equipment inventory.</p>
  </div>
</div>

<!-- 4 KPI Metrics Cards -->
<div class="kpi-grid">
  <div class="kpi-card">
    <span class="kpi-title">Managed Venues</span>
    <div class="kpi-value-row">
      <span class="kpi-value"><?= count($venues) ?></span>
    </div>
    <span class="kpi-desc">Official championship arenas</span>
  </div>

  <div class="kpi-card">
    <span class="kpi-title">Field Cleanliness</span>
    <div class="kpi-value-row">
      <span class="kpi-value" style="color: var(--accent-blue);"><?= $avgCleaning ?>%</span>
    </div>
    <span class="kpi-desc">Average turf condition</span>
  </div>

  <div class="kpi-card">
    <span class="kpi-title">Seating Readiness</span>
    <div class="kpi-value-row">
      <span class="kpi-value" style="color: #10B981;"><?= $avgSeating ?>%</span>
    </div>
    <span class="kpi-desc">Gallery and VIP capacity</span>
  </div>

  <div class="kpi-card">
    <span class="kpi-title">Equipment Inventory</span>
    <div class="kpi-value-row">
      <span class="kpi-value"><?= count($equipment) ?></span>
    </div>
    <span class="kpi-desc">Match gear items in stock</span>
  </div>
</div>

<!-- venues table -->
<div class="grid-12" style="margin-bottom: 24px;">
  <div class="col-12">
    <div class="card">
      <div class="card-header">
        <h3>Tournament Stadiums &amp; Field Readiness</h3>
        <span style="font-size: 12px; color: var(--text-secondary);"><?= count($venues) ?> Venues</span>
      </div>

      <div class="table-responsive">
        <table class="data-table">
          <thead>
            <tr>
              <th>Venue Name &amp; City</th>
              <th>Field Clean</th>
              <th>Seating</th>
              <th>Status</th>
              <th style="text-align: right;">Action</th>
            </tr>
          </thead>
          <tbody>
            <?php
if (!empty($venues)): ?>
              <?php
foreach ($venues as $v): 
                $clean = (int)($v['field_cleaning_pct'] ?? 80);
                $seats = (int)($v['seating_pct'] ?? 100);
              ?>
                <tr>
                  <td>
                    <strong style="font-size: 13px; color: var(--text-primary); display: block;">
                      <?= esc($v['venue_name']) ?>
                    </strong>
                    <span style="font-size: 12px; color: var(--text-muted);"><?= esc($v['city']) ?></span>
                  </td>
                  <td><?= $clean ?>%</td>
                  <td><?= $seats ?>%</td>
                  <td>
                    <span class="badge badge-success">Ready</span>
                  </td>
                  <td style="text-align: right;">
                    <a href="index.php?page=employee&action=venue_delete&id=<?= (int)$v['id'] ?>&csrf_token=<?= esc($_SESSION['csrf_token'] ?? '') ?>"
                       class="btn btn-outline btn-sm"
                       style="color: var(--live-red); font-size: 12px; padding: 3px 8px;"
                       onclick="return confirm('Remove venue <?= esc($v['venue_name']) ?>?');">
                      Delete
                    </a>
                  </td>
                </tr>
              <?php
endforeach; ?>
            <?php
else: ?>
              <tr>
                <td colspan="5" class="text-center" style="padding: 24px; color: var(--text-muted);">
                  No venues registered yet.
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

<!-- equipment inventory -->
<div class="grid-12">
  <div class="col-12">
    <div class="card">
      <div class="card-header">
        <h3>Sports Equipment &amp; Gear Inventory</h3>
        <span style="font-size: 12px; color: var(--text-secondary);"><?= count($equipment) ?> Items Tracked</span>
      </div>

      <!-- Add Equipment Bar -->
      <form action="index.php?page=employee&action=equipment_add" method="POST" style="background: #ffffff; padding: 16px; border-radius: var(--radius-sm); margin-bottom: 18px; border: 1px solid var(--border-color);">
        <?php
csrf_field(); ?>
        <div style="display: grid; grid-template-columns: 2fr 1fr 1fr auto; gap: 12px; align-items: flex-end;">
          <div class="form-group" style="margin-bottom: 0;">
            <label for="item_name" style="font-size: 12px;">Item / Equipment Name *</label>
            <input type="text" id="item_name" name="item_name" class="form-control" placeholder="e.g. Footballs, Corner Flags, Cones" required>
          </div>
          <div class="form-group" style="margin-bottom: 0;">
            <label for="quantity" style="font-size: 12px;">Quantity in Stock *</label>
            <input type="number" id="quantity" name="quantity" class="form-control" value="10" min="0" required>
          </div>
          <div class="form-group" style="margin-bottom: 0;">
            <label for="equip_status" style="font-size: 12px;">Availability Status *</label>
            <select id="equip_status" name="equip_status" class="form-control" required>
              <option value="Available">Available</option>
              <option value="Low Stock">Low Stock</option>
              <option value="Out of Stock">Out of Stock</option>
            </select>
          </div>
          <button type="submit" class="btn btn-primary" style="height: 38px; white-space: nowrap;">
            Add Gear
          </button>
        </div>
      </form>

      <!-- Inventory Table -->
      <div class="table-responsive">
        <table class="data-table">
          <thead>
            <tr>
              <th>Equipment Item</th>
              <th>Quantity in Stock</th>
              <th>Inventory Status</th>
              <th style="text-align: right;">Action</th>
            </tr>
          </thead>
          <tbody>
            <?php
if (!empty($equipment)): ?>
              <?php
foreach ($equipment as $eq): 
                $st = $eq['status'] ?? 'Available';
                $badgeClass = ($st === 'Available') ? 'badge-success' : (($st === 'Low Stock') ? 'badge-warning' : 'badge-danger');
              ?>
                <tr>
                  <td>
                    <strong style="font-size: 13px; color: var(--text-primary);">
                      <?= esc($eq['item_name']) ?>
                    </strong>
                  </td>
                  <td>
                    <strong style="font-size: 14px; color: var(--text-primary);"><?= (int)$eq['quantity'] ?></strong> units
                  </td>
                  <td>
                    <span class="badge <?= $badgeClass ?>"><?= esc($st) ?></span>
                  </td>
                  <td style="text-align: right;">
                    <a href="index.php?page=employee&action=equipment_delete&id=<?= (int)$eq['id'] ?>&csrf_token=<?= esc($_SESSION['csrf_token'] ?? '') ?>"
                       class="btn btn-outline btn-sm"
                       style="color: var(--live-red); font-size: 12px; padding: 3px 8px;"
                       onclick="return confirm('Remove <?= esc($eq['item_name']) ?> from inventory?');">
                      Delete
                    </a>
                  </td>
                </tr>
              <?php
endforeach; ?>
            <?php
else: ?>
              <tr>
                <td colspan="4" class="text-center" style="padding: 20px; color: var(--text-muted);">
                  No equipment tracked yet.
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

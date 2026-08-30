/**
 * SPORTS TOURNAMENT MANAGEMENT SYSTEM
 * Dashboard Interactivity & DOM Manipulation
 * AIUB Web Technologies (CSC 3222) Standard Pattern
 */

document.addEventListener('DOMContentLoaded', function () {
  // ----------------------------------------------------
  // 1. Employee Task List Checklist Dynamic Counter
  // ----------------------------------------------------
  const taskCheckboxes = document.querySelectorAll('.task-checkbox');
  const taskCounterEl = document.getElementById('taskCounter');

  function updateTaskCounter() {
    if (!taskCheckboxes.length || !taskCounterEl) return;
    let completedCount = 0;
    taskCheckboxes.forEach(function (cb) {
      const taskItem = cb.closest('.task-item');
      if (cb.checked) {
        completedCount++;
        if (taskItem) taskItem.classList.add('completed');
      } else {
        if (taskItem) taskItem.classList.remove('completed');
      }
    });
    taskCounterEl.textContent = completedCount + '/' + taskCheckboxes.length + ' Completed';
  }

  if (taskCheckboxes.length) {
    taskCheckboxes.forEach(function (cb) {
      cb.addEventListener('change', updateTaskCounter);
    });
    updateTaskCounter();
  }

  // ----------------------------------------------------
  // 2. Spectator Match Prediction Radio Poll
  // ----------------------------------------------------
  const predictionOptions = document.querySelectorAll('input[name="prediction"]');
  if (predictionOptions.length) {
    predictionOptions.forEach(function (radio) {
      radio.addEventListener('change', function () {
        const parentCards = document.querySelectorAll('.prediction-option');
        parentCards.forEach(function (card) {
          card.style.borderColor = 'var(--border-color)';
          card.style.backgroundColor = 'var(--bg-surface-low)';
        });
        const selectedParent = radio.closest('.prediction-option');
        if (selectedParent) {
          selectedParent.style.borderColor = 'var(--accent-blue)';
          selectedParent.style.backgroundColor = '#FFFFFF';
        }
      });
    });
  }

  // ----------------------------------------------------
  // 3. Admin Live Score Simulator Button
  // ----------------------------------------------------
  const updateScoreBtn = document.getElementById('updateScoreBtn');
  const teamAScoreEl = document.getElementById('teamAScore');
  if (updateScoreBtn && teamAScoreEl) {
    updateScoreBtn.addEventListener('click', function () {
      let currentScore = parseInt(teamAScoreEl.textContent.trim(), 10) || 0;
      currentScore += 1;
      teamAScoreEl.textContent = currentScore;
      
      // Temporary highlight
      teamAScoreEl.style.color = 'var(--accent-blue)';
      setTimeout(function () {
        teamAScoreEl.style.color = 'var(--text-primary)';
      }, 600);
    });
  }

  // ----------------------------------------------------
  // 4. Mobile Sidebar Toggle
  // ----------------------------------------------------
  const mobileMenuToggle = document.getElementById('mobileMenuToggle');
  const sidebar = document.querySelector('.sidebar');
  if (mobileMenuToggle && sidebar) {
    mobileMenuToggle.addEventListener('click', function () {
      sidebar.classList.toggle('open');
    });
  }
});

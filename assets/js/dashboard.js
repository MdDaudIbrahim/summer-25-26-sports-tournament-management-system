document.addEventListener('DOMContentLoaded', function () {
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

  // Prediction poll
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

  // Live score quick buttons
  const teamAScoreEl = document.getElementById('teamAScore');
  const teamBScoreEl = document.getElementById('teamBScore');
  const matchStatusTextEl = document.getElementById('matchStatusText');
  const btnGoalTeamA = document.getElementById('btnGoalTeamA');
  const btnGoalTeamB = document.getElementById('btnGoalTeamB');

  function flashElement(el) {
    if (!el) return;
    el.style.color = 'var(--accent-blue)';
    setTimeout(function () {
      el.style.color = 'var(--text-primary)';
    }, 600);
  }

  if (btnGoalTeamA && teamAScoreEl) {
    btnGoalTeamA.addEventListener('click', function () {
      let currentScore = parseInt(teamAScoreEl.textContent.trim(), 10) || 0;
      currentScore += 1;
      teamAScoreEl.textContent = currentScore;
      flashElement(teamAScoreEl);
    });
  }

  if (btnGoalTeamB && teamBScoreEl) {
    btnGoalTeamB.addEventListener('click', function () {
      let currentScore = parseInt(teamBScoreEl.textContent.trim(), 10) || 0;
      currentScore += 1;
      teamBScoreEl.textContent = currentScore;
      flashElement(teamBScoreEl);
    });
  }

  // Score update modal
  const updateScoreBtn = document.getElementById('updateScoreBtn');
  const scoreModalBackdrop = document.getElementById('scoreModalBackdrop');
  const closeScoreModalBtn = document.getElementById('closeScoreModalBtn');
  const cancelScoreModalBtn = document.getElementById('cancelScoreModalBtn');
  const saveScoreModalBtn = document.getElementById('saveScoreModalBtn');
  const modalScoreA = document.getElementById('modalScoreA');
  const modalScoreB = document.getElementById('modalScoreB');
  const modalStatusInput = document.getElementById('modalStatusInput');
  const modalIncA = document.getElementById('modalIncA');
  const modalDecA = document.getElementById('modalDecA');
  const modalIncB = document.getElementById('modalIncB');
  const modalDecB = document.getElementById('modalDecB');

  if (updateScoreBtn && scoreModalBackdrop) {
    // Open modal
    updateScoreBtn.addEventListener('click', function () {
      if (modalScoreA && teamAScoreEl) {
        modalScoreA.value = parseInt(teamAScoreEl.textContent.trim(), 10) || 0;
      }
      if (modalScoreB && teamBScoreEl) {
        modalScoreB.value = parseInt(teamBScoreEl.textContent.trim(), 10) || 0;
      }
      if (modalStatusInput && matchStatusTextEl) {
        modalStatusInput.value = matchStatusTextEl.textContent.trim();
      }
      scoreModalBackdrop.style.display = 'flex';
    });

    // Close modal
    function closeModal() {
      scoreModalBackdrop.style.display = 'none';
    }

    if (closeScoreModalBtn) closeScoreModalBtn.addEventListener('click', closeModal);
    if (cancelScoreModalBtn) cancelScoreModalBtn.addEventListener('click', closeModal);
    scoreModalBackdrop.addEventListener('click', function (e) {
      if (e.target === scoreModalBackdrop) closeModal();
    });

    // +/- buttons
    if (modalIncA && modalScoreA) {
      modalIncA.addEventListener('click', function () {
        modalScoreA.value = (parseInt(modalScoreA.value, 10) || 0) + 1;
      });
    }
    if (modalDecA && modalScoreA) {
      modalDecA.addEventListener('click', function () {
        let val = (parseInt(modalScoreA.value, 10) || 0) - 1;
        modalScoreA.value = val < 0 ? 0 : val;
      });
    }
    if (modalIncB && modalScoreB) {
      modalIncB.addEventListener('click', function () {
        modalScoreB.value = (parseInt(modalScoreB.value, 10) || 0) + 1;
      });
    }
    if (modalDecB && modalScoreB) {
      modalDecB.addEventListener('click', function () {
        let val = (parseInt(modalScoreB.value, 10) || 0) - 1;
        modalScoreB.value = val < 0 ? 0 : val;
      });
    }

    // Save & apply
    if (saveScoreModalBtn) {
      saveScoreModalBtn.addEventListener('click', function () {
        if (teamAScoreEl && modalScoreA) {
          teamAScoreEl.textContent = modalScoreA.value;
          flashElement(teamAScoreEl);
        }
        if (teamBScoreEl && modalScoreB) {
          teamBScoreEl.textContent = modalScoreB.value;
          flashElement(teamBScoreEl);
        }
        if (matchStatusTextEl && modalStatusInput && modalStatusInput.value.trim()) {
          matchStatusTextEl.textContent = modalStatusInput.value.trim();
        }
        closeModal();
      });
    }
  }

  // Reschedule modal
  const openRescheduleModalBtn = document.getElementById('openRescheduleModalBtn');
  const rescheduleModalBackdrop = document.getElementById('rescheduleModalBackdrop');
  const closeRescheduleModalBtn = document.getElementById('closeRescheduleModalBtn');
  const cancelRescheduleModalBtn = document.getElementById('cancelRescheduleModalBtn');

  if (openRescheduleModalBtn && rescheduleModalBackdrop) {
    function openRescheduleModal() {
      rescheduleModalBackdrop.style.display = 'flex';
    }
    function closeRescheduleModal() {
      rescheduleModalBackdrop.style.display = 'none';
    }

    openRescheduleModalBtn.addEventListener('click', openRescheduleModal);
    if (closeRescheduleModalBtn) closeRescheduleModalBtn.addEventListener('click', closeRescheduleModal);
    if (cancelRescheduleModalBtn) cancelRescheduleModalBtn.addEventListener('click', closeRescheduleModal);
    rescheduleModalBackdrop.addEventListener('click', function (e) {
      if (e.target === rescheduleModalBackdrop) closeRescheduleModal();
    });
  }

  // Mobile sidebar toggle
  const mobileMenuToggle = document.getElementById('mobileMenuToggle');
  const sidebar = document.querySelector('.sidebar');
  if (mobileMenuToggle && sidebar) {
    mobileMenuToggle.addEventListener('click', function () {
      sidebar.classList.toggle('open');
    });
  }
});

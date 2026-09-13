document.addEventListener('DOMContentLoaded', function () {
  function showError(inputEl, errorEl, message) {
    if (errorEl) {
      errorEl.textContent = message;
      errorEl.style.display = 'block';
    }
    if (inputEl) {
      inputEl.classList.add('is-invalid');
    }
  }

  function clearError(inputEl, errorEl) {
    if (errorEl) {
      errorEl.textContent = '';
      errorEl.style.display = 'none';
    }
    if (inputEl) {
      inputEl.classList.remove('is-invalid');
    }
  }

  const loginForm = document.getElementById('loginForm');
  if (loginForm) {
    loginForm.addEventListener('submit', function (e) {
      let isValid = true;

      const emailInput = document.getElementById('email');
      const emailError = document.getElementById('emailError');
      const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

      if (!emailInput.value.trim()) {
        showError(emailInput, emailError, 'Email address is required.');
        isValid = false;
      } else if (!emailPattern.test(emailInput.value.trim())) {
        showError(emailInput, emailError, 'Please enter a valid email address.');
        isValid = false;
      } else {
        clearError(emailInput, emailError);
      }

      const passwordInput = document.getElementById('password');
      const passwordError = document.getElementById('passwordError');

      if (!passwordInput.value.trim()) {
        showError(passwordInput, passwordError, 'Password is required.');
        isValid = false;
      } else if (passwordInput.value.trim().length < 6) {
        showError(passwordInput, passwordError, 'Password must be at least 6 characters.');
        isValid = false;
      } else {
        clearError(passwordInput, passwordError);
      }

      if (!isValid) {
        e.preventDefault();
      }
    });
  }

  const registrationForm = document.getElementById('registrationForm');
  if (registrationForm) {
    registrationForm.addEventListener('submit', function (e) {
      let isValid = true;

      const nameInput = document.getElementById('name');
      const nameError = document.getElementById('nameError');
      const namePattern = /^[a-zA-Z\s'-]+$/;

      if (!nameInput.value.trim()) {
        showError(nameInput, nameError, 'Full name is required.');
        isValid = false;
      } else if (nameInput.value.trim().length < 3) {
        showError(nameInput, nameError, 'Full name must be at least 3 characters.');
        isValid = false;
      } else if (!namePattern.test(nameInput.value.trim())) {
        showError(nameInput, nameError, 'Name can only contain letters and spaces.');
        isValid = false;
      } else {
        clearError(nameInput, nameError);
      }

      const emailInput = document.getElementById('email');
      const emailError = document.getElementById('emailError');
      const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

      if (!emailInput.value.trim()) {
        showError(emailInput, emailError, 'Email address is required.');
        isValid = false;
      } else if (!emailPattern.test(emailInput.value.trim())) {
        showError(emailInput, emailError, 'Please enter a valid email address.');
        isValid = false;
      } else {
        clearError(emailInput, emailError);
      }

      const roleSelect = document.getElementById('role');
      const roleError = document.getElementById('roleError');

      if (!roleSelect.value || roleSelect.value === '') {
        showError(roleSelect, roleError, 'Please select your role.');
        isValid = false;
      } else {
        clearError(roleSelect, roleError);
      }

      const passwordInput = document.getElementById('password');
      const passwordError = document.getElementById('passwordError');

      if (!passwordInput.value.trim()) {
        showError(passwordInput, passwordError, 'Password is required.');
        isValid = false;
      } else if (passwordInput.value.trim().length < 6) {
        showError(passwordInput, passwordError, 'Password must be at least 6 characters.');
        isValid = false;
      } else {
        clearError(passwordInput, passwordError);
      }

      const confirmInput = document.getElementById('confirm_password');
      const confirmError = document.getElementById('confirmError');

      if (!confirmInput.value.trim()) {
        showError(confirmInput, confirmError, 'Please confirm your password.');
        isValid = false;
      } else if (confirmInput.value !== passwordInput.value) {
        showError(confirmInput, confirmError, 'Passwords do not match.');
        isValid = false;
      } else {
        clearError(confirmInput, confirmError);
      }

      const termsCheckbox = document.getElementById('terms');
      const termsError = document.getElementById('termsError');

      if (termsCheckbox && !termsCheckbox.checked) {
        showError(termsCheckbox, termsError, 'You must agree to the Terms of Service.');
        isValid = false;
      } else {
        clearError(termsCheckbox, termsError);
      }

      if (!isValid) {
        e.preventDefault();
      }
    });
  }

  const incidentForm = document.getElementById('incidentForm');
  if (incidentForm) {
    incidentForm.addEventListener('submit', function (e) {
      let isValid = true;

      const locationInput = document.getElementById('location');
      const descInput = document.getElementById('description');

      if (locationInput && locationInput.value.trim().length < 3) {
        alert('Please specify a valid venue location area (at least 3 characters).');
        locationInput.focus();
        isValid = false;
      } else if (descInput && descInput.value.trim().length < 10) {
        alert('Please provide a more detailed description (at least 10 characters).');
        descInput.focus();
        isValid = false;
      }

      if (!isValid) {
        e.preventDefault();
      } else {
        alert('Incident report submitted successfully!');
      }
    });
  }
});

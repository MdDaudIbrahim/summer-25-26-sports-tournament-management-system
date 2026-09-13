function validateForm(form) {
    clearFieldErrors(form);
    var valid = true;

    form.querySelectorAll('input, select, textarea').forEach(function (field) {
        var val   = field.value.trim();
        var label = field.dataset.label || field.name || 'This field';

        if (field.hasAttribute('required') && val === '') {
            showError(field, label + ' is required.');
            valid = false;
            return;
        }

        if (val === '') return;

        var min = parseInt(field.dataset.min, 10);
        if (!isNaN(min) && val.length < min) {
            showError(field, label + ' must be at least ' + min + ' characters.');
            valid = false;
            return;
        }

        if (field.type === 'email' && !/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(val)) {
            showError(field, label + ' must be a valid email address.');
            valid = false;
            return;
        }

        var matchId = field.dataset.match;
        if (matchId) {
            var other = document.getElementById(matchId);
            if (other && val !== other.value.trim()) {
                showError(field, label + ' does not match ' + (other.dataset.label || matchId) + '.');
                valid = false;
                return;
            }
        }
    });

    return valid;
}

function showError(field, msg) {
    var span = document.createElement('span');
    span.className   = 'field-error';
    span.textContent = msg;
    field.classList.add('input-error');
    field.parentNode.insertBefore(span, field.nextSibling);
}

function clearFieldErrors(form) {
    form.querySelectorAll('.field-error').forEach(function (el) { el.remove(); });
    form.querySelectorAll('.input-error').forEach(function (el) { el.classList.remove('input-error'); });
}

function esc(text) {
    return String(text)
        .replace(/&/g,  '&amp;')
        .replace(/</g,  '&lt;')
        .replace(/>/g,  '&gt;')
        .replace(/"/g,  '&quot;')
        .replace(/'/g,  '&#39;');
}

function liveSearch(inputId, handler) {
    var input = document.getElementById(inputId);
    if (!input) return;
    var timer;
    input.addEventListener('input', function () {
        clearTimeout(timer);
        timer = setTimeout(handler, 250);
    });
}

function ajaxTable(options) {
    fetch(options.url, { credentials: 'same-origin' })
        .then(function (res) {
            if (!res.ok) throw new Error('HTTP ' + res.status);
            return res.json();
        })
        .then(function (rows) {
            var tbody = document.getElementById(options.tbody);
            if (!tbody) return;

            if (!Array.isArray(rows) || rows.length === 0) {
                tbody.innerHTML = '<tr><td colspan="' + (options.columns || 5)
                    + '" class="empty">No ' + (options.word || 'results') + ' found.</td></tr>';
            } else {
                tbody.innerHTML = rows.map(options.row).join('');
            }

            if (options.counter) {
                var el = document.getElementById(options.counter);
                if (el) el.textContent = rows.length + ' ' + (options.word || '');
            }
        })
        .catch(function (err) {
            console.error('ajaxTable error:', err);
        });
}

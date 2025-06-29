document.addEventListener('DOMContentLoaded', function () {
  const form = document.getElementById('goalForm');

  form.addEventListener('submit', function (e) {
    let valid = true;

    // Clear all errors
    const errors = document.querySelectorAll('.error');
    errors.forEach(error => error.textContent = '');

    const title = document.getElementById('title').value.trim();
    const target = document.getElementById('target').value.trim();
    const unit = document.getElementById('unit').value.trim();
    const deadline = document.getElementById('deadline').value.trim();

    // Title must be letters and numbers
    if (!/^[a-zA-Z0-9 ]{3,50}$/.test(title)) {
      showError('title', '❌ Title is required (3-50 chars, letters & numbers)');
      valid = false;
    }

    // Target must be a number
    if (!/^\d+(\.\d+)?$/.test(target)) {
      showError('target', '❌ Target must be a number');
      valid = false;
    }

    // Unit should be alphabets only
    if (!/^[a-zA-Z]{1,10}$/.test(unit)) {
      showError('unit', '❌ Unit should be 1-10 letters');
      valid = false;
    }

    // Deadline must not be empty
    if (!deadline) {
      showError('deadline', '❌ Deadline is required');
      valid = false;
    }

    if (!valid) {
      e.preventDefault(); // Stop form from submitting
    }
  });

  function showError(fieldId, message) {
    const input = document.getElementById(fieldId);
    const error = input.nextElementSibling;
    error.textContent = message;
  }
});

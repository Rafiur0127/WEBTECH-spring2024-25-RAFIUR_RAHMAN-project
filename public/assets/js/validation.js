// document.addEventListener("DOMContentLoaded", function () {
//   const registerForm = document.getElementById("registerForm");
//   const loginForm = document.getElementById("loginForm");

//   function showError(input, message) {
//     const errorElement = input.nextElementSibling;
//     if (errorElement) {
//       errorElement.textContent = message;
//       errorElement.style.color = 'red';
//     }
//   }

//   function clearErrors(formId) {
//     document.querySelectorAll(`#${formId} .error`).forEach(e => e.textContent = "");
//   }

//   if (registerForm) {
//     registerForm.addEventListener("submit", function (e) {
//       clearErrors("registerForm");
//       let valid = true;

//       const name = registerForm.name;
//       const username = registerForm.username;
//       const age = registerForm.age;
//       const gender = registerForm.gender;
//       const phone = registerForm.phone;
//       const email = registerForm.email;
//       const password = registerForm.password;
//       const confirmPassword = registerForm.confirm_password;

//       const nameRegex = /^[A-Za-z\s]{2,}$/;
//       const usernameRegex = /^[a-zA-Z0-9_]{3,16}$/;
//       const phoneRegex = /^\d{10,15}$/;
//       const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
//       const passwordRegex = /^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d]{6,}$/;

//       if (!nameRegex.test(name.value.trim())) {
//         showError(name, "Enter a valid full name (2+ letters).");
//         valid = false;
//       }

//       if (!usernameRegex.test(username.value.trim())) {
//         showError(username, "3–16 chars, letters, numbers, or underscores only.");
//         valid = false;
//       }

//       if (!age.value || age.value < 1 || age.value > 120) {
//         showError(age, "Enter a valid age (1–120).");
//         valid = false;
//       }

//       if (!gender.value) {
//         showError(gender, "Please select a gender.");
//         valid = false;
//       }

//       if (!phoneRegex.test(phone.value.trim())) {
//         showError(phone, "Phone must be 10 to 15 digits.");
//         valid = false;
//       }

//       if (!emailRegex.test(email.value.trim())) {
//         showError(email, "Enter a valid email address.");
//         valid = false;
//       }

//       if (!passwordRegex.test(password.value.trim())) {
//         showError(password, "Password must have at least 6 characters, with letters and numbers.");
//         valid = false;
//       }

//       if (password.value !== confirmPassword.value) {
//         showError(confirmPassword, "Passwords do not match.");
//         valid = false;
//       }

//       if (!valid) e.preventDefault();
//     });
//   }

//   if (loginForm) {
//     loginForm.addEventListener("submit", function (e) {
//       clearErrors("loginForm");
//       let valid = true;

//       const emailInput = loginForm.email;
//       const passwordInput = loginForm.password;
//       const email = emailInput.value.trim();
//       const password = passwordInput.value.trim();
//       const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

//       if (!emailRegex.test(email)) {
//         showError(emailInput, "Please enter a valid email address.");
//         valid = false;
//       }

//       if (password.length < 6) {
//         showError(passwordInput, "Password must be at least 6 characters long.");
//         valid = false;
//       }

//       if (!valid) e.preventDefault();
//     });
//   }
// });

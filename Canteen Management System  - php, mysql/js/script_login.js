// Get the login form and the signup form
const loginForm = document.getElementById("login-form");
const signupForm = document.getElementById("signup-form");

// Get the login link and the signup link
const loginLink = document.getElementById("login-link");
const signupLink = document.getElementById("signup-link");

// Hide the signup form by default
signupForm.style.display = "none";

// When the login link is clicked, hide the signup form and show the login form
loginLink.addEventListener("click", function(event) {
  event.preventDefault();
  loginForm.style.display = "block";
  signupForm.style.display = "none";
});

// When the signup link is clicked, hide the login form and show the signup form
signupLink.addEventListener("click", function(event) {
  event.preventDefault();
  signupForm.style.display = "block";
  loginForm.style.display = "none";
});

document.addEventListener("DOMContentLoaded", () => {
  // --- Element References ---
  const loginForm = document.getElementById("login-form");
  const usernameInput = document.getElementById("username");
  const passwordInput = document.getElementById("password");
  const rememberMeCheckbox = document.getElementById("remember-me");
  const loginButton = document.getElementById("login-button");
  const submissionMessage = document.getElementById("submission-message");
  const usernameWarning = document.getElementById("username-warning");
  const passwordWarning = document.getElementById("password-warning");
  const eyeToggle = document.getElementById("toggle-login-eye"); // ✅ Correct ID
  const REMEMBER_ME_KEY = "shms_remembered_username";

  // --- 1. Load remembered username ---
  function loadRememberedUsername() {
    const rememberedUsername = localStorage.getItem(REMEMBER_ME_KEY);
    if (rememberedUsername) {
      usernameInput.value = rememberedUsername;
      rememberMeCheckbox.checked = true;
    }
  }

  // --- 2. Eye Icon Toggle ---
  if (eyeToggle) {
    eyeToggle.addEventListener("click", () => {
      const img = eyeToggle.querySelector("img");
      const isHidden = passwordInput.type === "password";

      if (isHidden) {
        passwordInput.type = "text";
        img.src = "/Img/eye_closed.jpeg"; // 👈 Use your closed-eye image
        img.alt = "Hide Password";
      } else {
        passwordInput.type = "password";
        img.src = "/Img/eye_opened.jpeg"; // 👈 Use your opened-eye image
        img.alt = "Show Password";
      }
    });
  }

  // --- 3. Form Validation and Submission ---
  loginForm.addEventListener("submit", function (event) {
    event.preventDefault();
    let isValid = true;
    usernameWarning.style.display = "none";
    passwordWarning.style.display = "none";

    if (usernameInput.value.trim() === "") {
      usernameWarning.style.display = "block";
      isValid = false;
    }

    if (passwordInput.value.trim() === "") {
      passwordWarning.style.display = "block";
      isValid = false;
    }

    if (isValid) {
      if (rememberMeCheckbox.checked) {
        localStorage.setItem(REMEMBER_ME_KEY, usernameInput.value.trim());
      } else {
        localStorage.removeItem(REMEMBER_ME_KEY);
      }

      submissionMessage.style.display = "block";
      loginButton.disabled = true;
      loginButton.textContent = "Please Wait...";

      setTimeout(() => {
        loginButton.disabled = false;
        loginButton.textContent = "Sign In";
        submissionMessage.style.display = "none";
        loginForm.submit();
      }, 1000);
    }
  });

  // --- 4. Load saved username ---
  loadRememberedUsername();
});

// Wait until the DOM is fully loaded
document.addEventListener("DOMContentLoaded", function () {
  const form = document.querySelector("form");
  const password = document.getElementById("password");
  const confirmPassword = document.getElementById("confirm_password");
  const submitBtn = form.querySelector("button[type='submit']");

  // ====== 1. Eye Icon Toggle for Password Visibility ======
  const eyePassword = document.getElementById("toggle-password").querySelector("img");
  const eyeConfirm = document.getElementById("toggle-confirm").querySelector("img");

  function toggleVisibility(input, icon) {
    if (input.type === "text") {
      // Switch back to hidden (dots)
      input.type = "password";
      icon.src = "/Img/eye_opened.jpeg"; // 👁️ means hidden
      icon.alt = "Show password";
    } else {
      // Show characters
      input.type = "text";
      icon.src = "/Img/eye_closed.jpeg"; // 🙈 means visible
      icon.alt = "Hide password";
    }
  }

  // Apply the toggling for both fields
  eyePassword.addEventListener("click", () => toggleVisibility(password, eyePassword));
  eyeConfirm.addEventListener("click", () => toggleVisibility(confirmPassword, eyeConfirm));

  // ====== 2. Password Match Check ======
  confirmPassword.addEventListener("input", function () {
    if (confirmPassword.value !== password.value) {
      confirmPassword.style.borderColor = "red";
    } else {
      confirmPassword.style.borderColor = "green";
    }
  });

  // ====== 3. Basic Validation Before Submit ======
  form.addEventListener("submit", function (e) {
    let messages = [];

    const firstName = document.getElementById("first_name").value.trim();
    const lastName = document.getElementById("last_name").value.trim();
    const email = document.getElementById("email").value.trim();

    if (firstName === "" || lastName === "") {
      messages.push("Please fill in your full name.");
    }

    if (!email.includes("@")) {
      messages.push("Please enter a valid email address.");
    }

    if (password.value !== confirmPassword.value) {
      messages.push("Passwords do not match.");
    }

    if (messages.length > 0) {
      e.preventDefault();
      alert(messages.join("\n"));
    }
  });

  // ====== 4. Button Hover Interactivity ======
  submitBtn.addEventListener("mouseover", function () {
    submitBtn.style.opacity = "0.8";
    submitBtn.style.transition = "0.2s ease";
  });
  submitBtn.addEventListener("mouseout", function () {
    submitBtn.style.opacity = "1";
  });
});

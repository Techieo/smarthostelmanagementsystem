document.addEventListener("DOMContentLoaded", () => {
  const hamburger = document.getElementById("hamburger");
  const mobileMenu = document.getElementById("mobileMenu");

  // ===== Hamburger menu toggle =====
  hamburger.addEventListener("click", (event) => {
    event.stopPropagation();
    mobileMenu.classList.toggle("active");

    // Hamburger bar color
    hamburger.querySelectorAll("span").forEach((bar) => {
      bar.style.backgroundColor = mobileMenu.classList.contains("active")
        ? "#1e90ff"
        : "#ffffff";
    });
  });

  // Close mobile menu when clicking outside
  document.addEventListener("click", (event) => {
    if (!mobileMenu.contains(event.target) && !hamburger.contains(event.target)) {
      mobileMenu.classList.remove("active");
      hamburger.querySelectorAll("span").forEach(bar => bar.style.backgroundColor = "#ffffff");
    }
  });

  // Close mobile menu when clicking a link
  mobileMenu.querySelectorAll("a").forEach(link => {
    link.addEventListener("click", () => {
      mobileMenu.classList.remove("active");
      hamburger.querySelectorAll("span").forEach(bar => bar.style.backgroundColor = "#ffffff");
    });
  });

  // ===== Dropdown for desktop =====
  const dropdown = document.querySelector(".dropdown");
  const dropdownToggle = dropdown?.querySelector("a");
  const dropdownMenu = dropdown?.querySelector(".dropdown-content");

  dropdownToggle?.addEventListener("click", (e) => {
    e.preventDefault();
    e.stopPropagation();
    dropdown.classList.toggle("active");
  });

  // Close dropdown when clicking outside
  document.addEventListener("click", (event) => {
    if (!dropdown.contains(event.target)) {
      dropdown.classList.remove("active");
    }
  });
});

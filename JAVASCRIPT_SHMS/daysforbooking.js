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

  // Close mobile menu when clicking a regular link
  mobileMenu.querySelectorAll("a:not(.dropdown-toggle)").forEach(link => {
    link.addEventListener("click", () => {
      mobileMenu.classList.remove("active");
      hamburger.querySelectorAll("span").forEach(bar => bar.style.backgroundColor = "#ffffff");
    });
  });

  // ===== Desktop dropdowns =====
  const desktopDropdowns = document.querySelectorAll("nav .dropdown");
  desktopDropdowns.forEach(dropdown => {
    const toggle = dropdown.querySelector("a");
    toggle.addEventListener("click", (e) => {
      e.preventDefault();
      e.stopPropagation();

      // Close all other desktop dropdowns
      desktopDropdowns.forEach(d => {
        if (d !== dropdown) d.classList.remove("active");
      });

      dropdown.classList.toggle("active");
    });
  });

  // ===== Mobile dropdowns =====
  const mobileDropdowns = document.querySelectorAll(".mobile-menu li.dropdown > a");
  mobileDropdowns.forEach(toggle => {
    toggle.addEventListener("click", (e) => {
      e.preventDefault();
      e.stopPropagation();

      const parentLi = toggle.parentElement;

      // Close other mobile dropdowns
      mobileDropdowns.forEach(t => {
        if (t !== toggle) t.parentElement.classList.remove("active");
      });

      parentLi.classList.toggle("active");
    });
  });

  // ===== Close dropdowns when clicking outside =====
  document.addEventListener("click", () => {
    desktopDropdowns.forEach(dropdown => dropdown.classList.remove("active"));
    mobileDropdowns.forEach(toggle => toggle.parentElement.classList.remove("active"));
  });
});

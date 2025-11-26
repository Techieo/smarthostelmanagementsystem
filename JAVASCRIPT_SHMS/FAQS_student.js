document.addEventListener("DOMContentLoaded", () => {
  // Hamburger Menu
  const hamburger = document.getElementById("hamburger");
  const mobileMenu = document.getElementById("mobileMenu");

  if (hamburger && mobileMenu) {
    hamburger.addEventListener("click", (event) => {
      event.stopPropagation();
      mobileMenu.classList.toggle("active");
      hamburger.classList.toggle("active");
      hamburger.querySelectorAll("span").forEach(bar => {
        bar.style.backgroundColor = mobileMenu.classList.contains("active") ? "#1e90ff" : "#fff";
      });
    });

    document.addEventListener("click", (event) => {
      if (!mobileMenu.contains(event.target) && !hamburger.contains(event.target)) {
        mobileMenu.classList.remove("active");
        hamburger.classList.remove("active");
        hamburger.querySelectorAll("span").forEach(bar => bar.style.backgroundColor = "#fff");
      }
    });

    mobileMenu.querySelectorAll("a").forEach(link => {
      link.addEventListener("click", () => {
        mobileMenu.classList.remove("active");
        hamburger.classList.remove("active");
        hamburger.querySelectorAll("span").forEach(bar => bar.style.backgroundColor = "#fff");
      });
    });
  }

  // Desktop Dropdown
  const dropdown = document.querySelector(".dropdown");
  const dropdownToggle = dropdown?.querySelector(".dropdown-toggle");
  const dropdownMenu = dropdown?.querySelector(".dropdown-content");

  if (dropdown && dropdownToggle && dropdownMenu) {
    dropdownToggle.addEventListener("click", (e) => {
      e.stopPropagation();
      dropdown.classList.toggle("active");
    });

    document.addEventListener("click", (event) => {
      if (!dropdown.contains(event.target)) {
        dropdown.classList.remove("active");
      }
    });

    dropdownMenu.querySelectorAll("a").forEach(link => {
      link.addEventListener("click", () => {
        dropdown.classList.remove("active");
      });
    });
  }
});

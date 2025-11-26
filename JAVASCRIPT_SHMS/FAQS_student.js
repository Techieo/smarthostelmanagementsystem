// ====== NAVBAR TOGGLE FUNCTIONALITY ======
document.addEventListener("DOMContentLoaded", () => {
  const hamburger = document.getElementById("hamburger");
  const mobileMenu = document.getElementById("mobileMenu");

  if (hamburger && mobileMenu) {
    // Toggle mobile menu
    hamburger.addEventListener("click", (event) => {
      event.stopPropagation(); // prevent click from bubbling
      mobileMenu.classList.toggle("active");
      hamburger.classList.toggle("active");

      // Change hamburger color when menu is active
      const bars = hamburger.querySelectorAll("span");
      bars.forEach((bar) => {
        bar.style.backgroundColor = mobileMenu.classList.contains("active")
          ? "#ff1e1eff" // blue when open
          : "#333"; // gray when closed
      });
    });

    // Close menu when clicking outside
    document.addEventListener("click", (event) => {
      const isClickInsideMenu = mobileMenu.contains(event.target);
      const isClickOnHamburger = hamburger.contains(event.target);

      if (!isClickInsideMenu && !isClickOnHamburger) {
        mobileMenu.classList.remove("active");
        hamburger.classList.remove("active");

        // Reset hamburger color when closed
        hamburger.querySelectorAll("span").forEach((bar) => {
          bar.style.backgroundColor = "#333";
        });
      }
    });

    // Close menu automatically when clicking a link
    const menuLinks = mobileMenu.querySelectorAll("a");
    menuLinks.forEach((link) => {
      link.addEventListener("click", () => {
        mobileMenu.classList.remove("active");
        hamburger.classList.remove("active");

        // Reset hamburger color
        hamburger.querySelectorAll("span").forEach((bar) => {
          bar.style.backgroundColor = "#333";
        });
      });
    });
  }

  // ====== DROPDOWN CLICK FUNCTIONALITY ======
  const dropdown = document.querySelector(".dropdown");
  const dropdownToggle = dropdown?.querySelector("a");
  const dropdownMenu = dropdown?.querySelector(".dropdown-content");

  if (dropdown && dropdownToggle && dropdownMenu) {
    // When clicking "More"
    dropdownToggle.addEventListener("click", (e) => {
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

    // When a dropdown link is clicked, close dropdown
    dropdownMenu.querySelectorAll("a").forEach((link) => {
      link.addEventListener("click", () => {
        dropdown.classList.remove("active");
      });
    });
  }
});

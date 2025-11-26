document.addEventListener("DOMContentLoaded", () => {

  // ====== Hamburger Menu (Mobile) ======
  const hamburger = document.getElementById("hamburger");
  const mobileMenu = document.getElementById("mobileMenu");

  if (hamburger && mobileMenu) {
    hamburger.addEventListener("click", (e) => {
      e.stopPropagation();
      mobileMenu.classList.toggle("active");
      hamburger.classList.toggle("active");
      hamburger.querySelectorAll("span").forEach(bar => {
        bar.style.backgroundColor = mobileMenu.classList.contains("active") ? "#1e90ff" : "#fff";
      });
    });

    document.addEventListener("click", (e) => {
      if (!mobileMenu.contains(e.target) && !hamburger.contains(e.target)) {
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

  // ====== Desktop Dropdown Menu ======
  const dropdown = document.querySelector(".dropdown");
  if (dropdown) {
    const toggle = dropdown.querySelector(".dropdown-toggle");
    const menu = dropdown.querySelector(".dropdown-content");

    if (toggle && menu) {
      toggle.addEventListener("click", (e) => {
        e.preventDefault(); // Prevent button default
        e.stopPropagation();
        dropdown.classList.toggle("active");
      });

      // Close dropdown if click outside
      document.addEventListener("click", () => {
        dropdown.classList.remove("active");
      });

      // Close dropdown when a link inside is clicked
      menu.querySelectorAll("a").forEach(link => {
        link.addEventListener("click", () => {
          dropdown.classList.remove("active");
        });
      });
    }
  }

  // ====== FAQ Collapsible ======
  document.querySelectorAll("dl dt").forEach(dt => {
    dt.addEventListener("click", () => {
      dt.classList.toggle("active");
      const dd = dt.nextElementSibling;
      if (dd.style.display === "block") {
        dd.style.display = "none";
      } else {
        dd.style.display = "block";
      }
    });
  });

});

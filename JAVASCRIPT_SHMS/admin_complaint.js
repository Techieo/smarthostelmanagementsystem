// ===== ADMIN NAVBAR TOGGLE =====
document.addEventListener("DOMContentLoaded", () => {
  const hamburger = document.getElementById("hamburger");
  const mobileMenu = document.getElementById("mobileMenu");

  if (hamburger && mobileMenu) {
    hamburger.addEventListener("click", (event) => {
      event.stopPropagation();
      mobileMenu.classList.toggle("active");
      hamburger.classList.toggle("active");

      const bars = hamburger.querySelectorAll("span");
      bars.forEach((bar) => {
        bar.style.backgroundColor = mobileMenu.classList.contains("active")
          ? "#1e90ff"
          : "#333";
      });
    });

    document.addEventListener("click", (event) => {
      if (!mobileMenu.contains(event.target) && !hamburger.contains(event.target)) {
        mobileMenu.classList.remove("active");
        hamburger.classList.remove("active");
        hamburger.querySelectorAll("span").forEach((bar) => {
          bar.style.backgroundColor = "#333";
        });
      }
    });

    mobileMenu.querySelectorAll("a").forEach((link) => {
      link.addEventListener("click", () => {
        mobileMenu.classList.remove("active");
        hamburger.classList.remove("active");
        hamburger.querySelectorAll("span").forEach((bar) => {
          bar.style.backgroundColor = "#333";
        });
      });
    });
  }
});

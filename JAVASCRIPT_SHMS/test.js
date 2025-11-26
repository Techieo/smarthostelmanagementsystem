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
/* PHOTO */
document.addEventListener("DOMContentLoaded", () => {
    const uploadBtn = document.getElementById("upload-btn");
    const uploadInput = document.getElementById("upload-input");
    const profilePhoto = document.getElementById("profile-photo");

    // Create a message element dynamically if not already present
    let uploadMessage = document.getElementById("upload-message");
    if (!uploadMessage) {
        uploadMessage = document.createElement("p");
        uploadMessage.id = "upload-message";
        uploadMessage.style.color = "green";
        uploadMessage.style.marginTop = "5px";
        uploadBtn.parentNode.appendChild(uploadMessage);
    }

    // Open file explorer when button or its icon is clicked
    const triggerFileInput = (e) => {
        e.preventDefault(); // Prevent default button behavior
        uploadInput.click();
    };

    uploadBtn.addEventListener("click", triggerFileInput);
    // Also handle clicks directly on the icon
    const icon = uploadBtn.querySelector("i");
    if (icon) {
        icon.addEventListener("click", triggerFileInput);
    }

    // When a file is selected, upload via AJAX
    uploadInput.addEventListener("change", () => {
        const file = uploadInput.files[0];
        if (!file) return;

        const formData = new FormData();
        formData.append("profile_photo", file);

        fetch("upload_profile_photo.php", {
            method: "POST",
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Update profile photo instantly with cache buster
                profilePhoto.src = data.filepath + "?t=" + new Date().getTime();
                uploadMessage.style.color = "green";
                uploadMessage.textContent = "Profile photo updated successfully!";
            } else {
                uploadMessage.style.color = "red";
                uploadMessage.textContent = "Error: " + data.error;
            }
        })
        .catch(err => {
            console.error(err);
            uploadMessage.style.color = "red";
            uploadMessage.textContent = "Upload failed.";
        });
    });
});

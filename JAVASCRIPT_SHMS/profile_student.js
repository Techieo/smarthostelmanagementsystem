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

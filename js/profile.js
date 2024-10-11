// Function to handle file input change
document.getElementById("profile_picture").addEventListener("change", function(event) {
    const file = event.target.files[0];

    if (file) {
        console.log("Selected file:", file); // Debugging log
        console.log("Detected file type:", file.type); // Debugging log

        // Valid file types
        const validTypes = ['image/jpeg', 'image/png', 'image/gif', 'image/bmp', 'image/tiff', 'image/svg+xml'];

        // Check if the file type is valid
        if (!validTypes.includes(file.type)) {
            const messageContainer = document.querySelector('.message-container');
            messageContainer.innerHTML += `<div class="error-message">Invalid image file type! Expected: jpg, jpeg, png, gif, bmp, tiff, svg (Detected: ${file.type})</div>`;
            document.getElementById("profile_picture").value = ''; // Clear the file input
            return; // Exit the function
        }

        // Preview the selected image
        const reader = new FileReader();
        reader.onload = function(e) {
            const profilePic = document.getElementById("profilePic");
            profilePic.src = e.target.result; // Set the source of the profile picture to the file's data URL
        };
        reader.readAsDataURL(file); // Read the file as a data URL

        // Upload the image to the server
        uploadImage(file);
    } else {
        // If no file is selected, reset to the default image
        const profilePic = document.getElementById("profilePic");
        profilePic.src = '../profilePics/defUser.png'; // Reset to default image
    }
});

// Function to upload image using AJAX
function uploadImage(file) {
    const formData = new FormData();
    formData.append('profile_picture', file);

    fetch('upload.php', { // Ensure this is the correct path to your PHP upload script
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            console.log("Image uploaded successfully:", data);
            // Update the profile picture src with the new image path
            document.getElementById("profilePic").src = data.imagePath; // Assuming your upload.php returns the new path
        } else {
            console.error("Image upload failed:", data.error);
            const messageContainer = document.querySelector('.message-container');
            messageContainer.innerHTML += `<div class="error-message">${data.error}</div>`;
        }
    })
    .catch(error => {
        console.error("Error uploading image:", error);
    });
}

// Existing form submission event listener
document.querySelector("form").addEventListener("submit", function(event) {
    const password = document.getElementById("password").value.trim();
    const confirmPassword = document.getElementById("confirm_password").value.trim();

    // Clear previous error messages
    const messageContainer = document.querySelector('.message-container');
    messageContainer.innerHTML = '';

    // Check for empty password fields
    if ((password && !confirmPassword) || (!password && confirmPassword)) {
        messageContainer.innerHTML += `<div class="error-message">Please fill in both password fields!</div>`;
        event.preventDefault(); // Prevent form submission
        return;
    }

    // Check for password match
    if (password !== confirmPassword) {
        messageContainer.innerHTML += `<div class="error-message">Passwords do not match!</div>`;
        event.preventDefault(); // Prevent form submission
    }
});

// Allow clicking the profile picture to change it
document.getElementById('profilePic').onclick = function() {
    document.getElementById('profile_picture').click();
};

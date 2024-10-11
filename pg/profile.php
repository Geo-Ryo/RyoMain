<?php
session_start();
$file = '../users.json';
$currentUser = null;

// Check if the session email is set
if (!isset($_SESSION['email'])) {
    header('Location: ../index.php'); // Redirect if no email is set in session
    exit;
}

// Load user data
if (file_exists($file)) {
    $json = file_get_contents($file);
    $users = json_decode($json, true);

    // Check if the user exists
    foreach ($users as $user) {
        if ($user['email'] === $_SESSION['email']) {
            $currentUser = $user;

            // Store the profile picture path in session (ensure correct path)
            $_SESSION['profile_picture'] = !empty($user['profile_picture']) ? $user['profile_picture'] : '../profilePics/defUser.png'; // Default picture if none exists

            break;
        }
    }
}

if (!$currentUser) {
    $_SESSION['error'] = "User not found. Redirecting to the homepage...";
    header('Location: ../index.php'); // Redirect to home page if user is not found
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/profile.css">
    <title>Profile Page</title>
</head>
<body>
<div class="profile-container">
    <h1><?php echo htmlspecialchars($currentUser['username']); ?></h1>

    <?php if (isset($_SESSION['error'])): ?>
        <div class="error-message"><?php echo htmlspecialchars($_SESSION['error']); ?></div>
        <?php unset($_SESSION['error']); ?>
    <?php endif; ?>

    <div style="position: relative;">
        <img src="<?php echo htmlspecialchars($_SESSION['profile_picture']); ?>" alt="Profile Picture" class="profile-pic" id="profilePic">
        <label for="profile_picture" style="cursor: pointer;">
            <img src="../img/camera_icon.png" alt="Change Picture" class="change-pic" style="position: absolute; top: 0; right: 0; width: 30px; height: 30px;">
        </label>
        <input type="file" id="profile_picture" name="profile_picture" style="display: none;" accept="image/*">
    </div>

    <form action="update_profile.php" method="POST" enctype="multipart/form-data" id="profileForm">
        <input type="hidden" name="current_picture" value="<?php echo htmlspecialchars($_SESSION['profile_picture']); ?>">
        <div class="form-group">
            <div class="input-group">
                <input type="text" id="username" name="username" placeholder="Enter your username" value="<?php echo htmlspecialchars($currentUser['username']); ?>" required>
            </div>
        </div>

        <div class="form-group">
            <div class="input-group">
                <input type="email" id="email" name="email" placeholder="Enter your email" value="<?php echo htmlspecialchars($currentUser['email']); ?>" required>
            </div>
        </div>

        <div class="form-group">
            <div class="input-group">
                <input type="password" id="password" name="password" placeholder="Enter new password">
            </div>
        </div>

        <div class="form-group">
            <div class="input-group">
                <input type="password" id="confirm_password" name="confirm_password" placeholder="Confirm new password">
            </div>
        </div>

        <button type="submit" id="saveBtn">Save</button>
    </form>
</div>

<script src="../js/profile.js"></script>
<script>
// Code to handle image upload (this part is fine and doesn't need changes)
document.getElementById('profile_picture').addEventListener('change', function(event) {
    const profilePic = document.getElementById('profilePic');
    const file = event.target.files[0];

    if (file) {
        const formData = new FormData();
        formData.append('profile_picture', file);

        // Upload image to server
        fetch('../php/upload.php', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                profilePic.src = URL.createObjectURL(file); // Preview the uploaded image
                console.log("Image uploaded successfully!");
            } else {
                console.error("Error uploading image:", data.error);
            }
        })
        .catch(error => {
            console.error("Error uploading image:", error);
        });
    } else {
        // If no file is selected, reset to the default image
        profilePic.src = '../profilePics/defUser.png'; // Reset to default image if no file is selected
    }
});
</script>
</body>
</html>

<?php
session_start();

$file = '../users.json'; // Path to the users JSON file
$uploadDir = '../profilePics/'; // Directory where images will be uploaded

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_FILES['profile_picture'])) {
    // Generate a unique file name to avoid collisions
    $fileName = basename($_FILES['profile_picture']['name']);
    $uploadFile = $uploadDir . uniqid() . '_' . $fileName;

    // Attempt to move the uploaded file
    if (move_uploaded_file($_FILES['profile_picture']['tmp_name'], $uploadFile)) {
        // Load user data from JSON file
        if (file_exists($file)) {
            $json = file_get_contents($file);
            $users = json_decode($json, true);

            // Update the current user's profile picture path
            $updatedUsers = []; // Prepare an array for updated user data
            $updated = false; // Flag to check if the user was found and updated
            
            foreach ($users as &$user) {
                if ($user['email'] === $_SESSION['email']) {
                    // Update the profile picture path to the new image
                    $user['profile_picture'] = $uploadFile; // Change to the new uploaded file path
                    $_SESSION['profile_picture'] = $uploadFile; // Update session variable
                    $updated = true; // Set flag to true
                }
                $updatedUsers[] = $user; // Always push user to updatedUsers
            }

            // Check if the user was found and updated
            if ($updated) {
                // Save the updated users data back to the JSON file
                if (file_put_contents($file, json_encode($updatedUsers, JSON_PRETTY_PRINT))) {
                    echo json_encode(['success' => true, 'imagePath' => $uploadFile]); // Include the new path in the response
                    exit;
                } else {
                    echo json_encode(['success' => false, 'error' => 'Failed to save updated user data.']);
                    exit;
                }
            } else {
                echo json_encode(['success' => false, 'error' => 'User not found.']);
                exit;
            }
        } else {
            echo json_encode(['success' => false, 'error' => 'User data file not found.']);
            exit;
        }
    } else {
        echo json_encode(['success' => false, 'error' => 'Failed to move uploaded file.']);
        exit;
    }
}

echo json_encode(['success' => false, 'error' => 'No file uploaded.']);
?>

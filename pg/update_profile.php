<?php
session_start();

// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $file = '../users.json';
    $updatedUsers = [];
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $confirmPassword = $_POST['confirm_password'];
    $currentEmail = $_SESSION['email'];
    $currentPicture = $_POST['current_picture'];
    
    // Load user data
    if (file_exists($file)) {
        $json = file_get_contents($file);
        $users = json_decode($json, true);
        $userExists = false;

        // Check for existing usernames and emails
        foreach ($users as $user) {
            if (($user['username'] === $username || $user['email'] === $email) && $user['email'] !== $currentEmail) {
                $userExists = true;
                break;
            }
        }

        // Validate that passwords match
        if (!empty($password) && $password !== $confirmPassword) {
            $_SESSION['error'] = "Passwords do not match!";
            header('Location: profile.php');
            exit;
        }

        if ($userExists) {
            $_SESSION['error'] = "Username or email already in use!";
            header('Location: profile.php');
            exit;
        }

        // Update user information
        foreach ($users as &$user) {
            if ($user['email'] === $currentEmail) {
                // Update username and email if changed
                $user['username'] = $username;
                $user['email'] = $email;

                if (!empty($password)) {
                    $user['password'] = password_hash($password, PASSWORD_BCRYPT);
                }

                // Handle profile picture upload
                if (isset($_FILES['profile_picture']) && $_FILES['profile_picture']['error'] === UPLOAD_ERR_OK) {
                    $uploadDir = '../profilePics/'; // Destination directory
                    $fileName = $_FILES['profile_picture']['name'];
                    $fileTmpPath = $_FILES['profile_picture']['tmp_name'];
                    $fileExtension = pathinfo($fileName, PATHINFO_EXTENSION);
                    $newFileName = uniqid() . '.' . $fileExtension; // Generate a unique name for the new file
                    
                    // Move the uploaded file to the destination directory
                    if (move_uploaded_file($fileTmpPath, $uploadDir . $newFileName)) {
                        // Update the user's profile picture path
                        $user['profile_picture'] = $uploadDir . $newFileName;
                    } else {
                        $_SESSION['error'] = "Failed to move uploaded file!";
                    }
                } else {
                    // If no new image is uploaded, keep the current picture
                    $user['profile_picture'] = $currentPicture;
                }
            }
            $updatedUsers[] = $user; // Always push user to updatedUsers
        }

        // Only save updated users if no error was found
        if (!isset($_SESSION['error'])) {
            if (file_put_contents($file, json_encode($updatedUsers, JSON_PRETTY_PRINT))) {
                $_SESSION['success'] = "Profile updated successfully!";
                header('Location: ../home.php');
                exit;
            } else {
                $_SESSION['error'] = "Failed to save user data!";
            }
        }
    } else {
        $_SESSION['error'] = "User data file does not exist!";
    }

    // Redirect on error
    if (isset($_SESSION['error'])) {
        header('Location: profile.php');
        exit;
    }
}
?>

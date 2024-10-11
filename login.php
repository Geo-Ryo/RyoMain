<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // File where the data is stored
    $file = 'users.json';

    if (file_exists($file)) {
        $json = file_get_contents($file);
        $users = json_decode($json, true);

        // Search for the user
        foreach ($users as $user) {
            if ($user['username'] == $username || $user['email'] == $username) {
                // Verify the password
                if (password_verify($password, $user['password'])) {
                    // Store the username and email in the session
                    $_SESSION['username'] = $user['username'];
                    $_SESSION['email'] = $user['email'];  // Add this line to store the email

                    // Check if profile picture exists, otherwise use the default 'def.jpg'
                    if (isset($user['profile_picture']) && !empty($user['profile_picture'])) {
                        $_SESSION['profile_picture'] = $user['profile_picture'];
                    } else {
                        $_SESSION['profile_picture'] = 'img/def.jpg'; // Default profile picture
                    }

                    // Redirect to home.php after successful login
                    header("Location: home.php");
                    exit;
                } else {
                    $_SESSION['error'] = 'Invalid password!';
                    header('Location: index.php');
                    exit;
                }
            }
        }

        $_SESSION['error'] = 'User not found!';
        header('Location: index.php');
        exit;
    } else {
        $_SESSION['error'] = 'No users registered yet!';
        header('Location: index.php');
        exit;
    }
}
?>

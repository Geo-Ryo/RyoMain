<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);  // Hash the password for security

    // File where the data will be stored
    $file = 'users.json';

    // Check if file exists, otherwise create an empty array
    if (file_exists($file)) {
        $json = file_get_contents($file);
        $users = json_decode($json, true);
    } else {
        $users = [];
    }

    // Check if the email or username already exists
    foreach ($users as $user) {
        if ($user['email'] == $email || $user['username'] == $username) {
            $_SESSION['error'] = "User with the same username or email already exists!";
            header('Location: index.php#');
            exit;
        }
    }

    // Add the new user to the array with a default profile picture
    $users[] = [
        'username' => $username,
        'email' => $email,
        'password' => $password,  // Save hashed password
        'profile_picture' => 'profilePics/defUser.png'  // Default profile picture
    ];

    // Encode the updated array back to JSON and save it
    file_put_contents($file, json_encode($users, JSON_PRETTY_PRINT));

    $_SESSION['success'] = "Registration successful!";
    header('Location: index.php#');
    exit;
}
?>

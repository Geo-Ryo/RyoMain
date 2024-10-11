<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Signup & Login</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

    <div class="container">
        <!-- Login Form -->
        <div id="login" class="form-container">
            <h2>Login</h2>

            <?php
            session_start();
            if (isset($_SESSION['error'])) {
                echo '<p class="error-message">' . $_SESSION['error'] . '</p>';
                unset($_SESSION['error']);  // Clear the error message after displaying it
            }
            if (isset($_SESSION['success'])) {
                echo '<p class="success-message" style="color: rgb(12, 179, 12);">' . $_SESSION['success'] . '</p>';
                unset($_SESSION['success']);  // Clear the success message after displaying it
            }
            ?>

            <form action="login.php" method="POST" id="login-form" autocomplete="off">
                <input type="text" name="username" placeholder="Username or Email" required autocomplete="off"><br>
                <input type="password" name="password" placeholder="Password" required autocomplete="off"><br>
                <button type="submit">Login</button>
                <p>Don't have an account? <a href="#" id="show-signup">Sign Up</a></p>
            </form>
        </div>

        <!-- Signup Form -->
        <div id="signup" class="form-container" style="display: none;">
            <h2>Sign Up</h2>

            <?php
            if (isset($_SESSION['error'])) {
                echo '<p class="error-message">' . $_SESSION['error'] . '</p>';
                unset($_SESSION['error']);  // Clear the error message after displaying it
            }
            ?>

            <form action="signup.php" method="POST" id="signup-form" autocomplete="off">
                <input type="text" name="username" placeholder="Username" required autocomplete="off"><br>
                <input type="email" name="email" placeholder="Email" required autocomplete="off"><br>
                <input type="password" name="password" placeholder="Password" required autocomplete="off"><br>
                <button type="submit">Sign Up</button>
                <p>Already have an account? <a href="#" id="show-login">Login</a></p>
            </form>
        </div>
    </div>

    <script src="script.js"></script>
</body>
</html>

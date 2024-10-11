<?php
session_start();
if (!isset($_SESSION['username'])) {
    header('Location: index.php');
    exit;
}

// Determine the profile picture path
$profilePicturePath = isset($_SESSION['profile_picture']) ? $_SESSION['profile_picture'] : 'profilePics/defUser.png';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($_SESSION['username']); ?> | Home</title>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="css/index.css">
    <link rel="shortcut icon" href="img/rock.png">
    <script src="js/index.js"></script>
</head>
<body>
    <div class="navbar" id="myNavbar">
        <a href="#home" class="active"><i class="fa fa-home"></i> Home</a>
        <a href="#about"><i class="fa fa-user"></i> About</a>
        <a href="#services"><i class="fa fa-cog"></i> Services</a>
        <a href="#contact"><i class="fa fa-envelope"></i> Contact</a>
        <a href="php/logout.php"><i class="fas fa-sign-out-alt"></i> Logout</a>
        <div class="username-display" onclick="document.location='pg/profile.php'">
            <img src="<?php echo htmlspecialchars($profilePicturePath); ?>" alt="Profile Picture" class="profile-picture"> <!-- Use $profilePicturePath here -->
            <span class="username"><?php echo htmlspecialchars($_SESSION['username']); ?></span>
        </div>
        <a href="javascript:void(0);" class="icon" onclick="toggleNavbar()">
            <i class="fa fa-bars"></i>
        </a>
    </div>

    <div class="header">
        <h1>Welcome to Ryo's Space</h1>
        <p>Explore a world where innovation, entertainment, and knowledge converge.</p>
    </div>

    <div class="deviderCenterer">
        <div class="devider">
            <button onclick="">Social</button>
            <button onclick="" class="actt">Utilities</button>
        </div>
    </div>

    <div id="social" style="display:none">
        <h1>Coming Soon</h1>
    </div>

    <div id="windows"> <!----------------------------------------------------Windows-->
        <!-- Content Sections -->
        <div class="content-container">
            <!-- Music Section -->
            <div class="music-div">
                <img src="img/spotify.png" alt="Spotify Logo">
                <div class="text">
                    <h2>Discover Music</h2>
                    <h3>Explore your favorite genres</h3>
                    <p>Immerse yourself in an endless stream of melodies and rhythms.</p>
                    <img src="img/musiccontrols.png" id="music-controls">
                </div>
                <a href="your-music-page.html">
                    <button><i class="fa fa-music"></i> Listen Now</button>
                </a>
            </div>
            <img class="side-image music-side-image" src="img/greenmusic.png" alt="Music Side Image">
        </div>
        
        <!-- Movie Section -->
        <div class="content-container">
            <img class="side-image movie-side-image" src="img/popcorn.png" alt="Movie Side Image">
            <div class="movie-div">
                <img src="img/netflix.png" alt="Netflix Logo">
                <div class="text">
                    <h2>Explore Movies</h2>
                    <h3>Discover new favorites</h3>
                    <p>Dive into a collection of captivating films and timeless classics.</p>
                    <img src="img/1080p.png" id="hd"><br>
                    <a href="pg/movies.html">
                        <button style="transform(translateX(50%))"><i class="fa fa-film"></i> Watch Now</button>
                    </a>
                </div>
            </div>
        </div>
        
        <!-- Cloud Section -->
        <div class="content-container">
            <div class="cloud-div">
                <img src="img/icloud.png" alt="Cloud Logo">
                <div class="text">
                    <h2>Cloud Storage</h2>
                    <h3>Virtual safe for important files.</h3>
                    <p>Store your files in a safe place with unlimited storage.</p>
                    <img src="img/harddrive.png">
                </div>
                <a href="pg/cloud.html">
                    <button><i class="fa fa-cloud"></i> View Now</button>
                </a>
            </div>
            <img class="side-image cloud-side-image" src="img/cloudplatforms.png" alt="Cloud Side Image">
        </div>
    </div><!--Windows-->

    <!-- Footer -->
    <footer class="site-footer">
        <div class="footer-container">
            <div class="footer-about">
                <h4>About Us</h4>
                <p>Your go-to place for movies, TV shows, and more. Stay entertained with our vast collection.</p>
            </div>
        
            <div class="footer-links">
                <h4>Quick Links</h4>
                <ul>
                    <li><a href="#">Home</a></li>
                    <li><a href="#">Genres</a></li>
                    <li><a href="#">Movies</a></li>
                    <li><a href="#">TV Shows</a></li>
                    <li><a href="#">Contact Us</a></li>
                </ul>
            </div>
        
            <div class="footer-contact">
                <h4>Contact Us</h4>
                <p>Email: kh.george.2005@gmail.com</p>
                <p>Phone: +961 81634151</p>
            </div>
        
            <div class="footer-social">
                <h4>Follow Us</h4>
                <a href="#" class="social-icon"><i class="fab fa-facebook-f"></i></a>
                <a href="#" class="social-icon"><i class="fab fa-twitter"></i></a>
                <a href="#" class="social-icon"><i class="fab fa-instagram"></i></a>
                <a href="#" class="social-icon"><i class="fab fa-youtube"></i></a>
            </div>
        </div>
        <div class="footer-bottom">
            <p>&copy; 2024 Ryo. All Rights Reserved.</p>
        </div>
    </footer>
</body>
</html>

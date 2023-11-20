<?php 
    include("conn.php");
    session_start(); // Start the session
    //$loggedIn = isset($_SESSION['uid']); // Check if the user is logged in
    $uid = $_SESSION['uid'];
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DishDelish</title>
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">

    <!-- custom css file link  -->
    <link rel="stylesheet" href="style.css">

    <!-- Link Swiper's CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />

</head>
<body>
    <!-- header section start  -->
    <header>
        <a href="#" class="logo"><img src="images/logo.png" alt="logo"> DishDelish</a>
        
        <nav class="navbar">
            <a href="#Home" class="active">Home</a>
            <a href="#Categories">Categories</a>
            <a href="#Aboutus">About us</a>
            <a href="#Contact">Contact</a>
        </nav>
        <div class="icons">
            <?php
                if ($uid) {
                    // If logged in, show profile and logout links
                    echo '<a href="profile.php">Profile</a>';
                    echo '<a href="logout.php">Logout</a>';
                }
                else{
                    echo '<i class="fas fa-bars" id="menu"></i>';
                    echo '<i class="fa fa-sign-in" aria-hidden="true" onclick="return redirectToRegister()"></i>';
                } 
            ?>           
        </div>
    </header>
    <!-- header section end  -->

    <!-- slider section start  -->
    <div class="home" id="Home">
        <div class="swiper home-slider">
            <div class="swiper-wrapper wrapper">
                <div class="swiper-slide slide slide1">
                    <div class="content">
                        <img src="images/crown-symbol.png" alt="vegpic">
                        <h3>Veg dishes</h3>
                        <h1>Veggie bliss on a plate</h1>
                        <p>PlantPowered</p>
                        <a href="dish.php?category=Veg" class="rbtn" onclick="setCategory('Veg')">View</a>
                    </div>
                </div>
                <div class="swiper-slide slide slide2">
                    <div class="content">
                        <img src="images/crown-symbol.png" alt="vegpic">
                        <h3>Non-Veg dishes</h3>
                        <h1>Indulging in carnivorous cravings</h1>
                        <p>MeatMania</p>
                        <a href="dish.php?category=Non-Veg" class="rbtn" onclick="setCategory('Non-Veg')">View</a>
                    </div>
                </div>
                <div class="swiper-slide slide slide3" >
                    <div class="content">
                        <img src="images/crown-symbol.png" alt="vegpic">
                        <h3>Beverages</h3>
                        <h1>Cheers to moments in a glass</h1>
                        <p>SipSensation</p>
                        <a href="dish.php?category=Beverages" class="rbtn" onclick="setCategory('Beverages')">View</a>
                    </div>
                </div>        
            </div>
            <div class="swiper-pagination"></div>
        </div>
    </div>
    <!-- slider section ends  -->


    <!-- category section starts -->
    <div class="Categories" id="Categories">
        <br><br><br>
        <section class="category container">
            <div class="category-title row">
                <h2>Categories</h2>
            </div>
            <div class="category-cards column">
                <a href="dish.php?category=Veg" class="cat-card" onclick="setCategory('Veg')"> 
                    <img src="images/category_veg.png" alt="img"> 
                    <h1>Veg dishes</h1> 
                </a> 
                <!-- <button class="cat-card" onclick="setCategory('Veg')"> 
                    <img src="images/category_veg.png" alt="img">
                    <h1>Veg dishes</h1>
                </button> -->

                <a href="dish.php?category=Non-Veg" class="cat-card" onclick="setCategory('Non-Veg')">
                    <img src="images/category_nonveg.png" alt="img">
                    <h1>Non-Veg dishes</h1>
                </a>
                <a href="dish.php?category=Beverages" class="cat-card" onclick="setCategory('Beverages')">
                    <img src="images/category_beverages.png" alt="img">
                    <h1>Bevarages</h1>
                </a>
                <a href="dish.php?category=Others" class="cat-card" onclick="setCategory('Others')">
                    <img src="images/category_others.png" alt="img">
                    <h1>Others</h1>
                </a>
            </div>
        </section>
    </div>
    <!-- category section ends -->

    <!-- about us section starts  -->
    <div class="Aboutus" id="Aboutus">
        <div class="category-title row">
            <h2>About us</h2><br>
        </div>
        <section class="learn row container">
            <div class="learn-content">
                <div>
                    <h2>Everyone can be a chef in their own kitchen</h2><br>
                    <p>Discover a world of culinary delights at DishDelish. We are passionate about sharing mouthwatering recipes, cooking tips, and the joy of good food. Whether you're a seasoned chef or a cooking enthusiast, our recipes are crafted to inspire and delight your taste buds. Welcome to a place where every dish tells a story, and every bite is a celebration of flavors. Join us on this delicious journey!</p>
                </div>
            </div>
            <div class="learn-img row">
                <div>
                    <img src="images/chef.jpg" alt="chef">
                </div>
            </div>
        </section>
    </div>
    <!-- about us section ends  -->

    <!-- footer/contact us section starts -->
    <div class="Contact" id="Contact">
        <div class="usefulLinks">
            <br><br>
            <h1>Useful Links</h1><br><br>
            <ul>
                <li><a href="#Home" class="active">Home</a></li>
                <li><a href="#Categories">Categories</a></li>
                <li><a href="#Aboutus">About us</a></li>
                <li><a href="#Contact">Contact</a></li>
            </ul>
        </div>
        <div class="contactlinks">
            <br><br>
            <h1>Contact</h1><br><br>
            <a href="#"><img src="images/facebook.png" alt="img"></a>
            <a href="#"><img src="images/instagram.png" alt="img"></a>
            <a href="#"><img src="images/gmail.png" alt="img"></a>
        </div>
        <br><br><br>
    </div>
    <footer class="footer-copyrights row">
        <br><br><br>
        <p>&copy; 2023 Preethi.All rights are reserved</p>
        <br><br>
    </footer>
    <!-- footer/contact us section ends -->


    <!-- javascript  -->
    <!-- script for redirection -->
    <script type="text/javascript">
        function setCategory(category) {
            <?php
            if ($uid) {
                // If logged in, redirect to the register page
                echo 'window.location.href = "dish.php?category="+ category;';
            } else {
                // If not logged in, display an alert message
                echo 'alert("Please log in to view this content.");';
                echo 'event.preventDefault();';
                // echo 'window.location.href = "home.php"';
            }
            ?>
        }
    </script>
    <!-- Swiper JS -->
  <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>

    <!-- Initialize Swiper -->
    <script>
        var swiper = new Swiper(".home-slider", {
        spaceBetween: 30,
        centeredSlides: true,
        autoplay: {
            delay: 7500,
            disableOnInteraction: false,
        },
        pagination: {
            el: ".swiper-pagination",
            clickable: true,
        },
        loop:true,
        });
    </script>
    <script type="text/javascript">
        function redirectToRegister() {
            window.location.href = 'register.php';
        }
        document.addEventListener("DOMContentLoaded", function () {
            let navbarLinks = document.querySelectorAll('.navbar a');

            // Initial call to set active link based on current scroll position
            highlightActiveLink();

            // Add scroll event listener
            window.addEventListener('scroll', function () {
                highlightActiveLink();
            });

            // Add click event listener to navbar links
            navbarLinks.forEach(function(link) {
                link.addEventListener('click', function(event) {
                    event.preventDefault();

                    let targetId = link.getAttribute('href').substring(1);
                    let targetSection = document.getElementById(targetId);

                    // Scroll to the target section with smooth behavior
                    window.scrollTo({
                        top: targetSection.offsetTop,
                        behavior: 'smooth'
                    });

                    // Highlight the active link after scrolling
                    highlightActiveLink();
                });
            });

            function highlightActiveLink() {
                let scrollPosition = window.scrollY;

                navbarLinks.forEach(function(link) {
                    let sectionId = link.getAttribute('href').substring(1);
                    let section = document.getElementById(sectionId);
                    let sectionOffset = section.offsetTop;
                    let sectionHeight = section.offsetHeight;

                    if (scrollPosition >= sectionOffset && scrollPosition < sectionOffset + sectionHeight) {
                        navbarLinks.forEach(function(innerLink) {
                            innerLink.classList.remove('active');
                        });

                        link.classList.add('active');
                    }
                });
            }
            let loginIcon = document.querySelector('.fa-sign-in');
        if (loginIcon) {
            loginIcon.addEventListener('click', function(event) {
                event.preventDefault();
                console.log('Login icon clicked'); // Add this line for debugging

                // Redirect to register page
                redirectToRegister();
            });
        }

            
        });
    </script>
    
      
    

</body>
</html>
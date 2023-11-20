<?php
    include("conn.php");
    session_start(); // Start the session
    $loggedIn = isset($_SESSION['uid']);
     // Check if the user is logged in

    $uid = isset($_SESSION['uid']) ? $_SESSION['uid'] : null;
    if($uid){
    }
    else{
        header('Location: home.php');
        exit();
    }
    // Initialize counts
    $postCount = 0;
    $likeCount = 0;
    $commentCount = 0;

    // Fetch user details if logged in
    if ($loggedIn) {
        $uid = $_SESSION['uid'];
        $sql = "SELECT * FROM users WHERE uid = $uid";
        $result = mysqli_query($conn, $sql);

        if ($result && mysqli_num_rows($result) > 0) {
            $userDetails = mysqli_fetch_assoc($result);
            $userName = $userDetails['name'];
            $userEmail = $userDetails['mail'];
            $userGender = $userDetails['gender'];
            $userLocation = $userDetails['location'];
        }

        // Count posts
        $postSql = "SELECT COUNT(*) as postCount FROM dishes WHERE uid = $uid";
        $postResult = mysqli_query($conn, $postSql);
        $postCount = ($postResult) ? mysqli_fetch_assoc($postResult)['postCount'] : 0;

        // Count likes
        $likeSql = "SELECT COUNT(*) as likeCount FROM likes WHERE uid = $uid and count = 1";
        $likeResult = mysqli_query($conn, $likeSql);
        $likeCount = ($likeResult) ? mysqli_fetch_assoc($likeResult)['likeCount'] : 0;

        // Count comments
        $commentSql = "SELECT COUNT(*) as commentCount FROM comments WHERE uid = $uid";
        $commentResult = mysqli_query($conn, $commentSql);
        $commentCount = ($commentResult) ? mysqli_fetch_assoc($commentResult)['commentCount'] : 0;
    }
?>




<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.2/css/all.min.css">
    <!-- custom css file link  -->
    <link rel="stylesheet" href="style.css">
    <title>Profile</title>
    <script>
        if(window.history.replaceState){
            window.history.replaceState(null, null, window.location.href);
        }
    </script>
</head>
<body style="min-height: 100vh;
    display: flex;
    flex-direction: column;">
    <!-- header section start  -->
    <header>
        <a href="#" class="logo"><img src="images/logo.png" alt="logo"> DishDelish</a> 
        <nav class="navbar" style="display:flex ; justify-content:right;">
            <a href="home.php">Home</a>
            <!-- <a href="home.php">Logout</a>  -->
        </nav>
    </header>
    <!-- header section end  -->


    <div class="side-bar">
        <div class="profile">
            <img src="images/profile.jpg" class="image" alt="img">
            <!-- <h3 class="name">preethi</h3>  -->
            <?php
                if ($loggedIn) {
                    echo '<h3 class="name">' . $userName . '</h3>';
                }
            ?>
        </div>
        <br><br>
        <div class="userdetails">    
            <!--  
            <i class="fa-solid fa-envelope" onmouseover="addBeat(this)" onmouseout="removeBeat(this)"><span>preethispr25@gmail.com</span></i><br>
            <i class="fa-solid fa-person" onmouseover="addBeat(this)" onmouseout="removeBeat(this)"><span>female</span></i><br>
            <i class="fa-solid fa-location-dot" onmouseover="addBeat(this)" onmouseout="removeBeat(this)"><span>vellalore,coimbatore,tamil nadu</span></i>
            -->
            <?php
                if ($loggedIn) {
                    echo '<i class="fa-solid fa-envelope" onmouseover="addBeat(this)" onmouseout="removeBeat(this)"><span>' . $userEmail . '</span></i><br>';
                    echo '<i class="fa-solid fa-person" onmouseover="addBeat(this)" onmouseout="removeBeat(this)"><span>' . $userGender . '</span></i><br>';
                    echo '<i class="fa-solid fa-location-dot" onmouseover="addBeat(this)" onmouseout="removeBeat(this)"><span>' . $userLocation . '</span></i>';
                }
            ?>
        </div>
    </div>
    <div class="flex-container">
        <div class="flex-element">
            <div class="flex-left">
                <i class="fa-solid fa-pen-to-square"></i>
                <h1>Posts</h1><br>
            </div>
            <div class="flex-right">
                <!-- <h3>10</h3>  -->
                <h3><?php echo $postCount; ?></h3>
            </div>
        </div>
        <div class="flex-element">
            <div class="flex-left">
                <i class="fa-solid fa-heart"></i>
                <h1>Likes</h1><br>
            </div>
            <div class="flex-right">
                <!-- <h3>25</h3>   -->
                <h3><?php echo $likeCount; ?></h3>
            </div>
        </div>
        <div class="flex-element">
            <div class="flex-left">
                <i class="fa-solid fa-comments"></i>
                <h1>Comments</h1><br>
            </div>
            <div class="flex-right">
                <!-- <h3>5</h3>  -->
                <h3><?php echo $commentCount; ?></h3>
            </div>
        </div>
    </div>
    <div class="post-heading">
        <h1>Posts</h1>
        <a href="add.php">Add Post</a>
    </div>
    <main>
       <!-- <div class="post-container">
            <div class="post">
                <div class="image">
                    <img src="images/nonveg_img.png" alt="">
                </div>
                <br>
                <h3>Chicken biriyani</h3>
                <a href="recipe.php">View Recipe</a>
            </div>
            <div class="post"> 
                <div class="image">
                    <img src="images/nonveg_img.png" alt="">
                </div>
                <br>
                <h3>Chicken curry</h3>
                <a href="recipe.php">View Recipe</a>
            </div>
             <div class="post"> 
                <div class="image">
                    <img src="images/nonveg_img.png" alt="">
                </div>
                <br>
                <h3>Chicken 65</h3>
                <a href="recipe.php">View Recipe</a>
            </div>
            
        </div>
        <div class="post-container">
            <div class="post">
                <div class="image">
                    <img src="images/nonveg_img.png" alt="">
                </div>
                <br>
                <h3>Chicken biriyani</h3>
                <a href="recipe.php">View Recipe</a>
            </div>
            <div class="post">
                <div class="image">
                    <img src="images/nonveg_img.png" alt="">
                </div>
                <br>
                <h3>Chicken curry</h3>
                <a href="recipe.php">View Recipe</a>
            </div>
            <div class="post">
                <div class="image">
                    <img src="images/nonveg_img.png" alt="">
                </div>
                <br>
                <h3>Chicken 65</h3>
                <a href="recipe.php">View Recipe</a>
            </div>
        </div>-->
            
        <!-- </div> -->
            
              
        <div class="post-container">
        <?php 
            // Assuming you have a database connection
            //include("conn.php");

            // Fetch posts from the database
            
            $sql = "SELECT * FROM dishes WHERE uid = '$uid'" ;
            $result = mysqli_query($conn, $sql);

            // Check if there are any posts
            if ($result && mysqli_num_rows($result) > 0) {
                // $counter = 0; 
                while ($row = mysqli_fetch_assoc($result)) {
                    // Loop through each row and display post information

                    // if ($counter % 3 == 0 && $counter!=0) {
                    //     echo '</div><div class="dish_post-container">';
                    // }
                    
                    echo '<div class="post">';
                    echo '<div class="image">';
                    echo '<img src="images/' . $row['image'] . '" alt="">';
                    echo '</div>';
                    echo '<br>';
                    echo '<h3>' . $row['dish_name'] . '</h3>';
                    echo '<a href="recipe.php?dish_id=' . $row['dish_id'] . '">View Recipe</a>';
                    echo '</div>';

                    // $counter++; // Increment counter 
                }
            } else {
                // Display a message if there are no posts
                echo '<p>No posts available.</p>';
            }

            //Close the database connection
            mysqli_close($conn);
        ?>
        </div>
            </main>
    <footer class="footer-copyrights row" style="margin-top:auto;">
        <br><br><br>
        <p>&copy; 2023 Preethi.All rights are reserved</p>
        <br><br>
    </footer>
    <script>
        function addBeat(element) {
            element.classList.add('fa-beat');
        }

        function removeBeat(element) {
            element.classList.remove('fa-beat');
        }
    </script>
</body>
</html>

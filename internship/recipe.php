<?php 
    include("conn.php");

    session_start(); // Start the session 
    $uid = isset($_SESSION['uid']) ? $_SESSION['uid'] : null;
    if($uid){
    }
    else{
        header('Location: home.php');
        exit();
    }
    // $uid = isset($_SESSION['uid']);
    //$id = isset($_POST["dish_id"]) ? $_POST["dish_id"] :"";
    //echo '<h1 style="margin-top:90px;">dish id:' . $id . '</h1>'; 
    // $dish_id = 4;

    if(isset($_GET["dish_id"])){
        $dish_id = $_GET["dish_id"];
        // echo "".$dish_id.""; 
    }

    $sql = "SELECT * FROM dishes WHERE dish_id = '$dish_id'";
    $result = mysqli_query($conn, $sql);
    if ($result) {
        $dish = mysqli_fetch_assoc($result);
        if($dish){
            $dishName = $dish['dish_name'];
            $imagePath = "images/" . $dish['image'];
            $video_url = $dish['video'];
            // $videoId = 'JGjOdRawq5g';
            // $urlParts = parse_url($video_url); 
            // if (isset($urlParts['path'])) {
            //     $pathParts = explode('/', trim($urlParts['path'], '/'));

            //     // The video ID is the last part of the path
            //     $videoId = end($pathParts);
            // }
            $pattern = '/(?:https?:\/\/)?(?:www\.)?(?:youtube\.com\/(?:[^\/\n\s]+\/\S+\/|(?:v|e(?:mbed)?)\/|\S*?[?&]v=)|youtu\.be\/)([a-zA-Z0-9_-]{11})/';
    
            preg_match($pattern, $video_url, $matches);
        
            // The video ID will be in the first capturing group
            $videoId = isset($matches[1]) ? $matches[1] : null;


            //ingredients
            $sql_ingredient = "SELECT ingredient FROM ingredients WHERE dish_id = '$dish_id'";
            $result_ingredient = mysqli_query($conn, $sql_ingredient);


             //directions
             $sql_direction = "SELECT direction FROM directions WHERE dish_id = '$dish_id'";
             $result_direction = mysqli_query($conn, $sql_direction);
        }

    }
    // Handle comment submission
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['comment'])) {
        // $username = $_POST['username']; 
        $name = "SELECT name FROM users WHERE uid = '$uid'";
        $username = mysqli_query($conn,$name);
        // $commentText = $_POST['comment'];
        $commentText = mysqli_real_escape_string($conn, $_POST["comment"]);

        
        // Insert comment into the 'comments' table
        $sql_insert_comment = "INSERT INTO comments  VALUES ('', '$uid', '$dish_id', '$commentText')";
        mysqli_query($conn, $sql_insert_comment);
    }

    // Retrieve comments for the current dish
    // $sql_comments = "SELECT * FROM comments WHERE dish_id = '$dish_id'";
    // $result_comments = mysqli_query($conn, $sql_comments);
    // Retrieve comments for the current dish along with user details
    $sql_comments = "SELECT comments.*, users.name FROM comments
    INNER JOIN users ON comments.uid = users.uid
    WHERE comments.dish_id = '$dish_id'";
    $result_comments = mysqli_query($conn, $sql_comments);

    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['like'])) {
        // Get dish ID from the form
        // $dish_id = $_POST['dish_id']; 
    
        // Check the current like status for the user and dish
        $checkLikeSQL = "SELECT count FROM likes WHERE uid = '$uid' AND dish_id = '$dish_id'";
        $resultCheckLike = mysqli_query($conn, $checkLikeSQL);
    
        if ($resultCheckLike) {
            if ($likeData = mysqli_fetch_assoc($resultCheckLike)) {
                $currentCount = $likeData['count'];
    
                // Toggle the like status
                $newCount = $currentCount == 0 ? 1 : 0;
    
                // Update the like status in the database
                $updateLikeSQL = "UPDATE likes SET count = '$newCount' WHERE uid = '$uid' AND dish_id = '$dish_id'";
                mysqli_query($conn, $updateLikeSQL);
    
                // Send the updated like status to the frontend
                // echo json_encode(['success' => true, 'count' => $newCount]); 
            // } else {
            //     // Handle the case where fetching like data fails
            //     echo json_encode(['success' => false, 'message' => 'Error fetching like data']);
            }
        }
        //  else {
        //     // Handle the case where checking like status fails
        //     echo json_encode(['success' => false, 'message' => 'Error checking like status']);
        // }
    }
    // Retrieve like count for the current dish
    $sql_like_count = "SELECT COUNT(*) AS like_count FROM likes WHERE dish_id = '$dish_id' AND count = 1 ";
    $result_like_count = mysqli_query($conn, $sql_like_count);
    $likeCount = $result_like_count ? mysqli_fetch_assoc($result_like_count)['like_count'] : 0;
   

    $checkLikeSQL = "SELECT count FROM likes WHERE uid = '$uid' AND dish_id = '$dish_id'";
    $resultCheckLike = mysqli_query($conn, $checkLikeSQL);

    if ($resultCheckLike) {
        if ($likeData = mysqli_fetch_assoc($resultCheckLike)) {
            $currentCount = $likeData['count'];

            // Set the appropriate class based on the like status
            $heartIconClass = $currentCount == 1 ? 'fas' : 'far';
        }
    }

?>





<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recipe</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.2/css/all.min.css">
    <!-- custom css file link  -->
    <link rel="stylesheet" href="style.css">
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
            
        </nav>
    </header>
    <!-- header section end  -->
<br>

    <!-- image and ingredient style starts  -->
    <div class="recipe-container1">
        <div class="rc1-left">
            <!-- <h1>Chicken biriyani</h1> -->
            <h1><?php echo $dishName; ?></h1>
            <!-- <img src="images/nonveg_img.png" alt=""> -->
            <img src="<?php echo $imagePath; ?>" alt="<?php echo $dishName; ?>">
        </div>
        <div class="rc1-right">
            <h1>Ingredients</h1><br>
            <?php 
            if ($result_ingredient) {
                echo '<ul>';
                // Loop through the results and display each ingredient
                while ($row = mysqli_fetch_assoc($result_ingredient)) {
                    echo '<li>' . htmlspecialchars($row['ingredient']) . '</li>';
                }
                echo '</ul>';
            } else {
                // Handle the case where the query fails
                echo 'Error fetching ingredients: ' . mysqli_error($conn);
            }
            // <ul>
            //     <li>2 cups basmati rice</li>
            //     <li>1 kg chicken pieces</li>
            //     <li>1 cup yogurt</li>
            //     <li>2 large onions</li>
            //     <li>2 tomatoes</li>
            //     <li>Mint and coriander leaves</li>
            //     <li>Ghee or vegetable oil</li>
            //     <li>Spices: bay leaf, cloves, cardamom, cinnamon, garam masala, saffron strands (optional)</li>
            //     <li>Salt</li>
            //     <li>Turmeric</li>
            //     <li>Red chili powder</li>
                
               
            // </ul>
            ?>
        </div>
    </div>
    <!-- image and ingredient style ends  -->

  <!-- directions, video starts  -->
    <div class="directions">
        <h1>Directions</h1>
        <ol>
        <?php 
            if ($result_direction) {
                // echo '<ol>'; 
                // Loop through the results and display each ingredient
                while ($row = mysqli_fetch_assoc($result_direction)) {
                    echo '<li>' . htmlspecialchars($row['direction']) . '</li>';
                }
                // echo '</ol>';
            } else {
                // Handle the case where the query fails
                echo 'Error fetching directions: ' . mysqli_error($conn);
            }
        ?>
            <!-- <li>Marinate Chicken: Mix yogurt, ginger-garlic paste, turmeric, red chili powder, salt. Marinate chicken for 2 hours.</li>
            <li>Prepare Rice: Boil rice with spices until 70-80% cooked. Drain.</li>
            <li>Cook Chicken: Sauté onions, add marinated chicken, cook until brown. Add tomatoes, mint, coriander.</li>
            <li>Layer Biryani: Alternate layers of partially cooked rice and chicken mixture. Top with garam masala and saffron-infused milk.</li>
            <li>Dum Cooking: Seal and cook on low heat (dum) for 20-25 mins on stovetop or in a preheated oven.</li>
            <li>Serve: Garnish with mint, coriander. Serve hot with raita.</li> -->
            <br><br><br>
            <?php
                // Embed the YouTube video with the dynamically retrieved video ID
                echo '<iframe width="1150" height="600" src="https://www.youtube.com/embed/' . $videoId . '" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" allowfullscreen></iframe>';
            ?>
            <!-- <iframe width="1150" height="600" src="https://www.youtube.com/embed/sVNQIbuv_Mc" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" allowfullscreen></iframe> -->
        </ol>
    </div>
  <!-- directions, video ends  -->


  <!-- comments starts -->
    <div class="comments">
        <div class="comment-heading">
            <h1>Comment</h1>
            <!-- <h3>3</h3> -->
            <div class="like_style">
                <form method="POST" action="">
                    <button type="submit" name="like" value="toggle">
                        <!-- <i class="far fa-heart" id="heartIcon"></i> -->
                        <?php 
                        echo '<i class="' . $heartIconClass . ' fa-heart" id="heartIcon" style="color: red;"></i>';
                        ?>
                    </button>
                </form> 
                <span>  <?php echo $likeCount; ?></span> 
            </div>
            

        </div>
        <br>
        <div class="comment-box">
            <!-- <input type="text" id="username" placeholder="Your Name">  -->
            <form method="POST" action="">
                <textarea name="comment" id="comment" cols="30" placeholder="Enter your comment" rows="5"></textarea><br>
                <button type="submit">Comment</button>
            </form>
        </div>
        <div id="commentList">
        <?php 
            if ($result_comments) {
                while ($comment = mysqli_fetch_assoc($result_comments)) {
                    echo '<div class="comment-container">';
                    echo '<img src="images/profile.jpg" alt="User Profile Image" class="profile-image">';
                    echo '<div class="user-details">';
                    echo '<p class="comment-user">' . htmlspecialchars($comment['name']) . '</p>';
                    echo '<p>' . htmlspecialchars($comment['comment']) . '</p>';
                    echo '</div>';
                    echo '</div>';
                }
            } else {
                // Handle the case where the query fails
                echo 'Error fetching comments: ' . mysqli_error($conn);
            }
            ?>
        </div>
    </div>


  <!-- comments ends -->


    <footer class="footer-copyrights row" style="margin-top:auto;">
        <br><br><br>
        <p>&copy; 2023 Preethi.All rights are reserved</p>
        <br><br>
    </footer>
    <script>
        function toggleHeartColor() {
            var heartIcon = document.getElementById("heartIcon");

            // Toggle between outlined and filled heart icons
            if (heartIcon.classList.contains("far")) {
                // If the heart icon is outlined, fill it
                heartIcon.classList.remove("far");
                heartIcon.classList.add("fas");
            } else {
                // If the heart icon is filled, outline it
                heartIcon.classList.remove("fas");
                heartIcon.classList.add("far");
            }
        }
       
</body>
</html>
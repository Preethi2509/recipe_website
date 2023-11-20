<?php 
    include("conn.php");
    session_start(); // Start the session 
    $uid = isset($_SESSION['uid']);

    if($uid) {
        //$category = isset($_GET['cat']) ? $_GET['cat'] : '';
        //$category = !empty($_GET['category']) ? $_GET['category'] : '';
        // echo '<h1 style="margin-top:90px;">Category:'. $category .'</h1>';
        if(isset($_GET['category'])){
            $category = $_GET['category'];
        }else{
            echo 'not found';
        }
        if($category == '') {
            $sql = "SELECT * FROM dishes";
        }else{
            $sql = "SELECT * FROM dishes WHERE category = '$category'";
        }
        $result = mysqli_query($conn, $sql);
    }else{
        header('Location: home.php');
        exit();
    }

?>






<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DishDelish</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.2/css/all.min.css">
    <!-- custom css file link  -->
    <link rel="stylesheet" href="style.css">
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
    <section class="dish">
        <div class="dish_post-container">
        <?php
            // $counter = 0; // Initialize counter

            // Display the dishes based on the retrieved category
            while ($row = mysqli_fetch_assoc($result)) {
                // Start a new row if counter is divisible by 4
                // if ($counter % 4 == 0 && $counter!=0) {
                //     echo '</div><div class="dish_post-container">';
                // }

                // echo 'window.location.href = "dish.php?category="+ category;';
                $did = $row["dish_id"];
                echo '<div class="post" style="max-width: 20%;
                min-width: 20%;">';
                echo '<div class="image">';
                echo '<img src="images/' . $row['image'] . '" alt="' . $row['dish_name'] . '">';
                echo '</div>';
                echo '<br>';
                echo '<h3>' . $row['dish_name'] . '</h3>';
                echo '<a href="recipe.php?dish_id=' . $did . '">View Recipe</a>'; // Add dish_id to the URL
                echo '</div>';

                // $counter++; // Increment counter
            }
            ?>
            
        </div>
        <!-- comment  
        <div class="dish_post-container">
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
            <div class="post">
                <div class="image">
                    <img src="images/nonveg_img.png" alt="">
                </div>
                <br>
                <h3>Chicken biriyani</h3>
                <a href="recipe.php">View Recipe</a>
            </div>
        </div>-->
    </section>
    <footer class="footer-copyrights row" style="margin-top:auto;">
        <br><br><br>
        <p>&copy; 2023 Preethi.All rights are reserved</p>
        <br><br>
    </footer>
</body>
</html>
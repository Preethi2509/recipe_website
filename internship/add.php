<?php
    include("conn.php");
    session_start(); // Start the session
    $uid = $_SESSION['uid'];
    if($uid){
    }
    else{
        header('Location: home.php');
        exit();
    }

    if(isset($_POST["submit"])){
        // storing data into dishes table
        $dish_name = mysqli_real_escape_string($conn, $_POST["title"]);
        $category = mysqli_real_escape_string($conn, $_POST["category"]);
        $video_url = mysqli_real_escape_string($conn, $_POST["vtitle"]);


        if($_FILES["image"]["error"] == 0){
            $file_name = $_FILES["image"]["name"];
            $file_size = $_FILES["image"]["size"];
            $tmpName = $_FILES["image"]["tmp_name"];
            $validImageExtension = ['jpg','jpeg','png'];
            $imageExtension = explode('.', $file_name);
            $imageExtension = strtolower(end($imageExtension));
            
            if(!in_array($imageExtension, $validImageExtension)){
                echo "<script> alert('Invalid image extension'); </script>";
            }
            else if($file_size > 1000000){
                echo "<script> alert('Image size is too large'); </script>";
            }
            else {
                //$newChapterId = uniqid();
                //$newChapterId = '.'.$imageExtension;

                move_uploaded_file($tmpName, 'images/'.$file_name);
                $sql = "INSERT INTO dishes VALUES ('', '$uid', '$dish_name', '$category', '$file_name', '$video_url')";
                $result = mysqli_query($conn, $sql);
                //echo "<script> 
                //alert('Recipe is successfully added!');
                //</script>";

                if($result){
                    $dish_id = mysqli_insert_id($conn); // Get the last inserted dish_id

                    // Insert into ingredients table
                    $ingredients = $_POST['ingredientList'];
                    foreach ($ingredients as $ingredient) {
                        $ingredient = mysqli_real_escape_string($conn, $ingredient);
                        $sql1 = "INSERT INTO ingredients (dish_id, ingredient) VALUES ('$dish_id', '$ingredient')";
                        $result1 = mysqli_query($conn, $sql1);
                    }

                    // Insert into directions table
                    $directions = $_POST['directionList'];
                    foreach ($directions as $direction) {
                        $direction = mysqli_real_escape_string($conn, $direction);
                        $sql2 = "INSERT INTO directions (dish_id, direction) VALUES ('$dish_id', '$direction')";
                        $result2 = mysqli_query($conn, $sql2);
                    }
                    $usersQuery = "SELECT uid FROM users";
                    $resultUsers = mysqli_query($conn, $usersQuery);

                    if ($resultUsers) {
                        while ($user = mysqli_fetch_assoc($resultUsers)) {
                            // Access the uid for each user
                            $uid = $user['uid'];

                            // Insert default entry for the user into the likes table with count value 0
                            $insertLikesSQL = "INSERT INTO likes  VALUES ('', '$dish_id', '$uid', 0)";
                            mysqli_query($conn, $insertLikesSQL);
                        }
                    } else {
                        // Handle the case where the query fails
                        echo 'Error fetching uids: ' . mysqli_error($conn);
                    }

                    echo "<script> alert('Recipe is successfully added!'); </script>";
                } else {
                    echo "<script> alert('Error adding recipe. Please try again.'); </script>";
                }
            }
        }
        else{
            echo "<script> alert('Image doesn't exist'); </script>";
        }
        header("Location: profile.php");
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
            <a href="profile.php">Back</a>
            <!-- <a href="home.php">Logout</a>  -->
        </nav>
    </header>
    <!-- header section end  -->

    <!-- post form starts  -->
    <form action="" id="recipeForm" method="post" class="addform" enctype="multipart/form-data">
        <h1>Add Recipe</h1><br><br>
        <div class="add">
            <label for="title">Title</label><br>
            <input type="text" name="title" id="title" required>
            <label for="image">Image</label>
            <input type="file" id="image" name="image" accept=".jpg, .jpeg, .png" required>
            <label for="category">Category</label><br>
            <select name="category" id="category" required>
                <option value="Veg">Veg</option>
                <option value="Non-Veg">Non-Veg</option>
                <option value="Beverages">Beverages</option>
                <option value="Others">Others</option>
            </select><br>
            <label for="ingredients">Ingredients</label><br>
            <input type="text" name="ingredients" id="ingredients">
            <button type="button" id="addIngredientBtn" onclick="addIngredient()">Add</button>
        </div>
        <br>
        <ul id="ingredientList" name="ingredientList"></ul>
        <div class="add">
            <label for="ingredients">Directions</label><br>
            <input type="text" name="directions" id="directions" >
            <button type="button" id="addDirectionBtn"  onclick="addDirection()">Add</button>
        </div>
        <br>
        <ul id="directionList" name="directionList"></ul>
        <div class="add">
            <label for="title">Video url</label><br>
            <input type="text" name="vtitle" id="vtitle" required>
            <button type="submit" name="submit">Submit</button>
        </div>
    </form>
    <!-- ajax  
    <script>
        $(document).ready(function () {
            $("#addIngredientBtn").on("click", function () {
                var ingredientInput = $("#ingredients").val();
                $("#ingredientList").append("<li>" + ingredientInput + "</li>");
                $("#ingredients").val(""); // Clear the input field
            });

            $("#addDirectionBtn").on("click", function () {
                var directionInput = $("#directions").val();
                $("#directionList").append("<li>" + directionInput + "</li>");
                $("#directions").val(""); // Clear the input field
            });

            $("#recipeForm").on("submit", function (e) {
                e.preventDefault();
                // Perform AJAX request to submit form data to the server
                $.ajax({
                    type: "POST",
                    url: "profile.php",
                    data: new FormData(this),
                    processData: false,
                    contentType: false,
                    success: function (response) {
                        // Handle the server response
                        alert(response);
                    },
                    error: function () {
                        alert("Error submitting form. Please try again.");
                    }
                });
            });
        });
    </script>
     -->



    <script>
        function addIngredient() {
        // Get the input value
        var ingredientInput = document.getElementById('ingredients');
        var ingredientValue = ingredientInput.value;

        // Clear the input field
        ingredientInput.value = '';

        // Create a new div for the ingredient
        var ingredientDiv = document.createElement('div');
        ingredientDiv.className = 'ingredient-box';

        // Set the text content of the div
        ingredientDiv.textContent = ingredientValue;

        // Append the div to the ingredient list
        var ingredientList = document.getElementById('ingredientList');
        ingredientList.appendChild(ingredientDiv);
        

         // Create a hidden input field to store the ingredient value
        var hiddenInput = document.createElement('input');
        hiddenInput.type = 'hidden';
        hiddenInput.name = 'ingredientList[]'; // Use an array for dynamic input fields
        hiddenInput.value = ingredientValue;
        ingredientDiv.appendChild(hiddenInput);
        }
        function addDirection() {
        // Get the input value
        var directionInput = document.getElementById('directions');
        var directionValue = directionInput.value;

        // Clear the input field
        directionInput.value = '';

        // Create a new div for the ingredient
        var directionDiv = document.createElement('div');
        directionDiv.className = 'direction-box';

        // Set the text content of the div
        directionDiv.textContent = directionValue;

        // Append the div to the ingredient list
        var directionList = document.getElementById('directionList');
        directionList.appendChild(directionDiv);

        var hiddenInput = document.createElement('input');
        hiddenInput.type = 'hidden';
        hiddenInput.name = 'directionList[]'; // Use an array for dynamic input fields
        hiddenInput.value = directionValue;
        directionDiv.appendChild(hiddenInput);
        }
  </script>






    <!-- post form ends  -->
    <footer class="footer-copyrights row" style="margin-top:auto;">
        <br><br><br>
        <p>&copy; 2023 Preethi.All rights are reserved</p>
        <br><br>
    </footer>
</body>
</html>
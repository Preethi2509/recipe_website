<?php
    include("conn.php");
    if(isset($_POST["submit"])){
        $username = mysqli_real_escape_string($conn, $_POST['uname']);
        $email = mysqli_real_escape_string($conn, $_POST['email']);
        $password = mysqli_real_escape_string($conn, $_POST['pswd']);
        $gender = mysqli_real_escape_string($conn, $_POST['gender']);
        $location = mysqli_real_escape_string($conn, $_POST['location']);
        $sql = "SELECT * FROM users WHERE name = '$username' && password = '$password'";
        $result = mysqli_query($conn, $sql);
        if(mysqli_num_rows($result) > 0){
            $error[] = 'User already exist!';
        }
        else{
            $insert = "INSERT INTO users VALUES('','$username','$email','$password','$gender','$location')";
            mysqli_query($conn, $insert);
            header('location:login.php');
        }
    };

?>








<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register form</title>
    <link rel="stylesheet" href="style.css">
    <script>
        if(window.history.replaceState){
            window.history.replaceState(null, null, window.location.href);
        }
    </script>
    
</head>
<body class="signup">
    <div class="form-container">
        <form action="" method="post">
            <h2>Register Form</h2>
            <?php
                if(isset($error)){
                    foreach($error as $error){
                        echo '<span class="error-msg">'.$error.'</span>';
                    };
                };
            ?>
            <input type="text" name="uname" required placeholder="Enter your name">
            <input type="email" name="email" required placeholder="Enter your email">
            <input type="password" name="pswd" required placeholder="Enter your password"><br>
            <!-- <input type="file" id="image" name="image" accept=".jpg, .jpeg, .png" placeholder="Enter profile image" required>  -->
            <label>
                <input type="radio" id="gender_male" name="gender" value="Male">Male
            </label>
            <br>
            <label>
                <input type="radio" id="gender_female" name="gender" value="Female">Female
            </label>
            <br>
            <input type="text" name="location" required placeholder="Enter location">
            <input type="submit" name="submit" value="Register" class="form-btn">
            <p><b>Already have an account? <a href="login.php">Login</a></p>
        </form>
    </div>
</body>
</html>
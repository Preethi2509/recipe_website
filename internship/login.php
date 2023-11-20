<?php
    include("conn.php");
    if(isset($_POST["submit"])){
        $email = mysqli_real_escape_string($conn, $_POST['email']);
        $password = mysqli_real_escape_string($conn, $_POST['pswd']);
        $sql = "select * from users where mail = '$email' and password = '$password'";
        $result = mysqli_query($conn, $sql);
        if(mysqli_num_rows($result)  == 1){
           // Fetch the user data
            $userData = mysqli_fetch_assoc($result);

            // Start the session
            session_start();

            // Store user ID in session
            $_SESSION['uid'] = $userData['uid'];

            // Redirect to home.php
            header("Location: home.php");
            exit();
        }
        else{
            $error[] = 'Invalid username or password!';
        }
    }

?>




<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="style.css">
    <script>
        if(window.history.replaceState){
            window.history.replaceState(null, null, window.location.href);
        }
    </script>
   
</head>
<body class="signup">
    <div class="form-container">
        <form name="form"  method="post">
            <h2>Login Form</h2>
            <?php
                if(isset($error)){
                    foreach($error as $error){
                        echo '<span class="error-msg">'.$error.'</span>';
                    };
                };
            ?>
            <input type="email" name="email" required placeholder="Enter your email">
            <input type="password" name="pswd" required placeholder="Enter your password">
            <input type="submit" name="submit" value="Login" class="form-btn">
            <p><b>Don't have an account? <a href="register.php">Register</a></p>
        </form>
        
        
    </div>

</body>
</html>
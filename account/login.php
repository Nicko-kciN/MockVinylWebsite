<?php
    session_start();
    if(isset($_SESSION['user_id'])) {
        header("Location: ../index.html");
    }

    $conn = new mysqli("localhost","root","","musiconline_db");

    //Intialise variable
    $email = '';
    $error = false;
    $notification = '';

    //Error Message
    $eError = '';
    $pError = '';

        if(isset($_SESSION['notiGet'])) {
            $notiGet = $_SESSION['notiGet'];
            if($notiGet == "signUp") {
                $notification = "You have successfully signed up!";
            }
            else if ($notiGet == "passChange") {
                $notification = "You have successfully changed your password!";
            }
            unset($_SESSION['notiGet']);
        }

    if($conn->connect_error){
        die("Connection Failed : ".$conn->connect_error);

    }
    else{
        if ($_SERVER["REQUEST_METHOD"] == "POST") {

            $email = trim($_POST["email"]);
            $password = trim($_POST["password"]);

            if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL))
                {
                    $eError = "Please enter a valid email";
                    $error = true;
                }
            
            if (empty($password))
                {
                    $pError = "Password can not be empty";
                    $error = true;
                }
            
            if (!$error) {
                $query = "SELECT * FROM user_info WHERE user_email = '$email'";
                $result = mysqli_query($conn, $query);

                if ($result && mysqli_num_rows($result) > 0) {

                    $user_data = mysqli_fetch_assoc($result);

                    $stored_password = $user_data['user_password'];

                    if (password_verify($password, $stored_password)){

                        $_SESSION['user_id'] = $user_data['user_id'];
                        header("Location: ../index.html");
                        exit();
                    }
                    else {
                        $pError = "Incorrect Password";
                        $error = true;
                    }
                }
                else {
                    $eError = "Email does not exist";
                    $error = true;
                }
            }
        }
    }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="../styles.css?v=2">
    <!--Font-->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Quicksand&display=swap" rel="stylesheet">
</head>
<body class="account-bg">
    <div class="account">
        <div class="loginText-cont">
            <span class="loginText"> <?php echo $notification ?></span>
        </div>
        <form method="post">
            <div class="account-cont">
                <div>
                    <a href="../index.html">
                    <img src="../Images/logo.png" class="account-logo"> </a>
                </div>

                <div>
                    <label for="email">Email:</label> <br/>
                    <input type="text" placeholder="Enter your email" id="email" name="email"> <br/>
                    <span class="error"> <?php echo $eError ?></span> 
                </div>
                <div>
                    <label for="password">Password:</label> <br/>
                    <input type="password" placeholder="Enter your password" id="password" name="password"> <br/>
                    <span class="error"> <?php echo $pError ?></span> 
                </div>
                <div>
                    <a href="passreset.php">Forgot your password</a>
                </div>

                <div class="logBttn">
                    <input type="submit" value="Log In" class="submit-bttn">
                </div>

                <div class="signup-link">
                    <p>Don't have an account?</p>
                    <a href="signup.php">Sign Up</a>
                </div>
            </div>
        </form>
    </div>
</body>
</html>
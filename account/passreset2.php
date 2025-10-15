<?php
    session_start();

    if(isset($_SESSION['user_id'])) {
        header("Location: ../index.html");
    }
    $conn = new mysqli("localhost","root","","musiconline_db");

    //Intialise variable
    $error = false;

    //Error Message
    $pError = '';

    if($conn->connect_error){
        die("Connection Failed : ".$conn->connect_error);

    }
    else{
        if ($_SERVER["REQUEST_METHOD"] == "POST") {

            $password = trim($_POST['password']);

            if (empty($password))
                {
                    $pError = "Password can not be empty";
                    $error = true;
                }
            else if(!preg_match('/^.{8,}$/', $password)) {
                $pError = "Password must be 8 characters long";
                $error = true;
            }

            if(!$error) {
                $hashed_password = password_hash($password, PASSWORD_DEFAULT);
                $reset_email = $_SESSION['email'];

                $query_alter = "UPDATE user_info SET user_password = '$hashed_password' WHERE user_email= '$reset_email'";
                mysqli_query($conn, $query_alter);

                $_SESSION['notiGet'] = "passChange";

                header("Location: login.php");
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
    <link rel="stylesheet" href="../styles.css">
    <!--Font-->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Quicksand&display=swap" rel="stylesheet">
</head>
<body class="account-bg">
    <div class="account">
        <form method="post">
            <div class="account-cont">
                
                <div>
                    <a href="../index.html">
                    <img src="../Images/logo.png" class="account-logo"> </a>
                </div>
                <div>
                    <label for="password">Password:</label> <br/>
                    <input type="password" placeholder="Enter your new password" id="password" name="password"><br/>
                    <span><?php echo $pError ?></span>
                </div>
                    <div class="xtra-padding">
                    <input type="submit" value="Change Password" class="submit-bttn">
                </div>
            </div>
        </form>
    </div>
</body>
</html>
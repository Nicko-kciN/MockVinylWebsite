<?php
    session_start();

    if(isset($_SESSION['user_id'])) {
        header("Location: ../index.html");
    }
    $conn = new mysqli("localhost","root","","musiconline_db");

    //Intialise variable
    $email = '';
    $error = false;

    //Error Message
    $eError = '';

    if($conn->connect_error){
        die("Connection Failed : ".$conn->connect_error);

    }
    else{
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            
            $email = trim($_POST['email']);


            if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL))
                {
                    $eError = "Please enter a valid email";
                    $error = true;
                }
                
                if (!$error) {
                $query = "SELECT * FROM user_info WHERE user_email = '$email' LIMIT 1 ";
                $result = mysqli_query($conn, $query);

                if ($result && mysqli_num_rows($result) > 0) {

                    $reset_email = mysqli_fetch_assoc($result);

                    $_SESSION['email'] = $reset_email['user_email'];
                    header("Location: passreset2.php");
                    exit();
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
                <div class="xtra-padding">
                    <input type="submit" value="Submit" class="submit-bttn">
                </div>
            </div>
        </form>
    </div>
</body>
</html>
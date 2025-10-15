<?php
    session_start();

    if(isset($_SESSION['user_id'])) {
        header("Location: ../index.html");
    }
    $conn = new mysqli("localhost","root","","musiconline_db");

    //Error messages
    $uError = '';
    $pError = '';
    $eError = '';
    $dError = '';
    $rError = '';
    $nError = '';
    $error = false;

    //Initialise variable
    $username = '';
    $password = '';
    $email = '';
    $dob = '';
    $retailerStatus = null;
    $adminStatus = 0;
    $phone = '';

    if($conn->connect_error){
        die("Connection Failed : ".$conn->connect_error);

    }
    else{
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            //User info variables
            $username = trim($_POST["username"]);
            $password = trim($_POST["password"]);
            $email = trim($_POST["email"]);
            $dob = trim($_POST["dob"]);
            $retailerStatus = $_POST["retailerStatus"] ?? null;
            $adminStatus = 0;
            $phone = trim($_POST["phone_no"]);

            //Username Check
            if (empty($username))
                {
                    $uError = "Username can not be empty";
                    $error = true;
                }

            //Email Check
            if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL))
                {
                    $eError = "Please enter a valid email";
                    $error = true;
                }
            else 
                {
                    $emailQuery = "SELECT * FROM user_info WHERE user_email='$email'";
                    $checkEmail = mysqli_query($conn, $emailQuery);
                    if (mysqli_num_rows($checkEmail) > 0 ) {
                        $eError = "*Email is already in use";
                        $error = true;
                    }
                }

            //Password Check
            if (empty($password))
                {
                    $pError = "Password can not be empty";
                    $error = true;
                }
            else if(!preg_match('/^.{8,}$/', $password)) {
                $pError = "Password must be 8 characters long";
                $error = true;
            }

            //DOB check
            if (empty($dob))
                {
                    $dError = "Please enter a valid date";
                    $error = true;
                }

            //Status Check
            if (!isset($retailerStatus))
            {
                $rError = "Please choose your account status";
                $error = true;
            }

            //Phone No Check
            if (empty($phone)) 
            {
                $nError = "Please enter a valid phone number";
                $error = true;
            }
            else if(preg_match("/^[0-9]{10}$/", $phone)) {
                $nError = "Please use the format XXX-XXXXXXX";
                $error = true;
            }
            else {
                $checkPhone = mysqli_query($conn, "SELECT * FROM user_info WHERE phone_no='$phone'");
                if (mysqli_num_rows($checkPhone) > 0 ) {
                    $nError = "*Phone Number is already in use";
                    $error = true;
                    }
                }

            if(!$error) {
                $hashed_password = password_hash($password, PASSWORD_DEFAULT);
                $query = "INSERT INTO user_info(user_name, user_password, user_email, user_dob, retailer_status, admin_status, phone_no) 
                VALUES ('$username', '$hashed_password', '$email', '$dob', '$retailerStatus', '$adminStatus', '$phone')";

                mysqli_query($conn, $query);
                $_SESSION['notiGet'] = "signUp";
                header("Location: http://localhost/account/login.php");
                exit();
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
                    <label for="email">E-mail:</label> <br/>
                    <input type="text" placeholder="Enter your E-mail" id="email" name="email"  value="<?php echo htmlspecialchars($email);?>"> <br> 
                    <span class="error"> <?php echo $eError ?></span> 
                </div>
                <div>
                    <label for="username">Username</label> <br/>
                    <input type="text" placeholder="Enter your username" id="username" name="username" value="<?php echo htmlspecialchars($username);?>"> <br/>
                    <span class="error"> <?php echo $uError ?></span> 
                </div>
                <div>
                    <label for="password">Password:</label> <br/>
                    <input type="password" placeholder="Enter your password" id="password" name="password" value="<?php echo htmlspecialchars($password);?>"> <br/>
                    <span class="error"> <?php echo $pError ?></span> 
                </div>
                <div>
                    <label for="phone_no">Phone Number:</label> <br/>
                    <input type="text" placeholder="Enter Your Phone Number" id="phone_no" name="phone_no" value="<?php echo htmlspecialchars($phone);?>"> <br/>
                    <span class="error"> <?php echo $nError ?></span> 
                </div>
                <div>
                    <label for="dob">Date of Birth</label> <br/>
                    <input type="date" id="dob" name="dob" value="<?php echo htmlspecialchars($dob);?>"> <br/>
                    <span class="error"> <?php echo $dError ?></span> 
                </div>
                <div>
                    <label for="retailStatus">Choose your account type</label> <br/>
                    <input type="Button" id="dropBttn"onclick="showBox()" name="retailStatus" value="Choose"><br/>
                    <div id="drop" class="dropDown">
                        <input type="radio"  name="retailerStatus" value= 1 onclick="changeBttnName('retailer')">
                        <label id="retailer" for="retailer">Retailer</label><br>
                        <input type ="radio" name="retailerStatus" value=0 onclick="changeBttnName('customer')">
                        <label id="customer" for="customer">Customer</label>
                    </div>
                    <span class="error"> <?php echo $rError ?></span> 
                </div>
                <div>
                <input type="submit" value="Create Account" class="submit-bttn">
            </div>

            <div class="signup-link">
                <p>Already have an account?</p>
                <a href="login.php">Log in</a>
            </div>
            </div>

        </form>
    </div>

    <script src="../script.js"></script>
</body>
</html>
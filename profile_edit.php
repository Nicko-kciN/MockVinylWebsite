<?php 
    session_start();
    if(!isset($_SESSION['user_id'])) {
        header("Location: account/login.php");
        exit();
    }

    $id = $_SESSION['user_id'];

    $conn = new mysqli("localhost","root","","musiconline_db");

    //initialise variables
    $name = '';
    $email = '';
    $dob = '';
    $jDate = '';
    $status = '';
    $phone = '';

    $address1 = '';
    $address2 = '';
    $city = '';
    $state = '';
    $zip = '';

    //Error messages
    $nError ='';
    $eError = '';
    $dError = '';
    $sError = '';
    $pError = '';

    $zError = '';
    $error = false;

    $query = "SELECT * FROM user_info WHERE user_id='$id'";
    $query2 = "SELECT * FROM shipping_info WHERE user_id='$id'";

    $result = mysqli_query($conn, $query);
    $result2 = mysqli_query($conn, $query2);

    $userInfo = mysqli_fetch_assoc($result);
    $shippingInfo = mysqli_fetch_assoc($result2);

    $name = $userInfo['user_name'];
    $email = $userInfo['user_email'];
    $dob = $userInfo['user_dob'];
    $jDate = $userInfo['date_joined'];
    $phone = $userInfo['phone_no'];

    $address1 = $shippingInfo['address1'] ?? null;
    $address2 = $shippingInfo['address2'] ?? null;
    $city = $shippingInfo['city'] ?? null;
    $state = $shippingInfo['c_state'] ?? null;
    $zip = $shippingInfo['zip_code'] ?? null;

    if($conn->connect_error){
        die("Connection Failed : ".$conn->connect_error);

    }
    else{
        if ($_SERVER["REQUEST_METHOD"] == "POST") { 

            $name = $_POST['name'];
            $email = $_POST['email'];
            $dob = $_POST['dob'];
            $phone = $_POST['phone'];
            $status = $_POST['status'] ?? null;

            $address1 = $_POST['address1'];
            $address2 = $_POST['address2'];
            $city = $_POST['city'];
            $state = $_POST['state'] ?? null;
            $zip = $_POST['zip'];

            //Name Validation
            if (empty($name)) {
                $nError = "User name can not be empty";
                $error = true;
            }

            //Email Validation
            if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL))
                {
                    $eError = "Please enter a valid email";
                    $error = true;
                }
            else 
                {
                    $emailQuery = "SELECT * FROM user_info WHERE user_email='$email'";
                    $checkEmail = mysqli_query($conn, $emailQuery);
                    $emailRow = mysqli_fetch_assoc($checkEmail);
                    if (mysqli_num_rows($checkEmail) > 0 && ($id != $emailRow['user_id'])) {
                        $eError = "*Email is already in use";
                        $error = true;
                    }
                }
            
            //Date of Birth Validation
            if (empty($dob)) {
                $dError = "Please choose a date of birth";
                $error = true;
            }

            //Phone number validation
            if (empty($phone)) 
            {
                $pError = "Please enter a valid phone number";
                $error = true;
            }
            else if(preg_match("/^[0-9]{10}$/", $phone)) {
                $pError = "Please use the format XXX-XXXXXXX";
                $error = true;
            }
            else {
                $checkPhone = mysqli_query($conn, "SELECT * FROM user_info WHERE phone_no='$phone'");
                $phoneRow = mysqli_fetch_assoc($checkPhone);
                if (mysqli_num_rows($checkPhone) > 0 && ($id != $phoneRow['user_id'])) {
                    $pError = "*Phone Number is already in use";
                    $error = true;
                    }
                }
            
            //Status Check
            if (!isset($status))
            {
                $sError = "Please re-choose your account status";
                $error = true;
            }

            if (!empty($zip)) {
                if (!is_numeric($zip) || !preg_match('/^\d{5}$/', $zip)) {
                    $zError = "Please enter a valid zip code";
                    $error = true;
                }
            }

            if (!$error) {
                $updateUserQuery = "UPDATE user_info SET user_name='$name', user_email ='$email', user_dob ='$dob',
                                    retailer_status ='$status', phone_no='$phone' WHERE user_id='$id'";
                mysqli_query($conn, $updateUserQuery);

                if (($shippingInfo)) {
                    $updateShippingQuery = "UPDATE shipping_info SET address1='$address1', address2='$address2', city='$city',
                                            c_state='$state', zip_code='$zip' WHERE user_id='$id'";  
                    
                    mysqli_query($conn, $updateShippingQuery);
                    header("Location: profile.php");
                    exit();
                }
                else {
                    $addShippingQuery = "INSERT INTO shipping_info(address1, address2, city, c_state, zip_code, user_id)
                                        VALUES ('$address1', '$address2', '$city', '$state', '$zip', '$id')";
                    
                    mysqli_query($conn, $addShippingQuery);
                    header("Location: profile.php");
                    exit();
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
    <title>CSC1215 Assignment 1</title>
    <link rel="stylesheet" href="styles.css?v=2">
    <!--Font-->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Quicksand&display=swap" rel="stylesheet">
</head>
<body>

    <header>
        <!--Navigation bar-->
        <nav class="headbar">
            
            <div class="head-links">
            <a href="account/login.php" id="header1">Login</a>
            <a href="account/signup.php" id="header2">Sign Up</a>
            <a id="header3"></a>
            </div>
            <div class="head-links">
            <p class="head-text">The Soul of Music</p>
            </div>

            <!-- Navigation links -->
            <div class="head-links">
                <a href="cart.html">Cart</a>  
                
            <div class="search-container">
                <div>
                    <label for="search"></label>
                    <input type="text" placeholder="Search..." id="searchHome">
                </div>
                <div class="search-vinyl">
                    </div>
                </div>
            </div>
        </div>      
        </nav>
    </header>
    <div class="img-container">
    <a href="index.html">
    <img src="Images/logo.png" class="logo">
    </a> 
    </div>

    <nav class="nav-links">
        <ul>
            <li><a href="index.html">Home</a></li>
            <li><a href="vinyl_main.html">Vinyls</a></li>
            <li><a id="nav-listing" href="listing.html">My Listings</a></li>
            <li><a href="about_us.html">About Us</a></li>
            <li><a href="contact_us.html">Contact Us</a></li>
        </ul>
    </nav>

    <div class="profile-cont">
        <form method="post">
        <div class="profile-info">
            <div class="profile-inner">
                    <div class="padding">
                        <label>Name: </label><br>
                        <input type="text" placeholder="Enter your name" name="name" value="<?php echo htmlspecialchars($name);?>"><br>
                        <span class="error"><?php echo $nError?></span>
                    </div>
                    <div class="padding">
                        <label>Email: </label><br>
                        <input type="text" placeholder="Enter your email" name="email" value="<?php echo htmlspecialchars($email);?>"><br>
                        <span class="error"><?php echo $eError?></span>
                    </div>
                    <div class="padding">
                        <label>Phone Number: </label><br>
                        <input type="text" placeholder="Enter your phone number" name="phone" value="<?php echo htmlspecialchars($phone);?>"><br>
                        <span class="error"><?php echo $pError?></span>
                    </div>
                    <div class="padding"> 
                        <label>Date of Birth: </label><br>
                        <input type="date" name="dob" value="<?php echo htmlspecialchars($dob);?>"><br>
                        <span class="error"><?php echo $dError?></span>
                    </div>
                    <div class="padding">
                        <label for="joined">Date Joined: </label><br>
                        <span><?php echo $jDate?></span>
                    </div>
                        <div class="padding">
                        <label for="status">Account Status: </label><br>
                        <div>
                        <input type="button" id="dropBttn" onclick="showBox()" name="status" value="Choose"><br/>
                        <div id="drop" class="dropDown">
                            <input type="radio" name="status" value= 1 onclick="changeBttnName('retailer')">
                            <label id="retailer" for="retailer">Retailer</label><br>
                            <input type ="radio" name="status" value=0 onclick="changeBttnName('customer')">
                            <label id="customer" for="customer">Customer</label>
                        </div>
                        <span class="error"><?php echo $sError?></span>
                    </div>
            </div>
        </div><br>

        <div class="shipping-info">
            <div class="shipping-inner">
                <div class="padding">
                    <label>Shipping Address 1: </label><br>
                    <input type="text" placeholder="Enter your Address" name="address1" value="<?php echo htmlspecialchars($address1);?>"><br>
                </div>
                <div class="padding">
                    <label>Shipping Address 2: </label><br>
                    <input type="text" placeholder="Enter your Address" name="address2" value="<?php echo htmlspecialchars($address2);?>"><br>
                </div>
                <div class="padding">
                    <label>City: </label><br>
                    <input type="text" placeholder="Enter your City" name="city" value="<?php echo htmlspecialchars($city);?>"><br>
                </div>
                <div class="padding">
                    <label>State: </label><br>
                    <input type="text" placeholder="Enter your State" name="state" value="<?php echo htmlspecialchars($state);?>"><br>
                </div>
                <div class="padding">
                    <label>Zip-code: </label><br>
                    <input type="text" placeholder="Enter your Zip-code" name="zip" value="<?php echo htmlspecialchars($zip);?>"><br>
                    <span class="error"><?php echo $zError?></span>
                </div>
            </div>
        </div>
        <div class="profile-submit">
            <input type="submit" value="Confirm Changes">
        </div>
        </form>
    </div>
    </div>
    <script src="script.js"></script>
 <footer class="footer">
  <div class="footer-container">
    <div class="footer-section-about">
        <ul>
      <h4>About Us</h4>
      
      <p>Founded since 2024 by Dominic Ng</p>
      <p>Partership with Spookify</p>
      <p>2025 Vinyl Business Award</p>
      </ul>
    </div>
    <div class="footer-section quick-links">
      <h4>Questions:</h4>
      <ul>
        <li><a href="about_us.html">About Us</a></li>
        <li><a href="contact_us.html">Contact Us</a></li>
      </ul>
    </div>
    <div class="footer-section-contact">
      <ul>
      <h4>Contact Us</h4>
      <p>Email: vinylsupport@gmail.com</p>
      <p>Phone: +60 12-345 6789</p>
      <p>Address: 2,Jalan Pjs5, Bandar Sun, Selangor</p>
      </ul>
    </div>
  </div>

  <div class="footer-bottom">
    &copy; 2025 Music Online. All rights reserved.
  </div>
</footer>
</body>
</html>
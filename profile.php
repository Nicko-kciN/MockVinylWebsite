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

    $query = "SELECT * FROM user_info WHERE user_id='$id'";
    $query2 = "SELECT * FROM shipping_info WHERE user_id='$id'";

    $result = mysqli_query($conn, $query);
    $result2 = mysqli_query($conn, $query2);

    $userInfo = mysqli_fetch_assoc($result);
    $shippingInfo = mysqli_fetch_assoc($result2);

    if ($userInfo['retailer_status'] == 1 && $userInfo['admin_status'] == 0) {
        $status = "Retailer";
    }
    else if($userInfo['admin_status'] == 1) {
        $status = "Admin";
    }
    else {
        $status = "Customer";
    }

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
        <div class="profile-info">
            <div class="profile-inner">
                    <div class="padding">
                        <label for="name">Name: </label><br>
                        <span><?php echo $name ?></span>
                    </div>
                    <div class="padding">
                        <label for="email">Email: </label><br>
                        <span><?php echo $email ?></span>
                    </div>
                    <div class="padding">
                        <label for="phone">Phone Number: </label><br>
                        <span><?php echo $phone ?></span>
                    </div>
                    <div class="padding"> 
                        <label for="dob">Date of Birth: </label><br>
                        <span><?php echo $dob ?></span>
                    </div>
                    <div class="padding">
                        <label for="joined">Date Joined: </label><br>
                        <span><?php echo $jDate?></span>
                    </div>
                    <div class="padding">
                        <label for="joined">Account Status: </label><br>
                        <span><?php echo $status?></span>
                    </div>
                    
            </div>
        </div><br>

        <div class="shipping-info">
            <div class="shipping-inner">
                <div class="padding">
                    <label for="address1">Shipping Address 1: </label><br>
                    <span><?php echo $address1 ?></span>
                </div>
                <div class="padding">
                    <label for="address2">Shipping Address 2: </label><br>
                    <span><?php echo $address2 ?></span>
                </div>
                <div class="padding">
                    <label for="city">City: </label><br>
                    <span><?php echo $city ?></span>
                </div>
                <div class="padding">
                    <label for="state">State: </label><br>
                    <span><?php echo $state ?></span>
                </div>
                <div class="padding">
                    <label for="zip-code">Zip-code: </label><br>
                    <span><?php echo $zip ?></span>
                </div>
            </div>
        </div>
        <div class="profile-submit">
            <a href="profile_edit.php">
            <input type="button" value="Edit Profile">
            </a>
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
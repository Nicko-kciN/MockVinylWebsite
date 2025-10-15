<?php
    session_start();

    if(!isset($_SESSION['user_id'])) {
        header("Location: account/login.php");
        exit();
    }

    $conn = new mysqli("localhost","root","","musiconline_db");
    mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);  

    //Error Messages
        $nError ='';
        $aError ='';
        $iError ='';
        $rError ='';
        $pError ='';
        $gError ='';
        $dError = '';
        $error = false;

        //Intialise Variable
        $vName = '';
        $author = '';
        $imageLink = '';
        $rDate = '';
        $price = '';
        $genre = null;
        $desc = '';

        if($conn->connect_error){
            die("Connection Failed : ".$conn->connect_error);
            
        }
        else{
            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                $vName = $_POST['vinylName'];
                $author = $_POST['vinylAuthor'];
                $imageLink = $_POST['vinylImage'];
                $rDate = $_POST['vinylDate'];
                $price = $_POST['vinylPrice'];
                $genre = $_POST['vinylGenre'] ?? null;
                $uploader = $_SESSION['user_id'];
                $desc = $_POST['vinylDesc'];

                if (empty($vName)) {
                $nError = "Vinyl Name can not be empty";
                $error = true;
            }
            else {

                $checkName = "SELECT * FROM vinyl_info WHERE vinyl_name='$vName'";
                $checkResult = mysqli_query($conn, $checkName);
                try {if (mysqli_num_rows($checkResult) > 0) {
                    $nError = "Vinyl Name already exist";
                    $error = true;
                }

                } catch (error) {
                    $nError = "Name can not have any special characters";
                    $error = true;
            }
            }

            if (empty($author)) {
                $aError = "Author Name can not be empty";
                $error = true;
            }
            
            if (empty($imageLink)) {
                $iError = "Image link can not be empty";
                $error = true;
            }

            if (empty($rDate)) {
                $rError = "Date can not be empty";
                $error = true;
            }

            if (empty($price)) {
                $pError = "Price can not be empty";
                $error = true;
            }

            else if (!is_numeric($price) || $price < 0) {
                $pError = "Please enter a valid price";
                $error = true;
            }
            
            if (!isset($genre)) {
                $gError = "Please choose a genre";
                $error = true;
            }

            if (empty($desc)) {
                $dError = "Description can not be empty";
                $error = true;
            }

            if (!$error) {
                //prepared statement for special characters
                $stmt = $conn->prepare(
                    "INSERT INTO vinyl_info(vinyl_name, uploader_id, vinyl_genre, vinyl_image, vinyl_rdate, 
                    vinyl_price, author, vinyl_desc) 
                    VALUES (?, ?, ?, ?, ?, ?, ?, ?)"
                    );
                $stmt->bind_param("sisssdss", $vName, $uploader, $genre, $imageLink, $rDate, $price, $author, $desc);

                $stmt->execute();
        
                $stmt->close();
                $conn->close();

                echo "Vinyl Successfully added";
                header("Location: listing.html");
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
    <title>CSC1215 Assignment 1</title>
    <link rel="stylesheet" href="styles.css">
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

    <div class="add-cont">
        <div class="add-text">
            <h2>Add your vinyls</h2>
        </div>
        <form method="post">
            <div class="add-inner">
                <div class="add-img">
                    <img id="preview" class="preview-img" src="">
                </div>
                <div class="add-content">
                    <div>
                        <label for="vinylName">Vinyl Name: </label> <br>
                        <input type="text" name="vinylName" id="vinylName" placeholder="Vinyl's Name"><br>
                        <span class="error"><?php echo $nError?></span>
                    </div>
                    <div>
                    <label for="vinylAuthor">Author Name: </label> <br>
                        <input type="text" name="vinylAuthor" id="vinylAuthor" placeholder="Author Name"><br>
                        <span class="error"><?php echo $aError?></span>
                    </div>
                    <div>
                        <label for="vinylImage">Image Link: </label> <br>
                        <input type="text" name="vinylImage" id="vinylImage" placeholder="Image Link"><br>
                        <span class="error"><?php echo $iError?></span>
                    </div>
                    <div>
                        <label for="vinylDate">Release Date: </label> <br>
                        <input type="date" name="vinylDate" id="vinylDate" placeholder="Release Date"><br>
                        <span class="error"><?php echo $rError?></span>
                    </div>
                    <div>
                        <label for="vinylPrice">Vinyl Price (RM): </label> <br>
                        <input type="text" name="vinylPrice" id="vinylPrice" placeholder="Vinyl's Price"><br>
                        <span class="error"><?php echo $pError?></span>
                    </div>
                    <div>
                        <label for="vinylDesc">Vinyl Description </label> <br>
                        <textarea type="text" name="vinylDesc" id="vinylDesc" placeholder="Vinyl's Description" class="vinyl-desc"></textarea><br>
                        <span class="error"><?php echo $dError?></span>
                    </div>
                    <div>
                        <label for="vinylGenre">Vinyl Genre: </label> <br>
                        <input type="Button" name="vinylGenre" id="dropBttn" onclick="showBox()" value="Choose a genre"><br>
                        <div id="drop" class="dropDown">
                            <input type="radio" name="vinylGenre" value= "jpop" onclick="changeBttnName('jpop')">
                            <label id="jpop" for="jpop">J-pop</label><br>
                            <input type="radio"  name="vinylGenre" value= "pop" onclick="changeBttnName('pop')">
                            <label id="pop" for="pop">Pop</label><br>
                            <input type="radio" name="vinylGenre" value= "rock" onclick="changeBttnName('rock')">
                            <label id="rock" for="rock">Rock</label><br>
                            <input type="radio" name="vinylGenre" value= "electronic" onclick="changeBttnName('electronic')">
                            <label id="electronic" for="electronic">Electronic</label><br>
                            <input type="radio" name="vinylGenre" value= "classical" onclick="changeBttnName('classical')">
                            <label id="classical" for="classical">Classical</label><br>
                            <input type="radio" name="vinylGenre" value= "vg" onclick="changeBttnName('vg')">
                            <label id="vg" for="vg">Video Game</label><br>
                            <input type="radio" name="vinylGenre" value= "jazz" onclick="changeBttnName('jazz')">
                            <label id="jazz" for="jazz">Jazz</label><br>
                        </div>
                        <span class="error"><?php echo $gError?></span>
                    </div>
                    <input type="submit" value="Add to Listing" class="submit-bttn">
                </div>
            </div>
        </form>
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
<?php 
    session_start();

    if(!$_GET['id']) {
        header("Location: error.html");
    }
    else {
        if(!isset($_SESSION['user_id'])) {
            header("Location: account/login.php");
    }
    else {
        $isAdmin = false;
        $isUploader = false;
        $vinyl_id = $_GET['id'];
        $user_id = $_SESSION['user_id'];
        $conn = new mysqli("localhost","root","","musiconline_db");

        $getUser = "SELECT * FROM user_info WHERE user_id='$user_id'";
        $resultUser = mysqli_query($conn, $getUser);
        $userRow = mysqli_fetch_assoc($resultUser);

        $admin = $userRow['admin_status'];
        if ($admin == "1") {
            $isAdmin = true;
        }

        $getVinyl = "SELECT uploader_id FROM vinyl_info WHERE vinyl_id='$vinyl_id'";
        $result = mysqli_query($conn, $getVinyl);
        $getRow = mysqli_fetch_assoc($result);

        if($user_id == $getRow['uploader_id']) {
            $isUploader = true;
        }

        if ($isAdmin || $isUploader) {
            $deleteQuery = "DELETE FROM vinyl_info WHERE vinyl_id='$vinyl_id'";
            mysqli_query($conn, $deleteQuery);
            header("Location: listing.html");
            exit();
        }
        else {
            header("Location: index.html");
            exit();
        }
        }
    }
?>

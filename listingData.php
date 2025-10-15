<?php
    session_start();
    $conn = new mysqli("localhost","root","","musiconline_db");

    header('Content-Type: application/json');

    $data = [];

    //Checks if the session has the user id
    if (isset($_SESSION['user_id'])) {
        //Searches for user data using user id
        $user_id = $_SESSION['user_id'];
        $query = "SELECT admin_status FROM user_info WHERE user_id= '$user_id'";

        $result = mysqli_query($conn, $query);
        $user_data = mysqli_fetch_assoc($result);
        
        if ($user_data['admin_status'] == 1) {
            $adminVinyl = "SELECT * FROM vinyl_info"; 
            $resultAdmin = mysqli_query($conn, $adminVinyl);
            $adminData = mysqli_fetch_all($resultAdmin, MYSQLI_ASSOC);

            $data = $adminData;
        }
        else {
            $userVinyl = "SELECT * FROM vinyl_info WHERE uploader_id='$user_id'";
            $resultUser = mysqli_query($conn, $userVinyl);
            $userData = mysqli_fetch_all($resultUser, MYSQLI_ASSOC);

            $data = $userData;
        }
        }
        else {
            return null;
        }

    echo json_encode($data);

?>

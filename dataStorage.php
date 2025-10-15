<?php
    session_start();
    $conn = new mysqli("localhost","root","","musiconline_db");

    header('Content-Type: application/json');

    $data = [];

    //Checks if the session has the user id
    if (isset($_SESSION['user_id'])) {
        //Searches for user data using user id
        $user_id = $_SESSION['user_id'];
        $query = "SELECT * FROM user_info WHERE user_id= '$user_id'";

        $result = mysqli_query($conn, $query);

        $user_data = mysqli_fetch_assoc($result);

        //Sets user logged to true
        $data = [
            'user_logged' => true,
            'user_id' => $user_data['user_id'],
            'user_name' => $user_data['user_name'],
            'user_email' => $user_data['user_email'],
            'user_dob' => $user_data['user_dob'],
            'phone' => $user_data['phone_no'],
            'retailer' => $user_data['retailer_status'],
            'admin' => $user_data['admin_status'],
            'date_joined' => $user_data['date_joined']];
    }
    else {
        //If the session does not have an user id that means the user is not logged in
        $data = ['user_logged' => false];
    }

    echo json_encode($data);
?>
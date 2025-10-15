<?php
    session_start();
    $conn = new mysqli("localhost","root","","musiconline_db");

    header('Content-Type: application/json');

    $data = [];

    $get_data = "SELECT * FROM vinyl_info LIMIT 3";
    $result = mysqli_query($conn, $get_data);
    if (mysqli_num_rows($result) > 0) {

        $vinyl_data = mysqli_fetch_all($result, MYSQLI_ASSOC);

        $data = $vinyl_data;
    }

    echo json_encode($data);
?>
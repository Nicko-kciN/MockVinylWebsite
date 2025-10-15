<?php
    session_start();

    $data = [];
    $vinyl_id = [];

    if(isset($_SESSION['user_id'])) {

        $user_id = $_SESSION['user_id'];

        $conn = new mysqli("localhost","root","","musiconline_db");

        $getCart = "SELECT * FROM cart WHERE user_id='$user_id'";
        $cartResult = mysqli_query($conn, $getCart);
        $cartData = mysqli_fetch_all($cartResult, MYSQLI_ASSOC);

        $id_array = array_column($cartData, 'vinyl_id');
        if (!empty($id_array)) {$id_list = implode(',', $id_array);

        $getVinyl = "SELECT * FROM vinyl_info WHERE vinyl_id IN ($id_list)";
        $vinylResult = mysqli_query($conn, $getVinyl);
        $vinylData = mysqli_fetch_all($vinylResult, MYSQLI_ASSOC);

        $data = $vinylData;
    }
    }
    else {
        return null;
    }
    echo json_encode($data);

?>
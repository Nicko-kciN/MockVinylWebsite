<?php 
    session_start();

    if (!isset($_SESSION['user_id'])) {
        header("Location: account/login.php");
        exit();
    }
    if (!isset($_GET['id'])) {
        header("Location: vinyl_main.html");
        exit();
    } 

    $user_id = $_SESSION['user_id'];
    $vinyl_id = $_GET['id'];
    $conn = new mysqli("localhost","root","","musiconline_db");

    $check = "SELECT * FROM cart WHERE vinyl_id='$vinyl_id' AND user_id='$user_id'";
    $result = mysqli_query($conn, $check);

    if(mysqli_num_rows($result) > 0) {
        echo "<script>alert('Item is already in cart')</script>";
        header("Location: cart.html");
       
    }

    $addQuery = "INSERT INTO cart(vinyl_id, user_id) VALUES('$vinyl_id', '$user_id')";

    mysqli_query($conn, $addQuery);
    header("Location: cart.html");
    exit();

?>
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

    $deleteQuery = "DELETE FROM cart WHERE vinyl_id='$vinyl_id' AND user_id='$user_id'";

    mysqli_query($conn, $deleteQuery);
    header("Location: cart.html");
    exit();

?>
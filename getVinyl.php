    <?php
        session_start();
        $conn = new mysqli("localhost","root","","musiconline_db");

        header('Content-Type: application/json');

        $data = array();


        if (isset($_GET['id'])) {
            //Searches for user data using user id
            $vinyl_id = $_GET['id'];

            $query = "SELECT * FROM vinyl_info WHERE vinyl_id='$vinyl_id'";
            $result = mysqli_query($conn, $query);

            $vinyl_data = mysqli_fetch_assoc($result);

            $uploader_id = $vinyl_data['uploader_id'];
            $getUser = "SELECT * FROM user_info WHERE user_id='$uploader_id'";

            $userResult = mysqli_query($conn, $getUser);
            $user_data = mysqli_fetch_assoc($userResult);

            $data['vinyl_data'] = $vinyl_data;
            $data['user_data'] = $user_data;
        }
        else {
            return null;
        }

        echo json_encode($data);
    ?>
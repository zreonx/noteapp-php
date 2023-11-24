<?php 
    require_once '../db.php';

    if(isset($_POST["id"])) {
        $id = $_POST['id'];

        $sql = "SELECT * FROM notes WHERE id = '$id'";

        $result = mysqli_query($conn, $sql);

        if(mysqli_num_rows($result) > 0) { 

            $row = mysqli_fetch_assoc($result);

            echo json_encode($row);
        }
    }
?>
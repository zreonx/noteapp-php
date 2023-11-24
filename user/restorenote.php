<?php 
    require_once '../db.php';

    if(isset($_POST["id"])) {
        $id = $_POST['id'];

        date_default_timezone_set('Asia/Manila');
        $dates = date('Y-m-d h:i:sa');

        $sql = "UPDATE notes SET status = 'active', deleted_at = '' WHERE id = '$id'";

        $result = mysqli_query($conn, $sql);

        header('location: index.php?restore=true');
    }
?>
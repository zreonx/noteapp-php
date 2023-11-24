<?php 
    require_once '../db.php';

    if(isset($_GET["id"])) {
        $id = $_GET['id'];

        date_default_timezone_set('Asia/Manila');
        $dates = date('Y-m-d h:i:sa');

        $sql = "UPDATE notes SET status = 'deleted', deleted_at = '$dates' WHERE id = '$id'";

        $result = mysqli_query($conn, $sql);

        header('location: index.php');
    }
?>
<?php 
    require_once '../db.php';

    if(isset($_GET["id"])) {
        $id = $_GET['id'];

        date_default_timezone_set('Asia/Manila');
        $dates = date('Y-m-d h:i:sa');

        $sql = "DELETE FROM notes WHERE id = '$id'";

        $result = mysqli_query($conn, $sql);

        header('location: archive.php?deleted=true');
    }
?>
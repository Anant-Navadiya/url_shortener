<?php
    include "./config.php";
    if(isset($_GET['id'])){
        $delete_id = mysqli_real_escape_string($conn, $_GET['id']);
        $sql = mysqli_query($conn, "DELETE FROM url WHERE shorten_url = '{$delete_id}'");
        if($sql){
            header("Location: ./dashboard.php");
        }else{
            header("Location: ./dashboard.php");
        }
    }elseif(isset($_GET['delete'])){
        $sql3 = mysqli_query($conn, "DELETE FROM url");
        if($sql3){
            header("Location: ./dashboard.php");
        }else{
            header("Location: ./dashboard.php");
        }
    }else{
        header("Location: ./dashboard.php");
    }
?>
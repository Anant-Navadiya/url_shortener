<?php 
  
    $domain = ""; 
    $host = "localhost";
    $user = "root";
    $pass = ""; 
    $db = "url_shortener"; 

    $conn = mysqli_connect($host, $user, $pass, $db);
    if(!$conn){
        echo "Database connection error".mysqli_connect_error();
    }
?>
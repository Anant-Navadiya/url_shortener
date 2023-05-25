<?php
    include "./config.php";
    include "./auth_session.php";
    $full_url = mysqli_real_escape_string($conn, $_POST['full_url']);
    if(!empty($full_url) && filter_var($full_url, FILTER_VALIDATE_URL)){
        $ran_url = substr(md5(microtime()), rand(0, 26), 5);
        $user = $_SESSION['username'];
        $sql0 = mysqli_query($conn,"SELECT id FROM users WHERE username = '{$user}'");
        if(mysqli_num_rows($sql0) > 0){
            $shorten_url = mysqli_fetch_assoc($sql0);
            $user_id = $shorten_url['id'];
        }
        $sql = mysqli_query($conn, "SELECT * FROM url WHERE shorten_url = '{$ran_url}'");
        if(mysqli_num_rows($sql) > 0){
            echo "Something went wrong. Please generate again!";
        }else{
            $sql2 = mysqli_query($conn, "INSERT INTO url (full_url, shorten_url, clicks, user_id) 
                                         VALUES ('{$full_url}', '{$ran_url}', '0','{$user_id}')");
            if($sql2){
                $sql3 = mysqli_query($conn, "SELECT shorten_url FROM url WHERE shorten_url = '{$ran_url}'");
                if(mysqli_num_rows($sql3) > 0){
                    $shorten_url = mysqli_fetch_assoc($sql3);
                    echo $shorten_url['shorten_url'];
                }
            }
        }
    }else{
        echo "$full_url - This is not a valid URL!";
    }
?>
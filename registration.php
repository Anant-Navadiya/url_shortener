<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8" />
    <title>Registration</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
    <link rel="stylesheet" href="./style.css">
</head>


<body>
    <?php
    require('./config.php');

    // When form submitted, insert values into the database.
    if (isset($_REQUEST['username'])) {
        // removes backslashes
        $username = stripslashes($_REQUEST['username']);
        //escapes special characters in a string
        $username = mysqli_real_escape_string($conn, $username);
        $email    = stripslashes($_REQUEST['email']);
        $email    = mysqli_real_escape_string($conn, $email);
        $password = stripslashes($_REQUEST['password']);
        $password = mysqli_real_escape_string($conn, $password);
        $create_datetime = date("Y-m-d H:i:s");

        $sql = "SELECT * FROM `users` WHERE username = '$username'";
        $result = mysqli_query($conn, $sql);
        if (mysqli_num_rows($result)) {
            die("<div class='contact-form'>
            <h3>User already exist</h3><br/>
            <p class='link'>Click here to <a href='login.php'>Login</a></p>
            </div>");
        }

        $query  = "INSERT into `users` (username, password, email, created_at)
                     VALUES ('$username', '" . md5($password) . "', '$email', '$create_datetime')";
        $result   = mysqli_query($conn, $query);
        if ($result) {
            // header("Location: login.php");
            echo "<div class='contact-form'>
                  <h3>You are registered successfully.</h3><br/>
                  <p class='link'>Click here to <a href='login.php'>Login</a></p>
                  </div>";
        } else {
            echo "<div class='contact-form'>
                  <h3>Required fields are missing.</h3><br/>
                  <p class='link'>Click here to <a href='registration.php'>registration</a> again.</p>
                  </div>";
        }
    } else {
    ?>

        <div class="contact-form">
            <span class="heading">Register</span>
            <form method="post">
                <label for="username">Username:</label>
                <input id="username" type="text" name="username" required>
                <label for="email">Email:</label>
                <input id="email" type="email" name="email" required>
                <label for="password">Password:</label>
                <input id="password" type="password" name="password" required>
                <button type="submit">Submit</button>
                <div class="link">Already have an account?<a href="./login.php" class="ms-2">Login</a></div>
            </form>
        </div>
    <?php
    }
    ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>
</body>

</html>
<?php
include "config.php";
include "auth_session.php";



// $new_url = "";
// if (isset($_GET)) {
//   foreach ($_GET as $key => $val) {
//     $u = mysqli_real_escape_string($conn, $key);
//     $new_url = str_replace('/', '', $u);
//     //change
//     // $new_url = explode('/', $u)[1];
//   }
//   $sql = mysqli_query($conn, "SELECT full_url FROM url WHERE shorten_url = '{$new_url}'");
//   if (mysqli_num_rows($sql) > 0) {
//     $sql2 = mysqli_query($conn, "UPDATE url SET clicks = clicks + 1 WHERE shorten_url = '{$new_url}'");
//     if ($sql2) {
//       $full_url = mysqli_fetch_assoc($sql);
//       header("Location:" . $full_url['full_url']);
//     }
//   }
// }

$user = $_SESSION['username'];
$sql0 = mysqli_query($conn, "SELECT id FROM users WHERE username = '{$user}'");
if (mysqli_num_rows($sql0) > 0) {
  $shorten_url = mysqli_fetch_assoc($sql0);
  $user_id = $shorten_url['id'];
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <title>URL Shortener</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
  <link rel="stylesheet" href="style.css">
  <!-- Iconsout Link for Icons -->
  <link rel="stylesheet" href="https://unicons.iconscout.com/release/v3.0.6/css/line.css">
</head>

<body>
  <div class="wrapper">
    
  <div class="d-flex justify-content-between">
    <h1 class="d-inline-block">Welcome, <?php echo ucfirst($_SESSION['username']); ?></h1>
    <h5 class="d-inline-block align-self-center "><a href="./logout.php">Logout</a></h5>
  </div>

    <form action="#" autocomplete="off" id="new_url">
      <input type="text" spellcheck="false" name="full_url" placeholder="Enter or paste a long url" required>
      <i class="url-icon uil uil-link"></i>
      <button class="button">Shorten</button>
    </form>
    <?php
     
    $sql2 = mysqli_query($conn, "SELECT * FROM url where user_id ='{$user_id}'");
    if (mysqli_num_rows($sql2) > 0) {;
    ?>
      <div class="statistics">
        <?php
        $sql3 = mysqli_query($conn, "SELECT COUNT(*) FROM url where user_id ='{$user_id}'");
        $res = mysqli_fetch_assoc($sql3);

        $sql4 = mysqli_query($conn, "SELECT clicks FROM url where user_id ='{$user_id}'");
        $total = 0;
        while ($count = mysqli_fetch_assoc($sql4)) {
          $total = $count['clicks'] + $total;
        }
        ?>
        <span>Total Links: <span><?php echo end($res) ?></span> & Total Clicks: <span><?php echo $total ?></span></span>
        <a href="delete.php?delete=all">Clear All</a>
      </div>
      <div class="urls-area">
        <div class="title">
          <li>Shorten URL</li>
          <li>Original URL</li>
          <li>Clicks</li>
          <li>Action</li>
        </div>
        <?php
        while ($row = mysqli_fetch_assoc($sql2)) {
          $shorten_url = $row['shorten_url'];
        ?>
          <div class="data">
            <li>
              <a href="<?php echo $row['full_url'] ?>" target="_blank" id="short_url">
                <?php
                if ( strlen($row['shorten_url']) > 50) {
                  echo  substr($row['shorten_url'], 0, 50) . '...';
                } else {
                  echo  $row['shorten_url'];
                }
                ?>
              </a>
            </li>
            <li>
              <?php
              if (strlen($row['full_url']) > 60) {
                echo substr($row['full_url'], 0, 60) . '...';
              } else {
                echo $row['full_url'];
              }
              ?>
            </li>
            </li>
            <li><?php echo $row['clicks'] ?></li>
            <li><a href="delete.php?id=<?php echo $row['shorten_url'] ?>">Delete</a></li>
          </div>
        <?php
        }
        ?>
      </div>
    <?php
    }
    ?>
  </div>

  <div class="blur-effect"></div>
  <div class="popup-box">
    <div class="info-box">Your short link is ready. You can also edit your short link now but can't edit once you saved it.</div>
    <form action="#" autocomplete="off">
      <label>Edit your shorten url</label>
      <input type="text" class="shorten-url" spellcheck="false" required>
      <i class="copy-icon uil uil-copy-alt"></i>
      <button class="button">Save</button>
    </form>
  </div>

  <script src="./script.js"></script>
  <script>
    document.getElementById('short_url').onclick= function(){
      console.log('clicked')

      <?php 
        mysqli_query($conn, "UPDATE url SET clicks = clicks + 1 WHERE shorten_url = '{$shorten_url}'");
        ?>
    }
    </script>
<!-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script> -->
</body>

</html>
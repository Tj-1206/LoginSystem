<!-- PHP SCRIPT -->
<?php

$login = false;
$showError = false;

if($_SERVER['REQUEST_METHOD'] == "POST"){

  // including db connection php script
  include 'partials/_dbconnect.php';

  $username = $_POST["username"];
  $password = $_POST["password"];

  // serial no is auto incremented, so no need to have it in the query
  // $sql = "SELECT * FROM `users` WHERE `username`='$username' AND `password`='$password'";
  
  // now no need to have password here, as password hashing method will take care of that
  $sql = "SELECT * FROM `users` WHERE `username`='$username'";

  $result = mysqli_query($conn, $sql);

  $num = mysqli_num_rows($result);

  if($num == 1){
    // input password and its hash should match
    while($row = mysqli_fetch_assoc($result)){
      if(password_verify($password, $row['password'])){
        $login = true;
        // now that you are logged in, start the session
        session_start();

        $_SESSION['loggedin'] = true;
        $_SESSION['username'] = $username;
        // password is not set, because we cant set user's password, and password should not be plain text for security reasons

        // function used to redirect to given location after logging in
        header("location: welcome.php");
      }
      else{
        $showError = "Incorrect Password!";
      }
    }
  }
  else{
    $showError = "Invalid Credentials!";
  }
}

?>

<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">

    <title>Login</title>
  </head>
  <body>
    <!-- ADDING NAVBAR -->
    <?php require "partials/_nav.php" ?>

    <!-- SUCCESS ALERT -->
    <?php
    if($login){
      echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
              <strong>Success!</strong> You are now logged in!
              <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>';
    }
    if($showError){
      echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
              <strong>Error!</strong> ' . $showError . '
              <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>';
    }
    ?>

    <div class="container my-4">
        <h4 class="text-center">Login to our website</h4>

        <!-- SIGNUP FORM -->
        <form action="/PHP_PROJECTS/LoginSystemPHPProject/login.php" method="post">
            <div class="form-group">
                <label for="username">Username</label>
                <input type="text" class="form-control" id="username" name="username" aria-describedby="emailHelp">
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" class="form-control" id="password" name="password">
            </div>
            <button type="submit" class="btn btn-primary">Login</button>
        </form>
    </div>

    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
  </body>
</html>
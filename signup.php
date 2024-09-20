<!-- PHP SCRIPT -->
<?php

$showAlert = false;
$showError = false;

if($_SERVER['REQUEST_METHOD'] == "POST"){

  // including db connection php script
  include 'partials/_dbconnect.php';

  $username = $_POST["username"];
  $password = $_POST["password"];
  $confirmpassword = $_POST["confirmpassword"];

  // if username already exists in db, tell user to create a new username
  // $exists = false;
  $existsSql = "SELECT * FROM `users` WHERE username='$username'";

  $result = mysqli_query($conn, $existsSql);

  $numExistRows = mysqli_num_rows($result);
  if($numExistRows > 0){
    // $exists = true;
    $showError = "Username already exists!";
  }
  else{
    // $exists = false;

    // validating form fields
    if(($password == $confirmpassword)){
      
      // while signup, you hash the password created by user for enhanced security 
      // this needs upto 255 characters storage space
      $hash = password_hash($password, PASSWORD_DEFAULT);

      // serial no is auto incremented, so no need to have it in the query
      // store hash value of password in db
      $sql = "INSERT INTO `users` (`username`, `password`, `date`) VALUES ('$username', '$hash', current_timestamp())";

      $result = mysqli_query($conn, $sql);

      if($result){
        $showAlert = true;
      }
    }
    else{
      $showError = "Passwords do not match!";
    }
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

    <title>Signup</title>
  </head>
  <body>
    <!-- ADDING NAVBAR -->
    <?php require "partials/_nav.php" ?>

    <!-- SUCCESS ALERT -->
    <?php
    if($showAlert){
      echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
              <strong>Success!</strong> New account created. Login to continue!
              <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>';
    }
    if($showError){
      echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
              <strong>Oops!</strong> ' . $showError . '
              <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>';
    }
    ?>

    <div class="container my-4">
        <h4 class="text-center">Signup and Create you account</h4>

        <!-- SIGNUP FORM -->
        <form action="/PHP_PROJECTS/LoginSystemPHPProject/signup.php" method="post">
            <div class="form-group">
                <label for="username">Username</label>
                <input type="text" maxlength="11" class="form-control" id="username" name="username" aria-describedby="emailHelp">
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" maxlength="23" class="form-control" id="password" name="password">
            </div>
            <div class="form-group">
                <label for="confirmpassword">Confirm Password</label>
                <input type="password" class="form-control" id="confirmpassword" name="confirmpassword">
                <small id="emailHelp" class="form-text text-muted">Your password is safe with us</small>
            </div>
            <button type="submit" class="btn btn-primary">Signup</button>
        </form>
    </div>

    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
  </body>
</html>
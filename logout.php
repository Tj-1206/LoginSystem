<?php

// starting the session
session_start();

// frees all the variables currently registered
// returns true on success, false on failure
session_unset();

// destroying the session
session_destroy();

// redirecting to login page
header("location: login.php");

exit();

?>
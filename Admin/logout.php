<?php 
session_start(); // Resume the session
session_unset(); // Unset the data from the session
session_destroy(); // Destroy the session
header('location:index.php'); // Redirect to Login Page
exit();
?>
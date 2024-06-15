<?php 
//Authorization - Access Control
//Check whether the user is logged in or not
if(!isset($_SESSION['user'])) //If user session is not set
{
//User Is Not Logged In
//Redirect to login page with message
$_SESSION['no-login-message'] = "<div class='error text-center'>Please Log In To Access Admin Panel.</div>";
//Redirect to login page
header('location:'.SITEURL.'admin/login.php');
}

?>
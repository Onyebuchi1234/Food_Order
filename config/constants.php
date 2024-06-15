<?php 

//Start Session
session_start();

//Create constants to store non repeating values. Constants are named with capital letter while variable are names with small letter
define('SITEURL', 'http://localhost/Food_Order/');
define('LOCALHOST', 'localhost');
define('USERNAME', 'root');
define('PASSWORD', '');
define('DB_NAME', 'food_order_system');


 $servername = "localhost";
 $username = "root";
 $password = "";
 $db_name = "food_order_system";

 // Create connection
 $conn = mysqli_connect($servername, $username, $password, $db_name);

 // Check connection
 if (!$conn) {
 die("Connection failed: " . mysqli_connect_error());
 }
 // echo "Connected successfully";

?>
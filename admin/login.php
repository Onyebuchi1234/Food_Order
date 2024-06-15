<?php include('../config/constants.php'); ?>
<html>
    <head>
        <title>Login - Food Order System</title>
        <link rel="stylesheet" href="../css/admin.css">
    </head>

    <body class="bb">
        <div class="login"><br>
            <h1 class="text-center">Login</h1>
            <br>

            <?php
            if(isset($_SESSION['login'])){
                echo $_SESSION['login'];
                unset($_SESSION['login']);
            }

            if(isset($_SESSION['no-login-message'])){
                echo $_SESSION['no-login-message'];
                unset($_SESSION['no-login-message']);
            }
            
            
            ?>
            <br>

            <!-- Login form starts here -->
            <form action="" method="POST" class="text-center" >
            <label for="username">Username:</label><br><br>
            <input type="text" name="username" id="username" placeholder="Enter Your Username..."><br><br>

            <label for="password">Password:</label><br><br>
            <input type="password" name="password" id="password" placeholder="Enter Your Password..."><br><br>

            <input type="submit" name="submit" value="Login" class="btn-tertiary">
            <br><br>
            </form>
            <!-- login form ends here -->
            <p class="text-centers" >Created By - <a href="https://mail.google.com/mail/u/0/#inbox">Onyebuchi Okameme</a></p>
        </div>
    </body>
</html>

<?php
//Check whether the submit button is clicked or not
if(isset($_POST['submit'])){
    //Process for login
    //1. Get the data from login form
    //  $username=$_POST['username'];
    $username=mysqli_real_escape_string($conn, $_POST['username']);
    // $password=md5($_POST['password']);
    $raw_password=md5($_POST['password']);
    $password = mysqli_real_escape_string($conn, $raw_password);

     //2. SQL To Check whether the username and password exists or not
     $sql ="SELECT * F)ROM tbl_admin WHERE username='$username' AND password='$password'"; 

     //Execute the query
     $res = mysqli_query($conn, $sql);

     //4. Count rows to check whether the user exists or not
     $count = mysqli_num_rows($res);

     if($count==1){
        //User available and login success
        $_SESSION['login'] = "<div class='success'>Login Successful.</div>";
        $_SESSION['user'] = $username; //To check whether the user is logged in or not and log out will unset it
        
        //Redirect to home page/ Dashboard
        header('location:'.SITEURL.'admin/');

     }
     else{
        //User not available
        $_SESSION['login'] = "<div class='error text-center'>Username Or Password Did Not Match.</div>";
        //Redirect to home page/ Dashboard
        header('location:'.SITEURL.'admin/login.php');
     }
}



?>
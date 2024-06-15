<?php
//Include constants.php file here
include('../config/constants.php');

//1. Get the ID of the admin to be deleted
echo $id=$_GET['id'];

//2. Create sql query to delete admin
$sql = "DELETE FROM tbl_admin WHERE id=$id";

//Execute the query
$res=mysqli_query($conn, $sql);

//Check whether the query executed successfully
if($res==true){
    //Query Executed Successfully And Admin Deleted
    //echo "Admin Deleted";

    //Create session variable to display message
    $_SESSION['delete'] = "<div class='success'>Admin Deleted Successfully.</div>";
    //Redirect to Manage Admin Page
    header('location:'.SITEURL.'admin/manage-admin.php');
}
else{
    //Failed to delete admin
   // echo "Failed To Delete Admin";

   $_SESSION['delete'] = "<div class='error'>Failed To Delete Admin Try Again Later.</div>";
    //Redirect to Manage Admin Page
    header('location:'.SITEURL.'admin/manage-admin.php');
}

//3. Redirect to manage admin page with message and the message can be either success or error



?>
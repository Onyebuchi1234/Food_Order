<?php
//Include constants page
include('../config/constants.php');
//echo "Delete Food Name";

if(isset($_GET['id']) && isset($_GET['image_name'])){
    //Process to delete
    //echo "Process To Delete";

    //1. Get id and image name
    $id = $_GET['id'];
    $image_name = $_GET['image_name'];

    //2. Remove the image if available
    //Check whether image is available or not and delete
    if($image_name != ""){
        //It has image and need to be removed from folder
        //Get the image path
        $path = "../images/food/".$image_name;

        //Remove the file from folder
        $remove = unlink($path);

        //Check whether the image is removed
        if($remove==false){
            //Failed To Remove Image
            $_SESSION['upload'] = "<div class='error'>Failed To Remove Image File.</div>";
            //Redirect to manage food
            header('location:'.SITEURL.'admin/manage-food.php');
            //Stop the process of deleting food
            die();
        }
    }
    //3. Delte food from dbase
    $sql = "DELETE FROM tbl_food WHERE id=$id";
    //Execute the query
    $res = mysqli_query($conn, $sql);

    //Check whether the query executed or not and set the session message respectively
     //4. Redirect to manage-food with error message
    if($res==true){
        //Food Deleted
        $_SESSION['delete'] = "<div class='success'>Food Deleted Successfully.</div>";
        header('location:'.SITEURL.'admin/manage-food.php');
    }
    else{
        //Failed To Delete Food
        $_SESSION['unauthorize'] = "<div class='error'>Failed To Delete Food.</div>";
        header('location:'.SITEURL.'admin/manage-food.php');
    }

}
else{
    //Redirect to manage food page
    //echo "REDIRECT";
    $_SESSION['delete'] = "<div class='error'>Unauthorized Access.</div>";
    header('location:'.SITEURL.'admin/manage-food.php');
}
?>
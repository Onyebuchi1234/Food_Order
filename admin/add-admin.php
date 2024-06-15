<?php include('partials/menu.php'); ?>

<div class="main-content">
        <div class="wrapper">
        <h1>Add Admin</h1>
<br><br>
 
        <?php 
        if(isset($_SESSION['add'])){
            echo $_SESSION['add'];
            unset($_SESSION['add']);
        }
        
        
        ?>

        <form action="" method="POST">
            <table class="tbl-30">

                <tr>
                    <td>Full Name: </td>
                    <td><input type="text" id="full_name" name="full_name" placeholder="Enter Your Full-Name..." required></td>

                </tr>

                <tr>
                    <td>Username: </td>
                    <td><input type="text" id="username" name="username"  placeholder="Enter Your Username..." required></td>
                </tr>

                <tr>
                    <td>Password: </td>
                    <td><input type="password" name="password" placeholder="Enter Your Password..." required></td>
                </tr>

                <tr>
                    <td colspan="2">
                        <input type="submit" name="submit" value="Add Admin" class="btn-secondary" >
                    </td>
                </tr>
            </table>
        </form>
    
</div>
</div>



<?php include('partials/footer.php'); ?>

<?php 
//Process the value from form and save it in database
//Check whether the button is clicked or not
if(isset($_POST['submit'])){
    //Button Clicked
    // echo "Button Clicked";

    //1. Get the data from form
    $full_name =mysqli_real_escape_string($_POST['full_name']);
    $username = mysqli_real_escape_string($_POST['username']);
    $password = md5($_POST['password']); //Password Encryption with md5

    //2. Sql query to save the data into database
    $sql = "INSERT INTO tbl_admin SET 
    full_name = '$full_name',
    username = '$username',
    password = '$password'
    ";
    

    //3. Executing query and saving data in database
    $res = mysqli_query($conn, $sql) or die(mysqli_error());

    //4. Check whether the (Query is executed) data is inserted or not and display appropriate message
    if($res==TRUE){
        //Data inserted
        //echo "Data Inserted";
        //Create A session variable to display message$
        $_SESSION['add'] ="<div class='success'>Admin Added Successfully.</div>";
        //Redirect Page to manage admin
        header("location:".SITEURL.'admin/manage-admin.php');
    }
    else{
        //Failed to insert data
        //echo "Failed to insert data";
         //Create A session variable to display message$
         $_SESSION['add'] = "<div class='error'>Failed To Add Admin.</div>";
         //Redirect Page to Add admin
         header("location:".SITEURL.'admin/add-admin.php');
    }
}


?>
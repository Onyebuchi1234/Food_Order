<?php include('partials/menu.php'); ?>

        <!-- Main Section Starts here -->
        <div class="main-content">
        <div class="wrapper">
        <h1>Add Category</h1>

        

        <?php
        if(isset($_SESSION['add'])){
            echo $_SESSION['add'];
            unset($_SESSION['add']);
        }

        if(isset($_SESSION['upload'])){
            echo $_SESSION['upload'];
            unset($_SESSION['upload']);
        }
        
        ?>
        <br><br>

        <!-- Add category form, enctype is used to upload file or image  --> 
        <form action="" method="POST" enctype="multipart/form-data">
        <table class="tbl-30">
        <tr>
                    <td>Title: </td>
                    <td><input type="text" id="full_name" name="title" placeholder="Category Title..."></td>

                </tr>

                <tr>
                <td>Select Image: </td>
                <td><input type="file" name="image"></td>
                </tr>

                <tr>
                    <td>Featured: </td>
                    <td>
                        <input type="radio" name="featured" value="Yes">Yes
                        <input type="radio" name="featured" value="No" >No
                </td>
                </tr>

                <tr>
                    <td>Active: </td>
                    <td><input type="radio" name="active" value="Yes">Yes
                    <input type="radio" name="active" value="No" >No
                </td>
                </tr>

                <tr>
                    <td colspan="2">
                        <input type="submit" name="submit" value="Add Category" class="btn-secondary" >
                    </td>
                </tr>
        </table>
        </form>
        <!-- Add category form ends -->

        <?php
        //Check whether the submit button is clicked or not
        if(isset($_POST['submit'])){
            // echo "Clicked";

            //1. Get the value from the form
            $title = $_POST['title'];


            //For radio input type, we need to check whether the button is selected or not
            if(isset($_POST['featured'])){
                //Get the value from form else set the default value
                $featured = $_POST['featured'];
            }
            else{
                //Set default value
                $featured = "No";
            }

            if(isset($_POST['active'])){
                $active=$_POST['active'];
            }
            else{
                $active="No";
            }

            //Check whether image is selected or not and set the value for the image accordingly
            //print_r($_FILES['image']); //Print_r would display the value of array

            //Break the code here
           // die();

           if(isset($_FILES['image']['name'])){
                //Upload the image
                //To upload image we need image name, source path and destination path
                $image_name=$_FILES['image']['name'];

                //Upload Image Only If Image Is Selected
                if($image_name!=""){  

                //Auto rename image
                //Get the extension of our image (jpg, png etc) e.g "food1.jpg"
                $ext = end(explode('.', $image_name));

                //Rename image
                $image_name = "Food_Category_".rand(000, 999).'.'.$ext; //e.g Food_Category_834.jpg

                $source_path=$_FILES['image']['tmp_name'];

                $destination_path="../images/category/".$image_name;

                //Finally upload image
                $upload = move_uploaded_file($source_path, $destination_path);

                //Check whether the image is uploaded or not
                //And if the image is not uploaded then we will stop the process and redirect with error message
                if($upload==false){
                    //Set Message
                    $_SESSION['upload'] = "<div class='error'>Failed To Upload Image.</div>";
                    //Redirect to add category page
                    header('location:'.SITEURL.'admin/add-category.php');
                    //Stop the process
                    die();
                }
                else{
                    $_SESSION['upload'] = "<div class='success'>Image Uploaded.</div>";
                    //Redirect to manage category page
                    header('location:'.SITEURL.'admin/manage-category.php');
                    //Stop the process
                    die();
                }

            }

           }
           else{
            //Don't upload the image and set the image name value as blank
            $image_name="";
           }


            //2. Create SQL query to insert category into dbase
            $sql = "INSERT INTO tbl_category SET 
            title='$title',
            image_name='$image_name',
            featured='$featured',
            active='$active'
            ";

            //Execute the query and save in database
            $res = mysqli_query($conn, $sql);

            //Check whether the query executed or not and data added or not
            if($res==true){
                //Query executed and Category Added
                $_SESSION['add'] = "<div class='success'>Category Added Successfully.</div>";
                //Redirect to manage category page
                header('location:'.SITEURL.'admin/manage-category.php');
            }
            else{
                //Failed To Add Category 
                $_SESSION['add'] = "<div class='error'>Failed To Add Category .</div>";
                //Redirect to manage category page
                header('location:'.SITEURL.'admin/manages-category.php');
            }

        }
        
        
        ?>




        <!-- Add category form ends -->
        <!-- Footer Section Starts here -->
        <div class="footers">
        <div class="wrapper">
        <p class="text-center">2024 GFCL Project. All rights reserved, Buchi's Restaurant. Developed By - 
            <a href="https://mail.google.com/mail/u/0/#inbox"> Okameme Onyebuchi</a></p>
        </div>
        </div>
        <!-- Footer Section Ends Here -->


    </body>

</html>
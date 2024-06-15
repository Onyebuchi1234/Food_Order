<?php include('partials/menu.php'); ?>

<?php 
//Check whether id is set or not
if(isset($_GET['id'])){
    //Get the ID and all other details
    //echo "Getting The Data";
    $id = $_GET['id'];
    //Create SQL query to get all other details
    $sql2 = "SELECT * FROM tbl_food WHERE id=$id";

    //Execute the query
    $res2 = mysqli_query($conn, $sql2);

    //Count the rows to check whether the id is valid or not
    $count = mysqli_num_rows($res2);

    if($count==1){
        //Get all the data
        $row = mysqli_fetch_assoc($res2);
        $title = $row['title'];
        $description = $row['description'];
        $current_image = $row['image_name'];
        
        $featured = $row['featured'];
        $active = $row['active'];
    }
    else{
        //Redirect to Manage Food Page with session message
        $_SESSION['food-not-updated'] = "<div class='error'>Food Not Updated.</div>";
        header('location:'.SITEURL.'admin/manage-food.php');
    }
}
else{
    //Redirect to Manage Food
    header('location:'.SITEURL.'admin/manage-food.php');
}



?>
<div class="main-content">
    <div class="wrapper">
    <h1>Update Food</h1>

    <br>
    <form action="" method="POST" enctype="multipart/form-data">
        <table class="tbl-30">

        <tr>
            <td>Title: </td>
            <td>
                <input type="text" name="title" value="<?php echo $title; ?>" id="full_name" placeholder="Food Title Goes Here..." >
            </td>
        </tr>

        <tr>
            <td>Description:</td>
            <td>
            <textarea name="description" cols="30" row="5"><?php echo $description; ?></textarea>
            </td>
        </tr>

        <tr>
            <td>Price: </td>
            <td>
                <input type="number" name="price" value="<?php echo $price; ?>" id="full_name">
            </td>
        </tr>

        <tr>
            <td>Current Image: </td>
            <td>
                <?php
                if($current_image == ""){
                    //Image not available
                    echo "<div class='error'>Image Not Available.</div>";
                }
                else{
                    //Image available
                    ?>
                    <img src="<?php echo SITEURL; ?>images/food/<?php echo $current_image; ?>" alt="Food Image">
                    <?php
                }
                
                
                ?>
            </td>
        </tr>

        <tr>
            <td>Select New Image: </td>
            <td>
                <input type="file" name="image_name">
            </td>
        </tr>

        <tr>
            <td>Category: </td>
            <td>
                <select name="category" id="full_name">
                    <?php
                    //Query to Get Active Categories
                    $sql = "SELECT * FROM tbl_category WHERE active='Yes' AND featured='Yes'";

                    //Execute the query
                    $res = mysqli_query($conn, $sql);

                    //Count rows
                    $count = mysqli_num_rows($res);

                    //Check whether category available or not
                    if($count>0){
                        //Category Available
                        while($row=mysqli_fetch_assoc($res)){
                            $category_title = $row['title'];
                            $category_id = $row['id'];
                            ?>
                            <option <?php if($current_image==$category_id){echo "selected";}?>value="<?php echo $category_id;?>"><?php echo $category_title;?></option>
                            <?php
                        }
                    }
                    else{
                        //Category Not Available
                        echo "<option value='0'>Category Not Available</option>";
                    }
                    
                    ?>
                    <option value="0">Text Category</option>
                </select>
            </td>
        </tr>

        <tr>
            <td>Featured: </td>
            <td>
                <input <?php if($featured=="Yes") {echo "checked";} ?> type="radio" name="featured" value="Yes">Yes
                <input <?php if($featured=="No") {echo "checked";} ?> type="radio" name="featured" value="No">No
            </td>
        </tr>

        <tr>
            <td>Active: </td>
            <td>
            <input <?php if($active=="Yes") {echo "checked";} ?> type="radio" name="active" value="Yes">Yes
            <input <?php if($active=="No") {echo "checked";} ?> type="radio" name="active" value="No">No
            </td>
        </tr>

        <tr>
            <td colspan="2">
            <input type="hidden" name="id" value="<?php echo $id; ?>">
            <input type="hidden" name="current_image" value="<?php echo $current_image;?>">

            <input type="submit" name="submit" value="Update Food" class="btn-secondary" >
            </td>
            </tr>

        </table>

    </form>

    <?php
    //1. Check whether button is clicked or not
    if(isset($_POST['submit'])){
        //echo "Button Clicked";
        //1. Get all the details from the form
        $id = $_POST['id'];
        $title = $_POST['title'];
        $description = $_POST['description'];
        $price = $_POST['price'];
        $current_image = $_POST['current_image'];
        $category = $_POST['category'];
        $featured = $_POST['featured'];
        $active = $_POST['active'];

        //2. Upload the image if selected

        //Check whether the upload button is clicked or not
        if(isset($_FILES['image']['name'])){
            //Upload Button Clicked
            $image_name = $_FILES['image']['name']; //New image name

            //Check whether the file is available or not
            if($image_name!=""){
                //Image Is Available
                //A. Uploaded new image

                //Rename the image
                $ext = end(explode('.', $image_name)); //Get the extension of the image
                $image_name = "Food-Name-".rand(0000, 9999).'.'.$ext; //This would be renamed image

                //Get the source path and destination path
                $src_path = $_FILES['image']['tmp_name']; //Source path
                $dest_path = "../images/food/".$image_name; //Destination path

                //Upload the image
                $upload = move_uploaded_file($src_path, $dest_path);

                //Check whether the image is uploaded or not
                if($upload==false){
                    //Failed to upload
                    $_SESSION['upload'] = "<div class='error'>Failed To Upload New Image</div>";
                    //Redirect to manage food page
                    header('location:'.SITEURL.'admin/manage-food.php');

                    //Stop the process
                    die();
                }
                 //3. Remove the image if no image is uploaded and current image exists
                //B. Remove current image if available

                if($current_image!=""){
                    //Current Image Is Available
                    //Remove the image if available
                    $remove_path = "../images/food/".$current_image;

                    $remove = unlink($remove_path);
                    //Check whether the image is removed or not
                    if($remove==false){
                        //Failed to remove current image
                        $_SESSION['remove-failed'] = "<div class='error'>Failed To Remove Current Image.</div>";

                        //Redirect to manage-food
                        header('location:'.SITEURL.'admin/manage-food.php');
                        //stop the process
                        die();
                    }
                }
            }
            else{
                $image_name = $current_image; //Default image when image is not selected
            }
        }
        
        else{
            $image_name = $current_image; //Default image when button is not clicked
        }

        //4. Update the food in database
        $sql3 = "UPDATE tbl_food SET
        title = '$title',
        description = '$description',
        price = $price,
        image_name = '$image_name',
        category_id = '$category',
        featured = '$featured',
        active = '$active'
        WHERE id=$id
        ";

        //Execute the sql query
        $res3 = mysqli_query($conn, $sql3);

        //Check whether the query is executed or not
        if($res3==true){
            //Query executed and food update
            $_SESSION['update'] = "<div class='success'>Food Updated Successfully.</div>";
            header('location:'.SITEURL.'admin/manage-food.php');
        }
        else{
            //Failed to upload food.
            $_SESSION['update'] = "<div class='error'>Failed To Update Food.</div>";
            header('location:'.SITEURL.'admin/manage-food.php');
        }

        //Finally redirect food with session message
    }
    
    ?>

    </div>
</div>

 <?php include('partials/footer.php'); ?>
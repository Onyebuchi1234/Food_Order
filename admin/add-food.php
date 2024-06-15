<?php
ob_start(); // Start output buffering
include('partials/menu.php');
?>

<div class="main-content">
    <div class="wrapper">
        <h1>Add Food</h1>
        <br><br> 

        <?php
        if (isset($_SESSION['upload'])) {
            echo $_SESSION['upload'];
            unset($_SESSION['upload']);
        }
        if (isset($_SESSION['add'])) {
            echo $_SESSION['add'];
            unset($_SESSION['add']);
        }
        ?>

        <form action="" method="POST" enctype="multipart/form-data">
            <table class="tbl-30">
                <tr>
                    <td>Title: </td>
                    <td>
                        <input type="text" name="title" placeholder="Food Title Goes Here...">
                    </td>
                </tr>
                <tr>
                    <td>Description:</td>
                    <td>
                        <textarea name="description" cols="30" rows="5" placeholder="Description Of The Food..."></textarea>
                    </td>
                </tr>
                <tr>
                    <td>Price: </td>
                    <td>
                        <input type="number" name="price">
                    </td>
                </tr>
                <tr>
                    <td>Select Image: </td>
                    <td>
                        <input type="file" name="image">
                    </td>
                </tr>
                <tr>
                    <td>Category: </td>
                    <td>
                        <select name="category">
                            <?php
                            // Create SQL query to get all active categories from database
                            $sql = "SELECT * FROM tbl_category WHERE active='Yes'";
                            $res = mysqli_query($conn, $sql);
                            $count = mysqli_num_rows($res);

                            // Check whether we have categories or not
                            if ($count>0) {
                                // We have categories
                                while ($row = mysqli_fetch_assoc($res)) {
                                    $id = $row['id'];
                                    $title = $row['title'];
                                    ?>
                                    <option value="<?php echo $id; ?>"><?php echo $title; ?></option>
                                    <?php
                                }
                            } else {
                                ?>
                                <option value="0">No Category Found</option>
                                <?php
                            }
                            ?>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td>Featured: </td>
                    <td>
                        <input type="radio" name="featured" value="Yes"> Yes
                        <input type="radio" name="featured" value="No"> No
                    </td>
                </tr>
                <tr>
                    <td>Active: </td>
                    <td>
                        <input type="radio" name="active" value="Yes"> Yes
                        <input type="radio" name="active" value="No"> No
                    </td>
                </tr>
                <tr>
                    <td colspan="2">
                        <input type="submit" name="submit" value="Add Food" class="btn-secondary">
                    </td>
                </tr>
            </table>
        </form>

        <?php
        // Check whether the form is submitted or not
        if (isset($_POST['submit'])) {
            // Get the data from form
            $title = mysqli_real_escape_string($conn, $_POST['title']);
            $description = mysqli_real_escape_string($conn, $_POST['description']);
            $price = mysqli_real_escape_string($conn, $_POST['price']);
            $category = mysqli_real_escape_string($conn, $_POST['category']);
            $featured = isset($_POST['featured']) ? mysqli_real_escape_string($conn, $_POST['featured']) : "No";
            $active = isset($_POST['active']) ? mysqli_real_escape_string($conn, $_POST['active']) : "No";

// Image upload handling
if (isset($_FILES['image']['name']) && $_FILES['image']['name'] != "") {
    $image_name = $_FILES['image']['name'];
    $ext = pathinfo($image_name, PATHINFO_EXTENSION);
    $image_name = "Food-Name-" . rand(0000, 9999) . "." . $ext;
    $src = $_FILES['image']['tmp_name'];
    $dst = "../images/food/" . $image_name;

    if (!move_uploaded_file($src, $dst)) {
        $_SESSION['upload'] = "<div class='error'>Failed to Upload Image: " . $_FILES['image']['error'] . "</div>";
        header('location:' . SITEURL . 'admin/add-food.php');
        exit();
    }
} else {
    $image_name = "";
}



            // Insert into database
            $sql2 = "INSERT INTO tbl_food SET
                title = '$title',
                description = '$description',
                price = $price,
                image_name = '$image_name',
                category_id = $category,
                featured = '$featured',
                active = '$active'
            ";

            // Execute query
            $res2 = mysqli_query($conn, $sql2);

            // Check whether data inserted or not
            if ($res2 == true) {
                $_SESSION['add'] = "<div class='success'>Food Added Successfully.</div>";
                header('location:'.SITEURL.'admin/manage-food.php');
            } else {
                $_SESSION['add'] = "<div class='error'>Failed to Add Food.</div>";
                header('location:'.SITEURL.'admin/add-food.php');
            }
        }
        ?>
    </div>
</div>

<?php
include('partials/footer.php');
ob_end_flush(); // Flush the output buffer and end buffering
?>

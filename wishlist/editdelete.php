<?php 
    session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
<link rel="stylesheet" href="../homestyle.css">
<link rel="stylesheet" href="/healthtea/style/editdelete.css">
<link rel="stylesheet" href="/healthtea/style/addeditlisting.css">
        <!-- logo beside the title -->
        <link rel="tab logo icon" href="/healthtea/images/1.png" type="image/x-icon">
        <!-- for house and people icon -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" 
        integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" 
        crossorigin="anonymous" referrerpolicy="no-referrer" />
        <title>HealthTea | Listing</title>
</head>
<body>
<?php 
    include('../include/header.php');
    include('../db_connection.php');
    // from order.php
    if(isset($_POST['orderreceived'])){
        $result = mysqli_query($conn,"UPDATE orders SET is_received=1 WHERE order_id='{$_POST['order_id']}'");
        if($result){
            echo "<script>alert('Thank you for buying for us, hope to see u next time 😉');";
            echo "window.location.href='/healthtea/order'</script>";
        }
    }
    elseif(isset($_POST['deleteorder'])){
        $result = mysqli_query($conn,"DELETE FROM order_item WHERE order_id='{$_POST['order_id']}'");
        if($result){
            $result2 = mysqli_query($conn,"DELETE FROM orders WHERE order_id='{$_POST['order_id']}'");
            if($result2){
                echo "<script>alert('Order deleted, hope to see u next time');";
                echo "window.location.href='/healthtea/order'</script>";
            }
        }
    }
    // from wishlist.php
    elseif(isset($_GET['id'])){
        //user wish to edit order
        if($_GET['action'] == 'edit'){
            $result = mysqli_query($conn,"SELECT wishlistquantity FROM wishlist WHERE id='{$_GET['id']}'");
            $row = mysqli_fetch_assoc($result);
            ?>
            <!-- Send form to below elseif statement -->
			<form class="edit-quantity-container" action="editdelete.php" method='post'>
				<h2>Edit Order Quantity</h2>
				<p>Enter the quantity that you desire:</p>
				<div class="row">
					<label for="quantityentered">Quantity:</label>
					<input type="number" name='quantityentered' value='<?php echo $row['wishlistquantity'] ?>'>
					<input type="hidden" name='id' value='<?php echo $_GET['id'] ?>'>
					<input type="submit" name='editquantity' value='Edit'>
				</div>
			</form>
        <?php
        }
        elseif($_GET['action'] == 'delete'){
            if(mysqli_query($conn,"DELETE FROM wishlist WHERE id={$_GET['id']}")){
                echo "<script>alert('Delete successfully.')</script>";
                echo "<script>window.location.href='index.php'</script>";
            }
        }
    }
    // from above elseif statement
    elseif (isset($_POST['editquantity'])){
        $result = mysqli_query($conn,"UPDATE wishlist SET wishlistquantity={$_POST['quantityentered']} WHERE id='{$_POST['id']}'");
        if($result){
            echo "<script>alert('Update successful!!!');";
            echo "window.location.href='index.php'</script>";
        }
    }
    // from listingproductpage when admin add new product.
    elseif (isset($_GET['add'])){   ?>
      <form class="edit-form-container" action="editdelete.php" method='post' enctype='multipart/form-data' name='addproductform' onsubmit='return validateform()'>
        <label for="photo">Select photo:</label><br>
        <input type="file" name='photo' required><br><br>
        <label for="prod_name">Product Name:</label><br>
        <input type="text" name='prod_name' required><br><br>
        <label for="prod_desc">Product Description:</label><br>
        <input type="text" name='prod_desc' required><br><br>
        <label for="prod_price">Price:</label><br>
        <input type="text" name='prod_price' required><br><br>
        <input type="submit" name='addproduct' value='Add Product'>
      </form>
    <?php  
    }

    elseif (isset($_POST['addproduct'])){
        $prod_name = $_POST['prod_name'];
        $filename = $_FILES['photo']['name'];
        $fileExtension = pathinfo($filename, PATHINFO_EXTENSION);
        $newFilename = $prod_name . '.' . $fileExtension;
        $uploadDirectory = '../images/';
        $uploadPath = $uploadDirectory . $newFilename;
        if (move_uploaded_file($_FILES['photo']['tmp_name'], $uploadPath)) {
            if(mysqli_query($conn,"INSERT INTO productlist(prod_name,prod_desc,prod_price) VALUES ('{$_POST['prod_name']}','{$_POST['prod_desc']}',
                {$_POST['prod_price']})")){
                echo "<script>alert('File uploaded successfully.'); window.location.href='/healthtea/listing_product_page'</script>";
            }
        }
        else {
            echo "<script>alert('Error uploading file.'); window.location.href='/healthtea/listing_product_page'</script>";
        }
    }
    // from listingproductpage when admin edit product.
    elseif(isset($_GET['edit'])){
        $result=mysqli_query($conn,"SELECT * FROM productlist WHERE prod_id={$_GET['prod_id']}"); 
        while($row=mysqli_fetch_assoc($result)){
        ?>
        <form class="edit-form-container" action="editdelete.php" method='post' name='editproductform' enctype='multipart/form-data' 
            onsubmit='return validatePrice()'>
            <label for="prodName">Product Name:</label><br>
            <input type="text" name='prodName' value= '<?php echo $row['prod_name']?>' required><br><br>
            <label for="prodDesc">Product Description:</label><br>
            <textarea name='prodDesc' required><?php echo $row['prod_desc']?></textarea><br><br>
            <label for="prodPrice">Product Price:</label><br>
            <input type="text" name='prodPrice' value= '<?php echo $row['prod_price']?>' required><br><br>
            <input type="checkbox" name='newpic' id='newpic'>
            <label for="newpic"> Add new Picture</label><br><br>
            <!-- Only show if new pic checkbox is checked -->
            <div id='NewPicDiv' style='display:none'>
                <label for="newpicinput">Choose new jpg / jpeg file:</label>
                <input type="file" name='newpicinput' id='newpicinput'>
            </div>
            <input type="hidden" name='prod_id' value='<?php echo $_GET["prod_id"] ?>'>
            <input type="submit" name='editproduct' value='Edit Product'>
        </form>
    <?php }}

    elseif(isset($_POST['editproduct'])){
        $result1 = mysqli_query($conn,"SELECT prod_name FROM productlist WHERE prod_id={$_POST['prod_id']}");
        if($row1 = mysqli_fetch_assoc($result1)){
            if (isset($_FILES['newpicinput']) && $_FILES['newpicinput']['error'] === UPLOAD_ERR_OK) {

                // take new pic original name to find its extension and name this new pic with product name.
                $newPicOriName = $_FILES['newpicinput']['name'];
                $PicExtension = pathinfo($newPicOriName, PATHINFO_EXTENSION);
                $newPicName = $_POST['prodName']. "." .$PicExtension;
    
                $newPicPath = '../images/'. $newPicName;
                $oldPicPathjpg = '../images/'. $row1['prod_name'].'.jpg';
                $oldPicPathjpeg = '../images/'. $row1['prod_name'].'.jpeg';
    
                // Delete the original photo (if it exists)
                if (file_exists($oldPicPathjpg)) {
                    unlink($oldPicPathjpg);
                    echo "<script>alert('Delete old photo successful.');</script>";
                }
                elseif(file_exists($oldPicPathjpeg)) {
                    unlink($oldPicPathjpeg);
                    echo "<script>alert('Delete old photo successful.');</script>";
                }
    
                // Move the uploaded file to the desired location with the new filename
                move_uploaded_file($_FILES['newpicinput']['tmp_name'], $newPicPath);
                $result2 = mysqli_query($conn,"UPDATE productlist SET prod_name='{$_POST['prodName']}', prod_desc='{$_POST['prodDesc']}', prod_price={$_POST['prodPrice']} WHERE prod_id={$_POST['prod_id']}");
                if ($result2){
                    echo "<script>alert('Edit successful.'); window.location.href='/healthtea/listing_product_page';</script>";
                } else{
                    echo "Error: " . mysqli_error($conn);
                }
            } 
            else {
                // No new photo uploaded, change the name of the original photo (if it exists)
                $oldPicPathjpg = '../images/'. $row1['prod_name'].'.jpg';
                $oldPicPathjpeg = '../images/'. $row1['prod_name'].'.jpeg';
                if (file_exists($oldPicPathjpg)) {
                    $newPicName = $_POST['prodName'].'.jpg'; // Set the desired name for the photo
                    $newPicPath = '../images/' . $newPicName; // Specify the desired location
                    // Rename the original photo to the new filename
                    if(rename($oldPicPathjpg, $newPicPath)){
                        $result2 = mysqli_query($conn,"UPDATE productlist SET prod_name='{$_POST['prodName']}', prod_desc='{$_POST['prodDesc']}', prod_price={$_POST['prodPrice']} WHERE prod_id={$_POST['prod_id']}");
                        if ($result2){
                            echo "<script>alert('Edit successful.'); window.location.href='/healthtea/listing_product_page';</script>";
                        } else{
                            echo "Error: " . mysqli_error($conn);
                        }
                    }
                }
                elseif(file_exists($oldPicPathjpeg)) {
                    $newPicName = $_POST['prodName'].'.jpeg'; // Set the desired name for the photo
                    $newPicPath = '../images/' . $newPicName; // Specify the desired location
                    // Rename the original photo to the new filename
                    if(rename($oldPicPathjpeg, $newPicPath)){
                        $result2 = mysqli_query($conn,"UPDATE productlist SET prod_name='{$_POST['prodName']}', prod_desc='{$_POST['prodDesc']}', prod_price={$_POST['prodPrice']} WHERE prod_id={$_POST['prod_id']}");
                        if ($result2){
                            echo "<script>alert('Edit successful.'); window.location.href='/healthtea/listing_product_page';</script>";
                        } else{
                            echo "Error: " . mysqli_error($conn);
                        }
                    }
                }
            }    
        }
    }

    // from listingparoductpage when admin delete product.
    elseif(isset($_GET['delete'])){
        $result=mysqli_query($conn,"UPDATE productlist SET is_available=0 WHERE prod_id={$_GET['prod_id']}");
        if($result){
            echo "<script>alert('Hide from user successfully.'); window.location.href='/healthtea/listing_product_page'</script>";
        }
        else{
            echo "<script>alert('Hide from user failed.'); window.location.href='/healthtea/listing_product_page'</script>";
        }
    }
    elseif(isset($_GET['show'])){
        $result=mysqli_query($conn,"UPDATE productlist SET is_available=1 WHERE prod_id={$_GET['prod_id']}");
        if($result){
            echo "<script>alert('Show to user successfully.'); window.location.href='/healthtea/listing_product_page'</script>";
        }
        else{
            echo "<script>alert('Show to user failed.'); window.location.href='/healthtea/listing_product_page'</script>";
        }
    }
?>
    <?php include('../include/footer.php'); ?>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<script>

    $(document).ready(function(){
        var fileInput = $('#newpicinput');

        $('#newpic').change(function(){
            $('#newpic:checked').each(function(){
                $('#NewPicDiv').css('display','block');
                $('#newpicinput').prop('required',true);
            })
            $('#newpic:not(:checked)').each(function(){
                $('#NewPicDiv').css('display','none');
                $('#newpicinput').prop('required',false);
            })
        });
        fileInput.change(function() {
            var file = fileInput[0].files[0];
            var fileName = file.name.toLowerCase();
            if (!fileName.endsWith('.jpg') && !fileName.endsWith('.jpeg')) {
                alert('Please select a JPG or JPEG file.');
                fileInput.val('');
            }
        });
    })

    function validateform(){
        var prod_name = document.forms["addproductform"]["prod_name"].value;
        var prod_desc = document.forms["addproductform"]["prod_desc"].value;
        var prod_price = document.forms["addproductform"]["prod_price"].value;
        var photo = document.forms["addproductform"]["photo"].value;
        if (prod_name == "" || prod_desc == "" || prod_price == "" || photo == "") {
            alert("All fields are required!");
            return false;
        }
        if (isNaN(prod_price)) {
            alert("Price must be a numeric value");
            return false;
        }
        if (!/\.(jpg|jpeg)$/i.test(photo)) {
            alert("Photo must be in JPG or JPEG format");
            return false;
        }
        return true;
    }
    function validatePrice(){
        var prod__price=document.forms['editproductform']['prodPrice'].value;
        if(isNaN(prod__price)){
            alert("Price must be a numeric value");
            return false;
        }
        return true;
    }
</script>
<script src="app.js"></script>
</body>
</html>

<?php
    session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
<link rel="stylesheet" href="../homestyle.css">
<link rel="stylesheet" href="/healthtea/style/itemDetail.css">
        <!-- logo beside the title -->
        <link rel="tab logo icon" href="/healthtea/images/1.png" type="image/x-icon">
        <!-- for house and people icon -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
        <title>HealthTea | Item Details</title>
</head>
<body>    
    <?php 
    include('../include/header.php');
    include("../db_connection.php");
    if(isset($_POST['submit'])){
        $prod_id = $_POST['prod_id'];
        $quantity = $_POST['quantity'];
        $user_id = $_SESSION['username'];

        $result=mysqli_query($conn,"SELECT id FROM users WHERE username='{$_SESSION['username']}'");
        if($row = mysqli_fetch_assoc($result)){
            $user_id = $row['id'];
        }

        $sql="INSERT INTO wishlist(userid,wishlistitemid,wishlistquantity) VALUES ({$user_id},{$prod_id},{$quantity})";
        if(mysqli_query($conn,$sql)){
            echo "<script>alert('Added to your wishlist!!')</script>";
            echo "<script>window.location.href = 'index.php';</script>";

        }
        else{
            echo"Insert fail.";
        }
    }

    ?>
    
    <h1 style="padding:20px;">Product Detail</h1>
    <?php 
        include("../db_connection.php");

        if(isset($_GET['id'])) {
            if(!isset($_SESSION['loggedin'])){
                echo "<script>alert('You need to log in before buying the product.');";
                echo "window.location.href='/healthtea/login'</script>";
            }
            else{
                // Sanitize the ID to prevent SQL injection
                $item_id = mysqli_real_escape_string($conn, $_GET['id']);
            
                // Query to retrieve item details based on ID
                $sql = "SELECT * FROM productlist WHERE prod_id = '$item_id'";
                $result = mysqli_query($conn, $sql);
                $row= mysqli_fetch_assoc($result);
                echo "<img class=\"item_image\" src='../images/{$row['prod_name']}.jpg' 
                    onerror=\"this.src='../images/{$row['prod_name']}.jpeg'\" height=\"300px\">";
                // Output as HTML table
                if(mysqli_num_rows($result) > 0){
                    echo "<table class=\"product_detail_table\" border=\"1\">";
                    echo "<tr><th> ID </th><th> Name </th><th> Price(RM) </th><th>Description</th></tr>";
                    echo "<tr><td> {$row['prod_id']} </td><td> {$row['prod_name']} </td>";
                    echo "<td> {$row['prod_price']} </td><td>{$row['prod_desc']}</td></tr>";
                    echo"</table>";

                    echo "<form class=\"add_wishlist\" action ='itemdetailpage.php' method ='post'>";
                    echo "<input type ='hidden' name ='prod_id' value ='".$item_id."'>";
                     echo "<input type ='number' name ='quantity' min='1' value='1'>";
                    echo "<input type ='submit' name='submit' value='Add to wishlist'>";
                    echo "</form>";
                }
                else{
                    echo "<script>window.location.href = 'listing_product_page';</script>";

                }
            }
        }
        mysqli_close($conn);
    ?>

    <?php include('../include/footer.php'); ?>
    <script src="app.js"></script>
</body>
</html>

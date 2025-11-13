<?php 
    session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" href="../homestyle.css">
	<link rel="stylesheet" href="/healthtea/style/wishlist.css">
    <!-- logo beside the title -->
    <link rel="tab logo icon" href="/healthtea/images/1.png" type="image/x-icon">
    <!-- for house and people icon -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <title>HealthTea | Wishlist</title>
</head>
<body>
    <?php include('../include/header.php'); ?> 
    <h1 style="padding:30px;">Your Wishlist</h1>
    <?php 

        if(isset($_SESSION['username'])){
            include("../db_connection.php");
            $user_id = $_SESSION['username'];
            $total=0;
            $result=mysqli_query($conn,"SELECT id FROM users WHERE username='{$_SESSION['username']}'");
            if($row = mysqli_fetch_assoc($result)){
                $user_id = $row['id'];
            }            
            $result1 = mysqli_query($conn,"SELECT * FROM wishlist WHERE userid='{$user_id}'");

            echo"<form method='post' action='../listing_product_page/billing.php'>";
            // Output as HTML table
            if(mysqli_num_rows($result1) > 0){
                echo "<table class=\"product_table\">";
                echo "<tr><th>Image</th><th>Name</th><th>Unit Price(RM)</th><th>Quantity</th><th>Total Price(RM)</th><th colspan=2>Action</th></tr>";
                while ($row1 = mysqli_fetch_assoc($result1)){
                    $result2 = mysqli_query($conn,"SELECT * FROM productlist WHERE prod_id='{$row1['wishlistitemid']}'");
                    if($row2 = mysqli_fetch_assoc($result2)){
                        // Construct the image path with possible extensions: jpg, jpeg, png
                        $imagePathJPG = '../images/' . $row2['prod_name'] . '.jpg';
                        $imagePathJPEG = '../images/' . $row2['prod_name'] . '.jpeg';
                        
                        // Check if any of the image paths exist
                        if (file_exists($imagePathJPG)) {
                            $imagePath = $imagePathJPG;
                        } elseif (file_exists($imagePathJPEG)) {
                            $imagePath = $imagePathJPEG;
                        } else {
                            // If no image found, display a placeholder or alternative message
                            $imagePath = '../images/placeholder.jpg'; // Provide a path to a placeholder image
                        }
                        
                        echo "<tr>";
                        echo "<td><img src='{$imagePath}' height='200px' alt='{$row2['prod_name']}'></td>";
                        echo "<td>{$row2['prod_name']}</td>";
                        echo "<td>{$row2['prod_price']}</td>";
                        echo "<td>{$row1['wishlistquantity']}</td>";
                        $subtotal = $row2['prod_price'] * $row1['wishlistquantity'];
                        echo "<td class ='subtotal'> {$subtotal} </td>";
                        echo "<td><input type='checkbox' class='checkout' name='checked[]' value='{$row1['id']}' >Check out</td>";
						echo "<td><a href='editdelete.php?id={$row1['id']}&action=edit' class='edit_button'>Edit</a> | 
                            <a href='editdelete.php?id={$row1['id']}&action=delete' class='hide_button'>Delete</a></td></tr>";
                        echo "</tr>";
                    }
                }  
                echo "</table>";
            }
            echo "<h3 id='totalPrice'>Total price: RM {$total}</h3>";
            if(mysqli_num_rows($result1) !== 0) {
                echo "<input type= 'submit' name= 'checkingout' value='Checkout' class=\"checkout_button\">";
            }
            echo "</form>";
        }
        else{
            echo "<h3>Please log in first to view your wishlist.</h3>";
        }
    ?>

    <?php include('../include/footer.php'); ?>
    <script src="app.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script>
        $(document).ready(function(){    // When any checkbox with class 'checkout' changes
            $('.checkout').change(function() {
                var total = 0;
                // For each checked checkbox with class 'checkout'
                $('.checkout:checked').each(function() {
                    // Get the subtotal from the previous sibling (which is the table cell containing subtotal)
                    var subtotal = parseFloat($(this).closest('tr').find('.subtotal').text());
                    total += subtotal;
                });
                // Update the total price display
                $('#totalPrice').text('Total price: RM' + total);
            });
        })
    </script>

</body>
</html>

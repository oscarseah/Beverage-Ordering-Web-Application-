<?php 
    session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" href="../homestyle.css">
	<link rel="stylesheet" href="/healthtea/style/order.css">
    <!-- logo beside the title -->
    <link rel="tab logo icon" href="/healthtea/images/1.png" type="image/x-icon">
    <!-- for house and people icon -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <title>HealthTea | Checkout</title>
</head>
<body>
    <?php include('../include/header.php'); ?>
    <h1 style="padding:30px; ">Checkout</h1>
    <?php 
        if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true || !isset($_SESSION['id'])){
            echo "<h3>You must log in to place an order.</h3>";
        }
        else{
            include('../db_connection.php');

            $result = mysqli_query($conn,"SELECT id FROM users WHERE username='{$_SESSION['username']}'");
            if($row = mysqli_fetch_assoc($result)){
                $user_id = $row['id'];
            }
            $result1 = mysqli_query($conn,"SELECT * FROM orders WHERE user_id='{$user_id}' AND is_received=0");
            while($row1 = mysqli_fetch_assoc($result1)){
                $total = 0;
                //start of the table
                echo "<table class=\"product_table\">";
                echo "<tr><th>Order</th><th>Image</th><th>Unit Price(RM)</th><th>Quantity</th><th>Subtotal(RM)</th></tr>";
                $result2 = mysqli_query($conn,"SELECT * FROM order_item WHERE order_id={$row1['order_id']}");
                while($row2 = mysqli_fetch_assoc($result2)){
                    $result3 = mysqli_query($conn,"SELECT * FROM productlist WHERE prod_id={$row2['prod_id']}");
                    $row3 = mysqli_fetch_assoc($result3);
                    $imagePath = '../images/' . $row3['prod_name'] . '.jpg'; // Assuming images are in .jpg format
                    if (file_exists($imagePath)) {
                        echo "<tr>";
                        echo "<td>{$row3['prod_name']}</td>";
                        echo "<td><img src='{$imagePath}' height='100px'></td>";
                        echo "<td>{$row2['price']}</td>";
                        echo "<td>{$row2['quantity']}</td>";
                        $subtotal = $row2['price'] * $row2['quantity'];
                        echo "<td>{$subtotal}</td>";
                        echo "</tr>";
                        $total += $subtotal;
                    } else {
                        echo "<tr><td colspan='5'>Image not found</td></tr>";
                    }
                }
                ?>
                </table>
                <p style="margin-top: 14px;">Grand Total: RM<?php echo $total; ?></p>
                <form style="padding:15px;" method='post' action='../wishlist/editdelete.php' onsubmit='return confirmaction()'>
                    <input type="hidden" name='order_id' value=" <?php echo $row1['order_id'] ?>">
                    <input type="submit" name='orderreceived' value='Order Received'>
                    <input type="submit" name='deleteorder' value='Delete Order'>
                </form>
                <hr>
            <?php } 
        } ?>
    
    <script src="app.js"></script>
	<script>
    function confirmaction() {
        var msg;
        if (document.activeElement.name === 'orderreceived') {
            msg = "Are you sure you have received the order?";
        }
        else if (document.activeElement.name === 'deleteorder') {
            msg = "Are you sure you want to delete the order?";
        }
        return confirm(msg);
    }
    </script>
	<?php include('../include/footer.php'); ?>
</body>
</html>
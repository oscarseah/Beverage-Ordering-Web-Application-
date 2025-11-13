<?php 
    session_start();
?>
<?php 
    if(isset($_POST['order'])){
        include("../db_connection.php");
        $result = mysqli_query($conn,"SELECT id FROM users WHERE username='{$_SESSION['username']}'");
        $userid = mysqli_fetch_assoc($result)['id'];
        $checkedItems = unserialize($_POST['checkedItemsSerialized']);
        if(isset($_POST['address']) && !empty($_POST['address'])){
            $result2=mysqli_query($conn,"INSERT INTO address(userid,address) VALUES ('{$userid}','{$_POST['address']}')");
            if(!$result2){
                echo"Failed insert...result2";
            }
            $add_id = mysqli_insert_id($conn);
            $sql= "INSERT INTO orders(user_id,address_id,is_received) VALUES ('{$userid}',{$add_id},0)";
        }
        else{
            $sql = "INSERT INTO orders (user_id,address_id,is_received) VALUES ('{$userid}','{$_POST['addresstype']}',0)";
        }
        $result2 = mysqli_query($conn,$sql);
        if ($result2) {
            $order_id = mysqli_insert_id($conn);
            foreach ($checkedItems as $wishlistId) {
                $result2 = mysqli_query($conn,"SELECT w.wishlistitemid, w.wishlistquantity, p.prod_price FROM wishlist w
                JOIN productlist p ON w.wishlistitemid = p.prod_id WHERE w.id = {$wishlistId}");
                $row2 = mysqli_fetch_assoc($result2);
                if($row2) {
                    $result3=mysqli_query($conn,"INSERT INTO order_item(order_id,prod_id,quantity,price) 
                                                VALUES ('{$order_id}',{$row2['wishlistitemid']},{$row2['wishlistquantity']},
                                                {$row2['prod_price']})"); 
                    $result4=mysqli_query($conn,"DELETE FROM wishlist WHERE id={$wishlistId}");
                    if($result3 && $result4){
                        echo "<script>alert('Order successfully!'); window.location.href='/healthtea/wishlist'</script>";
                        
                    }
                }              
            }
        }
    }
?>
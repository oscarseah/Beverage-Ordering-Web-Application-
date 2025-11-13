<?php 
    session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
		<link rel="stylesheet" href="../homestyle.css">
		<link rel="stylesheet" href="/healthtea/style/listingproduct.css">
        <!-- logo beside the title -->
        <link rel="tab logo icon" href="/healthtea/images/1.png" type="image/x-icon">
        <!-- for house and people icon -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
        <title>HealthTea | Listing</title>
</head>
<body>
    <?php include('../include/header.php'); ?>
    
    <h1 style="padding:25px;">Product List</h1>

    <?php 
        include("../db_connection.php");
        if(isset($_SESSION['is_admin']) && $_SESSION['is_admin'] == 1){
			echo "<button onclick=\"location.href='../wishlist/editdelete.php?add=addnewproduct'\" class=\"add_button\"'>Add new product</button>";
        }
        // Execute query
        $sql = "SELECT * FROM productlist WHERE is_available=1";
        $result = mysqli_query($conn,$sql);

        // Output as HTML table
        if(mysqli_num_rows($result) > 0){
            echo "<table class=\"product-table\">";
            echo "<tr><th>Image</th><th> ID </th><th> Name </th><th> Price (RM) </th><th colspan=3> Action </th></tr>";

            while ($row = mysqli_fetch_assoc($result)){
                echo "<tr><td><img src='../images/{$row['prod_name']}.jpg' 
                    onerror=\"this.src='../images/{$row['prod_name']}.jpeg'\" height=\"200px\"></td>";
                echo "<td> {$row["prod_id"]} </td>";
                echo "<td>{$row["prod_name"]}</td>";
                echo "<td> {$row["prod_price"]} </td>";
                echo "<td><a href='itemdetailpage.php?id={$row['prod_id']}' class=\"buy_button\"'>Buy Now</a></td>";
                if(isset($_SESSION['is_admin']) && $_SESSION['is_admin'] == 1){
                    echo "<td><a href='../wishlist/editdelete.php?edit=editproduct&prod_id={$row['prod_id']}' class=\"edit_button\"'>Edit product</a></td>";
                    echo "<td><a href='../wishlist/editdelete.php?delete=deleteproduct&prod_id={$row['prod_id']}&name={$row["prod_name"]}' 
                        class=\"hide_button\"'>Hide product</a></td>";
                }
                echo "</tr>";
            };
            echo "</table>";
        };
        if(isset($_SESSION['is_admin']) && $_SESSION['is_admin'] == 1){
            $result1= mysqli_query($conn,"SELECT * FROM productlist WHERE is_available=0");
            if(mysqli_num_rows($result1) > 0){
                echo "<hr>";
                echo "<h1 style=\"padding: 20px;\">Hidden product</h1>";
                echo "<table class=\"hide_product_table\">";
                echo "<tr><th>Image</th><th> ID </th><th> Name </th><th> Price(RM) </th><th colspan=3> Action </th></tr>";
    
                while ($row1 = mysqli_fetch_assoc($result1)){
                    echo "<tr><td><img src='../images/{$row1['prod_name']}.jpg' onerror=\"this.src='../images/{$row1['prod_name']}.jpeg'\" height=\"200px\"></td>";
                    echo "<td> {$row1["prod_id"]} </td>";
                    echo "<td>{$row1["prod_name"]}</td>";
                    echo "<td> {$row1["prod_price"]} </td>";
                    echo "<td><a href='../wishlist/editdelete.php?edit=editproduct&prod_id={$row1['prod_id']}' style='color:purple; text-decoration:underline;'>Edit product</a></td>";
                    echo "<td><a href='../wishlist/editdelete.php?show=showproduct&prod_id={$row1['prod_id']}&name={$row1["prod_name"]}' style='color:green; text-decoration:underline;'>Show product</a></td>";
                    echo "</tr>";
                };
                echo "</table>";
            };
    
        }
        mysqli_close($conn);
    ?>
    <?php include('../include/footer.php'); ?>
    <script src="app.js"></script>
</body>
</html>

<?php 
?>
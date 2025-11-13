<?php 
    session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
<link rel="stylesheet" href="../homestyle.css">
<link rel="stylesheet" href="/healthtea/style/billing.css">
        <!-- logo beside the title -->
        <link rel="tab logo icon" href="/healthtea/images/1.png" type="image/x-icon">
        <!-- for house and people icon -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
        <title>HealthTea | Billing</title>
</head>
<body>
<?php
    include('../include/header.php');
    if(isset($_POST['checkingout']) && is_array($_POST['checked'])) { 
        include('../db_connection.php');

        // hold checked item.
        $checkedItemsSerialized = serialize($_POST['checked']);
        foreach ($_POST['checked'] as $wishlistId) {
            $result1= mysqli_query($conn,"SELECT * FROM wishlist WHERE id='{$wishlistId}'");
			echo "<table class=\"billing_product_table\">";
            $total = 0;
			echo "<tr><th>Image</th><th> Name </th><th> Quantity </th><th> Price(RM) </th></tr>";
            while($row1=mysqli_fetch_assoc($result1)){
                $result2 = mysqli_query($conn,"SELECT prod_name,prod_price FROM productlist WHERE prod_id='{$row1['wishlistitemid']}'");
                $row2= mysqli_fetch_assoc($result2);
                $imagePath = '../images/' . $row2['prod_name'] . '.jpg'; // Assuming images are in .jpg format
                $imagePathjpeg = '../images/' . $row2['prod_name'] . '.jpeg'; // Assuming images are in .jpeg format
                if (file_exists($imagePath)) {
                    echo "<tr><td><img src='{$imagePath}' height=200px></td>"; // Display the actual image
                } 
                else if (file_exists($imagePathjpeg)) {
                    echo "<tr><td><img src='{$imagePathjpeg}' height=200px></td>"; // Display the actual image
                }
                else {
                    echo "<tr><td>Image not found</td></tr>"; // Display a message if the image file doesn't exist
                }
                echo "<td> {$row2['prod_name']} </td>";
                echo "<td> {$row1['wishlistquantity']} </td>";
                $subtotal = $row2['prod_price'] * $row1['wishlistquantity'];
                echo "<td> {$subtotal} </td></tr>";
                $total+=$subtotal;
            }

        }            
        echo "</table>";
        echo "<h3 style=\"padding:20px;\">Total price: RM{$total}</h3>";

        $result3 = mysqli_query($conn,"SELECT id FROM users WHERE username='{$_SESSION['username']}'");
        $userid = mysqli_fetch_assoc($result3)['id'];
        $result4 = mysqli_query($conn,"SELECT * FROM address WHERE userid='{$userid}'");

        ?>
        <hr>
        <form class="container" method='post' action='post-billing.php' onsubmit='return getAddressVISA()'>
            <fieldset class="address-section">
                <legend><h2>Address</h2></legend>
                <!-- Use old address -->
                <div id='OldAddDiv'>
                    <label for='addresstype'>Please choose your destinated address:</label><br>
                    <select name="addresstype">
                        <?php 
                            while($row4=mysqli_fetch_assoc($result4)){
                                echo "<option value='{$row4['id']}'>{$row4['address']}</option>";
                            }
                        ?> 
                    </select><br>
                </div>
                <!-- Use New address -->
                <input type="checkbox" class='newaddress' name='newaddress' id='newaddress'> 
                <label for="newaddress">Create new address</label>
                <div id='NewAddDiv' style='display:none'>
                    <label for='streetname'>Street Name 1:</label><br>
                    <input type="text" name='streetname' id='streetname'><br><br>
                    <label for="streetname2">Street Name 2:</label><br>
                    <input type="text" name='streetname2' id='streetname2'><br><br>
                    <label for="postcode" >Postcode:</label><br>
                    <input type="text" name='postcode' id='postcode' ><br><br>
                    <label for="city">City:</label><br>
                    <input type="text" name='city' id='city'><br><br>
                    <label for="state">State:</label><br>
                    <input type="text" name='state' id='state'><br>
                </div>
            </fieldset>
            <fieldset class="payment-method-section">
                <legend><h2>Payment Method</h2></legend>
                <select name="payment" id="payment">
                    <option value="CODpayment">Cash on delivery</option>
                    <option value="visapayment">VISA card</option>
                </select>
                <div id='visapayment' style='display:none'>
                    <p>Please enter your visa information below:</p>
                    <label for="cardnum">Your Card Number:</label>
                    <input type="text" name='cardnum' id=cardnum placeholder="0000 0000 0000 0000">
                    <label for="expirydate">Expiry Date:</label>
                    <input type="text" name='expirydate' id='expirydate' placeholder="MM/YY">
                    <label for="cvv">CVV:</label>
                    <input type="text" name='cvv' id='cvv'>
                </div>
                <div id='CODpayment' style='display:block'>
                    <p>You will need to pay RM<?php echo $total; ?> on delivery.</p>
                </div>
            </fieldset>

            <input type="hidden" name="checkedItemsSerialized" value="<?php echo htmlspecialchars($checkedItemsSerialized); ?>">
            <input type="hidden" name="address" id="address">
            <input type="submit" name='order' value='Order Now'>
        </form>

    <?php
    }
    else{ ?>
    <script> 
        alert('Please tick the checkbox to checkout');
        window.location.href = 'wishlist.php'
    </script>";
    <?php }
    ?>
    <?php include('../include/footer.php'); ?>
    <script src="app.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script>
        $(document).ready(function(){
            $('.newaddress').change(function(){
                $('.newaddress:checked').each(function(){
                    $('#OldAddDiv').css('display','none');
                    $('#NewAddDiv').css('display','block');
                })
                $('.newaddress:not(:checked)').each(function(){
                    $('#OldAddDiv').css('display','block');
                    $('#NewAddDiv').css('display','none');
                })
            })
            $('#payment').change(function(){
                var paymethod = $('#payment').val();
                if (paymethod =='visapayment'){
                    $('#visapayment').css('display','block');
                    $('#CODpayment').css('display','none');
                }
                else {
                    $('#visapayment').css('display','none');
                    $('#CODpayment').css('display','block');
                }   
            })
        })

        function getAddressVISA() {
            var address = "";
            if ($('#newaddress').prop('checked')) {
                var streetname = $('#streetname').val().trim();
                var postcode = $('#postcode').val().trim();
                var city = $('#city').val().trim();
                var state = $('#state').val().trim();
                var streetname2 = $('#streetname2').val().trim();
                if (streetname !== "" && postcode !== "" && city !== "" && state !== "" && postcode.length == 5 && /^\d{5}$/.test(postcode)) {
                    if(streetname2 !== ""){
                        address = streetname + ", " + streetname2 + ", " + postcode + " " + city + ", " + state;
                    }
                    else{
                        address = streetname + ", " + postcode + " " + city + ", " + state;
                    }
                }
                else {
                    alert("Please fill in all required address fields correctly.");
                    return false;
                }
            }
            $('#address').val(address);

            if($('#payment').val() == 'visapayment') {
                var cardNumber = $('#cardnum').val();
                var expiryDate = $('#expirydate').val();
                var cvv = $('#cvv').val();

                // Perform validation
                if (!validateCardNumber(cardNumber)) {
                    alert("Please enter a valid card number.");
                    return false;
                }

                if (!validateExpiryDate(expiryDate)) {
                    alert("Please enter a valid expiry date (MM/YY format).");
                    return false;
                }

                if (!/^\d{3}$/.test(cvv)) {
                    alert("Please enter a valid CVV.");
                    return false;
                }

                // If all validations pass, proceed with submission
                alert("Visa information submitted successfully!");
            }

            // Validation functions
            function validateCardNumber(cardNumber) {
                if(isNaN(cardNumber)){
                    return false;
                }
                return cardNumber.length === 16;
            }

            function validateExpiryDate(expiryDate) {
                if (!/^\d{2}\/\d{2}$/.test(expiryDate)) {
                    return false;
                }
                var monthyear = expiryDate.split('/');
                var month = parseInt(monthyear[0]);
                var year = parseInt(monthyear[1]);

                // Check if the month is between 1 and 12
                if (month < 1 || month > 12) {
                    return false;
                }

                // Get the current date
                var currentDate = new Date();
                var currentYear = currentDate.getFullYear() % 100; // Get last two digits of the current year

                // Check if the expiry year is in the future
                if (year < currentYear || (year === currentYear && month < (currentDate.getMonth() + 1))) {
                    return false;
                }

                return true;
            }
            return true;
        }
    </script>
</body>
</html>

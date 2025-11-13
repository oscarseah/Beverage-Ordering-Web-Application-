<?php 
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "healthtea";
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $conn = new mysqli($servername, $username, $password, $dbname);
    if ($conn->connect_error) {
        echo "<p>not connected</p>";
        die("Connection failed: " . $conn->connect_error);
    }
}
$username = $email = $address = $message = "";
$username_err = $email_err = $address_err = $message_err = "";
$feedback_message = "";

if($_SERVER["REQUEST_METHOD"] == "POST"){
    // Validate username
    if(empty(trim($_POST["username"]))){
        $username_err = "Please enter a username.";
    } elseif(!preg_match('/^[a-zA-Z0-9_]+$/', trim($_POST["username"]))){
        $username_err = "Username can only contain letters, numbers, and underscores.";
    } else{
        $username = trim($_POST["username"]);
    }
    // Validate email
    if (isset($_POST["email"]) && empty(trim($_POST["email"]))) {  
        $email_err = "Email is required";  
    } else if(isset($_POST["email"])){
        $email = trim($_POST["email"]);  
        // check that the e-mail address is well-formed  
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {  
            $email_err = "Invalid email format";  
        }
    }  

    if(empty(trim($_POST["street1"])) || empty(trim($_POST["street2"])) || empty(trim($_POST["postcode"])) || empty(trim($_POST["city"])) || empty(trim($_POST["state"]))){
        $address_err = "Please enter a complete address.";     
    } else{
        $street1 = trim($_POST["street1"]);
        $street2 = trim($_POST["street2"]);
        $postcode = trim($_POST["postcode"]);
        $city = trim($_POST["city"]);
        $state = trim($_POST["state"]);
        $address = $street1 . ', ' . $street2 . ', ' . $postcode . ', ' . $city . ', ' . $state;
    }
        
    if(empty(trim($_POST["message"]))){
        $message_err = "Please leave us a message.";     
    } else{
        $message = trim($_POST["message"]);
    }
       
    // Check input errors before inserting in database
    if(empty($username_err) && empty($email_err) && empty($message_err) && empty($address_err)){
        
        // Prepare an insert statement
        $sql = "INSERT INTO contact (username, email, address, message) VALUES (?, ?, ?, ?)";
        if($stmt = $conn->prepare($sql)){
            // Bind variables to the prepared statement as parameters
            $stmt->bind_param("ssss", $param_username, $param_email, $param_address, $param_message);

            // Set parameters
            $param_username = $username;
            $param_email = $email;
            $param_address = $address;
            $param_message = $message;

            if($stmt->execute()){
                // Clear the variables
                $username = $email = $address = $message = "";
                $feedback_message = "Thanks for your feedback!";
            } else{
                $feedback_message = "Oops! Something went wrong. Please try again later.";
            }
        }
        // Close statement
        $stmt->close();
    }
}
?>
<!DOCTYPE html>
<html>
    <head>
        <link rel="stylesheet" href="../homestyle.css">
		<link rel="stylesheet" href="/healthtea/style/contactus.css">
        <!-- logo beside the title -->
        <link rel="tab logo icon" href="/healthtea/images/1.png" type="image/x-icon">
        <!-- for house and people icon -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css"> 
        <title>HealthTea | Contact Us</title>
        <style>
            body{ font: 14px sans-serif; }
            .wrapper{ width: 360px; padding: 20px; }
        </style>
    </head>
    <body>
        <?php include('../include/header.php'); ?>
		<h2 style="margin:30px; font-size: 3em; font-weight: bold;">Please Send Us a Message!</h2>
        <div class="container">
            <section class="contact_us">
                <div class="wrapper">
                    
                    <p>Please fill this form to send a feedback to us.</p>
                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                        <div class="form-group">
                            <label>Username</label>
                            <input type="text" name="username" class="form-control <?php echo (!empty($username_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $username; ?>">
                            <span class="invalid-feedback"><?php echo $username_err; ?></span>
                        </div>
                        <div class="form-group">
                            <label>Email</label>
                            <input type="text" name="email" class="form-control <?php echo (!empty($email_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $email; ?>">
                            <span class="invalid-feedback"><?php echo $email_err; ?></span>
                        </div>
                        <div class="form-group">
                            <label>Street Name</label>
                            <input type="text" name="street1" class="form-control">
                            <label>Street Name 2</label>
                            <input type="text" name="street2" class="form-control">
                            <label>Postcode</label>
                            <input type="text" name="postcode" class="form-control">
                            <label>City</label>
                            <input type="text" name="city" class="form-control">
                            <label>State</label>
                            <input type="text" name="state" class="form-control"> 
                        </div>
                        <div class="form-group">
                            <label>Please leave your message here:</label>
                            <textarea name="message" class="form-control <?php echo (!empty($message_err)) ? 'is-invalid' : ''; ?>"><?php echo $message; ?></textarea>
                            <span class="invalid-feedback"><?php echo $message_err; ?></span>
                        </div>
                        <div class="form-group">
                            <input type="submit" class="btn btn-primary" value="Submit">
                            <input type="reset" class="btn btn-secondary ml-2" value="Reset">
                        </div>
                        <?php echo $feedback_message; ?>
                    </form>
                </div>
                <div class="contact_us_image">
                    <img src="/healthtea/images/contactus.png" alt="" style="width:138%">
                </div>
            </section>
        </div>
        <?php include('../include/footer.php'); ?>
        <script src="app.js"></script>
    </body>
</html>

<?php
// Initialize the session
session_start();
 
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

// Check if the user is already logged in, if yes then redirect him to welcome page
if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] !== true){
    header("location: ../login/index.php");
    
    exit;
}
?>
 
<!DOCTYPE html>
<html>
    <head>
    <link rel="stylesheet" href="../homestyle.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
        <!-- logo beside the title -->
        <link rel="tab logo icon" href="/healthtea/images/1.png" type="image/x-icon">
        <!-- for house and people icon -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
        <title>HealthTea | Account</title>
        <style>
        body{ font: 14px sans-serif; text-align: center; }
        </style>
    </head>
    <body>
        <?php include('../include/header.php'); ?>
		<img style="width:100%" src="/healthtea/images/welcome.png" alt="">
        <h1 class="my-5">Welcome, <b><?php echo htmlspecialchars($_SESSION["username"]); ?></b>. Nice to see you again.</h1>
    <p>
        <a href="reset-password.php" class="btn btn-warning">Change Password</a>
        <a href="logout.php" class="btn btn-danger ml-3">Sign Out Account</a>
    </p>
        <?php include('../include/footer.php'); ?>
    <script src="app.js"></script>
    </body>
</html>
<?php 
    //Database configuration
    $db_server = 'localhost';
    $db_user = 'root';
    $db_password = '';
    $db_name = 'healthtea';

    //Create database connection
    $conn = mysqli_connect($db_server,$db_user,$db_password,$db_name);   
?>
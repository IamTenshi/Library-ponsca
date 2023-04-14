<?php 
    $db_host="localhost";
    $db_port=3306;
    $db_user="root";
    $db_password="1223334444";
    $db_name="library";
    
    $conn = new mysqli($db_host, $db_user, $db_password, $db_name, $db_port)
        or die ('Could not connect to the database server' . mysqli_connect_error());

    mysqli_select_db($conn, $db_name)
        or die ("Could not find the database");

    mysqli_set_charset($conn,"utf8");
?>
<?php
    $base_url = "http://127.0.0.1/5TOINF_10/library/";
    $host = "localhost";
    $db = "library";
    $db_user = "root";
    $pass = "1223334444";
    $charset = "charset=utf8";

    $conn = new mysqli($host, $db, $db_user, $pass)
	or die ('Could not connect to the database server' . mysqli_connect_error());
?>
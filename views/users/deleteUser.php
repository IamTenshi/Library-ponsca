<?php 
  include_once("../../config/config.php");

  if (isset($_POST['username'])) {
    $username = $_POST['username'];
    mysqli_query($conn, "DELETE FROM `library`.`users` WHERE `username` = '$username'");
  }

  $conn->close();
  header("Location: users.php");
?>
<?php 
  include_once("../../config/config.php");

  if (isset($_POST['bookName'])) {
    $bookName = $_POST['bookName'];
    mysqli_query($conn, "DELETE FROM `library`.`books` WHERE `name` = '$bookName'");
  }

  $conn->close();
  header("Location: books.php");
?>
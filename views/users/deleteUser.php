<?php
  include_once("../../config/config.php");

  class User {
    private $conn;

    public function __construct($conn) {
      $this->conn = $conn;
    }

    public function deleteUser($username) {
      $stmt = $this->conn->prepare("DELETE FROM `library`.`users` WHERE `username` = ?");
      $stmt->bind_param("s", $username);
      $stmt->execute();
    }
  }

  if (isset($_POST['username'])) {
    $user = new User($conn);
    $user->deleteUser($_POST['username']);
  }

  $conn->close();
  header('Location: users.php');
?>
<?php
    require_once("../../config/config.php");
    class Lending {
        private $conn;
        public function __construct($conn) {
            $this->conn = $conn;
        }
        public function deleteLending($id, $book) {
            $returnBookQuery = "UPDATE `library`.`books` SET `stock` = `stock` +1 WHERE `name` = '$book'";
            mysqli_query($this->conn, $returnBookQuery);
        
            $deleteLendingQuery = "DELETE FROM `library`.`lendings` WHERE id = ?";
            $stmt = mysqli_prepare($this->conn, $deleteLendingQuery);
            mysqli_stmt_bind_param($stmt, 'i', $id);
            mysqli_stmt_execute($stmt);
        }
    }

    if (isset($_POST['deleteLendingButton'])) {
        $id = $_POST['id'];
        $book = $_POST['book_name']; 
        $lending = new Lending($conn);
        $lending->deleteLending($id, $book);
    }

    header("Location: lending.php");
?>
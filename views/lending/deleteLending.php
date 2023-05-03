<?php
    require_once("../../config/config.php");

    class Lending {
        private $conn;

        public function __construct($conn) {
            $this->conn = $conn;
        }

        public function deleteLending($id) {
            $deleteLendingQuery = "DELETE FROM `library`.`lendings` WHERE id = ?";
            $stmt = mysqli_prepare($this->conn, $deleteLendingQuery);
            mysqli_stmt_bind_param($stmt, 'i', $id);
            mysqli_stmt_execute($stmt);
        }
    }

    if (isset($_POST['deleteLendingButton'])) {
        $id = $_POST['id'];
        $lending = new Lending($conn);
        $lending->deleteLending($id);
    }

    header("Location: lending.php");
?>
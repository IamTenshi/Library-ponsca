<?php
    include_once("../../config/config.php");

    class Book {
        private $bookName;

        public function __construct($bookName) {
            $this->bookName = $bookName;
        }

        public function deleteFromDatabase($conn) {
            // Delete the book from the database
            $stmt = $conn->prepare("DELETE FROM `library`.`books` WHERE `name` = ?");
            $stmt->bind_param("s", $this->bookName);
            $stmt->execute();
        }
    }

    // Check if the form has been submitted
    if (isset($_POST['bookName'])) {
        // Get the form data
        $bookName = $_POST['bookName'];

        // Create a new Book object and delete it from the database
        $book = new Book($bookName);
        $book->deleteFromDatabase($conn);

        // Redirect to a success page
        header('Location: books.php');
    }

    $conn->close();
?>
<?php
    session_start();
    require_once("../../config/config.php");

    class Library {
        private $conn;
        private $book;
        private $user;

        public function __construct($conn, $book, $user) {
            $this->conn = $conn;
            $this->book = $book;
            $this->user = $user;
        }

        public function bookExists() {
            $bookExistsQuery = "SELECT * FROM books WHERE name = ?";
            $stmt = mysqli_prepare($this->conn, $bookExistsQuery);
            mysqli_stmt_bind_param($stmt, "s", $this->book);
            mysqli_stmt_execute($stmt);
            $bookExistsResult = mysqli_stmt_get_result($stmt);

            if (mysqli_num_rows($bookExistsResult) == 0) {
                $_SESSION['error'] = "The book was not found in the database";
                header("Location: lending.php");
                exit;
            }
        }

        public function userExists() {
            $userExistsQuery = "SELECT * FROM `library`.`users` WHERE `username` = '$this->user'";
            $userExistsResult = mysqli_query($this->conn, $userExistsQuery);
            if (mysqli_num_rows($userExistsResult) == 0) {
                $_SESSION['error'] = "The user is not in the database";
                header("Location: lending.php");
                exit;
            }
        }

        public function checkStock() {
            $countBooksQuery = "SELECT * FROM `library`.`books` WHERE `name` = '$this->book'";
            $countBooksQueryResult = mysqli_query($this->conn, $countBooksQuery);
            $stock = mysqli_fetch_assoc($countBooksQueryResult)['stock'];
            if ($stock < 1) {
                $_SESSION['error'] = "There are not enough books";
                header("Location: lending.php");
                exit;
            }
        }

        public function takeBook() {
            $takeBookQuery = "UPDATE `library`.`books` SET `stock` = `stock` -1 WHERE `name` = '$this->book';";
            mysqli_query($this->conn, $takeBookQuery);
        }

        public function addLending() {
            $lendingDate = date('Y-m-d H:i:s');
            $devolutionDate = date('Y-m-d H:i:s', strtotime('+14 days'));

            $addLendingQuery = "INSERT INTO `library`.`lendings` (`book_name`, `lending_date`, `devolution_date`, `users_username`) VALUES ('$this->book', '$lendingDate', '$devolutionDate', '$this->user');";
            mysqli_query($this->conn, $addLendingQuery);

            header("Location: lending.php");
        }
    }

    $library = new Library($conn, $_POST['book'], $_POST['user']);
    $library->bookExists();
    $library->userExists();
    $library->checkStock();
    $library->takeBook();
    $library->addLending();
?>
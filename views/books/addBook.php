<?php
    // Connect to the database
    require_once("../../config/config.php");

    class Book {
        private $title;
        private $topic;
        private $author;
        private $coverFilePath;

        public function __construct($title, $topic, $author, $coverFilePath) {
            $this->title = $title;
            $this->topic = $topic;
            $this->author = $author;
            $this->coverFilePath = $coverFilePath;
        }

        public function saveToDatabase($conn) {
            // Insert the data into the database
            $query = "INSERT INTO books (name, topic, author, cover_url) VALUES (?, ?, ?, ?)";
            $stmt = mysqli_prepare($conn, $query);
            mysqli_stmt_bind_param($stmt, 'ssss', $this->title, $this->topic, $this->author, $this->coverFilePath);
            mysqli_stmt_execute($stmt);
        }
    }

    // Check if the form has been submitted
    if (isset($_POST['title'])) {
        // Get the form data
        $title = $_POST['title'];
        $topic = $_POST['topic'];
        $author = $_POST['author'];

        // Handle the file upload
        if (isset($_FILES['cover-file']) && $_FILES['cover-file']['error'] == 0) {
            // Move the uploaded file to a permanent location
            $coverFilePath = '../../assets/images/book/' . basename($_FILES['cover-file']['name']);
            move_uploaded_file($_FILES['cover-file']['tmp_name'], $coverFilePath);
        } else {
            $coverFilePath = null;
        }

        // Create a new Book object and save it to the database
        $book = new Book($title, $topic, $author, $coverFilePath);
        $book->saveToDatabase($conn);

        // Redirect to a success page
        header('Location: books.php');
    }
?>
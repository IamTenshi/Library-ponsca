<?php
    // Connect to the database
    session_start();
    require_once("../../config/config.php");

    class User {
        private $conn;

        public function __construct($conn) {
            $this->conn = $conn;
        }

        public function createUser($username, $password, $phoneNumber, $profileImgFile) {
            // Set the default profile image URL
            $profileImgUrl = '';

            // Check if a file was uploaded
            if ($profileImgFile) {
                // Get the file information
                $fileName = $profileImgFile['name'];
                $fileTmpName = $profileImgFile['tmp_name'];
                $fileSize = $profileImgFile['size'];
                $fileError = $profileImgFile['error'];

                // Handle the file upload
                if ($fileError === 0) {
                    // Generate a unique file name
                    $fileNameNew = uniqid('', true) . '.' . pathinfo($fileName, PATHINFO_EXTENSION);

                    // Move the file to the uploads directory
                    move_uploaded_file($fileTmpName, '../../assets/images/profile/' . $fileNameNew);

                    // Set the profile image URL
                    $profileImgUrl = '../../assets/images/profile/' . $fileNameNew;
                }
            }

            // Insert the data into the database using a prepared statement
            $stmt = $this->conn->prepare("INSERT INTO `library`.`users` (username, password, phone_number, profile_img_url) VALUES (?, ?, ?, ?)");
            $stmt->bind_param("ssss", $username, $password, $phoneNumber, $profileImgUrl);
            $stmt->execute();            
        }

        public function formatPhoneNumber() {
            $stmt = $this->conn->prepare("UPDATE `library`.`users` SET phone_number = CONCAT('+1 (', SUBSTR(phone_number, 1, 3), ') ', SUBSTR(phone_number, 4, 3), '-', SUBSTR(phone_number, 7)) WHERE id = LAST_INSERT_ID()");
            $stmt->execute();
        }
    }

    // Check if the form was submitted
    if (isset($_POST['username']) && isset($_POST['password'])) {
        // Get the form data
        $username = $_POST['username'];
        $password = $_POST['password'];
        $phoneNumber = $_POST['phone-number'];
        $profileImgFile = isset($_FILES['profile-img']) ? $_FILES['profile-img'] : null;

        // Create a new user
        $user = new User($conn);
        $user->createUser($username, $password, $phoneNumber, $profileImgFile);
        $user->formatPhoneNumber();
    }

    // Close the database connection
    $conn->close();

    // Redirect to the users page
    header('Location: users.php');
?>
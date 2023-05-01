<?php
    // Connect to the database
    session_start();
    require_once("../../config/config.php");

    // Check if the form was submitted
    if (isset($_POST['username']) && isset($_POST['password'])) {
        // Get the form data
        $username = $_POST['username'];
        $password = $_POST['password'];
        $profileImgUrl = '';

        // Check if a file was uploaded
        if (isset($_FILES['profile-img'])) {
            // Get the file information
            $file = $_FILES['profile-img'];
            $fileName = $file['name'];
            $fileTmpName = $file['tmp_name'];
            $fileSize = $file['size'];
            $fileError = $file['error'];

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
        $stmt = $conn->prepare("INSERT INTO users (username, password, profile_img_url) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $username, $password, $profileImgUrl);
        $stmt->execute();
    }

    $conn->close();
    header('Location: users.php');
?>
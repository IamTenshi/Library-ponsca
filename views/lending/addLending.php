<?php 
    session_start();
    require_once("../../config/config.php"); 

    $book = $_POST['book'];
    $user = $_POST['user'];

    // Validar si el libro existe en la tabla books
    $bookExistsQuery = "SELECT * FROM books WHERE name = '$book'";
    $bookExistsResult = mysqli_query($conn, $bookExistsQuery);
    if (mysqli_num_rows($bookExistsResult) == 0) {
        // El libro no existe en la tabla books
        // Establecer una variable de sesión con el mensaje de error y redirigir al usuario a lending.php
        $_SESSION['error'] = "The book was not found in the database";
        header("Location: lending.php");
        exit;
    }

    // Validar si el usuario existe en la tabla users
    $userExistsQuery = "SELECT * FROM users WHERE username = '$user'";
    $userExistsResult = mysqli_query($conn, $userExistsQuery);
    if (mysqli_num_rows($userExistsResult) == 0) {
        // El usuario no existe en la tabla users
        // Establecer una variable de sesión con el mensaje de error y redirigir al usuario a lending.php
        $_SESSION['error'] = "The user is not in the database";
        header("Location: lending.php");
        exit;
    }

    // Si el libro y el usuario existen en las tablas books y users, insertar el registro en la tabla lendings
    $lendingDate = date('Y-m-d H:i:s');
    $devolutionDate = date('Y-m-d H:i:s', strtotime('+14 days'));

    $addLendingQuery = "INSERT INTO `library`.`lendings` (`book_name`, `lending_date`, `devolution_date`, `users_username`) VALUES ('$book', '$lendingDate', '$devolutionDate', '$user');";
    mysqli_query($conn, $addLendingQuery);

    header("Location: lending.php");
?>
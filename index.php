<?php 
    session_start();
    require_once("config/config.php");

    // Establecer tiempo de vida de la sesión en segundos
    $inactividad = 600;
    if(isset($_SESSION["timeout"])){
        // Calcular el tiempo de vida de la sesión (TTL = Time To Live)
        $sessionTTL = time() - $_SESSION["timeout"];
        if($sessionTTL > $inactividad){
            session_destroy();
            header('Location:users/login.php');
        }
    }
    $_SESSION["timeout"] = time();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Library Project</title>
    <meta name="author" content="Angel Jimenez">
    <meta name="description" content="it's a project about a school library">
    <?php require("helpers/helpers.php"); tailwind_link(); sweetalert_link();?>
</head>
<body class="bg-gray-100 font-family-karla flex">
    <?php if (!isset($_SESSION['user'])) { 
        echo "
            <script>
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'You have not logged in!',
                    confirmButtonText: 'Log in',
                    confirmButtonColor: '#3d68ff'
                }).then(function() {
                        window.location = 'views/users/login.php';
                })
            </script>
        ";
        session_destroy();
        die();
        } else {
            header("Location: views/lending/lending.php");
        }
    ?>
</body>
</html>
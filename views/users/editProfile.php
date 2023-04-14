<?php session_start(); require_once("../../config/config.php"); ?>
<header><?php require("../../helpers/helpers.php"); sweetalert_link(); ?></header>
<?php 
    if (!isset($_SESSION['user'])) {
        header("Location: login.php");
    }

    $username = $_SESSION['user'];
    $passkey = $_POST['passkey'];
    $confirmPasskey = $_POST['confirmPasskey'];
    $profileImg = $_FILES['profileImg'];
    $tmp_name = $profileImg['tmp_name'];

    $img_file = $profileImg['name'];
    $img_type = $profileImg['type'];
    $repository_route = "../../assets/images/profile";

    if (isset($profileImg)) {
        if (strpos($img_type, 'gif') || strpos($img_type, 'jpeg') || 
        strpos($img_type, 'jpg') || strpos($img_type, 'png')) {
            $route = $repository_route . '/' . $img_file;
            mysqli_query($conn, "UPDATE `library`.`users` SET `profile_img_url` = '$route' WHERE (`username` = '$username');");
            if (move_uploaded_file($tmp_name, $route)) {
                echo "              
                    <script>      
                        Swal.fire({
                            icon:'success',
                            text: 'Your data has been changed successfully',
                            confirmButtonText: 'Ok',
                            confirmButtonColor: '#3d68ff'
                        }).then(function() {
                            window.location = 'account.php';
                        })
                    </script>
                ";
                exit();
            }
        }
    }
                         
    if ($passkey != $confirmPasskey) {
        echo "         
            <script>        
                Swal.fire({         
                    icon: 'error',
                    title: 'Oops...',
                    text: 'Passwords do not match!',
                    confirmButtonText: 'Go back',
                    confirmButtonColor: '#3d68ff'
                }).then(function() {
                    window.location = 'account.php';
                })               
            </script>              
        ";      
        exit();
    } elseif (empty($passkey) || empty($confirmPasskey)) {
        echo "
            <script>        
                Swal.fire({         
                    icon: 'error',
                    title: 'Hey!',
                    text: 'Both fields must be filled!',
                    confirmButtonText: 'Go back',
                    confirmButtonColor: '#3d68ff'
                }).then(function() {
                    window.location = 'account.php';
                })               
            </script>
        ";
        exit();
    } else {           
        $editProfile = mysqli_query($conn, "UPDATE `library`.`users` SET `password` = '$passkey' WHERE (`username` = '$username');");
        echo "       
            <script>
                Swal.fire({
                    icon:'success',
                    text: 'Your data has been changed successfully',
                    confirmButtonText: 'Ok',
                    confirmButtonColor: '#3d68ff'
                }).then(function() {
                    window.location = 'account.php';
                })
            </script>
        ";
    }
?>
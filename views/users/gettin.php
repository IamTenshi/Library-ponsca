<?php 
    require_once("../../config/config.php");
    include("../../helpers/helpers.php");
    session_start();
?>
<header><?php sweetalert_link(); ?></header>
<?php

    $username = $_POST['username'];
    $passkey = $_POST['passkey'];

    if (!empty($username) && !empty($passkey)) {
        $validate_gettin = mysqli_query($conn, "SELECT * FROM users WHERE username = '$username' AND password = '$passkey'");
    
        if (mysqli_num_rows($validate_gettin) > 0) {
            $_SESSION['user'] = $username;
            header("location: ../../index.php");
            exit;
        } else {
            echo "
                <script>
                    Swal.fire({
                        icon: 'error',
                        text: 'Username and password do not match',
                        confirmButtonText: 'Try Again',
                        confirmButtonColor: '#3d68ff'
                    }).then(function() {
                            window.location = 'login.php';
                    })
                </script>
            ";
        }  
    } else {
        echo "
            <script>
                Swal.fire({
                    icon: 'error',
                    text: 'Both fields are required',
                    confirmButtonText: 'Ok',
                    confirmButtonColor: '#3d68ff'
                }).then(function() {
                        window.location = 'login.php';
                })
            </script>
        ";
    }
?>

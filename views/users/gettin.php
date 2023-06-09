<?php
    require_once("../../config/config.php");
    include("../../helpers/helpers.php");
    session_start();
?>
<header><?php sweetalert_link(); ?></header>
<?php
    class User {
        private $conn;
        private $username;
        private $passkey;

        public function __construct($conn, $username, $passkey) {
            $this->conn = $conn;
            $this->username = $username;
            $this->passkey = $passkey;
        }

        public function login() {
            if (!empty($this->username) && !empty($this->passkey)) {
                $validate_gettin = mysqli_query($this->conn, "SELECT * FROM users WHERE username = '$this->username' AND password = '$this->passkey'");
            
                if (mysqli_num_rows($validate_gettin) > 0) {
                    $_SESSION['user'] = $this->username;
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
        }
    }

    $user = new User($conn, $_POST['username'], $_POST['passkey']);
    $user->login();
?>
<?php
    class UserSession {
        public function startSession() {
            session_start();
        }

        public function logoutUser() {
            unset($_SESSION['user']);
            session_destroy();
        }

        public function redirectToLogin() {
            header("Location: login.php");
            exit;
        }
    }

    $session = new UserSession();
    $session->startSession();
    $session->logoutUser();
    $session->redirectToLogin();
?>
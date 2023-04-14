<?php 
    function base_url() {
        return $base_url;
    };

    function tailwind_link(){
        echo '
            <link href="https://cdnjs.cloudflare.com/ajax/libs/tailwindcss/2.2.19/tailwind.min.css" rel="stylesheet">
            <style>
            @import url("https://fonts.googleapis.com/css?family=Karla:400,700&display=swap");
            .font-family-karla {font-family: karla;}
            .bg-sidebar {background: #3d68ff;}
            .cta-btn {color: #3d68ff;}
            .upgrade-btn {background: #1947ee;}
            .upgrade-btn:hover {background: #0038fd;}
            .active-nav-link {background: #1947ee;}
            .nav-item:hover {background: #1947ee;}
            .account-link:hover {background: #3d68ff;}
        </style>
        ';
    };
    function sweetalert_link(){
        echo '
            <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        ';
    };
    function editAccountStyle(){
        echo '
            <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
            <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.bundle.min.js"></script>
            <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
            <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

            <style>
                body {
                    background: #3d68ff;
                }
              
                .form-control:focus {
                    box-shadow: none;
                    border-color: #3d68ff;
                }
              
                .profile-button {
                    background: #3d68ff;
                    box-shadow: none;
                    border: none;
                }
              
                .profile-button:hover {
                    background: #3d68ff;
                }
              
                .profile-button:focus {
                    background: #3d68ff;
                    box-shadow: none;
                }
              
                .profile-button:active {
                    background: #3d68ff;
                    box-shadow: none;
                }
              
                .back:hover {
                    color: #3d68ff;
                    cursor: pointer;
                }
            </style>
        ';
    };

    function tailwind_link2() {
        echo '
            <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/tw-elements/dist/css/index.min.css" />
            <script src="https://cdn.tailwindcss.com/3.2.4"></script>
        ';
    }
?>
<?php
    session_start();
    require 'adminFunction.php';
    if (isset($_POST['login'])) {
        if (empty($_POST['uname']) || empty($_POST['pass'])) {
            $_SESSION['error'] = "You must enter username and password.";
            header ("location: index.php");
        } else {
            $uname = $_POST['uname'];
            $pass = $_POST['pass'];
            $login = adminLogin($uname, $pass);
            if(empty($login['error'])) {
                $_SESSION['userID'] = $login['userID'];
                $_SESSION['userName'] = $login['userName'];
                $_SESSION['userRole'] = $login['userRole'];
                if($login['userRole'] == 1) {
                    header("location: admin_panel.php");
                } else if ($login['userRole'] == 2) {
                    header("location: sale_panel.php");
                }
            } else {
                $_SESSION['error'] = $login['error'];
                header ("location: index.php");
            }
        }
    }
?>
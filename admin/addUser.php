<?php
    session_start();
    require 'adminFunction.php';
    if(isset($_SESSION['success'])) {
        unset($_SESSION['success']);
    }
    if(isset($_SESSION['error1'])) {
        unset($_SESSION['error1']);
    }
    if(isset($_SESSION['error2'])) {
        unset($_SESSION['error2']);
    }

    if(isset($_POST['addUser'])) {
        $uname = $_POST['uname'];
        $email = $_POST['email'];
        $role = $_POST['role'];
        $pass = $_POST['pass'];
        $repass = $_POST['repass'];

        $result = admin_addUser($uname, $email, $pass, $repass, $role);

        if($result === TRUE) {
            $_SESSION['success'] = "New user added.";
        } elseif ($result === FALSE) {
            $_SESSION['error1'] = "Unable to add new user.";
        } else {
            $_SESSION['error2'] = $result;
        }
        header ("location: admin_User.php");
    }
?>
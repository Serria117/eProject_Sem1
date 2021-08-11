<?php
    session_start();
    require 'adminFunction.php';
    if(isset($_POST['save'])){
        $uid = $_POST['uid'];
        $uname = $_POST['uname'];
        $email = $_POST['email'];
        $pass = $_POST['resetpass'];
        $repass = $_POST['confirmpass'];
        $role = $_POST['role'];
        $status = $_POST['status'];

        $result = admin_updateUser($uid, $uname, $email, $pass, $repass, $role, $status);
        if($result===TRUE){
            $_SESSION['success'] = "User account update successfully.";
            header ("location: admin_User.php"); 
        } else {
            $_SESSION['error2'] = $result;
            header ("location: admin_User.php");
        }
        
    }

?>
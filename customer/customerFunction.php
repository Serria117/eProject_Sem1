<?php
require "../admin/database.php";

function customerValidate($name, $email, $phone, $address, $pass, $rePass) {
    $error = [];
    if(empty($name)) {
        $error['name'] = 'You must enter your name.';
    }
    if(empty($email)) {
        $error['email'] = 'You must enter an email.';
    }
    if(empty($phone)) {
        $error['phone'] = 'You must enter phone number.';
    }
    if(empty($address)) {
        $error['address'] = 'You must enter address.';
    }
    if(empty($pass)) {
        $error['pass'] = 'You must enter password.';
    }
    if(empty($rePass)) {
        $error['rePass'] = 'You must verify your password.';
    }
    if(!empty($pass) && !empty($rePass) && $rePass != $pass){
        $error['verifyPass'] = 'Your password is not matched. Please try again.';
    }
    if(!empty($email)) {
        $conn = connect();
        $email = filter_var($email, FILTER_SANITIZE_EMAIL);
        $sql = "SELECT customerEmail FROM customers WHERE customerEmail = '$email'";
        $result = $conn->query($sql);
        $conn->close();
        if($result->num_rows>0){
            $error['email'] = 'The email you enter has already been taken.';
        }
    }
    return $error;
}

function customerRegister($name, $email, $phone, $address, $pass, $rePass) {
    $conn = connect();
    $validate = customerValidate($name, $email, $phone, $address, $pass, $rePass);
    if(count($validate)===0){
        $name = filter_var($name, FILTER_SANITIZE_STRING);
        $phone = filter_var($phone, FILTER_SANITIZE_NUMBER_INT);
        $address = filter_var($address, FILTER_SANITIZE_STRING);
        $pass = password_hash($pass,PASSWORD_DEFAULT);
        $sql = "INSERT INTO customers (customerName, customerEmail, customerPhone, customerAdd, password)
        VALUES (?, ?, ?, ?, ?)";
        $stm = $conn->prepare($sql);
        $stm->bind_param("sssss", $name, $email, $phone, $address, $pass);
        $stm->execute();
        $stm->close();
        echo "<script>alert('Register successfully.')</script>";
    } else {
        return $validate;
    }
    $conn->close();
}

function customerLogin($email, $pass) {

}

?>
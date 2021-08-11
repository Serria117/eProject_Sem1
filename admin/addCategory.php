<?php
session_start();
require "adminFunction.php";

if (isset($_SESSION['success'])) {
    unset($_SESSION['success']);
}
if (isset($_SESSION['error2'])) {
    unset($_SESSION['error2']);
}

if (isset($_POST['create'])) {
    $cname = $_POST['cname'];
    $cunit = $_POST['cunit'];
    $detail = htmlentities($_POST['detail']);
    $result = admin_addCategory($cname, $cunit, $detail);
    if ($result === true) {
        $_SESSION['success'] = 'New category created.';
    } else {
        $_SESSION['error2'] = $result;
    }
}
if(isset($_SESSION['page'])){
    if($_SESSION['page'] === 'product') {
        header("location: admin_product.php");
    } else {
        header("location: admin_category.php");
    }
}
?>
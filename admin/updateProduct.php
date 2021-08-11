<?php
session_start();
if (isset($_SESSION['errUpdate'])) {
    unset($_SESSION['errUpdate']);
}
if (isset($_SESSION['success'])) {
    unset($_SESSION['success']);
}

require 'adminFunction.php';
if (isset($_POST['save'])) {
    $conn = connect();
    $pid = $_POST['pid'];
    $pname = filter_var($_POST['pname'], FILTER_SANITIZE_STRING);
    $category = $_POST['category'];
    $price = $_POST['price'];
    $detail = htmlspecialchars($_POST['detail']);
    $s = $_POST['status'];
    if ($s === "Sale") {
        $status = 1;
    } elseif ($s === "Discontinued") {
        $status = 0;
    }
    $imgURL = '';
    $errorImg = 0;
    $file = $_FILES['avatar'];
    if ($file['name'] == '') {
        $imgURL = '';
        $errorImg = 0;
    } else {
        $findExt = explode('.', $file['name']);
        $ext = strtolower(end($findExt));
        $allowExt = array('jpg', 'jpeg', 'png', 'gif');
        if (!in_array($ext, $allowExt)) {
            $errorImg = 'Invalid file type. The image format must be JPG, PNG or GIF.';
            
        } else {
            $errorImg = 0;
            $pathUpload = "../imgs/";
            $path = "imgs/";
            $fileName = $file['name'];
            $tmp_name = $file['tmp_name'];
            move_uploaded_file($tmp_name, $pathUpload . $fileName);
            $imgURL = $path . $fileName;
        }
        // echo $errorImg.'<br>';
        // echo $ext.'<br>';
        // echo $file['name'].'<br>';
        // echo $file['error'].'<br>';
        // echo $file['size'].'<br>';
    }
    
    // exit();
    //Return true if success or an array of errors
    $updateResult = admin_updateProduct($pid, $pname, $price, $category, $detail, $imgURL, $status);
    $inputResult = true;
    //Input stock
    if (!empty($_POST['input'])) {
        $input = $_POST['input'];
        $inputResult = admin_input($pid, $input);
    }

    if ($errorImg === 0) {
        if ($updateResult === true && $inputResult === true) {
            $_SESSION['success'] = 'Product updated successfully.';
            header("location: admin_product.php");
        } else if ($updateResult !== true && $inputResult === true) {
            $_SESSION['errUpdate'] = array_merge_recursive($updateResult);
        } elseif ($inputResult !== true && $updateResult === true) {
            $_SESSION['errUpdate'] = array_merge_recursive($inputResult);
        } elseif ($updateResult !== true && $inputResult !== true) {
            $_SESSION['errUpdate'] = array_merge_recursive($updateResult, $inputResult);
        }
    } else {
        if ($updateResult === true && $inputResult === true) {
            $_SESSION['errUpdate']['img'] = $errorImg;
        } else if ($updateResult !== true && $inputResult === true) {
            $_SESSION['errUpdate'] = array_merge_recursive($updateResult);
            array_push($_SESSION['errUpdate'],$errorImg);
        } elseif ($inputResult !== true && $updateResult === true) {
            // $_SESSION['errUpdate']['img'] = $errorImg;
            $_SESSION['errUpdate'] = array_merge_recursive($inputResult);
            array_push($_SESSION['errUpdate'],$errorImg);
        } elseif ($updateResult !== true && $inputResult !== true) {
            // $_SESSION['errUpdate']['img'] = $errorImg;
            $_SESSION['errUpdate'] = array_merge_recursive($updateResult, $inputResult);
            array_push($_SESSION['errUpdate'],$errorImg);
        }
    }
    // print_r ($_SESSION['errUpdate']);
    header("location: admin_product.php");
}
//OK
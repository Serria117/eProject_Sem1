<?php
session_start();
$currentID = $_SESSION['userID'];
require 'adminFunction.php';
$conn = connect();
if (isset($_REQUEST['user'])) {
    $uID = $_REQUEST['user'];
    $sql = "SELECT s.staffID, s.userName, s.status, sr.roleName, sr.roleDetail, s.email, s.status, s.roleID
    FROM staff as s INNER JOIN staffrole as sr ON s.roleID = sr.roleID
    WHERE s.staffID = '$uID'";
    $data = '';
    $user = [];
    $selectRole = '';
    $readonly = '';
    $findUser = $conn->query($sql);
    while ($row = $findUser->fetch_assoc()) {
        $user = $row;
    }

    if ($currentID == 1) {
        if ($user['staffID'] == 1) { //look rootadmin from editing
            $currentStatus = "<option value='Acitve'>Active</option>";
            $selectStatus = '';
            $selectRole = '';
            $readonly = ''; //input fields, only rootadmin can edit their own info
        } else {
            $readonly = '';
            $result = $conn->query("SELECT roleName FROM staffrole WHERE roleName != '{$user['roleName']}'");
            while ($row = $result->fetch_assoc()) {
                $selectRole .= "<option value = '{$row['roleName']}'>{$row['roleName']}</option>";
            }
            switch ($user['status']) {
                case 1:
                    $currentStatus = "<option value='Acitve'>Active</option>";
                    $selectStatus = "<option value='Suspend'>Suspend</option>";
                    break;
                case 0:
                    $currentStatus = "<option value='Suspend'>Suspend</option>";
                    $selectStatus = "<option value='Acitve'>Active</option>";
                    break;
            }
        }
    } else {
        if ($user['staffID'] == 1) { //lock rootadmin from editing
            $currentStatus = "<option value='Acitve'>Active</option>";
            $selectStatus = '';
            $readonly = 'readonly'; //lock rootadmin input field
        } else {
            $readonly = '';
            $result = $conn->query("SELECT roleName FROM staffrole WHERE roleName != '{$user['roleName']}'");
            while ($row = $result->fetch_assoc()) {
                $selectRole .= "<option value = '{$row['roleName']}'>{$row['roleName']}</option>";
            }
            switch ($user['status']) {
                case 1:
                    $currentStatus = "<option value='Acitve'>Active</option>";
                    $selectStatus = "<option value='Suspend'>Suspend</option>";
                    break;
                case 0:
                    $currentStatus = "<option value='Suspend'>Suspend</option>";
                    $selectStatus = "<option value='Acitve'>Active</option>";
                    break;
            }
        }
    }

    $data .= "
        <div class='input-group mb-3'>
            <span class='input-group-text' style='max-width:5%'>ID:</span>
            <input type='text' class='form-control' name='uid' value='{$user['staffID']}' style='max-width:5%' readonly>
            <span class='input-group-text' style='max-width:15%'>User name:</span>
            <input type='text' id='uname' class='form-control' name='uname' value='{$user['userName']}' aria-label='uname' required {$readonly}>
            <span class='input-group-text'>Status:</span>
            <select style='max-width:13%;' class='form-select' name='status' id='status'>
                {$currentStatus}
                {$selectStatus}
            </select>
            <span class='input-group-text'>Account type:</span>
            <select style='max-width:13%;' class='form-select' name='role' id='role'>
                <option value='{$user['roleName']}'>{$user['roleName']}</option>
                {$selectRole}
            </select>
        </div>
        <div class='input-group mb-3'>
            <span class='input-group-text' style='max-width:25%'>Email:</span>
            <input type='text' id='email' class='form-control' name='email' value='{$user['email']}' aria-label='email' required {$readonly}>
        </div>
        <div class='input-group mb-3'>
            <span class='input-group-text'>Re-set password:</span>
            <input type = 'password' class='form-control' id='resetpass' name='resetpass' aria-label='resetpass' {$readonly}>
            <span class='input-group-text'>Confirm password:</span>
            <input type = 'password' class='form-control' id='confirmpass' name='confirmpass' aria-label='confirmpass' {$readonly}>
        </div>
    ";

    $conn->close();
    echo $data;
}

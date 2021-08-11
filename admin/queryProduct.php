<?php
require 'adminFunction.php';
$conn = connect();
if ($_REQUEST['product']) {
    $pid = $_REQUEST['product'];
    $sql = "SELECT pd.productID, pd.imgURL, pd.productID, pd.productName, pd.categoryID, ct.categoryName, pd.productDetail, pd.unitPrice, pd.stock, pd.status
        FROM product as pd 
        INNER JOIN category as ct ON pd.categoryID = ct.categoryID 
        WHERE pd.productID = '$pid'";
    $result = $conn->query($sql);
    while ($row = $result->fetch_assoc()) { //get the category name of the selected product
        $ct = $row['categoryName'];
        $statValue = $row['status'];
    }

    if ($statValue == 1){
        $stat = "Sale";
        $statUpdate = "Discontinued";
    } elseif ($statValue == 0) {
        $stat = "Discontinued";
        $statUpdate = "Sale";}

    //find all category and exclude the selected product's category
    $list = $conn->query("SELECT categoryName FROM category WHERE categoryName NOT LIKE '$ct'");

    //store all <option> tags with categories in a variable
    if ($list->num_rows > 0) {
        $cOption = '';
        $sOption = '';
        while ($item = $list->fetch_assoc()) {
            $cOption .= "<option value='{$item['categoryName']}'>{$item['categoryName']}</option>";
        }
    }
    //store status in a variable

    $result = $conn->query($sql);
    $data = '';
    while ($row = $result->fetch_assoc()) {
        $data .= "
                <div class='input-group mb-1'>
                    
                    <input style='max-width:6%;' type='text' id='pid' class='form-control' name='pid' aria-label='pid' value='{$row['productID']}' readonly>
                    <span class='input-group-text'>Product name:</span>
                    <input type='text' id='pname' class='form-control' name='pname' aria-label='pname' value='{$row['productName']}' required>

                    <input style='max-width:6%; display:none' type='text' id='cid' class='form-control' name='cid' aria-label='cid' value='{$row['categoryID']}' readonly>
                    <span class='input-group-text'>Category:</span>
                    <select class='form-select' style='max-width:30%' name='category' id='ctg'>
                        <option value='{$row['categoryName']}' >{$row['categoryName']}</option>
                        {$cOption}
                    </select>
                    
                </div>
                <div class='input-group mb-3'>
                    <span class='input-group-text'>Unit price:</span>
                    <span class='input-group-text'>$</span>
                    <input type='text' id='price' class='form-control' name='price' aria-label='price' value='{$row['unitPrice']}' required>
                    <span class='input-group-text'>In Stock:</span>
                    <input style='max-width:10%' id='stock' type='text' class='form-control' name='stock' aria-label='stock' readonly value='{$row['stock']}'>
                    <span class='input-group-text'>Add to Stock:</span>
                    <input id='input' type='text' class='form-control' name='input' aria-label='input'>
                    <span class='input-group-text'>Status:</span>
                    <select class='form-select' style='max-width:15%' name='status' id='stt'>
                        <option value='{$stat}'>{$stat}</option>
                        <option value='{$statUpdate}'>{$statUpdate}</option>
                    </select>
                </div>
                <div >
                    <div class='form-floating mb-3' style='position:relative; width:78%; float:left;'>
                        <textarea id='detail' style='height: 120px;' class='form-control' name='detail' aria-label='detail' required>{$row['productDetail']}</textarea>
                        <label for='detail'>Product detail</label>
                    </div>
                    <div class='image' style='position: relative; float:right; width:20%; padding:3px; text-align:center; border:1px solid #dbdbdb; background: white; border-radius: 6px;'>
                        <img src='../{$row['imgURL']}' alt='image' style='width:114px; height:114px'>
                    </div>
                </div>
                <div class='input-group mb-1'>
                    <span class='input-group-text'>New picture:</span>
                    <input type='file' class='form-control' id='customFile' name='avatar' />
                </div>
                <div class='mb-1'>
                    <small id='imgHelp' class='form-text text-muted'>Accept only JPG, PNG and GIF image files.</small>
                </div>
            ";
    }
    $conn->close();
    echo $data;
}

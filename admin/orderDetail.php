<?php

require "adminFunction.php";
$conn = connect();
if (isset($_POST['order'])) {
    $orderID = $_POST['order'];
    $sql = "SELECT * FROM orders as o
        INNER JOIN customers as c ON o.customerID = c.customerID
        LEFT JOIN staff as s on o.staffID = s.staffID
        LEFT JOIN orderdetail as od ON o.orderID = od.orderID
        INNER JOIN product as p ON od.productID = p.productID
        INNER JOIN category as ct ON p.categoryID = ct.categoryID
        WHERE od.orderID = '$orderID'
    ";
    $result = $conn->query($sql);
    while ($row = $result->fetch_assoc()){
        $order = $row;
    }
    
    $orderNo = '#'.sprintf('%05d', $orderID);
    $date = date("d/m/Y h:m-A", strtotime($order['orderTime']));

    $data = "
        Order No.: {$orderNo} ------ Date: {$date} <br>
        Customer: {$order['customerName']}  ----- Phone: {$order['customerPhone']} <br>
        Delivery Address: {$order['deliveryAddress']} <br>
        Current Order Status: {$order['orderStatus']} <br>
        <table class='table'>
        <thead style='background-color: black'>
            <tr>
                <th style='text-align:center;'>Product</th>
                <th style='text-align:center;'>Price</th>
                <th style='text-align:center;'>Quantity</th>
                <th style='text-align:center;'>Unit</th>
                <th style='text-align:center;'>Subtotal</th>
            </tr>
        </thead>
    ";

    $result = $conn->query($sql);
    while($row = $result->fetch_assoc()){
        $subtotal = $row['unitPrice']*$row['quantity'];
        $data .= "
        <tbody>
            <tr>
                <td>{$row['productName']}</td>
                <td>\${$row['orderDetailPrice']}</td>
                <td>{$row['quantity']}</td>
                <td>{$row['unit']}</td>
                <td>\${$subtotal}</td>
            </tr>
        ";
    }
    $data .= "
        <tr style='background-color:black; color:white; font-weight:bold'>
            <td colspan='4'>TOTAL</td>
            <td>\${$order['orderValue']}</td>
        </tr>
    </tbody>
    </table>
    <div class='input-group'>
        <span class='input-group-text'>Status:</span>
        <button style='width: 120px' type='submit' name='cancel' class='btn btn-warning'>
            <i class='fa fa-ban' aria-hidden='true'></i> Cancel
        </button>
        <button style='width: 120px' type='submit' name='return' class='btn btn-secondary'>
            <i class='fa fa-undo' aria-hidden='true'></i> Return
        </button>
        <button style='width: 120px' type='submit' name='success' class='btn btn-success'>
            <i class='fa fa-check' aria-hidden='true'></i> Success
        </button>
    </div>
    ";
    
    echo $data;
}

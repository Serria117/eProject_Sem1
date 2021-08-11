<?php
require 'adminFunction.php';
$conn = connect();
if ($_REQUEST['product']) {
    $pid = $_REQUEST['product'];
}

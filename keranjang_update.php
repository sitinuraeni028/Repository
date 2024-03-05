<?php

session_start();
include 'config.php';
include 'authcheck.php';

$qty = $_POST['qty'];
print_r($qt);

foreach ($_SESSION['cart'] as $key => $value) {

    $_SESSION['cart'][$key]['qty'] = $qty[$key];
}
header('location:kasir.php');
?>
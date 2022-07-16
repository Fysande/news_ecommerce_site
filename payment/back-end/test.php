<?php
    //add to db
    //add to db
    require('../../setup.php');
    require('functions.php');
    require LOGIN_PATH;
    
    //defined variables
    $date = date('Y-m-d');
    $expire_date = date('Y-m-d', strtotime($date. ' + 3 months'));
    $mode = 'paypal';
    $itemAmount = '50';
    $data = [];
    $data['item_name'] = 'Photoshop';

    //array with data to be added to db
    $paymentData = [];
    $paymentData['customer_id'] = $_SESSION['customer_id'];
    $paymentData['amount'] = $itemAmount;
    $paymentData['date_paid'] = $date;
    $paymentData['expire_date'] = $expire_date;
    $paymentData['package_name'] = $data['item_name'];
    $paymentData['mode'] = $mode;

    insertPayment($paymentData);
?>
<?php
    // For test payments we want to enable the sandbox mode. If you want to put live
// payments through then this setting needs changing to `false`.
$enableSandbox = true;

// Database settings. Change these for your database configuration.
$dbConfig = [
    'host' => 'https://f8a4-105-234-166-35.ngrok.io',
    'username' => 'root',
    'password' => '',
    'name' => 'customer_subscription_system'
];

// PayPal settings. Change these to your account details and the relevant URLs
// for your site.
$paypalConfig = [
    'email' => 'sb-i2owc15542927@business.example.com',
    'return_url' => 'http://localhost/customer_subscription_system/payment/back-end/payment-done.php',
    'cancel_url' => 'http://example.com/payment-cancelled.html',
    'notify_url' => 'https://f8a4-105-234-166-35.ngrok.io/customer_subscription_system/payment/payment.php'
];

$paypalUrl = $enableSandbox ? 'https://www.sandbox.paypal.com/cgi-bin/webscr' : 'https://www.paypal.com/cgi-bin/webscr';

// Product being purchased.
//$itemName = 'Test Item';
//$itemAmount = 5.00;

if(isset($_POST['submit'])){
    $item_no = trim($_POST['item_number']);

    if($item_no == 1){
        $itemName = '1 Month';
        $itemAmount = 2.50;
        $duration = ' + 1 month';
    }else if($item_no == 2){
        $itemName = '3 Months';
        $itemAmount = 5.00;
        $duration = ' + 3 months';
    }else if($item_no == 3){
        $itemName = '6 Months';
        $itemAmount = 8.00;
        $duration = ' + 6 months';
    }else{
        header('location:dashboard.php');
    }
}

// Include Functions
require('../../setup.php');
require FUNCTIONS_PATH;
require LOGIN_PATH;

// Check if paypal request or response
if (!isset($_POST["txn_id"]) && !isset($_POST["txn_type"])) {

    // Grab the post data so that we can set up the query string for PayPal.
    // Ideally we'd use a whitelist here to check nothing is being injected into
    // our post data.
    $data = [];
    foreach ($_POST as $key => $value) {
        $data[$key] = stripslashes($value);
    }

    // Set the PayPal account.
    $data['business'] = $paypalConfig['email'];

    // Set the PayPal return addresses.
    $data['return'] = stripslashes($paypalConfig['return_url']);
    $data['cancel_return'] = stripslashes($paypalConfig['cancel_url']);
    $data['notify_url'] = stripslashes($paypalConfig['notify_url']);

    // Set the details about the product being purchased, including the amount
    // and currency so that these aren't overridden by the form data.
    $data['item_name'] = $itemName;
    $data['amount'] = $itemAmount;
    $data['currency_code'] = 'GBP';

    //add to db 
    //defined variables
    $date = date('Y-m-d');
    $expire_date = date('Y-m-d', strtotime($date. $duration));
    $mode = 'paypal';

    //array with data to be added to db
    $paymentData = [];
    $paymentData['customer_id'] = $_SESSION['customer_id'];
    $paymentData['amount'] = $itemAmount;
    $paymentData['date_paid'] = $date;
    $paymentData['expire_date'] = $expire_date;
    $paymentData['package_name'] = $data['item_name'];
    $paymentData['mode'] = $mode;

    if(checkExpireDate($paymentData['customer_id'])){
        insertPayment($paymentData);
        //update reports
        if(dateAvailable(date('Y-m-d'))){
           //get current subscriptions
            $sql = 'SELECT * FROM report WHERE report_date = :day';
            $handle = $pdo->prepare($sql);
            $params = ['day' => date('Y-m-d')];
            $handle->execute($params);
            $getRow = $handle->fetch(PDO::FETCH_ASSOC);

            $subs = $getRow['subscriptions'];
            $new_subs = $subs + 1;


          //update report
          $sql = "UPDATE report SET subscriptions = :s WHERE report_date = :day";
          try{
              $handle = $pdo->prepare($sql);
              $params = [
                  ':s' => $new_subs,
                  ':day' => date('Y-m-d')
              ];
              $handle->execute($params);
              $success[] = 'Profile has been updated successfully';
              echo "Database updated!";
              //header("Location: ../register.php");
          }
          catch(PDOException $e){
              //$errors[] = $e->getMessage();
                echo $e->getMessage();
          }

        }else{
            //insert into report
            $sql = "insert into report (report_date, subscriptions) values(:day, :req)";
            try{
                $handle = $pdo->prepare($sql);
                $params = [
                    ':day' => date('Y-m-d'),
                    ':req' => 1
                ];

                $handle->execute($params);
            }
            catch(PDOException $e){
               //$errors[] = $e->getMessage();
                echo $e->getMessage();
            }
        }
    }else{
        header('location:../../front-end/gohomepage.php');
        exit();
    }


    // Add any custom fields for the query string.
    //$data['custom'] = USERID;

    // Build the query string from the data.
    $queryString = http_build_query($data);

    // Redirect to paypal IPN
    header('location:' . $paypalUrl . '?' . $queryString);
    exit();

} else {
    // Handle the PayPal response.
    // Handle the PayPal response.

// Create a connection to the database.
$db = new mysqli($dbConfig['host'], $dbConfig['username'], $dbConfig['password'], $dbConfig['name']);

// Assign posted variables to local data array.
$data = [
    'item_name' => $_POST['item_name'],
    'item_number' => $_POST['item_number'],
    'payment_status' => $_POST['payment_status'],
    'payment_amount' => $_POST['mc_gross'],
    'payment_currency' => $_POST['mc_currency'],
    'txn_id' => $_POST['txn_id'],
    'receiver_email' => $_POST['receiver_email'],
    'payer_email' => $_POST['payer_email'],
    'custom' => $_POST['custom'],
];
// We need to verify the transaction comes from PayPal and check we've not
// already processed the transaction before adding the payment to our
// database.
if (verifyTransaction($_POST)) {
    if (addPayment($data) !== false) {
        // Payment successfully added.
    }
}
}
?>
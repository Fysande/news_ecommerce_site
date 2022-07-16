<?php
	function checkEmail($email){
		require CONFIG_PATH;

        $sql = 'select * from customer where email = :email';
        $a_sql = 'select * from admin where email = :email';
        $v_sql = 'select * from vendor where email = :email';

        $stmt = $pdo->prepare($sql);
        $a_stmt = $pdo->prepare($a_sql);
        $v_stmt = $pdo->prepare($v_sql);
        $p = ['email' => $email];
        $stmt->execute($p);
        $a_stmt->execute($p);
        $v_stmt->execute($p);

        if($stmt->rowCount() == 0 && $a_stmt->rowCount() == 0 && $v_stmt->rowCount() == 0)
        {
        	//email does'nt exist
        	return false;
        }
        else
        {
            //email exist
        	return true;
        }
	}

    function dateAvailable($date){
        require CONFIG_PATH;

        $sql = 'select * from report where report_date = :date';

        $stmt = $pdo->prepare($sql);
        $p = ['date' => $date];
        $stmt->execute($p);

        if($stmt->rowCount() == 0)
        {
            //date kulibe
            return false;
        }
        else
        {
            //iliko
            return true;
        }
    }

    function vEmail($email,$cus_id){
        require CONFIG_PATH;

        $sql = 'select * from customer where email = :email';
        $stmt = $pdo->prepare($sql);
        $p = ['email' => $email];
        $stmt->execute($p);
        $getRow = $stmt->fetch(PDO::FETCH_ASSOC);

        if($cus_id == $getRow['customer_id']){
            //update shoul work
            return false;
        }else{
            if($stmt->rowCount() == 0)
            {
                //email does'nt exist
                return false;
            }
            else
            {
                //email exist
                return true;
            }
        }
    }

    function sendEmail($email){
        
        //Load Composer's autoloader
        require '../../../composer/vendor/autoload.php';

        //Create an instance; passing `true` enables exceptions
        $mail = new PHPMailer(true);
        

        try {
        //Server settings
        $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
        $mail->isSMTP();                                            //Send using SMTP
        $mail->Host       = 'smtp.gmail.com';                     //Set the SMTP server to send through
        $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
        $mail->Username   = 'fysandy06@gmail.com';                     //SMTP username
        $mail->Password   = 'fysonsande01.';                               //SMTP password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
        $mail->Port       = 465;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

        //Recipients
        $mail->setFrom('fysandy06@gmail.com', 'Timati Technologies');
        $mail->addAddress($email);     //Add a recipient
        $mail->addReplyTo($email);
        //$mail->addCC('cc@example.com');
        //$mail->addBCC('bcc@example.com');

        //Content
        $mail->isHTML(true);                                  //Set email format to HTML
        $mail->Subject = 'Corfirm you registration';
        $mail->Body    = 'Click On This Link to Verify Email '.$link.'';
        $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

        $mail->send();
        echo 'Message has been sent';
        } catch (Exception $e) {
        echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        }
    }

	function validateEmail($email){
		if(filter_var($email, FILTER_VALIDATE_EMAIL))
            {
            	return true;
            }
            else
            {
            	//Email address is not valid
            	return false;
            }
	}


    //payment
    function moneyAvailable($cus_id){
        require('../setup.php');
        require CONFIG_PATH;

        $current_date = date('Y-m-d');
        $sql = "select * from payment where customer_id = :cus_id order by payment_id desc limit 1";
        $stmt = $pdo->prepare($sql);
        $p = ['cus_id' => $cus_id];
        $stmt->execute($p);

        if($stmt->rowCount() == 0){
            //customer doesn't exist in payment
            return false;
        }else{
            //customer exist in payment
            $getRow = $stmt->fetch(PDO::FETCH_ASSOC);
            $exp_date = $getRow['expire_date'];

            if($current_date > $exp_date){
                //date inadutsa
                return false;
            }else{
                return true;
            }
        }
    }

    function insertPayment($paymentData){
    require CONFIG_PATH;

    $sql = "insert into payment (customer_id, amount, date_paid, expire_date, package_name, mode) values(:c_id, :amt, :dt_pd, :ex_dt, :pn, :mode)";
    try{
        $handle = $pdo->prepare($sql);
        $params = [
            ':c_id' => $paymentData['customer_id'],
            ':amt' => $paymentData['amount'],
            ':dt_pd' => $paymentData['date_paid'],
            ':ex_dt' => $paymentData['expire_date'],
            ':pn' => $paymentData['package_name'],
            ':mode' => $paymentData['mode']
        ];

        $handle->execute($params);

        //$success = 'User has been created successfully';
        echo "Payment successfully";
        //header("Location: ../register.php");
    }
    catch(PDOException $e){
        $errors[] = $e->getMessage();
    }
}

function checkExpireDate($customer_id){
    //require('../../setup.php');
    require CONFIG_PATH;

    $current_date = date('Y-m-d');
    $sql = "select * from payment where customer_id = :cus_id order by payment_id desc limit 1";
    $stmt = $pdo->prepare($sql);
    $p = ['cus_id' => $customer_id];
    $stmt->execute($p);

    if($stmt->rowCount() == 0){
        //customer doesn't exist in payment
        return true;
    }else{
        //customer exist in payment
        $getRow = $stmt->fetch(PDO::FETCH_ASSOC);
        $exp_date = $getRow['expire_date'];

        if($current_date > $exp_date){
            //date inadutsa
            return true;
        }else{
            return false;
        }
    }
}

//payment from net

function verifyTransaction($data) {
    global $paypalUrl;

    $req = 'cmd=_notify-validate';
    foreach ($data as $key => $value) {
        $value = urlencode(stripslashes($value));
        $value = preg_replace('/(.*[^%^0^D])(%0A)(.*)/i', '${1}%0D%0A${3}', $value); // IPN fix
        $req .= "&$key=$value";
    }

    $ch = curl_init($paypalUrl);
    curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $req);
    curl_setopt($ch, CURLOPT_SSLVERSION, 6);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 1);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
    curl_setopt($ch, CURLOPT_FORBID_REUSE, 1);
    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 30);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Connection: Close'));
    $res = curl_exec($ch);

    if (!$res) {
        $errno = curl_errno($ch);
        $errstr = curl_error($ch);
        curl_close($ch);
        throw new Exception("cURL error: [$errno] $errstr");
    }

    $info = curl_getinfo($ch);

    // Check the http response
    $httpCode = $info['http_code'];
    if ($httpCode != 200) {
        throw new Exception("PayPal responded with http code $httpCode");
    }
    curl_close($ch);

    return $res === 'VERIFIED';
}

    function checkTxnid($txnid) {
    global $db;

    $txnid = $db->real_escape_string($txnid);
    $results = $db->query('SELECT * FROM payments WHERE txnid = \'' . $txnid . '\'');

    return ! $results->num_rows;
}

function addPayment($data) {
    global $db;

    if (is_array($data)) {
        $stmt = $db->prepare('INSERT INTO payments (txnid, payment_amount, payment_status, itemid, createdtime) VALUES(?, ?, ?, ?, ?)');
        $stmt->bind_param(
            'sdsss',
            $data['txn_id'],
            $data['payment_amount'],
            $data['payment_status'],
            $data['item_number'],
            date('Y-m-d H:i:s')
        );
        $stmt->execute();
        $stmt->close();

        return $db->insert_id;
    }

    return false;
}

    function passwordsMatch($pass, $id){
        require CONFIG_PATH;

        $sql = "select * from customer where customer_id = :id";
        $sql2 = "select * from vendor where vendor_id = :id";
        $handle = $pdo->prepare($sql);
        $handle2 = $pdo->prepare($sql2);
        $params = ['id' => $id];
        $handle->execute($params);
        $handle2->execute($params);
        $getRow = $handle->fetch(PDO::FETCH_ASSOC);
        $getVendor = $handle2->fetch(PDO::FETCH_ASSOC);
        if(password_verify($pass, $getRow['password']) || password_verify($pass, $getVendor['password']))
        {
            return true;
        }
        else
        {
            return false;
        }
    }

    function uploadNewsImage($image){
        $target_dir = "../imgs/news-imgs/";
        $target_file = $target_dir . basename($image["name"]);
        $uploadOk = 1;
        $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

        // Check if image file is a actual image or fake image
        if(isset($_POST["submit"])) {
          $check = getimagesize($image["tmp_name"]);
          if($check !== false) {
            echo "File is an image - " . $check["mime"] . ".";
            $uploadOk = 1;
          } else {
            echo "File is not an image.";
            $uploadOk = 0;
          }
        }

        // Check if file already exists
        if (file_exists($target_file)) {
          echo "Sorry, file already exists.";
          $uploadOk = 0;
        }

        // Check file size
        if ($image["size"] > 5000000) {
          echo "Sorry, your file is too large.";
          $uploadOk = 0;
        }

        // Allow certain file formats
        if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
        && $imageFileType != "gif" ) {
          echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
          $uploadOk = 0;
        }

        // Check if $uploadOk is set to 0 by an error
        if ($uploadOk == 0) {
          echo "Sorry, your file was not uploaded.";
        // if everything is ok, try to upload file
        } else {
          if (move_uploaded_file($image["tmp_name"], $target_file)) {
            echo "The file ". htmlspecialchars( basename( $image["name"])). " has been uploaded.";
          } else {
            echo "Sorry, there was an error uploading your file.";
          }
        }
    }

    function getNews($news_id){
        require CONFIG_PATH;
        $sql = "select * from digital_news where news_id = :id";
        $handle = $pdo->prepare($sql);
        $params = ['id' => $news_id];
        $handle->execute($params);
        $news = $handle->fetch(PDO::FETCH_ASSOC);

        return $news;
      }
?>
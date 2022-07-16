<?php
	if($_GET['key'] && $_GET['token']){
		require_once('db/config.php');
		$email = $_GET['key'];
		$token = $_GET['token'];

		

		$sql = 'select * from customer where email_link = :link';
        $stmt = $pdo->prepare($sql);
        $p = ['link' => $token];
        $stmt->execute($p);
        
        if($stmt->rowCount() > 0){
        	$getRow = $stmt->fetch(PDO::FETCH_ASSOC);
        	if($getRow['email'] == $email){
        		if($getRow['email_verified_at'] == NULL){
        			$d = date('Y-m-d H:i:s');
		        	$sql = "UPDATE customer SET email_verified_at = :day WHERE email = :email";
	                  try{
	                      $handle = $pdo->prepare($sql);
	                      $params = [
	                          ':day' => $d,
	                          ':email' => $email
	                      ];

	                      $handle->execute($params);

	                      echo "Congratulations! Your email has been verified.";
	                  }
	                  catch(PDOException $e){
	                      echo $e->getMessage();
	                  }
			        
		        }else{
		        	echo "You have already verified your account with us";
		        }
        	}else{
        		echo "Link is not for that email";
        	}
        }else{
        	echo "Link is not found!";
        }

        
	}else{
		echo "Danger! Your something goes to wrong.";
	}

?>
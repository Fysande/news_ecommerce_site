<?php
	require_once('functions.php');
	require_once('db/config.php');

	if(isset($_GET['cus_id'])){
		if(moneyAvailable($_GET['cus_id'])){
			//send Email
			//get requests
			$sql = 'SELECT * FROM digital_news WHERE news_id = :id';
		  	$handle = $pdo->prepare($sql);
		  	$params = ['id' => $_GET['news_id']];
		  	$handle->execute($params);
		  	$getRow = $handle->fetch(PDO::FETCH_ASSOC);

		  	//update reports
		  	if(dateAvailable(date('Y-m-d'))){
		  	   //get current requests
		  		$sql = 'SELECT * FROM report WHERE report_date = :day';
			  	$handle = $pdo->prepare($sql);
			  	$params = ['day' => date('Y-m-d')];
			  	$handle->execute($params);
			  	$getRow = $handle->fetch(PDO::FETCH_ASSOC);

			  	$requests = $getRow['requests'];
			  	$new_requests = $requests + 1;


		  	  //update report
		  	  $sql = "UPDATE report SET requests = :r WHERE report_date = :day";
	          try{
	              $handle = $pdo->prepare($sql);
	              $params = [
	                  ':r' => $new_requests,
	                  ':day' => date('Y-m-d')
	              ];
	              $handle->execute($params);
	              //$success[] = 'Profile has been updated successfully';
	              echo "Database updated!";
	              //header("Location: ../register.php");
	          }
	          catch(PDOException $e){
	              //$errors[] = $e->getMessage();
	          		echo $e->getMessage();
	          }

		  	}else{
		  		//insert into report
		  		$sql = "insert into report (report_date, requests) values(:day, :req)";
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

		  	//insert into requests
		  	$sql = "insert into requests (news_id, customer_id, request_date) values(:news_id, :cus_id, :created_at)";
		    try{
		        $handle = $pdo->prepare($sql);
		        $params = [
		            ':news_id' => $_GET['news_id'],
		            ':cus_id' => $_GET['cus_id'],
		            ':created_at' => date('Y-m-d')
		        ];

		        $handle->execute($params);
		    }
		    catch(PDOException $e){
		       //$errors[] = $e->getMessage();
		        echo $e->getMessage();
		    }

		  	//update database
			$requests = $getRow['requests'];
			$new_requests = $requests + 1;
			$sql = "UPDATE digital_news SET requests = :r WHERE news_id = :id";
	          try{
	              $handle = $pdo->prepare($sql);
	              $params = [
	                  ':r' => $new_requests,
	                  ':id' => $_GET['news_id']
	              ];

	              $handle->execute($params);

	              //$success[] = 'Profile has been updated successfully';
	              echo "Database updated!";
	              //header("Location: ../register.php");
	          }
	          catch(PDOException $e){
	              //$errors[] = $e->getMessage();
	          		echo $e->getMessage();
	          }
			echo "Check out your Email... We sent you";
		}else{
			//redirect to payment page
			header('location:../payment/gotopayment.php');
			exit();
		}
	}
?>
<?php
	require_once('../setup.php');
	require_once('../back-end/functions.php');
  require CONFIG_PATH;
    //require FUNCTIONS_PATH;
  require LOGIN_PATH;

    $sql = 'SELECT * FROM customer WHERE customer_id = :id';
  	$handle = $pdo->prepare($sql);
  	$params = ['id' => $_SESSION['customer_id']];
  	$handle->execute($params);
  	$getRow = $handle->fetch(PDO::FETCH_ASSOC);
  	//$d = $handle->fetchAll(PDO::FETCH_ASSOC);

  if(isset($_POST['updateProfile'])){
  	if(isset($_POST['firstname'], $_POST['lastname'], $_POST['username'], $_POST['location']) && !empty($_POST['firstname']) && !empty($_POST['lastname'])  && !empty($_POST['username']) && !empty($_POST['location'])){

  		  $firstName = trim($_POST['firstname']);
        $lastName = trim($_POST['lastname']);
        $username = trim($_POST['username']);
        $location = trim($_POST['location']);

    		$sql = "UPDATE customer SET firstname = :fname, lastname = :lname, username = :uname, location = :loc WHERE customer_id = :id";
          try{
              $handle = $pdo->prepare($sql);
              $params = [
                  ':fname' => $firstName,
                  ':lname' => $lastName,
                  'uname' => $username,
                  ':loc' => $location,
                  ':id' => $_SESSION['customer_id']
              ];

              $handle->execute($params);

              $success[] = 'Profile has been updated successfully';
              //header("Location: ../register.php");
          }
          catch(PDOException $e){
              $errors[] = $e->getMessage();
          }
  	}else{
  		$errors[] = "Fill the correctly!";
  	}

  	if(!empty($errors)){
    $_SESSION['updateError'] = $errors;
     //redirect_to("../test.php");
     header('location:../front-end/editProfile.php');
	}

	if(!empty($success)){
    $_SESSION['updateSucc'] = $success;
     //redirect_to("../test.php");
     header('location:../front-end/editProfile.php');
	}
  }

  if(isset($_POST['updatePass'])){
  	if(isset($_POST['pass'], $_POST['newPass'], $_POST['reNewPass']) && !empty($_POST['pass']) && !empty($_POST['newPass'])  && !empty($_POST['reNewPass'])){

  		$pass = $_POST['pass'];
  		$newPass = $_POST['newPass'];
  		$reNewPass = $_POST['reNewPass'];

  		$options = array("cost" => 4);
	    $hashPassword = password_hash($newPass, PASSWORD_BCRYPT, $options);

  		if($newPass == $reNewPass){
  			if($pass == $newPass){
  				$errors[] = "Your new password should not match old password!";
  			}else{
  				if(passwordsMatch($pass, $_SESSION['customer_id'])){
	    			//update pass here
	    			$sql = "UPDATE customer SET password = :pass WHERE customer_id = :id";
	                  try{
	                      $handle = $pdo->prepare($sql);
	                      $params = [
	                          ':pass' => $hashPassword,
	                          ':id' => $_SESSION['customer_id']
	                      ];

	                      $handle->execute($params);

	                      $success[] = 'Password has been updated successfully';
	                      //header("Location: ../register.php");
	                  }
	                  catch(PDOException $e){
	                      $errors[] = $e->getMessage();
	                  }
	    		}else{
	    			$errors[] = 'Your password is not correct!';
	    		}
  			}
  		}else{
  			$errors[] = 'Passwords do no match!';
  		}

  	}else{
  		$errors[] = 'Fill the form correctlyy!';
  	}
	}
	if(!empty($errors)){
    $_SESSION['updateError'] = $errors;
     //redirect_to("../test.php");
     header('location:../front-end/editProfile.php');
	}

	if(!empty($success)){
    $_SESSION['updateSucc'] = $success;
     //redirect_to("../test.php");
     header('location:../front-end/editProfile.php');
	}
?>
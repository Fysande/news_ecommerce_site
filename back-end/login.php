<?php
	session_start();
	require_once('db/config.php');
	require_once('functions.php');

	if(isset($_POST['submit']))
	{
		if(isset($_POST['email'], $_POST['password']) && !empty($_POST['email']) && !empty($_POST['password']))
		{
			$email = trim($_POST['email']);
			$password = trim($_POST['password']);

			if(filter_var($email, FILTER_VALIDATE_EMAIL))
			{
				$sql = "select * from customer where email = :email";
				$adm_sql = "select * from admin where email = :email";
				$vendor_sql = "select * from vendor where email = :email";

				$handle = $pdo->prepare($sql);
				$adm_handle = $pdo->prepare($adm_sql);
				$vendor_handle = $pdo->prepare($vendor_sql);

				$params = ['email' => $email];

				$handle->execute($params);
				$adm_handle->execute($params);
				$vendor_handle->execute($params);

				if($handle->rowCount() > 0)
				{
					$getRow = $handle->fetch(PDO::FETCH_ASSOC);
						if(password_verify($password, $getRow['password']))
						{
							unset($getRow['password']);
					        $_SESSION = $getRow;
					        header('location:../front-end/home.php');
					        exit();
						}
						else
						{
							$errors[] = "Wrong email or password";
						}
				}else if($adm_handle->rowCount() > 0){
					$getRow = $adm_handle->fetch(PDO::FETCH_ASSOC);
					if(password_verify($password, $getRow['password']))
					{
						unset($getRow['password']);
						$_SESSION = $getRow;
						header('location:../admin/dashboard.php');
						//$errors[] = $_SESSION['username'];
						exit();
					}
					else
					{
						$errors[] = "Wrong email or password";
					}
				}else if($vendor_handle->rowCount() > 0){
					$getRow = $vendor_handle->fetch(PDO::FETCH_ASSOC);
					if(password_verify($password, $getRow['password']))
					{
						unset($getRow['password']);
						$_SESSION = $getRow;
						header('location:../vendor/home.php');
						//$errors[] = $_SESSION['username'];
						exit();
					}
					else
					{
						$errors[] = "Wrong email or password";
					}
				}else{
					$errors[] = 'Wrong email or password all';
				}
			}
			else
			{
				$errors[] = "Email address is not valid";
			}
		}
		else
		{
			$errors[] = "Email and password are required";
		}

		if(!empty($errors)){
	    $_SESSION['value'] = $errors;
	     //redirect_to("../test.php");
	     header('location:../login.php');
		}
	}
?>
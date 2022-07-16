<?php
    require_once('../../setup.php');
	require_once('../../back-end/db/config.php');
    require_once('../../back-end/functions.php');
    
    //admn variables
    $username = "Alessia";
    $email = "ale@ale.ale";
    $password = "Alessia";

    $options = array("cost" => 4);
    $hashPassword = password_hash($password, PASSWORD_BCRYPT, $options);
    $date = date('Y-m-d H:i:s');

    //is email valid??
    if(validateEmail($email))
    {
        //does email exist??
        if(checkEmail($email))
        {
            //$errors[] = 'Email address already registered';
            echo "Email address already registered";   
        }
        else
        {
            $sql = "insert into admin (username, email, password, created_at) values(:uname, :email, :pass, :created_at)";
            try{
                $handle = $pdo->prepare($sql);
                $params = [
                    ':uname' => $username,
                    ':email' => $email,
                    ':pass' => $hashPassword,
                    ':created_at' => $date
                ];

                $handle->execute($params);

                //$success = 'User has been created successfully';
                echo "User has been created successfully";
                //header("Location: ../register.php");
            }
            catch(PDOException $e){
                $errors[] = $e->getMessage();
            }
        }
    }
    else
    {
        //$errors[] = 'Email address is not valid';
        echo "Email address is not valid";
    }

    /*foreach ($errors as $error) {
        # code...
        echo $error;
    }*/
?>
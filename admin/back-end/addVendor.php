<?php
    require_once('../../setup.php');
	require_once('../../back-end/db/config.php');
    require_once('../../back-end/functions.php');

    function generateRandomString($length = 6) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
    }
    
    if(isset($_POST['addVendorBtn'])){
        if (isset($_POST['name'], $_POST['email'], $_POST['location']) && !empty($_POST['email']) && !empty($_POST['location'])){
            $name = $_POST['name'];
            $email = $_POST['email'];
            $location = $_POST['location'];
            $password = generateRandomString();

            $options = array("cost" => 4);
            $hashPassword = password_hash($password, PASSWORD_BCRYPT, $options);
            $date = date('Y-m-d');

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
            $sql = "insert into vendor (name, email, location, password, created_at) values(:name, :email, :loc, :pass, :created_at)";
            try{
                $handle = $pdo->prepare($sql);
                $params = [
                    ':name' => $name,
                    ':email' => $email,
                    ':loc' => $location,
                    ':pass' => $hashPassword,
                    ':created_at' => $date
                ];

                $handle->execute($params);

                //$success = 'User has been created successfully';
                echo "User has been created successfully   ".$password;
                //header("Location: ../register.php");
            }
            catch(PDOException $e){
               //$errors[] = $e->getMessage();
                echo $e->getMessage();
            }
        }
    }
    else
    {
        //$errors[] = 'Email address is not valid';
        echo "Email address is not valid";
    }
        }
    }else{
        echo "no btn clicked!";
    }
    //admn variables
    

    /*foreach ($errors as $error) {
        # code...
        echo $error;
    }*/
?>
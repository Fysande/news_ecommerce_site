<?php
    session_start();

    if(isset($_POST['regBtn'])){
        require_once('../setup.php');
        require CONFIG_PATH;
        require_once('functions.php');
        if(isset($_POST['firstname'], $_POST['lastname'], $_POST['username'], $_POST['email'], $_POST['location'], $_POST['password'], $_POST['cpassword']) && !empty($_POST['firstname']) && !empty($_POST['lastname']) && !empty($_POST['username']) && !empty($_POST['email']) && !empty($_POST['location']) && !empty($_POST['password']) && !empty($_POST['cpassword'])){
            if($_POST['password'] == $_POST['cpassword']){
                //user variables
                $firstname = $_POST['firstname'];
                $surname = $_POST['lastname'];
                $username = $_POST['username'];
                $email = $_POST['email'];
                $location = $_POST['location'];
                $password = $_POST['password'];

                $options = array("cost" => 4);
                $hashPassword = password_hash($password, PASSWORD_BCRYPT, $options);
                $date = date('Y-m-d');
                

                //is email valid??
                if(validateEmail($email))
                {
                    //does email exist??
                    if(checkEmail($email))
                    {
                        $errors[] = 'Email address already registered';
                        //echo "Email address already registered";   
                    }
                    else
                    {
                        $sql = "insert into customer (firstname, lastname, username, email, location, password, created_at) values(:fname, :lname, :uname, :email, :loc, :pass, :date)";
                        try{
                            $handle = $pdo->prepare($sql);
                            $params = [
                                ':fname' => $firstname,
                                ':lname' => $surname,
                                ':uname' => $username,
                                ':email' => $email,
                                ':loc' => $location,
                                ':pass' => $hashPassword,
                                ':date' => $date
                            ];

                            $handle->execute($params);

                            $success[] = 'Registration successfully';
                            
                        }
                        catch(PDOException $e){
                            $errors[] = $e->getMessage();
                        }
                    }
                }
                else
                {
                    $errors[] = 'Email address is not valid';
                    //echo "Email address is not valid";
                }
            }else{
                $errors[] = 'Your passwords do not match!';
            }

        }else{
            $errors[] = 'Fill the form correctlly!';
        }

        if(!empty($errors)){
        $_SESSION['regErrors'] = $errors;
         //redirect_to("../test.php");
         header('location:../register.php');
        }
        if(!empty($success)){
        $_SESSION['regSucc'] = $success;
         //redirect_to("../test.php");
         header('location:../register.php');
        }
    }

    /*foreach ($errors as $error) {
        # code...
        echo $error;
    }*/
?>
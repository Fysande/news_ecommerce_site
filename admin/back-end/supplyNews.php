<?php
    require_once('../../setup.php');
	require_once('../../back-end/db/config.php');
    require_once('../../back-end/functions.php');

    $quantity = 100;
    $price = 750.00;
    $vendor_id = 1;
    //$date = date('Y-m-d');    

    $sql = "insert into vendor_news (quantity, price, vendor_id, date_supplied) values(:qnty, :prc, :vid, :created_at)";
    try{
        $handle = $pdo->prepare($sql);
        $params = [
            ':qnty' => $quantity,
            ':prc' => $price,
            ':vid' => $vendor_id,
            ':created_at' => date('Y-m-d')
        ];

        $handle->execute($params);

        //$success = 'User has been created successfully';
        echo "News has been supplied successfully   ".date('Y-m-d');
        //header("Location: ../register.php");
    }
    catch(PDOException $e){
       //$errors[] = $e->getMessage();
        echo $e->getMessage();
    }
    
    /*if(!isset($_POST['addVendorBtn'])){
        if (!isset($_POST['name'], $_POST['email'], $_POST['location']) && !empty($_POST['email']) && !empty($_POST['location'])){
            
            $quantity = 100;
            $price = 750.00;
            $vendor_id = 1;
            $date = date('Y-m-d');    
        
            $sql = "insert into news (quantity, price, vendor_id, date_supplied) values(:qnty, :prc, :vid, :created_at)";
            try{
                $handle = $pdo->prepare($sql);
                $params = [
                    ':qnty' => $quantity,
                    ':prc' => $price,
                    ':vid' => $vendor_id,
                    ':created_at' => $date,
                ];

                $handle->execute($params);

                //$success = 'User has been created successfully';
                echo "News has been supplied successfully   ".$password;
                //header("Location: ../register.php");
            }
            catch(PDOException $e){
               //$errors[] = $e->getMessage();
                echo $e->getMessage();
            }
        }
    }*/
    //admn variables
    

    /*foreach ($errors as $error) {
        # code...
        echo $error;
    }*/
?>
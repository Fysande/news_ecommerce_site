<?php
	//$message = '';
	if(isset($_POST['addBtn'])){
		require_once('../../back-end/db/config.php');
		require_once('../../back-end/functions.php');
		if (isset($_POST['title'], $_POST['company'], $_POST['date'], $_POST['description']) && !empty($_POST['title']) && !empty($_POST['company']) && !empty($_POST['date']) && !empty($_POST['description'])){

		  $image = $_FILES['image'];
		  $title = $_POST['title'];
		  $company = $_POST['company'];
		  $news_date = $_POST['date'];
		  $description = $_POST['description'];
		  $requests = 0;

		  //upload News image
	      uploadNewsImage($image);

		  $sql = 'INSERT INTO digital_news(title, company, description, news_date, date_added, requests, image) VALUES(:title, :company, :description, :news_date, :date_added, :requests, :image)';
		  
		  try{
	        $handle = $pdo->prepare($sql);
	        $params = [
	            ':title' => $title,
	            ':company' => $company,
	            ':description' => $description,
	            ':news_date' => $news_date,
	            ':date_added' => date('Y-m-d'),
	            ':requests' => $requests,
	            ':image' => $image['name']
	        ];

	        $handle->execute($params);
	        echo "News has been added successfully";
	        //$success[] = 'News has been added successfully';
	        //header('location:../addLecture.html');
	        //header("Location: ../register.php");
	    }
	    catch(PDOException $e){
	    	echo $e->getMessage();
	        //$errors[] = $e->getMessage();
	    }
	}else{
		//$errors[] =  "Fill the form collectlly";
		echo "Fill the form collectlly";
	}


	if(!empty($errors)){
    $_SESSION['addNewsError'] = $errors;
     //redirect_to("../test.php");
     header('location:../addNews.html');
	}
	if(!empty($success)){
    $_SESSION['addNewsSucc'] = $success;
     //redirect_to("../test.php");
     header('location:../addNews.html');
	}
}
?>
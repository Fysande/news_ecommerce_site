<?php
  include 'header.html';
  require_once('../back-end/db/config.php');
  require_once('../back-end/functions.php');
  if(isset($_POST['addBtn'])){
    if (isset($_POST['title'], $_POST['company'], $_POST['date'], $_POST['description']) && !empty($_POST['title']) && !empty($_POST['company']) && !empty($_POST['date']) && !empty($_POST['description'])){

        $image = $_FILES['image'];
        $title = $_POST['title'];
        $company = $_POST['company'];
        $news_date = $_POST['date'];
        $price = $_POST['price'];
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
            $success[] = 'News has been added successfully';
        }
        catch(PDOException $e){
          echo $e->getMessage();
            $errors[] = $e->getMessage();
        }
    }else{
      $errors[] =  "Fill the form collectlly";
    }
  }
?>
<main id="main" class="main">

    <div class="pagetitle">
      <h1>Add News</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="index.html">Home</a></li>
          <li class="breadcrumb-item active">View Products</li>
        </ol>
      </nav>
    </div><!-- End Page Title -->

    <section class="section dashboard">
      <div class="row">

    <!-- Left side columns -->
    <div class="col-lg-12">
      <div class="row">
        <div class="card">
            <div class="card-body">
              <h5 class="card-title">Fill this form to add news</h5>
              <?php
                  if(isset($errors))
                  {
                    foreach ($errors as $error) {
                      echo '<h4 class="text-center text-danger" >'.$error.'</h4>';
                    }
                  }

                  if(isset($success))
                  {
                    foreach ($success as $suc) {
                      echo '<h4 class="text-center text-success" >'.$suc.'</h4>';
                    }
                  }
                ?>
                <!-- Multi Columns Form -->
              <form class="row g-3" id="dscrp" action="addNews.php" method="post" enctype="multipart/form-data">
              	<div class="col-md-6">
                  <label for="inputName5" class="form-label">News Image</label>
                  <input type="file" class="form-control" id="inputName5" name="image">
                </div>
                <div class="col-md-6">
                  <label for="inputName5" class="form-label">News Title</label>
                  <input type="text" class="form-control" id="inputName5" name="title">
                </div>
                <div class="col-md-6">
                  <label for="inputEmail5" class="form-label">Company</label>
                  <input type="text" class="form-control" id="inputEmail5" name="company">
                </div>
                <div class="col-md-6">
                  <label for="inputPassword5" class="form-label">News Date</label>
                  <input type="date" class="form-control" id="inputPassword5" name="date">
                </div>
                <div class="col-md-6">
                  <label for="inputAddress2" class="form-label">Descriptions</label>
                  <textarea name="description" form="dscrp" class="form-control" placeholder="Add description" id="floatingTextarea" style="height: 100px;"></textarea>
                </div>
                <div class="text-center">
                  <button type="submit" class="btn btn-primary" name="addBtn">Add News</button>
                  <button type="reset" class="btn btn-secondary">Reset</button>
                </div>
              </form><!-- End Multi Columns Form -->
            </div>
          </div>        
      </div>
    </div><!-- End Left side columns -->


</div>
</section>

</main><!-- End #main -->
<?php
  include 'footer.html'
?>
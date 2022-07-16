<?php
    include '../setup.php';
    require CONFIG_PATH;

    if(!isset($_GET['vid'])){
      header('location: manageVendors.php');
    }

    include 'header.html';

    if(isset($_POST['supplyBtn'])){
      if(isset($_POST['quantity'], $_POST['date']) && !empty($_POST['quantity']) && !empty($_POST['date']))
      {
        $today = date('Y-m-d');
        if($_POST['date'] > $today){
          $errors[] = 'Date cannot in the future';
        }else{
          $sql = "insert into vendor_news (quantity, vendor_id, date_supplied) values(:qnty, :vid, :created_at)";
          try{
            $handle = $pdo->prepare($sql);
            $params = [
                ':qnty' => $_POST['quantity'],
                ':vid' => $_GET['vid'],
                ':created_at' => $_POST['date']
            ];

            $handle->execute($params);
            $success[] = "News has been supplied";
        }
        catch(PDOException $e){
           $errors[] = $e->getMessage();
        }
      }
    }else{
      $errors[] = 'Fill the form collectly';
    }
    }
?>
<main id="main" class="main">

    <div class="pagetitle">
      <h1>Supply News to Vendor</h1>
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
                  if(isset($success)){
                    foreach ($success as $suc) {
                      echo '<h4 class="text-center text-success">' .$suc. '</h4>';
                    }
                  }

                  if(isset($errors)){
                    foreach ($errors as $error) {
                      echo '<h4 class="text-center text-warning">' .$error. '</h4>';
                    }
                  }
                ?>
                <!-- Multi Columns Form -->
              <form class="row g-3" id="dscrp" action="supplyNews.php?vid=<?php echo $_GET['vid'] ?>" method="post" enctype="multipart/form-data">
                <div class="col-md-6">
                  <label for="inputEmail5" class="form-label">Quantity</label>
                  <input type="number" class="form-control" id="inputEmail5" name="quantity">
                </div>
                <div class="col-md-6">
                  <label for="inputPassword5" class="form-label">News Date</label>
                  <input type="date" class="form-control" id="inputPassword5" name="date">
                </div>
                <div class="text-center">
                  <button type="submit" class="btn btn-primary" name="supplyBtn">Supply News</button>
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
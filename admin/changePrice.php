<?php
    include 'header.html';
    include '../setup.php';
    require CONFIG_PATH;
    $today = date('Y-m-d');

    if(isset($_POST['setPrice'])){
      if (isset($_POST['date'], $_POST['price']) && !empty($_POST['date']) && !empty($_POST['price'])){
        $sql = 'SELECT * FROM price WHERE date = date';
        $stmt = $pdo->prepare($sql);
        $p = ['date' => $_POST['date']];
        $stmt->execute($p);

        if($stmt->rowCount() == 0)
        {
          //date does'nt exist
          $sql = "insert into price (date, price) values(:date, :price)";
          try{
              $handle = $pdo->prepare($sql);
              $params = [
                  ':date' => $_POST['date'],
                  ':price' => $_POST['price']
              ];

              $handle->execute($params);

              $success[] = "Price has been set!";
          }
          catch(PDOException $e){
             $errors[] = $e->getMessage();
          }
        }
        else
        {
            //email exist
            $sql = "UPDATE price SET price = :price WHERE date = :date";
            try{
                $handle = $pdo->prepare($sql);
                $params = [
                    ':price' => $_POST['price'],
                    ':date' => $_POST['date']
                ];

                $handle->execute($params);

                $success[] = 'News price has been updated!';
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
      <h1>Set News Price</h1>
    </div><!-- End Page Title -->

    <section class="section dashboard">
      <div class="row">

    <!-- Left side columns -->
    <div class="col-lg-12">
      <div class="row">
        <div class="card">
            <div class="card-body">
              <h5 class="card-title">Fill this form to set news price</h5>
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
              <form class="row g-3" id="dscrp" action="changeprice.php" method="post" enctype="multipart/form-data">

                <div class="col-md-6">
                  <label for="inputPassword5" class="form-label">News Date</label>
                  <input type="date" class="form-control" id="inputPassword5" name="date" value="<?php echo $today; ?>" readonly>
                </div>
                <div class="col-md-6">
                  <label for="inputEmail5" class="form-label">Price</label>
                  <input type="text" class="form-control" id="inputEmail5" name="price">
                </div>
                <div class="text-center">
                  <button type="submit" class="btn btn-primary" name="setPrice">Set Price</button>
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
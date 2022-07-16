<?php
  include 'header.html';
  require_once('../setup.php');
  require_once('../back-end/db/config.php');
  require_once('../back-end/functions.php');

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
    if (isset($_POST['name'], $_POST['email'], $_POST['location']) && !empty($_POST['name']) && !empty($_POST['email']) && !empty($_POST['location'])){

          $name = $_POST['name'];
          $email = $_POST['email'];
          $location = $_POST['location'];
          //$password = generateRandomString();
          $password = "malawi";

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

                      $success[] = "User has been created successfully";
                  }
                  catch(PDOException $e){
                     $errors[] = $e->getMessage();
                  }
              }
          }
          else
          {
              $errors[] = 'Email address is not valid';
          }

    }else{
      $errors[] = 'Fill the form collectly';
    }
  }
?>
<main id="main" class="main">

    <div class="pagetitle">
      <h1>Add Vendor</h1>
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
              <h5 class="card-title">Fill this form to add author</h5>
              <?php
                if(isset($errors)){
                  foreach ($errors as $error) {
                    echo '<h5 class="text-center text-danger">'.$error.'</h5>';
                  }
                }

                if(isset($success)){
                  foreach ($success as $suc) {
                    echo '<h5 class="text-center text-success">'.$suc.'</h5>';
                  }
                }
              ?>
                <!-- Multi Columns Form -->
              <form class="row g-3" id="dscrp" action="addAuthor.php" method="post">
                <div class="col-md-12">
                  <label for="inputName5" class="form-label">Name</label>
                  <input name="name" type="text" class="form-control" id="inputName5">
                </div>
                <div class="col-md-12">
                  <label for="inputEmail5" class="form-label">Email</label>
                  <input name="email" type="email" class="form-control" id="inputEmail5">
                </div>
                <div class="col-12">
                  <label for="inputEmail5" class="form-label">Location</label>
                  <input name="location" type="text" class="form-control" id="inputEmail5">
                </div>
                <div class="text-center">
                  <button name="addVendorBtn" type="submit" class="btn btn-primary">Add Vendor</button>
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
<?php
  include 'header.html';
  require_once('../setup.php');
  require CONFIG_PATH;
  require FUNCTIONS_PATH;

  $sql = 'SELECT * FROM vendor WHERE vendor_id = :id';
  $handle = $pdo->prepare($sql);
  $params = ['id' => $_SESSION['vendor_id']];
  $handle->execute($params);
  $getRow = $handle->fetch(PDO::FETCH_ASSOC);

  if(isset($_POST['updateProfile'])){
    if(isset($_POST['name'], $_POST['location']) && !empty($_POST['name']) && !empty($_POST['location'])){

        $firstName = trim($_POST['name']);
        $location = trim($_POST['location']);

        $sql = "UPDATE vendor SET name = :name, location = :loc WHERE vendor_id = :id";
          try{
              $handle = $pdo->prepare($sql);
              $params = [
                  ':name' => $firstName,
                  ':loc' => $location,
                  ':id' => $_SESSION['vendor_id']
              ];

              $handle->execute($params);

              $success[] = 'Profile has been updated successfully';
          }
          catch(PDOException $e){
              $errors[] = $e->getMessage();
          }
    }else{
      $errors[] = "Fill the correctly!";
    }
  }


  if(isset($_POST['updatePass'])){
    if(isset($_POST['pass'], $_POST['newPass'], $_POST['reNewPass']) && !empty($_POST['pass']) && !empty($_POST['newPass'])  && !empty($_POST['reNewPass'])){

      $pass = $_POST['pass'];
      $newPass = $_POST['newPass'];
      $reNewPass = $_POST['reNewPass'];

      $options = array("cost" => 4);
      $hashPassword = password_hash($newPass, PASSWORD_BCRYPT, $options);

      if($newPass == $reNewPass){
        if($pass == $newPass){
          $errors[] = "Your new password should not match old password!";
        }else{
          if(passwordsMatch($pass, $_SESSION['vendor_id'])){
            //update pass here
            $sql = "UPDATE vendor SET password = :pass WHERE vendor_id = :id";
                    try{
                        $handle = $pdo->prepare($sql);
                        $params = [
                            ':pass' => $hashPassword,
                            ':id' => $_SESSION['vendor_id']
                        ];

                        $handle->execute($params);

                        $success[] = 'Password has been updated successfully';
                        //header("Location: ../register.php");
                    }
                    catch(PDOException $e){
                        $errors[] = $e->getMessage();
                    }
          }else{
            $errors[] = 'Your password is not correct!';
          }
        }
      }else{
        $errors[] = 'Passwords do no match!';
      }

    }else{
      $errors[] = 'Fill the form correctlyy!';
    }
  }
?>
  <main id="main" class="main" id="top">
        <div class="row gx-4 gx-lg-5 justify-content-center">
        <div class="col-lg-8 col-xl-6 text-center">
            <h2 class="mt-5">Profile</h2>
            <hr class="divider" />
        </div>
    </div>
    <section class="section profile">
      <?php
        if(isset($success)){
          foreach ($success as $suc) {
            echo '<h4 class="text-center fw-bold mx-3 mb-0 text-success mb-3">'.$suc.'</h4>';
          }
        }

        if(isset($errors)){
          foreach ($errors as $error) {
            echo '<h4 class="text-center fw-bold mx-3 mb-0 text-danger mb-3">'.$error.'</h4>';
          }
        }
      ?>
      <div class="row">
        <div class="col-xl-4">

          <div class="card">
            <div class="card-body profile-card pt-4 d-flex flex-column align-items-center">

              <img src="assets/img/profile.jpg" alt="Profile" class="rounded-circle">
              <h2><?php echo $getRow['name']; ?></h2>
              <h5 style="color: #ca0405;">Vendor</h5>
            </div>
          </div>

        </div>

        <div class="col-xl-8">

          <div class="card">
            <div class="card-body pt-3">
              <!-- Bordered Tabs -->
              <ul class="nav nav-tabs nav-tabs-bordered">

                <li class="nav-item">
                  <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#profile-overview">Overview</button>
                </li>

                <li class="nav-item">
                  <button class="nav-link" data-bs-toggle="tab" data-bs-target="#profile-edit">Edit Profile</button>
                </li>

                <li class="nav-item">
                  <button class="nav-link" data-bs-toggle="tab" data-bs-target="#profile-change-password">Change Password</button>
                </li>

              </ul>
              <div class="tab-content pt-2">

                <div class="tab-pane fade show active profile-overview" id="profile-overview">
                  <h5 class="card-title">Profile Details</h5>

                  <div class="row">
                    <div class="col-lg-3 col-md-4 label ">Full Name</div>
                    <div class="col-lg-9 col-md-8"><?php echo $getRow['name']; ?></div>
                  </div>
                  <div class="row">
                    <div class="col-lg-3 col-md-4 label">Email</div>
                    <div class="col-lg-9 col-md-8"><?php echo $getRow['email']; ?></div>
                  </div>

                  <div class="row">
                    <div class="col-lg-3 col-md-4 label">Location</div>
                    <div class="col-lg-9 col-md-8"><?php echo $getRow['location']; ?></div>
                  </div>

                  <div class="row">
                    <div class="col-lg-3 col-md-4 label">Joined at</div>
                    <div class="col-lg-9 col-md-8"><?php echo $getRow['created_at']; ?></div>
                  </div>
                </div>

                <div class="tab-pane fade profile-edit pt-3" id="profile-edit">

                  <!-- Profile Edit Form -->
                  <form action="profile.php" method="post" enctype="multipart/form-data">
                    
                    <div class="row mb-3">
                      <label for="profileImage" class="col-md-4 col-lg-3 col-form-label">Profile Image</label>
                      <div class="col-md-8 col-lg-9">
                        <img src="assets/img/profile.jpg" alt="Profile">
                      </div>
                    </div>

                    <div class="row mb-3">
                      <label for="fullName" class="col-md-4 col-lg-3 col-form-label">Full Name</label>
                      <div class="col-md-8 col-lg-9">
                        <input name="name" type="text" class="form-control" id="fullName" value="<?php echo $getRow['name']; ?>">
                      </div>
                    </div>

                    <div class="row mb-3">
                      <label for="Address" class="col-md-4 col-lg-3 col-form-label">Location</label>
                      <div class="col-md-8 col-lg-9">
                        <input name="location" type="text" class="form-control" id="Address" value="<?php echo $getRow['location']; ?>">
                      </div>
                    </div>

                    <div class="text-center">
                      <button type="submit" class="btn batani" name="updateProfile">Save Changes</button>
                    </div>
                  </form><!-- End Profile Edit Form -->

                </div>

                <div class="tab-pane fade pt-3" id="profile-settings">

                </div>

                <div class="tab-pane fade pt-3" id="profile-change-password">
                  <!-- Change Password Form -->
                  <form action="profile.php" method="post">

                    <div class="row mb-3">
                      <label for="currentPassword" class="col-md-4 col-lg-3 col-form-label">Current Password</label>
                      <div class="col-md-8 col-lg-9">
                        <input name="pass" type="password" class="form-control" id="currentPassword">
                      </div>
                    </div>

                    <div class="row mb-3">
                      <label for="newPassword" class="col-md-4 col-lg-3 col-form-label">New Password</label>
                      <div class="col-md-8 col-lg-9">
                        <input name="newPass" type="password" class="form-control" id="newPassword">
                      </div>
                    </div>

                    <div class="row mb-3">
                      <label for="reNewPass" class="col-md-4 col-lg-3 col-form-label">Re-enter New Password</label>
                      <div class="col-md-8 col-lg-9">
                        <input name="reNewPass" type="password" class="form-control" id="renewPassword">
                      </div>
                    </div>

                    <div class="text-center">
                      <button type="submit" class="btn batani" name="updatePass">Change Password</button>
                    </div>
                  </form><!-- End Change Password Form -->

                </div>

              </div><!-- End Bordered Tabs -->

            </div>
          </div>

        </div>
      </div>
    </section>
  </main><!-- End #main -->

        <!-- Footer-->
        <footer class="bg-light py-5">
            <div class="container px-4 px-lg-5"><div class="small text-center text-muted">Copyright &copy; 2022</div></div>
        </footer>
        <!-- Bootstrap core JS-->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
        <!-- SimpleLightbox plugin JS-->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/SimpleLightbox/2.1.0/simpleLightbox.min.js"></script>
        <!-- Core theme JS-->
        <script src="js/scripts.js"></script>
        <script src="https://cdn.startbootstrap.com/sb-forms-latest.js"></script>

        <!-- Vendor JS Files -->
        <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>


        <!-- Vendor JS Files -->
        <script src="assets/vendor/apexcharts/apexcharts.min.js"></script>
        <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
        <script src="assets/vendor/chart.js/chart.min.js"></script>
        <script src="assets/vendor/echarts/echarts.min.js"></script>
        <script src="assets/vendor/quill/quill.min.js"></script>
        <script src="assets/vendor/simple-datatables/simple-datatables.js"></script>
        <script src="assets/vendor/tinymce/tinymce.min.js"></script>
        <script src="assets/vendor/php-email-form/validate.js"></script>

        <!-- Template Main JS File -->
        <script src="assets/js/main.js"></script>
</body>
</html>
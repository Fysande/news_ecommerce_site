<?php
  include 'header.html';
  include '../setup.php';
  include CONFIG_PATH;
  include FUNCTIONS_PATH;
  $sql = "select * from admin where admin_id = :id";
  $handle = $pdo->prepare($sql);
  $params = ['id' => $_SESSION['admin_id']];
  $handle->execute($params);
  $getAdm = $handle->fetch(PDO::FETCH_ASSOC);

  if(isset($_POST['updateProfile'])){
    if(isset($_POST['username'], $_POST['email']) && !empty($_POST['username']) && !empty($_POST['email'])){

        $sql = "UPDATE admin SET username = :uname, email = :email WHERE admin_id = :id";
          try{
              $handle = $pdo->prepare($sql);
              $params = [
                  ':uname' => $_POST['username'],
                  ':email' => $_POST['email'],
                  ':id' => $_SESSION['admin_id']
              ];

              $handle->execute($params);

              $success[] = 'Profile has been updated successfully';
              //header("Location: ../register.php");
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
          if(passwordsMatch($pass, $_SESSION['customer_id'])){
            //update pass here
            $sql = "UPDATE admin SET password = :pass WHERE admin_id = :id";
                    try{
                        $handle = $pdo->prepare($sql);
                        $params = [
                            ':pass' => $hashPassword,
                            ':id' => $_SESSION['admin_id']
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

  if(isset($_POST['addAdmin'])){
    if (isset($_POST['name'], $_POST['email'], $_POST['password']) && !empty($_POST['name']) && !empty($_POST['email']) && !empty($_POST['password'])){

          $name = $_POST['name'];
          $email = $_POST['email'];
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
              }
              else
              {
                  $sql = "insert into admin (username, email, password, created_at) values(:name, :email, :pass, :created_at)";
                  try{
                      $handle = $pdo->prepare($sql);
                      $params = [
                          ':name' => $name,
                          ':email' => $email,
                          ':pass' => $hashPassword,
                          ':created_at' => $date
                      ];

                      $handle->execute($params);

                      $success[] = "User has been created successfully   ";
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
      <h1>Profile</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="index.html">Home</a></li>
          <li class="breadcrumb-item">Users</li>
          <li class="breadcrumb-item active">Profile</li>
        </ol>
      </nav>
    </div><!-- End Page Title -->

    <section class="section profile">
      <div class="row">
        <div class="col-xl-4">

          <div class="card">
            <div class="card-body profile-card pt-4 d-flex flex-column align-items-center">

              <img src="assets/img/profile.jpg" alt="Profile" class="rounded-circle">
              <h2><?php echo $getAdm['username']; ?></h2>
              <h3>Administrator</h3>
            </div>
          </div>

        </div>

        <div class="col-xl-8">
          <div class="card">
            <div class="card-body pt-3">
              <?php
                if(isset($errors)){
                  foreach ($errors as $error) {
                    echo '<h3 class="text-center text-danger">'.$error.'</h3>';
                  }
                }

                if(isset($success)){
                  foreach ($success as $suc) {
                    echo '<h3 class="text-center text-success">'.$suc.'</h3>';
                  }
                }
              ?>
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

                <li class="nav-item">
                  <button class="nav-link" data-bs-toggle="tab" data-bs-target="#profile-add-admin">Add Admin</button>
                </li>

              </ul>
              <div class="tab-content pt-2">

                <div class="tab-pane fade show active profile-overview" id="profile-overview">

                  <h5 class="card-title">Profile Details</h5>

                  <div class="row">
                    <div class="col-lg-3 col-md-4 label ">Username</div>
                    <div class="col-lg-9 col-md-8"><?php echo $getAdm['username']; ?></div>
                  </div>

                  <div class="row">
                    <div class="col-lg-3 col-md-4 label">Email</div>
                    <div class="col-lg-9 col-md-8"><?php echo $getAdm['email']; ?></div>
                  </div>
                  <div class="row">
                    <div class="col-lg-3 col-md-4 label">Date added</div>
                    <div class="col-lg-9 col-md-8"><?php echo $getAdm['created_at']; ?></div>
                  </div>

                </div>

                <div class="tab-pane fade profile-edit pt-3" id="profile-edit">

                  <!-- Profile Edit Form -->
                  <form action="myProfile.php" method="post">
                    <div class="row mb-3">
                      <label for="username" class="col-md-4 col-lg-3 col-form-label">Username</label>
                      <div class="col-md-8 col-lg-9">
                        <input name="username" type="text" class="form-control" id="fullName" value="<?php echo $getAdm['username']; ?>">
                      </div>
                    </div>

                    <div class="row mb-3">
                      <label for="company" class="col-md-4 col-lg-3 col-form-label">Email</label>
                      <div class="col-md-8 col-lg-9">
                        <input name="email" type="email" class="form-control" id="company" value="<?php echo $getAdm['email']; ?>">
                      </div>
                    </div>

                    <div class="text-center">
                      <button type="submit" class="btn btn-primary" name="updateProfile">Save Changes</button>
                    </div>
                  </form><!-- End Profile Edit Form -->

                </div>

                <div class="tab-pane fade pt-3" id="profile-change-password">
                  <!-- Change Password Form -->
                  <form action="myProfile.php" method="post">

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
                      <button name="updatePass" type="submit" class="btn btn-primary">Change Password</button>
                    </div>
                  </form><!-- End Change Password Form -->

                </div>

                <div class="tab-pane fade pt-3" id="profile-add-admin">
                    <div class="card">
            <div class="card-body">
              <h5 class="card-title">Fill this form to add new adminstrator</h5>

              <!-- No Labels Form -->
              <form class="row g-3" action="myProfile.php" method="post">
                <div class="col-md-12">
                  <input name="name" type="text" class="form-control" placeholder="Username" autocomplete="off">
                </div>
                <div class="col-md-12">
                  <input name="email" type="email" class="form-control" placeholder="Email">
                </div>
                <div class="col-md-12">
                  <input name="password" type="password" class="form-control" placeholder="Password" value="123456" autocomplete="off">
                </div>
                <div class="text-center">
                  <button name="addAdmin" type="submit" class="btn btn-primary">Submit</button>
                  <button type="reset" class="btn btn-secondary">Reset</button>
                </div>
              </form><!-- End No Labels Form -->

            </div>
          </div>
                </div>

              </div><!-- End Bordered Tabs -->

            </div>
          </div>

        </div>
      </div>
    </section>

</main><!-- End #main -->
<?php
  include 'footer.html'
?>
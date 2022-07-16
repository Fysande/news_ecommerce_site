<?php
  include 'header.html';
  include '../setup.php';
  include CONFIG_PATH;
  include FUNCTIONS_PATH;

  if(!isset($_GET['nid'])){
    header('location: viewProducts.php');
  }
  $sql = "select * from digital_news where news_id = :id";
  $handle = $pdo->prepare($sql);
  $params = ['id' => $_GET['nid']];
  $handle->execute($params);
  $getNews = $handle->fetch(PDO::FETCH_ASSOC);

  if(isset($_POST['updateBtn'])){
    if(isset($_POST['title'], $_POST['company'], $_POST['description']) && !empty($_POST['title']) && !empty($_POST['company'])  && !empty($_POST['description'])){

        $sql = "UPDATE digital_news SET title = :title, company = :cpny, description = :descr WHERE news_id = :id";
          try{
              $handle = $pdo->prepare($sql);
              $params = [
                  ':title' => $_POST['title'],
                  ':cpny' => $_POST['company'],
                  ':descr' => trim($_POST['description']),
                  ':id' => $_GET['nid']
              ];
              $handle->execute($params);
              $success[] = 'News has been updated!';
          }
          catch(PDOException $e){
              $errors[] = $e->getMessage();
          }
    }else{
      $errors[] = "Fill the correctly!";
    }

    if(isset($_FILES['image']) && !empty($_FILES['image'])){
      uploadNewsImage($_FILES['image']);

      $sql = "UPDATE digital_news SET image = :img WHERE news_id = :id";
          try{
              $handle = $pdo->prepare($sql);
              $params = [
                  ':img' => $_FILES['image']['name'],
                  ':id' => $_GET['nid']
              ];
              $handle->execute($params);
              $success[] = 'Image has been updated!';
          }
          catch(PDOException $e){
              $errors[] = $e->getMessage();
          }
    }
  }
?>
<main id="main" class="main">

    <div class="pagetitle">
      <h1>News Profile</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="index.html">Home</a></li>
          <li class="breadcrumb-item active">View News</li>
        </ol>
      </nav>
    </div><!-- End Page Title -->

    <section class="section profile">
      <div class="row">
        <div class="col-xl-4">

          <div class="card">
            <div class="card-body profile-card pt-4 d-flex flex-column align-items-center">

              <img width="60%" height="60%" src="../imgs/news-imgs/<?php echo $getNews['image']; ?>" />
              <h2><?php echo $getNews['title']; ?></h2>
            </div>
          </div>

        </div>

        <div class="col-xl-8">

          <div class="card">
            <div class="card-body pt-3">
              <?php
                if(isset($errors)){
                  foreach ($errors as $error) {
                    echo '<h4 class = "text-center text-danger">'.$error.'</h4>';
                  }
                }

                if(isset($success)){
                  foreach ($success as $suc) {
                    echo '<h4 class = "text-center text-success">'.$suc.'</h4>';
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

              </ul>
              <div class="tab-content pt-2">

                <div class="tab-pane fade show active profile-overview" id="profile-overview">

                  <h5 class="card-title">News Details</h5>
                  <div class="row">
                    <div class="col-lg-3 col-md-4 label ">News Image</div>
                    <div class="col-md-8 col-lg-9">
                      <img width="50%" height="50%" src="../imgs/news-imgs/<?php echo $getNews['image']; ?>" />
                    </div>
                  </div>

                  <div class="row">
                    <div class="col-lg-3 col-md-4 label ">Title</div>
                    <div class="col-lg-9 col-md-8"><?php echo $getNews['title']; ?></div>
                  </div>

                  <div class="row">
                    <div class="col-lg-3 col-md-4 label">Company</div>
                    <div class="col-lg-9 col-md-8"><?php echo $getNews['company']; ?></div>
                  </div>

                  <div class="row">
                    <div class="col-lg-3 col-md-4 label">Description</div>
                    <div class="col-lg-9 col-md-8"><?php echo $getNews['description']; ?></div>
                  </div>

                  <div class="row">
                    <div class="col-lg-3 col-md-4 label">News Date</div>
                    <div class="col-lg-9 col-md-8"><?php echo $getNews['news_date']; ?></div>
                  </div>

                  <div class="row">
                    <div class="col-lg-3 col-md-4 label">Date Added</div>
                    <div class="col-lg-9 col-md-8"><?php echo $getNews['date_added']; ?></div>
                  </div>

                  <div class="row">
                    <div class="col-lg-3 col-md-4 label">Total Requests</div>
                    <div class="col-lg-9 col-md-8"><?php echo $getNews['requests']; ?></div>
                  </div>
                  <div class="text-center">
                      <button type="submit" class="btn btn-danger">Remove News</button>
                    </div>
                </div>

                <div class="tab-pane fade profile-edit pt-3" id="profile-edit">

                  <!-- Profile Edit Form -->
                  <form action="newsProfile.php?nid=<?php echo $_GET['nid'] ?>" method="post" enctype="multipart/form-data" id="dscrp">
                    <div class="row mb-3">
                      <label for="profileImage" class="col-md-4 col-lg-3 col-form-label">News Image</label>
                      <div class="col-md-8 col-lg-9">
                        <input name="image" type="file" class="form-control" id="fullName">
                      </div>
                    </div>

                    <div class="row mb-3">
                      <label for="fullName" class="col-md-4 col-lg-3 col-form-label">Title</label>
                      <div class="col-md-8 col-lg-9">
                        <input name="title" type="text" class="form-control" id="fullName" value="<?php echo $getNews['title']; ?>">
                      </div>
                    </div>
                    <div class="row mb-3">
                      <label for="company" class="col-md-4 col-lg-3 col-form-label">Company</label>
                      <div class="col-md-8 col-lg-9">
                        <input name="company" type="text" class="form-control" id="company" value="<?php echo $getNews['company']; ?>">
                      </div>
                    </div>

                    <div class="row mb-3">
                      <label for="Job" class="col-md-4 col-lg-3 col-form-label">Description</label>
                      <div class="col-md-8 col-lg-9">
                        <textarea class="form-control" name="description" form="dscrp">
                          <?php echo $getNews['description']; ?>
                        </textarea>
                      </div>
                    </div>

                    <div class="text-center">
                      <button name="updateBtn" type="submit" class="btn btn-primary">Save Changes</button>
                    </div>
                  </form><!-- End Profile Edit Form -->
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
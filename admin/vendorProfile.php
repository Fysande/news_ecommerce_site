<?php
  include '../back-end/db/config.php';
  if(!isset($_GET['vendor_id'])){
    header('location: manageVendors.php');
  }

  include 'header.html';
  
  $sql = "select * from vendor where vendor_id = :id";
  $handle = $pdo->prepare($sql);
  $params = ['id' => $_GET['vendor_id']];
  $handle->execute($params);
  $vendors = $handle->fetch(PDO::FETCH_ASSOC);
?>
<main id="main" class="main">

    <div class="pagetitle">
      <h1>Vendor's Profile</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="index.html">Home</a></li>
          <li class="breadcrumb-item active">View Vendor</li>
        </ol>
      </nav>
    </div><!-- End Page Title -->

    <section class="section profile">
      <div class="row">
        <div class="col-xl-4">

          <div class="card">
            <div class="card-body profile-card pt-4 d-flex flex-column align-items-center">

              <img src="assets/img/profile.jpg" alt="Profile" class="rounded-circle">
              <h2><?php echo $vendors['name']; ?></h2>
              <h3>Vendor</h3>
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

              </ul>
              <div class="tab-content pt-2">

                <div class="tab-pane fade show active profile-overview" id="profile-overview">

                  <h5 class="card-title">Profile Details</h5>

                  <div class="row">
                    <div class="col-lg-3 col-md-4 label ">Full Name</div>
                    <div class="col-lg-9 col-md-8"><?php echo $vendors['name']; ?></div>
                  </div>

                  <div class="row">
                    <div class="col-lg-3 col-md-4 label">Email</div>
                    <div class="col-lg-9 col-md-8"><?php echo $vendors['email']; ?></div>
                  </div>

                  <div class="row">
                    <div class="col-lg-3 col-md-4 label">Location</div>
                    <div class="col-lg-9 col-md-8"><?php echo $vendors['location']; ?></div>
                  </div>

                  <div class="row">
                    <div class="col-lg-3 col-md-4 label">Date Joined</div>
                    <div class="col-lg-9 col-md-8"><?php echo $vendors['created_at']; ?></div>
                  </div>
                  <div class="text-center">
                      <a href="supplyNews.php?vid=<?php echo $_GET['vendor_id'] ?>" type="submit" class="btn btn-primary mr-5">Supply News</a>
                      <button type="submit" class="btn btn-danger ml-5">Remove Vendor</button>
                  </div>
                </div>
              </div><!-- End Bordered Tabs -->

            </div>
          </div>

        </div>


        <div class="col-xl-12">

          <div class="card">
            <div class="card-body pt-3">
              <!-- Bordered Tabs -->
              <ul class="nav nav-tabs nav-tabs-bordered">

                <li class="nav-item">
                  <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#profile-overview">Sales Report</button>
                </li>

              </ul>
              <div class="tab-content pt-2">

                <div class="tab-pane fade show active profile-overview" id="profile-overview">

                  <h5 class="card-title">Profile Details</h5>

                  <div class="row">
                    <div class="col-lg-3 col-md-4 label ">Full Name</div>
                    <div class="col-lg-9 col-md-8"><?php echo $vendors['name']; ?></div>
                  </div>

                  <div class="row">
                    <div class="col-lg-3 col-md-4 label">Email</div>
                    <div class="col-lg-9 col-md-8"><?php echo $vendors['email']; ?></div>
                  </div>

                  <div class="row">
                    <div class="col-lg-3 col-md-4 label">Location</div>
                    <div class="col-lg-9 col-md-8"><?php echo $vendors['location']; ?></div>
                  </div>

                  <div class="row">
                    <div class="col-lg-3 col-md-4 label">Date Joined</div>
                    <div class="col-lg-9 col-md-8"><?php echo $vendors['created_at']; ?></div>
                  </div>
                  <div class="text-center">
                      <a href="supplyNews.php?vid=<?php echo $_GET['vendor_id'] ?>" type="submit" class="btn btn-primary mr-5">Supply News</a>
                      <button type="submit" class="btn btn-danger ml-5">Remove Vendor</button>
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
<?php
  include 'header.html';
  include '../setup.php';
  include CONFIG_PATH;

  $sql = "select * from customer where customer_id = :id";
  $handle = $pdo->prepare($sql);
  $params = ['id' => $_GET['cid']];
  $handle->execute($params);
  $getCus = $handle->fetch(PDO::FETCH_ASSOC);
?>
<main id="main" class="main">

    <div class="pagetitle">
      <h1>Customer's Profile</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="index.html">Home</a></li>
          <li class="breadcrumb-item active">View Products</li>
        </ol>
      </nav>
    </div><!-- End Page Title -->

    <section class="section profile">
      <div class="row">
        <div class="col-xl-4">

          <div class="card">
            <div class="card-body profile-card pt-4 d-flex flex-column align-items-center">

              <img src="assets/img/profile.jpg" alt="Profile" class="rounded-circle">
              <h2><?php echo $getCus['firstname'].' '.$getCus['lastname']; ?></h2>
              <h3>Customer</h3>
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
                    <div class="col-lg-9 col-md-8"><?php echo $getCus['firstname'].' '.$getCus['lastname']; ?></div>
                  </div>

                  <div class="row">
                    <div class="col-lg-3 col-md-4 label">Email</div>
                    <div class="col-lg-9 col-md-8"><?php echo $getCus['email']; ?></div>
                  </div>

                  <div class="row">
                    <div class="col-lg-3 col-md-4 label">Location</div>
                    <div class="col-lg-9 col-md-8"><?php echo $getCus['location']; ?></div>
                  </div>

                  <div class="row">
                    <div class="col-lg-3 col-md-4 label">Date added</div>
                    <div class="col-lg-9 col-md-8"><?php echo $getCus['created_at']; ?></div>
                  </div>
                  <div class="text-center">
                      <button type="submit" class="btn btn-danger">Remove Customer</button>
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
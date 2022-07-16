<?php
  include 'header.html'
?>
<main id="main" class="main">

    <div class="pagetitle">
      <h1>Add Customer</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="index.html">Home</a></li>
          <li class="breadcrumb-item active">Add Vendor</li>
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
              <h5 class="card-title">Fill this form to add Customer</h5>
                <!-- Multi Columns Form -->
              <form class="row g-3" id="dscrp">
                <div class="col-md-12">
                  <label for="inputName5" class="form-label">Name</label>
                  <input type="text" class="form-control" id="inputName5">
                </div>
                <div class="col-md-12">
                  <label for="inputEmail5" class="form-label">Username</label>
                  <input type="email" class="form-control" id="inputEmail5">
                </div>
                <div class="col-12">
                  <label for="inputEmail5" class="form-label">Email</label>
                  <input type="text" class="form-control" id="inputEmail5">
                </div>
                <div class="col-12">
                  <label for="inputEmail5" class="form-label">Location</label>
                  <input type="email" class="form-control" id="inputEmail5">
                </div>
                <div class="text-center">
                  <button type="submit" class="btn btn-primary">Add Customer</button>
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
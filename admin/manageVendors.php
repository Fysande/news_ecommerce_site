<?php
  include '../back-end/db/config.php';

    $sql = "select * from vendor order by vendor_id desc";
    $statement = $pdo->query($sql);
    $vendors = $statement->fetchAll(PDO::FETCH_ASSOC);
  include 'header.html'
?>
<main id="main" class="main">

    <div class="pagetitle">
      <h1>Manage Vendors</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="index.html">Home</a></li>
          <li class="breadcrumb-item active">View Author</li>
        </ol>
      </nav>
    </div><!-- End Page Title -->

    <section class="section dashboard">
      <div class="row">

        <!-- Left side columns -->
        <div class="col-lg-12">
          <div class="row">


        <!-- Top Selling -->
        <div class="col-12">
          <div class="card top-selling overflow-auto">
            <a href="addAuthor.php"><button type="button" class="btn btn-primary m-2" style="width: 20%;"><i class="bi bi-plus me-2" sty></i>Add Vendor</button></a>

            <div class="card-body pb-0">
              <h5 class="card-title">List of Vendors</h5>

              <table class="table table-borderless">
                <thead>
                  <tr>
                    <th scope="col">Image</th>
                    <th scope="col">Name</th>
                    <th scope="col">Email</th>
                    <th scope="col">City</th>
                    <th scope="col">Date added</th>
                  </tr>
                </thead>
                <tbody>
                  <?php foreach($vendors as $vendor)
                  {
                  ?>
                  <tr>
                    <th scope="row"><a href="vendorProfile.php?vendor_id=<?php echo $vendor['vendor_id'] ?>"><img src="assets/img/profile.jpg" alt=""></a></th>
                    <td><a href="vendorProfile.php?vendor_id=<?php echo $vendor['vendor_id'] ?>" class="text-secondary fw-bold"><?php echo $vendor['name']; ?></a></td>
                    <td><?php echo $vendor['email']; ?></td>
                    <td class="fw-bold"><?php echo $vendor['location']; ?></td>
                    <td><?php echo $vendor['created_at']; ?></td>
                  </tr>
                  <?php
                  }
                  ?>
                </tbody>
              </table>

            </div>

          </div>
        </div><!-- End Top Selling -->

    </div>
  </div><!-- End Left side columns -->


</div>
</section>

</main><!-- End #main -->

<?php
  include 'footer.html'
?>
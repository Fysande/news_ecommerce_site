<?php

    include '../back-end/db/config.php';

    $sql = "select * from customer";
    $statement = $pdo->query($sql);
    $customers = $statement->fetchAll(PDO::FETCH_ASSOC);

    include 'header.html'
?>
<main id="main" class="main">

    <div class="pagetitle">
      <h1>Manage Customers</h1>
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


        <!-- Top Selling -->
        <div class="col-12">
          <div class="card top-selling overflow-auto">
            <a href="addCustomer.php"><button type="button" class="btn btn-primary m-2" style="width: 20%;"><i class="bi bi-plus me-2" sty></i>Add Customer</button></a>

            <div class="card-body pb-0">
              <h5 class="card-title">List of Customers</h5>

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
                  <?php foreach($customers as $customer)
                  {
                  ?>
                  <tr>
                    <th scope="row"><a href="userProfile.php"><img src="assets/img/profile.jpg" alt=""></a></th>
                    <td><a href="userProfile.php?cid=<?php echo $customer['customer_id']; ?>" class="text-secondary fw-bold"><?php echo $customer['firstname'].' '.$customer['lastname']; ?></a></td>
                    <td><?php echo $customer['email']; ?></td>
                    <td class="fw-bold"><?php echo $customer['location']; ?></td>
                    <td><?php echo $customer['created_at']; ?></td>
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
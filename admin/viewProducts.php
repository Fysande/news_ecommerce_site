<?php

    include '../back-end/db/config.php';

    $sql = "select * from digital_news";
    $statement = $pdo->query($sql);
    $news = $statement->fetchAll(PDO::FETCH_ASSOC);

    include 'header.html'
?>
<main id="main" class="main">

    <div class="pagetitle">
      <h1>Manage Stock</h1>
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
            <a href="addNews.php"><button type="button" class="btn btn-primary m-2" style="width: 15%;"><i class="bi bi-plus me-2" sty></i> Add News</button></a>

            <div class="card-body pb-0">
              <h5 class="card-title">Available News <span>| This week</span></h5>

              <table class="table table-borderless">
                <thead>
                  <tr>
                    <th scope="col">Image</th>
                    <th scope="col">Title</th>
                    <th scope="col">Date</th>
                    <th scope="col">Total requests</th>
                  </tr>
                </thead>
                <tbody>
                  <?php foreach($news as $new)
                  {
                  ?>
                  <tr>
                    <th scope="row"><a href="newsProfile.php"><img src="../imgs/news-imgs/<?php echo $new['image']; ?>" alt=""></a></th>
                    <td><a href="newsProfile.php?nid=<?php echo $new['news_id'] ?>" class="text-secondary fw-bold"><?php echo $new['title']; ?></a></td>
                    <td><?php echo $new['news_date']; ?></td>
                    <td class="fw-bold"><?php echo $new['requests']; ?></td>
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
<?php
    include 'header.html';

    if(isset($_GET['news_id'])){
      include '../setup.php';
      require CONFIG_PATH;
      require FUNCTIONS_PATH;

      $news = getNews($_GET['news_id']);
    }
?>

  <main id="main" class="main">

    <div class="row gx-4 gx-lg-5 justify-content-center">
        <div class="col-lg-8 col-xl-6 text-center">
            <h2 class="mt-3">News Details</h2>
            <hr class="divider" />
        </div>
    </div>
    <section class="section profile">
      <div class="row">
        <div class="col-xl-4">

          <div class="card">
            <div class="card-body pt-2 d-flex flex-column align-items-center">
              <h2 class="mb-2"><?php echo $news['title'] ?></h2>
              <img src="../imgs/news-imgs/<?php echo $news['image'] ?>" alt="Profile" height="250" width="150">
            </div>
          </div>

        </div>

        <div class="col-xl-8">

          <div class="">
            <h4>Description:</h4>
            <p><?php echo $news['description']?></p>
          </div>

        </div>
        <div class="text-center">
          <a href="../back-end/requestNews.php?cus_id=<?php echo $_SESSION['customer_id'];?>&&news_id=<?php echo $news['news_id'] ?>" class="btn-primary btn">Request News</a>
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
        <!-- * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *-->
        <!-- * *                               SB Forms JS                               * *-->
        <!-- * * Activate your form at https://startbootstrap.com/solution/contact-forms * *-->
        <!-- * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *-->
        <script src="https://cdn.startbootstrap.com/sb-forms-latest.js"></script>

        <!-- Vendor JS Files -->
    <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
</body>
</html>
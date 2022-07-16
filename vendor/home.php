<?php
    include 'header.html';
    function checkSalesDate($date, $vid){
      require CONFIG_PATH;

        $sql = 'select * from vendor_sales where date = :date and vendor_id = :id';

        $stmt = $pdo->prepare($sql);
        $p = ['date' => $date, 'id' => $vid];
        $stmt->execute($p);

        if($stmt->rowCount() == 0)
        {
            //date kulibe
            return false;
        }
        else
        {
            //iliko
            return true;
        }
    }

    $sql = "SELECT SUM(quantity) AS totQuantity FROM vendor_news WHERE vendor_id = '".$_SESSION['vendor_id']."' ";
	 $res = $pdo->query($sql);
  	$r_news = $res->fetchColumn();

    $sql = "SELECT SUM(news_sold) AS totQuantity FROM sales WHERE vendor_id = '".$_SESSION['vendor_id']."' ";
   $res = $pdo->query($sql);
    $s_news = $res->fetchColumn();

    $remain_news = $r_news - $s_news;

	if(isset($_POST['btn'])){
      if(isset($_POST['quantity'], $_POST['date']) && !empty($_POST['quantity']) && !empty($_POST['date']))
      {
        $today = date('Y-m-d');
        if($_POST['date'] > $today){
          $errors[] = 'Date cannot be in the future';
        }else{
          if($remain_news < $_POST['quantity']){
            $errors[] = 'Entered quantiy exceeds available quantity';
          }else{
              $sql = "insert into sales (vendor_id, sales_date, news_sold) values(:vid, :created_at, :news)";
              try{
                  $handle = $pdo->prepare($sql);
                  $params = [
                      ':vid' => $_SESSION['vendor_id'],
                      ':created_at' => $_POST['date'],
                      ':news' => $_POST['quantity']
                  ];

                  $handle->execute($params);
                  $success[] = "Report has been submitted";
                  //insert report
                  if(checkSalesDate($_POST['date'], $_SESSION['vendor_id'])){
                    //get row
                    $sql = "select * from vendor_sales where date = :date and vendor_id = :id";

                    $handle = $pdo->prepare($sql);
                    $params = ['date' => $_POST['date'], 'id' => $_SESSION['vendor_id']];
                    $handle->execute($params);
                    $getRow = $handle->fetch(PDO::FETCH_ASSOC);
                    $sales = $getRow['sales'];
                    $current_vendor_price = $getRow['price']
                    $current_sales = $sales + $_POST['quantity'];

                    $sql = "UPDATE vendor_sales SET sales = :sale WHERE date = :date";
                      try{
                          $handle = $pdo->prepare($sql);
                          $params = [
                              ':sale' => $current_sales,
                              ':date' => $_POST['date']
                          ];

                          $handle->execute($params);
                      }
                      catch(PDOException $e){
                          $errors[] = $e->getMessage();
                      }

                  }else{
                    $sql = "insert into vendor_sales (date, vendor_id, sales) values(:dt, :vid, :sale)";
                      try{
                          $handle = $pdo->prepare($sql);
                          $params = [
                              ':dt' => $_POST['date'],
                              ':vid' => $_SESSION['vendor_id'],
                              ':sale' => $_POST['quantity']
                          ];

                          $handle->execute($params);                        
                      }
                      catch(PDOException $e){
                         $errors[] = $e->getMessage();
                      }
                  }

              }
              catch(PDOException $e){
                 $errors[] = $e->getMessage();
              }
            }
          }
        }else{
        $errors[] = 'Fill the form collectluy';
      }
      }
      //graph editings
      //Apexcharts
      // Current timestamp
      //$today    = new DateTime();
      $today = new DateTime();

      // For a precise 10 day difference, clone $today
      // and substract 10 days from it.
      $backdate = clone $today;
      $backdate->sub(new DateInterval('P7D'));

      // Declare a DatePeriod between the two dates,
      // with a 1-day interval in between them
      $period = new DatePeriod($backdate, new DateInterval('P1D'), $today);
      // Profit
      $week = array();
      foreach ($period as $date) {
          //$week[] = $date->format('Y-m-d');
      }

      //subscribers line
      $lastweek = $backdate->format('Y-m-d');
      foreach($pdo->query("SELECT * FROM vendor_sales WHERE date > '".$lastweek."' AND vendor_id = '".$_SESSION['vendor_id']."' GROUP BY date ORDER BY date DESC") as $row) {

            $week[] = $row['date'];
            $sale[] = $row['sales'];
      }
?>

        <main id="main" class="main" id="top">
          <div class="col-lg-12">
          	<?php
              if(isset($success)){
                foreach ($success as $suc) {
                  echo '<h4 class="text-center text-success">' .$suc. '</h4>';
                }
              }

              if(isset($errors)){
                foreach ($errors as $error) {
                  echo '<h4 class="text-center text-warning">' .$error. '</h4>';
                }
              }
            ?>
            <div class="row">
              <!-- Sales Card -->
            <div class="col-xxl-3 col-md-4 mt-3">
              <div class="card info-card sales-card">

                <div class="card-body">
                  <h3 class="card-title" style="color: #ca0405; font-size: 1.5em;">News Received</h3>

                  <div class="d-flex align-items-center">
                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                      <i class="bi bi-newspaper"></i>
                    </div>
                    <div class="ps-3">
                      <h3><?php echo $r_news; ?></h3>

                    </div>
                  </div>
                </div>

              </div>
            </div><!-- End Sales Card -->

            <!-- Revenue Card -->
            <div class="col-xxl-3 col-md-4 mt-3">
              <div class="card info-card revenue-card">
                <div class="card-body">
                  <h5 class="card-title" style="color: #ca0405; font-size: 1.5em;">News Sold</h5>

                  <div class="d-flex align-items-center">
                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                      <i class="bi bi-newspaper"></i>
                    </div>
                    <div class="ps-3">
                      <h3><?php echo $s_news; ?></h3>

                    </div>
                  </div>
                </div>

              </div>
            </div><!-- End Revenue Card -->

            <!-- Customers Card -->
            <div class="col-xxl-3 col-md-4 mt-3">
              <div class="card info-card customers-card">
                <div class="card-body">
                  <h5 class="card-title" style="color: #ca0405; font-size: 1.5em;">Remaining</h5>
                  <div class="d-flex align-items-center">
                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                      <i class="bi bi-newspaper"></i>
                    </div>
                    <div class="ps-3">
                      <h3><?php echo $remain_news; ?></h3>
                    </div>
                  </div>
                </div>
              </div>
            </div><!-- End Customers Card -->
            </div>
          </div>

          <!-- Reports -->
            <div class="col-12" id = "chart">
              <div class="card">

                <div class="card-body">
                  <h5 class="card-title" style="color: #ca0405;">Reports <span style="color: #ca0405;">/This week</span></h5>

                  <!-- Line Chart -->
                  <div id="reportsChart"></div>

                  <script>
                    var days = <?php echo json_encode($week); ?>;
                    var sell = <?php echo json_encode($sale); ?>;

                    document.addEventListener("DOMContentLoaded", () => {
                      new ApexCharts(document.querySelector("#reportsChart"), {
                        series: [{
                          name: 'Sales',
                          data: sell,
                        }],
                        chart: {
                          height: 350,
                          type: 'area',
                          toolbar: {
                            show: false
                          },
                        },
                        markers: {
                          size: 4
                        },
                        colors: ['#4154f1', '#2eca6a', '#ff771d'],
                        fill: {
                          type: "gradient",
                          gradient: {
                            shadeIntensity: 1,
                            opacityFrom: 0.3,
                            opacityTo: 0.4,
                            stops: [0, 90, 100]
                          }
                        },
                        dataLabels: {
                          enabled: false
                        },
                        stroke: {
                          curve: 'smooth',
                          width: 2
                        },
                        xaxis: {
                          type: 'datetime',
                          categories: days
                        },
                        tooltip: {
                          x: {
                            format: 'dd/MM/yy HH:mm'
                          },
                        }
                      }).render();
                    });
                  </script>
                  <!-- End Line Chart -->

                </div>

              </div>
            </div><!-- End Reports -->

        </main><!-- End #main -->
        <div class="container card info-card customers-card" id="submit">
            <div class="rounded-3 text-center ">
                <div class="m-2 m-lg-2">
                  <div class="row gx-4 gx-lg-5 justify-content-center">
                    <div class="col-lg-8 col-xl-6 text-center">
                        <h2 class="mt-5" style="color: #ca0405">Submit Sales</h2>
                    </div>
                </div>
                  <div class="form">
                    <form action="home.php" method="post">
                      <div class="col-md-6" style="margin: auto; width: 50%;">
                        <label for="inputEmail5" class="form-label">Newspaper Sold</label>
                        <input type="number" class="form-control" id="inputEmail5" name="quantity">
                      </div>
                      <div class="col-md-6" style="margin: auto; width: 50%;">
                        <label for="inputPassword5" class="form-label" >Date of Sales</label>
                        <input type="date" class="form-control" id="inputPassword5" name="date">
                      </div>
                      <input type="submit" name="btn" class="btn batani btn-lg mt-2">
                    </form>
                  </div>
                </div>
            </div>
        </div>

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
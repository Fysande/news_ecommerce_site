<?php
  include 'header.html';
  include '../back-end/db/config.php';


  //top requested news
  $sql = "select * from digital_news where requests != 0 order by requests desc";
  $statement = $pdo->query($sql);
  $topNews = $statement->fetchAll(PDO::FETCH_ASSOC);

  //pie charts
  function pieChart($plan){
    include '../back-end/db/config.php';
    $sql = "SELECT count(*) FROM payment WHERE package_name = :pk"; 
    $result = $pdo->prepare($sql);
    $params = ['pk' => $plan]; 
    $result->execute($params); 
    return $result->fetchColumn();
  }

  $monthy = pieChart('1 Month');
  $monthy3 = pieChart('3 Months');
  $monthy6 = pieChart('6 Months');

  //news requests
  $sql = "SELECT SUM(requests) AS totRequests FROM digital_news";
  $res = $pdo->query($sql);
  $requests = $res->fetchColumn();

  //counting subscribers
  $sql = "SELECT COUNT(*) FROM payment WHERE expire_date > :today"; 
  $result = $pdo->prepare($sql);
  $params = ['today' => date('Y-m-d')]; 
  $result->execute($params); 
  $subs = $result->fetchColumn();

  //sales
  $sql = "SELECT SUM(news_sold) AS news FROM sales";
  $res = $pdo->query($sql);
  $news_sold = $res->fetchColumn();

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
  foreach($pdo->query("SELECT * FROM report GROUP BY report_date ORDER BY report_date LIMIT 6" ) as $row) {
        $subscribers[] = $row['subscriptions'];
        $week[] = $row['report_date'];
        $req[] = $row['requests'];
        $sale[] = $row['sales'];
    }

  //get price
  $sql = 'SELECT * FROM price ORDER BY price_id DESC LIMIT 1';
  $handle = $pdo->prepare($sql);
  $handle->execute($params);
  $getPrice = $handle->fetch(PDO::FETCH_ASSOC);
?>
<main id="main" class="main">

    <div class="pagetitle">
      <h1>Dashboard</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="dashboarhtml">Home</a></li>
          <li class="breadcrumb-item active">Dashboard</li>
        </ol>
      </nav>
    </div><!-- End Page Title -->

    <section class="section dashboard">
      <div class="row">

        <!-- Left side columns -->
        <div class="col-lg-12">
          <div class="row">

            <!-- Customers Card -->
            <div class="col-xxl-3 col-md-3">

              <div class="card info-card revenue-card">

                <div class="card-body">
                  <h5 class="card-title">News Price<span>| Today</span></h5>

                  <div class="d-flex align-items-center">
                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                      <i class="bi bi-currency-dollar"></i>
                    </div>
                    <div class="ps-3">
                      <h6>K<?php echo $getPrice['price'] ?></h6>
                     <a href="changePrice.php"><span class="text-success small pt-1 fw-bold">Change Price</span></a>
                    </div>
                  </div>

                </div>
              </div>

            </div><!-- End Customers Card -->
            <!-- Sales Card -->
            <div class="col-xxl-3 col-md-3">
              <div class="card info-card sales-card">

                <div class="card-body">
                  <h5 class="card-title">Subscribers</h5>

                  <div class="d-flex align-items-center">
                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                      <i class="bi bi-people"></i>
                    </div>
                    <div class="ps-3">
                      <h6><?php echo $subs; ?></h6>

                    </div>
                  </div>
                </div>

              </div>
            </div><!-- End Sales Card -->

            <!-- Revenue Card -->
            <div class="col-xxl-3 col-md-3">
              <div class="card info-card revenue-card">
                <div class="card-body">
                  <h5 class="card-title">News Request</h5>

                  <div class="d-flex align-items-center">
                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                      <i class="bi bi-newspaper"></i>
                    </div>
                    <div class="ps-3">
                      <h6><?php echo $requests ?></h6>
                      

                    </div>
                  </div>
                </div>

              </div>
            </div><!-- End Revenue Card -->

            <!-- Customers Card -->
            <div class="col-xxl-3 col-md-3">

              <div class="card info-card customers-card">

                <div class="card-body">
                  <h5 class="card-title">Sales</h5>

                  <div class="d-flex align-items-center">
                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                      <i class="bi bi-currency-dollar"></i>
                    </div>
                    <div class="ps-3">
                      <h6><?php echo $news_sold; ?></h6>

                    </div>
                  </div>

                </div>
              </div>

            </div><!-- End Customers Card -->


            <!-- Reports -->
            <div class="col-8">
              <div class="card">
                <div class="card-body">
                  <h5 class="card-title">Latest Report</h5>

                  <!-- Line Chart -->
                  <div id="reportsChart" ></div>

                  <script>
                    var days = <?php echo json_encode($week); ?>;
                    var subs = <?php echo json_encode($subscribers); ?>;
                    var reqs = <?php echo json_encode($req); ?>;
                    var sell = <?php echo json_encode($sale); ?>;

                    document.addEventListener("DOMContentLoaded", () => {
                      new ApexCharts(document.querySelector("#reportsChart"), {
                        series: [{
                          name: 'Subscribers',
                          data: subs,
                        }, {
                          name: 'News Requests',
                          data: reqs,
                        }, {
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
                            format: 'dd/MM/yy'
                          },
                        }
                      }).render();
                    });
                  </script>
                  <!-- End Line Chart -->
                </div>
              </div>
            </div>
            <div class="col-lg-4">
            <div class="card">
              <div class="card-body">
                <h5 class="card-title">Number of Subscriptions</h5>

                <!-- Pie Chart -->
                <canvas id="pieChart" style="min-height: 360px;"></canvas>
                <script>
                  document.addEventListener("DOMContentLoaded", () => {
                    new Chart(document.querySelector('#pieChart'), {
                      type: 'pie',
                      data: {
                        labels: [
                          'Monthy',
                          '3 Months',
                          '6 Months'
                        ],
                        datasets: [{
                          label: 'My First Dataset',
                          data: [<?php echo $monthy;?>, <?php echo $monthy3;?>, <?php echo $monthy6;?>],
                          backgroundColor: [
                            'rgb(255, 99, 132)',
                            'rgb(54, 162, 235)',
                            'rgb(255, 205, 86)'
                          ],
                          hoverOffset: 2
                        }]
                      }
                    });
                  });
                </script>
                <!-- End Pie CHart -->
              </div>
            </div>
          </div>

        <!-- Top Selling -->
        <div class="col-12">
          <div class="card top-selling overflow-auto">

            <div class="card-body pb-0">
              <h5 class="card-title">Top Requested News <span>| This week</span></h5>

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
                  <?php foreach($topNews as $new)
                  {
                  ?>
                  <tr>
                    <th scope="row"><a href="newsProfile.php?news_id = <?php echo $new['news_id']; ?>"><img src="../imgs/news-imgs/<?php echo $new['image']; ?>" alt=""></a></th>
                    <td><a href="newsProfile.php?news_id = <?php echo $new['news_id']; ?>" class="text-secondary fw-bold"><?php echo $new['title']; ?></a></td>
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
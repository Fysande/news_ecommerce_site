<?php
  include '../back-end/db/config.php';
  /*// Current timestamp
  $today    = new DateTime();

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
      $week[] = $date->format('Y-m-d');
  }

  $lastweek = $backdate->format('Y-m-d');

      //subscribers line
    $lastweek = $backdate->format('Y-m-d');
    foreach($pdo->query("SELECT date_paid,COUNT(*) FROM payment WHERE date_paid >= '".$lastweek."' GROUP BY date_paid") as $row) {
    echo "<tr>";
    echo "<td>" . $row['date_paid'] . "</td>";
    echo "<td>" . $row['COUNT(*)'] . "</td>";
    echo "</tr>"; 
    }

    /*function rowCount($connect,$query){
      $stmt = $connect->prepare($query);
      $stmt->execute();
      return $stmt->rowCount();
    }

    echo rowCount($pdo, "SELECT date_paid,COUNT(*) FROM payment WHERE date_paid >= '".$lastweek."' GROUP BY date_paid");*/

    $today = new DateTime();

    $backdate = clone $today;
    $backdate->sub(new DateInterval('P7D'));

    $period = new DatePeriod($backdate, new DateInterval('P1D'), $today);

    //subscribers line
    $lastweek = $backdate->format('Y-m-d');

    foreach($pdo->query("SELECT requests, report_date FROM report WHERE report_date > '".$lastweek."'") as $row) {
      echo $row['requests'];
      echo $row['report_date'];
    }

?>
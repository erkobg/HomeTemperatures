<?php

include("connect.php");
$connection = Connection();

define('DEFAULT_HRS', 72);

$hrs = DEFAULT_HRS; 
if ($_GET["hrs"]) {
  $hrs = $_GET["hrs"];
}
$timea = array();
$tempa = array();
$huma = array();

try {
  if ($stmt = $connection->prepare("SELECT `sensor_id`, `date`, `temperature`, `humidity` from `temp_humid` where date>=DATE_SUB(NOW(), INTERVAL ? HOUR) order by date")) {
      $stmt->bind_param("i", $hrs);
      $stmt->execute();
/* Fetch result to array */
$res = $stmt->get_result();


while($row = $res->fetch_array(MYSQLI_ASSOC)){
    $timea[] = $row["date"];
    $tempa[] = $row["temperature"];
    $huma[] = $row["humidity"];
  }
      $stmt->close();
  }
  $connection->close();
} catch (Exception $e) {
  $errors[] = ("DB connection error! <code>" . $e->getMessage() . "</code>.");
}

?>
<!DOCTYPE html>
<meta charset="utf-8">
<head>
  <title>TempGraph</title>
  <style>
body {
  font: 11px tahoma, arial, sans-serif;
}
  .axis path,
  .axis line {
    fill: none;
    stroke: #000;
    shape-rendering: crispEdges;
  }
  .line {
    fill: none;
    stroke: steelblue;
    stroke-width: 2.0px;
  }
  .brush .extent {
    stroke: #fff;
    fill-opacity: .125;
    shape-rendering: crispEdges;
  }
  </style>
  <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js"></script>
<script type="text/javascript">
$(function () {
        $('#container').highcharts({
            chart: {
                type: 'line',
                marginRight: 130,
                marginBottom: 80
            },
            title: {
                text: 'Todays Temperature Chart',
                x: -20 //center
            },
            subtitle: {
                text: 'Source: My Sensor',
                x: -20
            },
            xAxis: {
                categories: [<?php
                foreach($timea as $child) {  echo "'".$child."'," . "\n"; } ?>]
            },
            yAxis:[{ //--- Primary yAxis
                title: {
                    text: 'Temperature'
                }
               
            }, { //--- Secondary yAxis
                title: {
                    text: 'Humidity'
                },
                opposite: true
            }],
            tooltip: {
                valueSuffix: ''
            },
            legend: {
                layout: 'vertical',
                align: 'right',
                verticalAlign: 'top',
                x: 10,
                y: 100,
                borderWidth: 0
            },
            series: [{
              yAxis: 0,
                name: 'Celcius',
                color: '#ff0000',
                data: 
                         [<?php foreach($tempa as $child) { echo $child."," . "\n"; } ?> ]
                        
            }
            , {
                name: 'Humidity',
                yAxis: 1,
                color: '#00ff00',
                data: 
                       [<?php foreach($huma as $child) { echo $child."," . "\n"; } ?> ]
            }
            ]
        });
    });
</script>
</head>
<body>
<script src="js/highcharts.js"></script>
<script src="js/modules/exporting.js"></script>
<div id="container" style="width: 800px; height: 600px; margin: 0 auto"></div>
<br/><br/>
test adding <a href='add.php?d=1&t=<?php echo rand(1, 30);?>&h=<?php echo rand(1, 30);?>'>test adding</a>
<br/><br/>
<a href='show.php'>Show data</a>
</script>
</body>
</html>
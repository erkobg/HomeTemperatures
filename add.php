<?php  include("connect.php");
$connection = Connection();

 $sqlstring = "INSERT INTO `temp_humid` (`id`, `sensor_id`, `date`, `temperature`, `humidity`) VALUES(NULL,'".intval($_GET['d'])."',CURRENT_TIMESTAMP,'".intval($_GET['t'])."','".intval($_GET['h'])."');";
 if (!$connection->query($sqlstring)) {
     printf("Error: %s\n        ", $connection->sqlstate);
 }
$connection->close();
include("index.php")
?>
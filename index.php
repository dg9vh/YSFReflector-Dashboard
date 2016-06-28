<?php
$time = microtime();
$time = explode(' ', $time);
$time = $time[1] + $time[0];
$start = $time;

// do not touch this includes!!! Never ever!!!
include "config/config.php";
include "include/tools.php";
include "include/functions.php";
?>
<!doctype html>
<html lang="de">
  <head>
    <meta charset="utf-8">
    <!--<meta name="viewport" content="width=device-width, initial-scale=1.0">
    -->
    <meta name="viewport" content="width=device-width, initial-scale=0.6,maximum-scale=1, user-scalable=yes">
    <meta http-equiv="refresh" content="<?php echo REFRESHAFTER?>">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.3/jquery.min.js"></script>
    <!-- Das neueste kompilierte und minimierte CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
    <!-- Optionales Theme -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap-theme.min.css">
    <!-- Das neueste kompilierte und minimierte JavaScript -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
    <!-- Datatables -->
 	<link rel="stylesheet" href="https://cdn.datatables.net/1.10.12/css/jquery.dataTables.min.css"></style>
 	<script type="text/javascript" src="https://cdn.datatables.net/1.10.12/js/jquery.dataTables.min.js"></script>
  	<style>
 	    h4 {
 		display: inline
 		}		
 	</style>
    <title><?php echo getConfigItem("Info", "Name", $configs); ?> - YSFReflector-Dashboard by DG9VH</title>
  </head>
  <body>
  <div class="page-header">
  <h1><small>YSFReflector-Dashboard by DG9VH for Reflector:</small>  <?php echo getConfigItem("Info", "Name", $configs); ?> / <?php echo getConfigItem("Info", "Description", $configs); ?></h1>
  <h4>XSFReflector by G4KLX Version: 
  <?php  echo getYSFReflectorVersion(); ?></h4>
</div>
<?php
checkSetup();
// Here you can feel free to disable info-sections by commenting out with // before include
include "include/sysinfo.php";
include "include/disk.php";
include "include/gateways.php";
include "include/lh.php";
?>
	<div class="panel panel-info">
<?php
$datum = date("Y-m-d");
$uhrzeit = date("H:i:s");
echo "Last Update $datum, $uhrzeit";
$time = microtime();
$time = explode(' ', $time);
$time = $time[1] + $time[0];
$finish = $time;
$total_time = round(($finish - $start), 4);
echo '<!--Page generated in '.$total_time.' seconds.-->';	
?> | get your own at: <a href="https://github.com/dg9vh/YSFReflector-Dashboard">https://github.com/dg9vh/YSFReflector-Dashboard</a>
	</div>
  </body>
</html>
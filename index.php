<?php
$time = microtime();
$time = explode(' ', $time);
$time = $time[1] + $time[0];
$start = $time;
// do not touch this includes!!! Never ever!!!
include "config/config.php";
include "include/tools.php";
include "include/functions.php";
include "include/init.php";
include "version.php";
?>

<!DOCTYPE html>
<html lang="en">

<head>

  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="YSF-Reflector Dashboard by DG9VH">
  <meta name="author" content="DG9VH, KC1AWV">
  <meta http-equiv="refresh" content="<?php echo REFRESHAFTER?>">
  <!-- So refresh works every time -->
  <meta http-equiv="expires" content="0">

  <title><?php echo getConfigItem("Info", "Name", $configs); ?> - YSFReflector-Dashboard by DG9VH</title>

  <!-- Bootstrap core CSS -->
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
  <!-- Bootstrap core JavaScript -->
  <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
  <!-- Datatables -->
  <link rel="stylesheet" href="https://cdn.datatables.net/1.10.21/css/jquery.dataTables.min.css">
  <script type="text/javascript" src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>


</head>

<body>

  <!-- Navigation -->
  <nav class="navbar navbar-expand-lg navbar-dark bg-dark static-top">
    <div class="container-fluid">
      <span class="float:left">
        <a class="navbar-brand" href="#">YSFReflector-Dashboard by DG9VH for Reflector: <?php echo getConfigItem("Info", "Name", $configs); ?> / <?php echo getConfigItem("Info", "Description", $configs); ?> (#<?php echo getConfigItem("Info", "Id", $configs); ?>)</a>
      </span>
      <span class="navbar-brand float:right">
        YSFReflector by G4KLX Version: <?php  echo getYSFReflectorVersion(); ?>
      </span>
    </div>
  </nav>

  <!-- Page Content -->
  <div class="container-fluid">
    <?php
      checkSetup();
    ?>
    <div class="row">
      <div class="col-10">
        <?php
          include "include/txinfo.php";
        ?>
      </div>
      <?php if (LOGO !== "") { ?>
      <div id="Logo" class="col-2">
        <img src="<?php echo LOGO ?>" width="250px" style="width:250px; border-radius:10px;box-shadow:2px 2px 2px #808080; padding:1px;background:#FFFFFF;border:1px solid #808080;" border="0" hspace="10" vspace="10" align="justify-content-center">
      </div>
      <?php } else { ?>
      <div id="Logo" class="col-2">
        <h3 class="text-center">YSF-Reflector<br />Dashboard</h3>
      </div>
      <?php } ?>
    </div>
  </div>

    <div class="row">
      <div class="col">
        <?php
          include "include/sysinfo.php";
        ?>
      </div>
      <div class="col">
        <?php
          include "include/disk.php";
        ?>
      </div>
    </div>
    <?php
      include "include/gateways.php";
      include "include/lh.php";
      include "include/allheard.php";
      if (defined("SHOWOLDMHEARD")) {
        include "include/oldheard.php";
      }
    ?>
  </div>

  <div class="card">
    <div class="card-body">
      <?php
        $lastReload = new DateTime();
        $lastReload->setTimezone(new DateTimeZone(TIMEZONE));
        echo "YSFReflector-Dashboard V ".VERSION." | Last Reload ".$lastReload->format('Y-m-d, H:i:s')." (".TIMEZONE.")";
        $time = microtime();
        $time = explode(' ', $time);
        $time = $time[1] + $time[0];
        $finish = $time;
        $total_time = round(($finish - $start), 4);
        echo '<!--Page generated in '.$total_time.' seconds.-->';
      ?> | get your own at: <a href="https://github.com/dg9vh/YSFReflector-Dashboard">https://github.com/dg9vh/YSFReflector-Dashboard</a>
    </div>
  </div>
</body>
</html>

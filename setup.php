<?php

include "include/tools.php";
?>
<!doctype html>
<html lang="de">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
    <!-- Das neueste kompilierte und minimierte CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
    <!-- Optionales Theme -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap-theme.min.css">
    <!-- Das neueste kompilierte und minimierte JavaScript -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
    <title>YSFReflector-Dashboard by DG9VH - Setup</title>
  </head>
  <body>
<?php
	if ($_GET['cmd'] =="writeconfig") {
		if (!file_exists('./config')) {
		    if (!mkdir('./config', 0777, true)) {
?>
<div class="alert alert-danger" role="alert">You forgot to give write-permissions to your webserver-user!</div>

<?php
		    }
		}
		$configfile = fopen("config/config.php", 'w');
		fwrite($configfile,"<?php\n");
		fwrite($configfile,"# This is an auto-generated config-file!\n");
		fwrite($configfile,"# Be careful, when manual editing this!\n\n");
		fwrite($configfile,"date_default_timezone_set('UTC');\n");
		fwrite($configfile, createConfigLines());
		fwrite($configfile,"?>\n");
		fclose($configfile);
?>
  <div class="page-header">
    <h1><small>YSFReflector-Dashboard by DG9VH</small> Setup-Process</h1>
    <div class="alert alert-success" role="alert">Your config-file is written in config/config.php, please remove setup.php for security reasons!</div>
    <p><a href="index.php">Your dashboard is now available.</a></p>
  </div>
<?php
	} else {
?>
  <div class="page-header">
    <h1><small>YSFReflector-Dashboard by DG9VH</small> Setup-Process</h1>
    <h4>Please give necessary information below</h4>
  </div>
  <form id="config" action="setup.php" method="get">
    <input type="hidden" name="cmd" value="writeconfig">
    <div class="container">
      <h2>YSFReflector-Configuration</h2>
      <div class="input-group">
        <span class="input-group-addon" id="YSFREFLECTORLOGPATH" style="width: 300px">Path to YSFReflector-logfile</span>
        <input type="text" name="YSFREFLECTORLOGPATH" class="form-control" placeholder="/var/log/YSFReflector/" aria-describedby="YSFREFLECTORLOGPATH" required data-fv-notempty-message="Value is required">
      </div>
      <div class="input-group">
        <span class="input-group-addon" id="YSFREFLECTORLOGPREFIX" style="width: 300px">Logfile-prefix</span>
        <input type="text" name="YSFREFLECTORLOGPREFIX" class="form-control" placeholder="YSFReflector" aria-describedby="YSFREFLECTORLOGPREFIX" required data-fv-notempty-message="Value is required">
      </div>
      <div class="input-group">
        <span class="input-group-addon" id="YSFREFLECTORINIPATH" style="width: 300px">Path to YSFReflector.ini</span>
        <input type="text" name="YSFREFLECTORINIPATH" class="form-control" placeholder="/etc/" aria-describedby="YSFREFLECTORINIPATH" required data-fv-notempty-message="Value is required">
      </div>
      <div class="input-group">
        <span class="input-group-addon" id="YSFREFLECTORINIFILENAME" style="width: 300px">YSFReflector.ini-filename</span>
        <input type="text" name="YSFREFLECTORINIFILENAME" class="form-control" placeholder="YSFReflector.ini" aria-describedby="YSFREFLECTORINIFILENAME" required data-fv-notempty-message="Value is required">
      </div>
      <div class="input-group">
        <span class="input-group-addon" id="YSFREFLECTORPATH" style="width: 300px">Path to YSFReflector-executable</span>
        <input type="text" name="YSFREFLECTORPATH" class="form-control" placeholder="/usr/local/bin/" aria-describedby="YSFREFLECTORPATH" required data-fv-notempty-message="Value is required">
      </div>
    </div>
    <div class="container">
      <h2>Global Configuration</h2>
      <div class="input-group">
        <span class="input-group-addon" id="REFRESHAFTER" style="width: 300px">Refresh page after in seconds</span>
        <input type="text" name="REFRESHAFTER" class="form-control" placeholder="60" aria-describedby="REFRESHAFTER" required data-fv-notempty-message="Value is required">
      </div>
      <div class="input-group">
        <span class="input-group-addon" id="SHOWPROGRESSBARS" style="width: 300px">Show progressbars</span>
        <div class="panel-body"><input type="checkbox" name="SHOWPROGRESSBARS"></div>
      </div>
      <div class="input-group">
        <span class="input-group-addon" id="TEMPERATUREALERT" style="width: 300px">Enable CPU-temperature-warning</span>
        <div class="panel-body"><input type="checkbox" name="TEMPERATUREALERT"></div>
      </div>
      <div class="input-group">
        <span class="input-group-addon" id="TEMPERATUREHIGHLEVEL" style="width: 300px">Warning temperature</span>
        <input type="text" name="TEMPERATUREHIGHLEVEL" class="form-control" placeholder="60" aria-describedby="TEMPERATUREHIGHLEVEL" required data-fv-notempty-message="Value is required">
      </div>
      <div class="input-group">
        <span class="input-group-addon" id="LHLINES" style="width: 300px">Last heard list lines:</span>
        <input type="text" name="LHLINES" class="form-control" placeholder="20" aria-describedby="LHLINES" required data-fv-notempty-message="Value is required">
      </div>
      <div class="input-group">
      <span class="input-group-btn">
        <button class="btn btn-default" type="submit" form="config">Save configuration</button>
      </span>
    </div>
    </div>
  </form>
  <?php
	}
  ?>
  </body>
</html>

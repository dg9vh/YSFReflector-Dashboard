<?php
include "config/config.php";
include "include/tools.php";
?>

<!DOCTYPE html>
<html lang="en">

<head>

  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">

  <title>YSFReflector-Dashboard by DG9VH - Setup</title>

  <!-- Bootstrap core CSS -->
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

</head>

<body>

  <!-- Navigation -->
  <nav class="navbar navbar-expand-lg navbar-dark bg-dark static-top">
    <div class="container-fluid">
      <a class="navbar-brand" href="#">YSFReflector-Dashboard by DG9VH Setup Process</a>
    </div>
  </nav>

  <?php
	if ($_GET['cmd'] =="writeconfig") {
		if (!file_exists('./config')) {
		    if (!mkdir('./config', 0777, true)) {
  ?>
  <div class="alert alert-danger" role="alert">You forgot to give write permissions to your webserver user!</div>

  <?php
		    }
		}
		$configfile = fopen("config/config.php", 'w');
		fwrite($configfile,"<?php\n");
		fwrite($configfile,"# This is an auto-generated config file!\n");
		fwrite($configfile,"# Be careful, when manually editing this!\n\n");
		fwrite($configfile,"date_default_timezone_set('UTC');\n");
		fwrite($configfile, createConfigLines());
		fwrite($configfile,"?>\n");
		fclose($configfile);
  ?>

    <div class="alert alert-success" role="alert">Your config file is written in config/config.php, please remove setup.php for security reasons!</div>
    <p><a href="index.php">Your dashboard is now available.</a></p>

  <?php
	} else {
  ?>

  <div class="container text-center">
    <h2>YSFReflector-Dashboard by DG9VH Setup Process</h2>
    <h4>Please fill in the necessary information below</h4>
  </div>
  <form id="config" action="setup.php" method="get">
    <input type="hidden" name="cmd" value="writeconfig">

  <?php
      if (defined("DISABLESETUPWARNING")) {
  ?>
      <input type="hidden" name="DISABLESETUPWARNING" value="">
  <?php
      }
  ?>

    <div class="container">
      <div class="card">
        <div class="card-header">
          <h2>YSFReflector Configuration</h2>
        </div>
        <div class="card-body">
          <div class="card-text input-group">
            <span class="input-group-addon" id="YSFREFLECTORLOGPATH" style="width: 300px">Path to YSFReflector-logfile</span>
            <input type="text" value="<?php echo constant("YSFREFLECTORLOGPATH") ?>" name="YSFREFLECTORLOGPATH" class="form-control" placeholder="/var/log/YSFReflector/" aria-describedby="YSFREFLECTORLOGPATH" required data-fv-notempty-message="Value is required">
          </div>
          <div class="input-group">
            <span class="input-group-addon" id="YSFREFLECTORLOGPREFIX" style="width: 300px">Logfile-prefix</span>
            <input type="text" value="<?php echo constant("YSFREFLECTORLOGPREFIX") ?>" name="YSFREFLECTORLOGPREFIX" class="form-control" placeholder="YSFReflector" aria-describedby="YSFREFLECTORLOGPREFIX" required data-fv-notempty-message="Value is required">
          </div>
          <div class="input-group">
            <span class="input-group-addon" id="YSFREFLECTORINIPATH" style="width: 300px">Path to YSFReflector.ini</span>
            <input type="text" value="<?php echo constant("YSFREFLECTORINIPATH") ?>" name="YSFREFLECTORINIPATH" class="form-control" placeholder="/etc/" aria-describedby="YSFREFLECTORINIPATH" required data-fv-notempty-message="Value is required">
          </div>
          <div class="input-group">
            <span class="input-group-addon" id="YSFREFLECTORINIFILENAME" style="width: 300px">YSFReflector.ini-filename</span>
            <input type="text" value="<?php echo constant("YSFREFLECTORINIFILENAME") ?>" name="YSFREFLECTORINIFILENAME" class="form-control" placeholder="YSFReflector.ini" aria-describedby="YSFREFLECTORINIFILENAME" required data-fv-notempty-message="Value is required">
          </div>
          <div class="input-group">
            <span class="input-group-addon" id="YSFREFLECTORPATH" style="width: 300px">Path to YSFReflector-executable</span>
            <input type="text" value="<?php echo constant("YSFREFLECTORPATH") ?>" name="YSFREFLECTORPATH" class="form-control" placeholder="/usr/local/bin/" aria-describedby="YSFREFLECTORPATH" required data-fv-notempty-message="Value is required">
          </div>
        </div>
      </div>
    </div>
    <div class="container">
      <div class="card">
        <div class="card-header">
        <h2>Global Configuration</h2>
        </div>
        <div class="card-body">
        <?php
          function get_tz_options($selectedzone, $label, $desc = '') {
            echo '<div class="input-group">';
            echo '<span class="input-group-addon" id="TIMEZONE" style="width: 300px">Timezone</span>';
            echo '<div class="input"><select name="TIMEZONE">';
            function timezonechoice($selectedzone) {
              $all = timezone_identifiers_list();
              $i = 0;
              foreach($all AS $zone) {
                $zone = explode('/',$zone);
                $zonen[$i]['continent'] = isset($zone[0]) ? $zone[0] : '';
                $zonen[$i]['city'] = isset($zone[1]) ? $zone[1] : '';
                $zonen[$i]['subcity'] = isset($zone[2]) ? $zone[2] : '';
                $i++;
              }
              asort($zonen);
              $structure = '';
                foreach($zonen AS $zone) {
                extract($zone);
                //if($continent == 'Africa' || $continent == 'America' || $continent == 'Antarctica' || $continent == 'Arctic' || $continent == 'Asia' || $continent == 'Atlantic' || $continent == 'Australia' || $continent == 'Europe' || $continent == 'Indian' || $continent == 'Pacific') {
                if(!isset($selectcontinent)) {
                  $structure .= '<optgroup label="'.$continent.'">'; // continent
                } elseif($selectcontinent != $continent) {
                  $structure .= '</optgroup><optgroup label="'.$continent.'">'; // continent
                }
                if(isset($city) != ''){
                  if (!empty($subcity) != ''){
                    $city = $city . '/'. $subcity;
                  }
                  if ($continent != "UTC") {
                    $structure .= "<option ".((($continent.'/'.$city)==$selectedzone)?'selected="selected "':'')." value=\"".($continent.'/'.$city)."\">".str_replace('_',' ',$city)."</option>"; //Timezone
                  } else {
                    $structure .= "<option ".(("UTC"==$selectedzone)?'selected="selected "':'')." value=\"UTC\">UTC</option>"; //Timezone
                  }
                } else {
                  if (!empty($subcity) != ''){
                    $city = $city . '/'. $subcity;
                }
                $structure .= "<option ".(($continent==$selectedzone)?'selected="selected "':'')." value=\"".$continent."\">".$continent."</option>"; //Timezone
              }
              $selectcontinent = $continent;
                // }
            }
            $structure .= '</optgroup>';
            return $structure;
          }
          echo timezonechoice($selectedzone);
          echo '</select>';
          echo '</input>';
          echo '</div>';
          echo '</div>';
        }
        get_tz_options(constant("TIMEZONE"), "Timezone", '');
?>
        <div class="input-group">
          <span class="input-group-addon" id="LOGO" style="width: 300px">URL to Logo</span>
          <input type="text" value="<?php echo constant("LOGO") ?>" name="LOGO" class="form-control" placeholder="http://your-logo" aria-describedby="LOGO">
        </div>
        <div class="input-group">
          <span class="input-group-addon" id="REFRESHAFTER" style="width: 300px">Refresh page after in seconds</span>
          <input type="text" value="<?php echo constant("REFRESHAFTER") ?>" name="REFRESHAFTER" class="form-control" placeholder="60" aria-describedby="REFRESHAFTER" required data-fv-notempty-message="Value is required">
        </div>
        <div class="input-group">
          <span class="input-group-addon" id="SHOWPROGRESSBARS" style="width: 300px">Show progressbars</span>
          <div class="panel-body"><input type="checkbox" <?php if (defined("SHOWPROGRESSBARS")) echo "checked" ?> name="SHOWPROGRESSBARS"></div>
        </div>
        <div class="input-group">
          <span class="input-group-addon" id="SHOWOLDMHEARD" style="width: 300px">Show historic heard logs, in days</span>
          <input type="text" value="<?php echo constant("SHOWOLDMHEARD") ?>" name="SHOWOLDMHEARD" class="form-control" placeholder="60" aria-describedby="SHOWOLDMHEARD" required data-fv-notempty-message="Value is required">
        </div>
        <div class="input-group">
          <span class="input-group-addon" id="TEMPERATUREALERT" style="width: 300px">Enable CPU-temperature-warning</span>
          <div class="panel-body"><input type="checkbox" <?php if (defined("TEMPERATUREALERT")) echo "checked" ?> name="TEMPERATUREALERT"></div>
        </div>
        <div class="input-group">
          <span class="input-group-addon" id="TEMPERATUREHIGHLEVEL" style="width: 300px">Warning temperature</span>
          <input type="text" value="<?php echo constant("TEMPERATUREHIGHLEVEL") ?>" name="TEMPERATUREHIGHLEVEL" class="form-control" placeholder="60" aria-describedby="TEMPERATUREHIGHLEVEL" required data-fv-notempty-message="Value is required">
        </div>
        <div class="input-group">
          <span class="input-group-addon" id="SHOWQRZ" style="width: 300px">Show link to QRZ.com on Callsigns</span>
          <div class="panel-body"><input type="checkbox" name="SHOWQRZ" <?php if (defined("SHOWQRZ")) echo "checked" ?>></div>
        </div>
        <div class="input-group">
          <span class="input-group-addon" id="GDPR" style="width: 300px">Anonymize Callsigns (no function if QRZ.com enabled)</span>
          <div class="panel-body"><input type="checkbox" name="GDPR" <?php if (defined("GDPR")) echo "checked" ?>></div>
        </div>
        <div class="input-group">
        <span class="input-group-btn">
          <button class="btn btn-primary" type="submit" form="config">Save configuration</button>
        </span>
        </div>
      </div>
      </div>
    </div>
  </form>

<?php
	}
?>

  <!-- Bootstrap core JavaScript -->
  <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>

</body>

</html>

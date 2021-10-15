<?php
function getYSFReflectorVersion() {
	// returns creation-time of YSFReflector as version-number
	$filename = YSFREFLECTORPATH."/YSFReflector";
	exec($filename." -v 2>&1", $output);
	if (!startsWith(substr($output[0],21,8),"20")) {
		return getYSFReflectorFileVersion();
	} else {
		return substr($output[0],21,8)." (compiled ".getYSFReflectorFileVersion().")";
	}
}


function getYSFReflectorFileVersion() {
	// returns creation-time of YSFReflector as version-number
	$filename = YSFREFLECTORPATH."/YSFReflector";
	if (file_exists($filename)) {
		return date("d M Y", filectime($filename));
	}
}

function getGitVersion(){
	if (file_exists(".git")) {
		exec("git rev-parse --short HEAD", $output);
		return 'GitID #<a href="https://github.com/dg9vh/YSFReflector-Dashboard/commit/'.$output[0].'" target="_blank">'.$output[0].'</a>';
	} else {
		return 'GitID unknown';
	}
}

function getYSFReflectorConfig() {
	// loads YSFReflector.ini into array for further use
	$conf = array();
	if ($configs = fopen(YSFREFLECTORINIPATH."/".YSFREFLECTORINIFILENAME, 'r')) {
		while ($config = fgets($configs)) {
			array_push($conf, trim ( $config, " \t\n\r\0\x0B"));
		}
		fclose($configs);
	}
	return $conf;
}

function getConfigItem($section, $key, $configs) {
	// retrieves the corresponding config-entry within a [section]
	$sectionpos = array_search("[" . $section . "]", $configs) + 1;
	$len = count($configs);
	while(startsWith($configs[$sectionpos],$key."=") === false && $sectionpos <= ($len) ) {
		if (startsWith($configs[$sectionpos],"[")) {
			return null;
		}
		$sectionpos++;
	}
	
	return substr($configs[$sectionpos], strlen($key) + 1);
}

function getYSFReflectorLog() {
	// Open Logfile and copy loglines into LogLines-Array()
	$logLines = array();
	if ($log = fopen(YSFREFLECTORLOGPATH."/".YSFREFLECTORLOGPREFIX."-".date("Y-m-d").".log", 'r')) {
		while ($logLine = fgets($log)) {
			if (startsWith($logLine, "M:"))
				array_push($logLines, $logLine);
		}
		fclose($log);
	}
	return $logLines;
}


function listdir_by_date($path){
        $dir = opendir($path);
        $list = array();
        while($file = readdir($dir)){
            if ($file != '.' and $file != '..' and startsWith($file,YSFREFLECTORLOGPREFIX)){
                $ctime = filectime($path . "/" . $file) . ',' . $file;
                $list[$ctime] = $file;
            }
        }
        closedir($dir);
        krsort($list);
        return $list;
}


function getOldYSFReflectorLog() {
        $dir = YSFREFLECTORLOGPATH;
        $scannedLogs = 0;
        $oldlogLines = array();

        $dir_files = listdir_by_date($dir);
        
        foreach ($dir_files as $file) {
            $filepath = $dir."/".$file;
            if ( is_file( $filepath ) && substr( $filepath, -4 ) == '.log' ) {
                if ($log = fopen($filepath, 'r')) {
                        while ($oldlogLine = fgets($log)) {
                                if (startsWith($oldlogLine, "M:")){
                                        array_push($oldlogLines, $oldlogLine);
                                }
                        }
                        fclose($log);

                        $scannedLogs++;
                        if ( $scannedLogs > SHOWOLDMHEARD ) {
                                break;
                        }
                }
            }
        }
	return $oldlogLines;
}


function getShortYSFReflectorLog() {
	// Open Logfile and copy loglines into LogLines-Array()
	$logPath = YSFREFLECTORLOGPATH."/".YSFREFLECTORLOGPREFIX."-".date("Y-m-d").".log";
	//$logLines = explode("\n", `tail -n100 $logPath`);
	$logLines = explode("\n", `egrep -h "Received|watchdog" $logPath | tail -1`);
	return $logLines;
}

function getConnectedGateways($logLines) {
	$gateways = Array();
	foreach ($logLines as $logLine) {
		if(strpos($logLine,"YSFReflector")){
			$gateways = Array();
		}
		if(strpos($logLine,"Adding")) {
			$lineParts = explode(" ", $logLine);
			if (!array_search($gateways, $lineParts[4])) {
				array_push($gateways, Array('callsign'=>$lineParts[4],'timestamp'=>$lineParts[1]." ".substr($lineParts[2],0,8)));
			}
		}
		if(strpos($logLine,"Removing")) {
			$lineParts = explode(" ", $logLine);
			$pos = array_search($lineParts[4],array_column($gateways, 'callsign'));
			array_splice($gateways, $pos, 1);
		}
	}
	return $gateways;
}

function getLinkedGateways($logLines) {
//0000000000111111111122222222223333333333444444444455555555556666666666	
//0123456789012345678901234567890123456789012345678901234567890123456789
//M: 2016-06-24 11:11:41.787 Currently linked repeaters/gateways:
//M: 2016-06-24 11:11:41.787     GATEWAY   : 217.82.212.214:42000 2/60
//M: 2016-06-24 11:11:41.787     DM0GER    : 217.251.59.165:42000 5/60

	$gateways = Array();
	for ($i = count($logLines); $i>0; $i--) {
		$logLine = $logLines[$i];
		
		if (strpos($logLine, "Starting YSFReflector")) {
			return $gateways;
		}
		if (strpos($logLine, "No repeaters/gateways linked")) {
			return $gateways;
		}
		if (strpos($logLine, "Currently linked repeaters/gateways")) {
			for ($j = $i+1; $j <= count($logLines); $j++) {
				$logLine = $logLines[$j];
				if (!startsWith(substr($logLine,27), "   ")) {
					return $gateways;
				} else {
					$timestamp = substr($logLine, 3, 19);
					$callsign = substr($logLine, 31, 10);
					//$ipport = substr($logLine,43);
					$ipport = substr($logLine,31);
					$key = searchForKey("ipport",$ipport, $gateways);
					if ($key === NULL) {
						array_push($gateways, Array('callsign'=>$callsign,'timestamp'=>$timestamp,'ipport'=>$ipport));
					}
				}	
			}
		}
	}
	return $gateways;
}

function getHeardList($logLines) {
	$heardList = array();
	$dttxend = "";
	foreach ($logLines as $logLine) {
		if (strpos($logLine,"Data from") == false and strpos($logLine,"Received command") == false and  strpos($logLine,"blocked") == false and strpos($logLine,"Reload the Blacklist from File") == false and strpos($logLine,"Reload the Blacklist from File") == false and strpos($logLine,"YSF server status enquiry from") == false) {
			$duration = "transmitting";
			$timestamp = substr($logLine, 3, 19);
			$dttimestamp = new DateTime($timestamp);
			if ($dttxend !== "") {
				$duration = $dttimestamp->diff($dttxend)->format("%s");
			}
			$callsign2 = substr($logLine, strpos($logLine,"from") + 5, strpos($logLine,"to") - strpos($logLine,"from") - 6);
			$callsign = trim($callsign2);
			$target = substr($logLine, strpos($logLine, " to ") + 4, strpos($logLine," at ") - strpos($logLine, " to ") - 3);
			$gateway = substr($logLine, strrpos($logLine," at ") + 4);
			if (strpos($gateway, "FICH") == true) {
				$gateway = substr($gateway, 0, strpos($gateway, "FICH"));
			}
			// Callsign or ID should be less than 11 chars long, otherwise it could be errorneous
			if ( strlen($callsign) < 11 ) {
				array_push($heardList, array(convertTimezone($timestamp), $callsign, $target, $gateway, $duration));
			}
			if(strpos($logLine,"end of") || strpos($logLine,"watchdog has expired") || strpos($logLine,"ended RF data") || strpos($logLine,"ended network")) {
				$txend = substr($logLine, 3, 19);
				$dttxend = new DateTime($txend);
			}
		}
	}
	return $heardList;
}

function getLastHeard($logLines) {
	//returns last heard list from log
	$lastHeard = array();
	$heardCalls = array();
	$heardList = getHeardList($logLines);
	$counter = 0;
	foreach ($heardList as $listElem) {
		if(!(array_search($listElem[1], $heardCalls) > -1)) {
			array_push($heardCalls, $listElem[1]);
			array_push($lastHeard, $listElem);
			$counter++;
		}
	}
	return $lastHeard;
}

function getSize($filesize, $precision = 2) {
	$units = array('', 'K', 'M', 'G', 'T', 'P', 'E', 'Z', 'Y');
	foreach ($units as $idUnit => $unit) {
		if ($filesize > 1024)
			$filesize /= 1024;
		else
			break;
	}
	return round($filesize, $precision).' '.$units[$idUnit].'B';
}
?>

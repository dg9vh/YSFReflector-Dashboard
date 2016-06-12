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
		return date("d M y", filectime($filename));
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
			array_push($logLines, $logLine);
		}
		fclose($log);
	}
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

function getHeardList($logLines) {
	$heardList = array();
	foreach ($logLines as $logLine) {
		$timestamp = substr($logLine, 3, 19);
		$callsign2 = substr($logLine, strpos($logLine,"from") + 5, strpos($logLine,"to") - strpos($logLine,"from") - 6);
		$callsign = trim($callsign2);
		$target = substr($logLine, strpos($logLine, "to") + 3, strpos($logLine,"at") - strpos($logLine,"to") - 6); 
		$gateway = substr($logLine, strpos($logLine,"at") + 3);
		// Callsign or ID should be less than 11 chars long, otherwise it could be errorneous
		if ( strlen($callsign) < 11 ) {
			array_push($heardList, array($timestamp, $callsign, $target, $gateway));
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
		if ($counter == LHLINES) {
			return $lastHeard;
		}
	}
	return $lastHeard;
}

//Some basic inits
$configs = getYSFReflectorConfig();
$logLines = getYSFReflectorLog();

$reverseLogLines = $logLines;
array_multisort($reverseLogLines,SORT_DESC);
$lastHeard = getLastHeard($reverseLogLines);
?>
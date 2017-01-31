<?php
//Some basic inits
$configs = getYSFReflectorConfig();
if (!defined("TIMEZONE"))
   define("TIMEZONE", "UTC");
$logLines = getYSFReflectorLog();

$reverseLogLines = $logLines;
array_multisort($reverseLogLines,SORT_DESC);
$lastHeard = getLastHeard($reverseLogLines);
$allHeard = getHeardList($reverseLogLines);
?>
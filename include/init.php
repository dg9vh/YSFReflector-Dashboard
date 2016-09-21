<?php
//Some basic inits
$configs = getYSFReflectorConfig();
$logLines = getYSFReflectorLog();

$reverseLogLines = $logLines;
array_multisort($reverseLogLines,SORT_DESC);
$lastHeard = getLastHeard($reverseLogLines);
$allHeard = getHeardList($reverseLogLines);
?>
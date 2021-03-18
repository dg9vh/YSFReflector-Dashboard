<?php
//Some basic inits
$configs = getYSFReflectorConfig();
if (!defined("TIMEZONE"))
   define("TIMEZONE", "UTC");

$logLines = getYSFReflectorLog();

if (defined("SHOWOLDMHEARD")) {
   $oldlogLines = getOldYSFReflectorLog();
}

$reverseLogLines = $logLines;
array_multisort($reverseLogLines,SORT_DESC);
$lastHeard = getLastHeard($reverseLogLines);
$allHeard = getHeardList($reverseLogLines);

$reverseOldLogLines = $oldlogLines;
array_multisort($reverseOldLogLines,SORT_DESC);
$oldallHeard = getLastHeard($reverseOldLogLines);
?>

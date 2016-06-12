<?php
?>
  <div class="panel panel-default">
  <!-- Standard-Panel-Inhalt -->
  <div class="panel-heading">Connected YSFGateways</div>
  <!-- Tabelle -->
  <table class="table">
    <tr>
      <th>Time (UTC)</th>
      <th>Callsign</th>
    </tr>
<?php
	$gateways = getConnectedGateways($logLines);
	foreach ($gateways as $gateway) {
		
		echo "<tr>";
		echo "<td>$gateway[timestamp]</td><td>$gateway[callsign]</td>";
		echo "</tr>";
	}
?>
  </table>
</div>

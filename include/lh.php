<?php
?>
  <div class="panel panel-default">
  <!-- Standard-Panel-Inhalt -->
  <div class="panel-heading">Last Heard List of today's <?php echo LHLINES; ?> callsigns.</div>
  <!-- Tabelle -->
  <table class="table">
    <tr>
      <th>Time (UTC)</th>
      <th>Callsign</th>
      <th>Target</th>
      <th>Gateway</th>
    </tr>
<?php
for ($i = 0; ($i < LHLINES) AND ($i < count($lastHeard)); $i++) {
		$listElem = $lastHeard[$i];
		echo"<tr>";
		echo"<td>$listElem[0]</td>";
		echo"<td>$listElem[1]</td>";
		echo"<td>$listElem[2]</td>";
		echo"<td>$listElem[3]</td>";
		echo"<td>$listElem[4]</td>";
		echo"</tr>\n";
	}

?>
  </table>
</div>

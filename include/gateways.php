<?php
?>
  <div class="panel panel-default">
  <!-- Standard-Panel-Inhalt -->
  <div class="panel-heading">Connected YSFGateways</div>
  <!-- Tabelle -->
  <div class="table-responsive"> 
  <table id="gateways" class="table table-condensed">
  	<thead>
    <tr>
      <th>Time (UTC)</th>
      <th>Callsign</th>
    </tr>
    </thead>
    <tbody>
<?php
	$gateways = getConnectedGateways($logLines);
	foreach ($gateways as $gateway) {
		
		echo "<tr>";
		echo "<td>$gateway[timestamp]</td><td>$gateway[callsign]</td>";
		echo "</tr>";
	}
?>
  </tbody>
  </table>
  </div>
  <script>
    $(document).ready(function(){
      $('#gateways').dataTable( {
        "aaSorting": [[0,'desc']]
      } );
    });
   </script>
</div>

<?php
?>
  <div class="panel panel-default">
  <!-- Standard-Panel-Inhalt -->
  <div class="panel-heading">Last Heard List</div>
  <!-- Tabelle -->
  <div class="table-responsive">  
  <table id="lh" class="table table-condensed">
  <thead>
    <tr>
      <th>Time (UTC)</th>
      <th>Callsign</th>
      <th>Target</th>
      <th>Gateway</th>
      <th>Dur (s)</th>
    </tr>
  </thead>
  <tbody>
<?php
for ($i = 0; $i < count($lastHeard); $i++) {
		$listElem = $lastHeard[$i];
		echo"<tr>";
		echo"<td>$listElem[0]</td>";
		if (constant("SHOWQRZ") && $listElem[1] !== "??????????" && !is_numeric($listElem[1])) {
			echo"<td nowrap><a target=\"_new\" href=\"https://qrz.com/db/$listElem[1]\">".str_replace("0","&Oslash;",$listElem[1])."</a></td>";
		} else {
			echo"<td nowrap>".str_replace("0","&Oslash;",$listElem[1])."</td>";
		}
		echo"<td>$listElem[2]</td>";
		echo"<td>$listElem[3]</td>";
		echo"<td>$listElem[4]</td>";
		echo"</tr>\n";
	}

?>
  </tbody>
  </table>
  </div>
  <script>
    $(document).ready(function(){
      $('#lh').dataTable( {
        "aaSorting": [[0,'desc']]
      } );
    });
   </script>
</div>

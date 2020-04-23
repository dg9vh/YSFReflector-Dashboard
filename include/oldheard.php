<?php
?>
  <div class="card">
  <div class="card-header">Alltime Heard List</div>
  <div class="table-responsive">
  <table id="oldallHeard" class="table table-condensed">
  <thead>
    <tr>
      <th>Time (<?php echo TIMEZONE;?>)</th>
      <th>Callsign</th>
      <th>Target</th>
      <th>Gateway</th>
    </tr>
  </thead>
  <tbody>
<?php
for ($i = 0; $i < count($oldallHeard); $i++) {
		$listElem = $oldallHeard[$i];
		echo"<tr>";
		echo"<td>$listElem[0]</td>";

		if (defined("GDPR"))
			echo"<td nowrap>".str_replace("0","&Oslash;",substr($listElem[1],0,3)."***")."</td>";
		else
			echo"<td nowrap>".str_replace("0","&Oslash;",$listElem[1])."</td>";
		//echo"<td>$listElem[1]</td>";
		echo"<td>$listElem[2]</td>";
		if (defined("GDPR"))
			echo"<td nowrap>".str_replace("0","&Oslash;",substr($listElem[3],0,3)."***")."</td>";
		else
			echo"<td nowrap>".str_replace("0","&Oslash;",$listElem[3])."</td>";
		echo"</tr>\n";
	}

?>
  </tbody>
  </table>
  </div>
  <script>
    $(document).ready(function(){
      $('#oldallHeard').dataTable( {
        "aaSorting": [[0,'desc']]
      } );
    });
   </script>
</div>

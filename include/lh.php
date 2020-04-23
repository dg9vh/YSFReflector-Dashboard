<?php
?>
  <div class="card">
  <div class="card-header">Last Heard List</div>
  <div class="table-responsive">
  <table id="lh" class="table table-condensed">
  <thead>
    <tr>
      <th>Time (<?php echo TIMEZONE;?>)</th>
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
		if (defined("SHOWQRZ") && $listElem[1] !== "??????????" && !is_numeric($listElem[1])) {
			echo"<td nowrap><a target=\"_new\" href=\"https://qrz.com/db/$listElem[1]\">".str_replace("0","&Oslash;",$listElem[1])."</a></td>";
		} else {
			if (defined("GDPR"))
				echo"<td nowrap>".str_replace("0","&Oslash;",substr($listElem[1],0,3)."***")."</td>";
			else
				echo"<td nowrap>".str_replace("0","&Oslash;",$listElem[1])."</td>";
		}
		echo"<td>$listElem[2]</td>";
		if (defined("GDPR"))
			echo"<td nowrap>".str_replace("0","&Oslash;",substr($listElem[3],0,3)."***")."</td>";
		else
			echo"<td nowrap>".str_replace("0","&Oslash;",$listElem[3])."</td>";
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

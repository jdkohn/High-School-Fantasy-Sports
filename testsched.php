<?php

include "createconnection.php";
include "style.php";

$teamnum=53;
$leaguenum=32;

$drafttime = '';
foreach($conn->query("SELECT * FROM leagues WHERE id='$leaguenum'") as $liga) {
	$drafttime = $liga["draftdate"];
}	

date_default_timezone_set('America/Los_Angeles');
$timeToDraft = time() - strtotime($drafttime);

$min = ((((int)($timeToDraft/60)))*-1);
$ttdnice = $min . ":";
$seconds = (($timeToDraft%60)*-1);
if($seconds<10) {
	$ttdnice+= "0" . $seconds;
} else {
	$ttdnice+= $seconds;
}

if(1==1) {
?>
<script type="text/javascript">
		  setTimeout(function(){
		    update_content();
		  },1000)
</script>
<?php
}
?>


<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<script>

function update_content(){
	$.ajax({
		type: "GET",
      url: "testsched.php", // post it back to itself - use relative path or consistent www. or non-www. to avoid cross domain security issues
      cache: false, // be sure not to cache results
  })
	.done(function( page_html ) {
		var newDoc = document.open("text/html", "replace");
		newDoc.write(page_html);
		newDoc.close();
	});   
}

</script>

<html>

<table width="100%">
	<tr>
		<?php
		if($min > 0) {
			?>
			<td> <?php echo "Time To Draft: " . $timeToDraft; ?></td>
			<?php
		} else {
			?>
				<td><?php echo "On The Clock: " . "INSERT TEAM NAME HERE"; ?></td>
				<td><?php echo "TIMER"; ?></td>
			<?php
		}
		?>
	</tr>
</table>




</html>



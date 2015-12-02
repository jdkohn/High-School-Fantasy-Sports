<?php

$i = 60;

?>

<script>
	
function update_content() {
	$i--;
}

	setTimeout(function(){
	    update_content();
	  },1000)
</script>

<html>

<a><?php echo $i; ?></a>



</html>

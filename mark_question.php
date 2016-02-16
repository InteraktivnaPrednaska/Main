<?php

include("functions.php");
if ($link = spoj_s_db()) {
	$id=$_POST['i']; 
	$sql = "UPDATE questions SET solved=1, date=date WHERE id=".$id;
	$result = mysql_query($sql, $link);
	mysql_close($link); 
	
}

?>

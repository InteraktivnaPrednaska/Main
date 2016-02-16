<?php

include("functions.php");
if ($link = spoj_s_db()) {

	$type=$_POST['type']; 
	$sql = "DELETE FROM slides WHERE  id = ".$type; 

	$result = mysql_query($sql, $link);
	mysql_close($link); 
	
}

?>

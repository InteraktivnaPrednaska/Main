<?php

include("functions.php");
if ($link = spoj_s_db()) {
	$id=$_POST['i']; 
	$sql = "select yes,no from questions WHERE id=".$id;
	$result = mysql_query($sql, $link);
	$row = mysql_fetch_assoc($result);
	$_SESSION["yn"] = $row;
	mysql_close($link);

	
}

?>

<?php

include("functions.php");
if ($link = spoj_s_db()) {

	$type=$_POST['type']; 
	$val=$_POST['val1']; 
	$sql = "INSERT INTO questions (slide_id,question) VALUES ( ".$type.",'".$val."');";

	$result = mysql_query($sql, $link);
	mysql_close($link); 
	echo $sql;
}

?>

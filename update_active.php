<?php

include("functions.php");
if ($link = spoj_s_db()) {

	$type=$_POST['type']; 
	$val=$_POST['val1'];
	if($val) mysql_query("update slides set active=0, date=date where active =1", $link); 
	$sql = "UPDATE slides SET active='".$val."', public=1, date=date WHERE id='".$type."'";
	$result = mysql_query($sql, $link);
	mysql_close($link); 

}

?>

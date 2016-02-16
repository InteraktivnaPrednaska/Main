<?php
include("functions.php");
if(!is_admin()) die;
if ($link = spoj_s_db()) {

	$type=$_POST['type']; 
	$val=$_POST['val1']; 
	$sql = "INSERT INTO questions (slide_id,question,inq) VALUES ( ".$type.",'".$val."',1);";

	$result = mysql_query($sql, $link);
	mysql_close($link); 
	echo $sql;
}

?>

<?php

include("functions.php");
if ($link = spoj_s_db()) {
	$id=$_POST['i']; 
	mysql_query("update questions set no= no+1, date=date where id =$id", $link); 
	mysql_close($link); 

}

?>

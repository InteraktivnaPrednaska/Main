<?php

include("functions.php");
if ($link = spoj_s_db()) {
	
	$id=(int)$_POST['i']; 
	$type = (int)$_POST['type']==1 ? 1 : 0;


	$sql = mysql_query("SELECT * FROM poll WHERE poll_id='$id' && ip='".$_SERVER['REMOTE_ADDR']."'");
	if(mysql_num_rows($sql)==0) {
		mysql_query("INSERT INTO poll (id,ip,poll_id,answer,date_answered) VALUES(0,'".$_SERVER['REMOTE_ADDR']."','$id','$type','".time()."')");
		mysql_query("update questions set ".($type==1?"yes=yes+1":"no=no+1").", date=date where id =$id", $link); 
		
	}
	
	mysql_close($link); 
}

?>

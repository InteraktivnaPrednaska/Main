<?php
define("AUTOR", "tis team");

session_start();
error_reporting(E_ALL - E_NOTICE);
function spoj_s_db() {
	if ($link = mysql_connect('localhost', 'root', 'usbw')) {
		if (mysql_select_db('lecture', $link)) {
			mysql_query("SET CHARACTER SET 'utf8'", $link); 
			return $link;
		} else {
			// NEpodarilo sa vybrať databázu!
			return false;
		}
	} else {
		// NEpodarilo sa spojiť s databázovým serverom!
		return false;
	}
}

function login(){
$_SESSION["error"]=''; // Variable To Store Error Message
if (isset($_POST['submit'])) {
	if (empty($_POST['password'])) $_SESSION["error"] = "Password is invalid";
	else{
		$password=$_POST['password'];
		$connection = spoj_s_db();
		$db = mysql_select_db("company", $connection);
		$query = mysql_query("select * from login where password=MD5('$password')", $connection);
		$rows = mysql_num_rows($query);
		if ($rows == 0) {
			$_SESSION["error"] = "Password is invalid";
			mysql_close($connection);
			$_SESSION["admin"] = false;
			return;
		}
		mysql_close($connection);
		$_SESSION["admin"] = true;
		?>
		<script language="javascript">window.location.href = "admin.php"</script>
		<?php
	}
}
}

function is_admin() {
	return isset($_SESSION["admin"]) && $_SESSION["admin"]===true;
}

function do_alert($msg) 
{
	echo '<script type="text/javascript">alert("' . $msg . '"); </script>';
}
function inside_alert($msg){
	echo 'alert(' . $msg . ');';
}

function pridaj() {
	if (isset($_FILES['files']) && $link = spoj_s_db()) {
		$errors= array();
    
		foreach($_FILES['files']['tmp_name'] as $key => $tmp_name ){
		$file_name = $_FILES['files']['name'][$key];
		$file_size =$_FILES['files']['size'][$key];
		$file_tmp =$_FILES['files']['tmp_name'][$key];
		$file_type=$_FILES['files']['type'][$key];	
        
        $sql = "insert into slides (name, public, active) values ('".addslashes($file_name)."',0,0)";
		
		$desired_dir="sources";
        if(empty($errors)==true){
            if(is_dir($desired_dir)==false){
                mkdir("$desired_dir", 0700);		// Create directory if it does not exist
            }
            if(is_dir("$desired_dir/".$file_name)==false){
                move_uploaded_file($file_tmp,"$desired_dir/".$file_name);
            }else{									// rename the file if another one exist
                $new_dir="$desired_dir/".$file_name.time();
                 rename($file_tmp,$new_dir) ;				
            }
		if(!mysql_query($sql, $link)) do_alert("chyba v sql"); 			
        }else{
                do_alert("print_r($errors)");
        }
    }
	
		
		mysql_close($link);
	} else do_alert("NEpodarilo sa spojiť s databázovým serverom!");
}


function vypis_prednasky(){
	if ($link = spoj_s_db())
	{
		$sql = "select id,name, date, active from slides order by date";
		$result = mysql_query($sql, $link);
		if ($result){

			echo '<ul class="slides" >';
			echo '<li class="guide"><ul class="name"><p>názov</p></ul><ul class="date"><p>dátum</p></ul><ul class="name"><p>aktívne</p></ul></li>';
			while($row = mysql_fetch_assoc($result)){
				echo '<li>';
				echo '<ul class="name"><p>'.$row["name"].'</p></ul>';
				echo '<ul class="date"><p>'.$row["date"].'</p></ul>';
				if($row['active']) echo '<ul><input id="a'.$row["id"]. '"name="a'.$row["id"]. '" class="cmn-toggle cmn-toggle-round-flat" type="checkbox" checked><label data-slide="'.$row["id"].'" data-checked="1" class="toggle_act" id="la'.$row["id"]. '"for="a'.$row["id"]. '"></label></ul>';
				else echo '<ul><input id="a'.$row["id"]. '"name="a'.$row["id"]. '" class="cmn-toggle cmn-toggle-round-flat" type="checkbox"><label data-slide="'.$row["id"].'" data-checked="0" class="toggle_act" id="la'.$row["id"]. '"for="a'.$row["id"]. '"></label></ul>';
				echo '<ul class="del" data-slide='.$row["id"].'><p><a href="?del='.$row['id'].'">odstrániť</a></p></ul>';
				
				echo '</li>';
      	}
      	echo'</ul>';
      	
      }
      else echo '<p class="empty">Databáza prekdášok je prázdna</p>';
  }
  else do_alert("NEpodarilo sa spojiť s databázovým serverom!");

}
function is_active(){
	if($link = spoj_s_db()){
		$result = mysql_query("select name, id from slides where active = 1", $link);
		if(mysql_num_rows($result) == 1){
			$_SESSION['slide'] = mysql_fetch_assoc($result);
			mysql_close($link);
			return true;
		}
		mysql_close($link);
		return false;
	}

	do_alert("Nepodarilo sa spojiť s databázou.");
	return false;
}
function select_questions(){
	if ($link = spoj_s_db())
	{
		$sql = "select id,question,solved,inq,yes,no from questions where slide_id =".$_SESSION['slide']['id']." order by inq DESC, id desc";
		$result = mysql_query($sql, $link);
		$poll_shown = false;
		if ($result){
			echo '<ul class="questions">';
			while($row = mysql_fetch_assoc($result)){
				if($row["solved"]==1){
					echo "<li class='solved'>";
					echo "<p>".$row['question'];
					echo '</p></li>';
				} if($row["solved"]==0 && $row["inq"]==0) {
					echo "<li onclick='mark_as_solved(".$row["id"].")'>";
					echo "<p>".$row['question'];
					echo '</p></li>';

				}
				
				
				if($row["inq"]==1 && !$poll_shown) {
					$poll_shown = true;
					echo "<li class='inq' id='inq_".$row['id']."' onclick='show(".$row["id"].")'>";
					echo "<p>".$row['question'];
					echo '</p>';

					$sql = mysql_query("SELECT * FROM poll WHERE ip='".$_SERVER['REMOTE_ADDR']."' && poll_id='".$row['id']."'");

					if(mysql_num_rows($sql)==0 && !is_admin()) {
						echo "<p class='a1' onclick='plus(".$row["id"].")'>áno</p>";
						echo "<p class='a2' onclick='minus(".$row["id"].")'>nie</p>";
					} else {
						$yo = ($row['yes']+$row['no']) > 0 ? ($row['yes']+$row['no']) : 1;
						echo "<div class='poll-box'><div class='poll-box-yes' style='width:".(100*($row['yes']/ $yo))."%;'><span style='left:0'>".$row['yes']."</span></div><span style='right:0'>".$row['no']."</span></div>";
					}
					echo '</li>';
					

				}
				

			}
			echo'</ul>';
			
		}
		else echo '<p class="empty">Databáza prekdášok je prázdna</p>';
	}
	else do_alert("NEpodarilo sa spojiť s databázovým serverom!");
}
function show_php($id){
if ($link = spoj_s_db()) {
	$sql = "select yes,no from questions WHERE id=".$id;
	$result = mysql_query($sql, $link);
	$row = mysql_fetch_assoc($result);
	do_alert($id);
	mysql_close($link);
	
	
}}
?>


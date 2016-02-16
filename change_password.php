<?php
$title = "change password";
include("functions.php");
function change(){
$_SESSION["error"]=''; // Variable To Store Error Message
if (isset($_POST['submit'])) {
	if ($_POST['password1'] != $_POST['password2']) $_SESSION["error"] = "Heslá sa nezhodujú.";
	else{
		$pw=$_POST['password1'];
		$connection = spoj_s_db();
		$sql = "UPDATE `lecture`.`login` SET `password` = MD5('$pw') WHERE `login`.`id` = 1;";
		$query = mysql_query($sql, $connection);
		mysql_close($connection);
		?>
		<script language="javascript">window.location.href = "admin.php"</script>
		<?php
	}
}
}
change();
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<meta ln="sk"> 
<title><?php echo $title; ?></title>
<link href="style.css" rel="stylesheet">
<link href="features.css" rel="stylesheet">
<script type="text/javascript" src="script.js"></script>
</head>
<body>

<form class="login" method="post">
<input class="password" name="password1" placeholder="nové heslo" type="password">
<input class="password" name="password2" placeholder="zopakujte heslo" type="password">
<input class="submit" name="submit" type="submit" value="Zmeň heslo">
<span class="error"><?php echo $_SESSION["error"]; ?></span>
</form>
</body>
</html>

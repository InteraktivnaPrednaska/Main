<?php
$title = "login";
include("functions.php");
login();
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
<input class="password" name="password" placeholder="Password" type="password">
<input class="submit" name="submit" type="submit" value=" Submit ">
<span class="error"><?php echo $_SESSION["error"]; ?></span>
</form>
</body>
</html>

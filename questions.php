<?php
$ajax = false;
if(!defined("AUTOR")) {
	include 'functions.php';
	$ajax=true;
}
if(!is_active()) die;
$cont = select_questions();


if($ajax)
	echo $cont;
?>

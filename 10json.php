<?php
	$data = file_get_contents("php://input", "r");
	$mydata = array();
	$mydata = json_decode($data, true);
?>
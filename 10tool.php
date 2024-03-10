<?php
	//建立連線
	function create_connect(){
		$link = mysqli_connect("localhost", "id19291404_member10", ")^u#mF{]UGIWm7@j")
		or die("連線失敗".mysqli_connect_error());

		mysqli_query($link, "SET NAMES utf8");
		return $link;
	}
	
	//執行sql指令
	function execute_sql($link, $dbname, $sql)
	{
		mysqli_select_db($link, $dbname) or die("連線資料庫失敗: ".mysqli_error($link));

		$result = mysqli_query($link, $sql);

		return $result;
	}
?>
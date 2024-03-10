<?php
	require_once("10json.php");
	if(isset($mydata["username"]) && isset($mydata["password"]) && isset($mydata["email"])){
		if($mydata["username"] != "" && $mydata["password"] != "" && $mydata["email"] != ""){
			$c_username = $mydata["username"];
			$c_password = $mydata["password"];
			$c_email = $mydata["email"];
			require_once("10tool.php");
			$link = create_connect();
			$sql = "INSERT INTO user(Username, Password, Email) VALUES('$c_username','$c_password','$c_email')";
			if(execute_sql($link, "id19291404_awei", $sql)){
				echo '{"state" : true, "message" : "註冊成功!" }';
			}else{
				echo '{"state" : false, "message" : "註冊失敗! : '.mysqli_error($link).$sql.'" }';
			}
			mysqli_close($link);
		}else{
			echo '{"state": false, "message":"欄位不得為空白!"}';
		}
	}else if(isset($mydata["username"]) && isset($mydata["password"])){
		if($mydata["username"] != "" && $mydata["password"] != ""){
			$log_username = $mydata["username"];
			$log_password = $mydata["password"];
			$UID;
			$UID_2;
			require_once("10tool.php");
			$link = create_connect();
			$sql = "SELECT Username ,Password FROM user WHERE Username ='$log_username' AND Password = '$log_password'";
			$result = execute_sql($link, "id19291404_awei", $sql);
			if(mysqli_num_rows($result) == 1){
				$UID = substr(uniqid(md5(sha1(date("1 jS \of F Y h:i:s A")))), 3,10);
				$UID_2 = substr(date(md5("1 jS \of F Y h:i:s A")), 3,12);
				$sql = "UPDATE user SET UID = '$UID', UID_2 = '$UID_2' WHERE Username = '$log_username'";
				$result = execute_sql($link, "id19291404_awei", $sql);
				if($result){
					echo '{"state" : true, "message" : "登入成功!" ,"UID" : "'.$UID.'" ,"UID_2" : "'.$UID_2.'"}';
				}else{
					echo '{"state" : false, "message" : "UID更新失敗!'.mysqli_error($link).'" }';
				}
			}else{
				echo '{"state" : false, "message" : "帳號密碼不存在, 登入失敗!" }';
			}
			mysqli_close($link);
		}else{
			echo '{"state" : false, "message" : "欄位不得為空白!(login)" }';
		}
	}else if (isset($mydata["UID"]) && isset($mydata["UID_2"])) {
		if($mydata["UID"] != "" && $mydata["UID_2"] != ""){
			$C_UID = $mydata["UID"];
			$C_UID_2 = $mydata["UID_2"];
			require_once("10tool.php");
			$link = create_connect();
			$sql = "SELECT Username, Email, UID, UID_2 FROM user WHERE UID = '$C_UID'AND UID_2 = '$C_UID_2'";
			$result = execute_sql($link,"id19291404_awei",$sql);
			if(mysqli_num_rows($result)==1){
				$row = mysqli_fetch_assoc($result);
				echo '{"state" : true, "message" : "登入成功", "data" : '.json_encode($row).'}';
			}else{
				echo '{"state" : false, "message" : "登入失敗"}';
			}
			mysqli_close($link);
		}else{
			echo '{"state" : false, "message" : "欄位不得為空白!" }';
		}
	}else if(isset($mydata["username"])){
		if($mydata["username"]!=""){
			$check_username = $mydata["username"];
			require_once("10tool.php");
			$link = create_connect();
			$sql = "SELECT Username FROM user WHERE Username = '$check_username'";
			$result = execute_sql($link, "id19291404_awei", $sql);
	
			if(mysqli_num_rows($result) == 1){
				echo '{"state" : false, "message" : "帳號存在, 不可使用!" }';
			}else{
				echo '{"state" : true, "message" : "帳號不存在, 可以使用!" }';
			}
			mysqli_close($link);
		}else{
			echo '{"state" : false, "message" : "欄位不得為空白!" }';
		}
	}else if(true){
		require_once("10tool.php");
		$link = create_connect();
		$sql = "SELECT ID, Username, Email, Created_at, UID, UID_2 FROM user ORDER BY ID DESC"; //ASC : 遞增  ,DESC : 遞減
		$result = execute_sql($link, "id19291404_awei", $sql);
		if(mysqli_num_rows($result) > 0){
			$mydata = array();
			while($row = mysqli_fetch_assoc($result)){
				$mydata[] = $row;
			}
			echo '{"state" : true, "data":'.json_encode($mydata).', "message" : "資料讀取成功!" }';
		}else{
			echo '{"state" : false, "message" : "資料讀取失敗!" }';
		}
		mysqli_close($link);
	}else{
		echo '{"state": false, "message":"API規定的欄位不存在!"}';
	}
?>
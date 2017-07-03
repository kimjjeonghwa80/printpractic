<?php
	require("../library/config.php");

	$jpegcur_id = $_POST['jpegcurrentuserid'];
	$jpegcur_tempid = $_POST['jpegtempid'];

	$admin_sql = "SELECT jpeg_limit FROM download_imit";
	$admin_result = mysql_query($admin_sql);
	$admin_limit = mysql_fetch_array($admin_result);

	$client_sql = "SELECT jpeg FROM client_download_limit WHERE cur_userid='$jpegcur_id' AND temp_id='$jpegcur_tempid'";
	$client_result = mysql_query($client_sql);
	$client_limit = mysql_fetch_array($client_result);

	//echo $admin_limit['jpeg_limit']."/".$client_limit['jpeg'];

	if($admin_limit['jpeg_limit'] == 0){
		$sql = "SELECT * FROM client_download_limit WHERE cur_userid='$jpegcur_id' AND temp_id='$jpegcur_tempid'";
		$result = mysql_query($sql);
		$count = mysql_fetch_array($result);
		$num = mysql_num_rows($result);
		if($num == 1){
			$num_count = $count['jpeg']+1;
			$update_Query = "UPDATE client_download_limit SET jpeg='$num_count' WHERE cur_userid='$jpegcur_id' AND temp_id='$jpegcur_tempid'";
			$run_update_Query = mysql_query($update_Query) or die("ERROR: " . $update_Query);
		}else{
			$insert_Query = "INSERT INTO client_download_limit(cur_userid, temp_id, jpeg) values ('$jpegcur_id', '$jpegcur_tempid', '1')";
			$run_Query = mysql_query($insert_Query) or die("ERROR: " . $insert_Query);
		}
		echo "JPEG Image downloaded successfully.";
	}else if((($admin_limit['jpeg_limit'] == $client_limit['jpeg']) && ($admin_limit['jpeg_limit'] != 0))|| (($admin_limit['jpeg_limit'] < $client_limit['jpeg']) && ($admin_limit['jpeg_limit'] != 0))){
		echo "Download Limit Exceeded.";
	} else {
		$sql = "SELECT * FROM client_download_limit WHERE cur_userid='$jpegcur_id' AND temp_id='$jpegcur_tempid'";
		$result = mysql_query($sql);
		$count = mysql_fetch_array($result);
		$num = mysql_num_rows($result);
		if($num == 1){
			$num_count = $count['jpeg']+1;
			$update_Query = "UPDATE client_download_limit SET jpeg='$num_count' WHERE cur_userid='$jpegcur_id' AND temp_id='$jpegcur_tempid'";
			$run_update_Query = mysql_query($update_Query) or die("ERROR: " . $update_Query);
		}else{
			$insert_Query = "INSERT INTO client_download_limit(cur_userid, temp_id, jpeg) values ('$jpegcur_id', '$jpegcur_tempid', '1')";
			$run_Query = mysql_query($insert_Query) or die("ERROR: " . $insert_Query);
		}
		echo "JPEG Image downloaded successfully.";
	}
?>
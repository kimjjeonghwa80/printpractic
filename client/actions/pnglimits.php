<?php
	require("../library/config.php");

	$pngcur_id = $_POST['pngcurrentuserid'];
	$pngcur_tempid = $_POST['pngtempid'];

	$admin_sql = "SELECT png_limit FROM download_imit";
	$admin_result = mysql_query($admin_sql);
	$admin_limit = mysql_fetch_array($admin_result);

	$client_sql = "SELECT png FROM client_download_limit WHERE cur_userid='$pngcur_id' AND temp_id='$pngcur_tempid'";
	$client_result = mysql_query($client_sql);
	$client_limit = mysql_fetch_array($client_result);

	//echo $admin_limit['png_limit']."/".$client_limit['png'];

	if($admin_limit['png_limit'] == 0){
		$sql = "SELECT * FROM client_download_limit WHERE cur_userid='$pngcur_id' AND temp_id='$pngcur_tempid'";
		$result = mysql_query($sql);
		$count = mysql_fetch_array($result);
		$num = mysql_num_rows($result);
		if($num == 1){
			$num_count = $count['png']+1;
			$update_Query = "UPDATE client_download_limit SET png='$num_count' WHERE cur_userid='$pngcur_id' AND temp_id='$pngcur_tempid'";
			$run_update_Query = mysql_query($update_Query) or die("ERROR: " . $update_Query);
		}else{
			$insert_Query = "INSERT INTO client_download_limit(cur_userid, temp_id, png) values ('$pngcur_id', '$pngcur_tempid', '1')";
			$run_Query = mysql_query($insert_Query) or die("ERROR: " . $insert_Query);
		}
		echo "PNG Image downloaded successfully.";
	}else if((($admin_limit['png_limit'] == $client_limit['png']) && ($admin_limit['png_limit'] != 0)) || (($admin_limit['png_limit'] < $client_limit['png']) && ($admin_limit['png_limit'] != 0))){
		echo "Download Limit Exceeded.";
	} else {
		$sql = "SELECT * FROM client_download_limit WHERE cur_userid='$pngcur_id' AND temp_id='$pngcur_tempid'";
		$result = mysql_query($sql);
		$count = mysql_fetch_array($result);
		$num = mysql_num_rows($result);
		if($num == 1){
			$num_count = $count['png']+1;
			$update_Query = "UPDATE client_download_limit SET png='$num_count' WHERE cur_userid='$pngcur_id' AND temp_id='$pngcur_tempid'";
			$run_update_Query = mysql_query($update_Query) or die("ERROR: " . $update_Query);
		}else{
			$insert_Query = "INSERT INTO client_download_limit(cur_userid, temp_id, png) values ('$pngcur_id', '$pngcur_tempid', '1')";
			$run_Query = mysql_query($insert_Query) or die("ERROR: " . $insert_Query);
		}
		echo "PNG Image downloaded successfully.";
	}
?>
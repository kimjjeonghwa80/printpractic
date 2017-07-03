<?php
	require("library/config.php");

	ini_set('upload_max_filesize', '10M');
	ini_set('post_max_size', '10M');
	ini_set('max_input_time', 300);
	ini_set('max_execution_time', 300);

	$folderLocation = $_POST['path'];
	if(!file_exists($folderLocation)) {
	   mkdir($folderLocation, 0777, true);
	   chmod($folderLocation, 0777);
	}
	
	if (isset($_POST['jpegimageData'])) {


		$jpegcur_id = $_POST['jpegcurrentuserid'];
		$jpegcur_tempid = $_POST['jpegtempid'];

		$admin_sql = "SELECT jpeg_limit FROM download_imit";
		$admin_result = mysql_query($admin_sql);
		$admin_limit = mysql_fetch_array($admin_result);

		$client_sql = "SELECT jpeg FROM client_download_limit WHERE cur_userid='$jpegcur_id' AND temp_id='$jpegcur_tempid'";
		$client_result = mysql_query($client_sql);
		$client_limit = mysql_fetch_array($client_result);

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
				$encoded = $_POST['jpegimageData'];
				$decoded = "";
				for ($i=0; $i < ceil(strlen($encoded)/256); $i++) {
				  $decoded = $decoded . base64_decode(substr($encoded,$i*256,256));
				}
				$contents = $decoded; // output
				
				file_put_contents($folderLocation."/".$_POST['filename'].".jpeg", $contents);
				echo $folderLocation."/".$_POST['filename'].".jpeg";
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
				$encoded = $_POST['jpegimageData'];
				$decoded = "";
				for ($i=0; $i < ceil(strlen($encoded)/256); $i++) {
				  $decoded = $decoded . base64_decode(substr($encoded,$i*256,256));
				}
				$contents = $decoded; // output
				
				file_put_contents($folderLocation."/".$_POST['filename'].".jpeg", $contents);
				echo $folderLocation."/".$_POST['filename'].".jpeg";
		}
	}

	
	if (isset($_POST['pngimageData'])) {

		$pngcur_id = $_POST['pngcurrentuserid'];
		$pngcur_tempid = $_POST['pngtempid'];

		$admin_sql = "SELECT png_limit FROM download_imit";
		$admin_result = mysql_query($admin_sql);
		$admin_limit = mysql_fetch_array($admin_result);

		$client_sql = "SELECT png FROM client_download_limit WHERE cur_userid='$pngcur_id' AND temp_id='$pngcur_tempid'";
		$client_result = mysql_query($client_sql);
		$client_limit = mysql_fetch_array($client_result);

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

				$encoded = $_POST['pngimageData'];
				$decoded = "";
				for ($i=0; $i < ceil(strlen($encoded)/256); $i++) {
				  $decoded = $decoded . base64_decode(substr($encoded,$i*256,256));
				}
				$contents = $decoded;			
				file_put_contents($folderLocation."/".$_POST['filename'].".png", $contents);
				echo $folderLocation."/".$_POST['filename'].".png";
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
				$encoded = $_POST['pngimageData'];
				$decoded = "";
				for ($i=0; $i < ceil(strlen($encoded)/256); $i++) {
				  $decoded = $decoded . base64_decode(substr($encoded,$i*256,256));
				}
				$contents = $decoded;				
				file_put_contents($folderLocation."/".$_POST['filename'].".png", $contents);
				echo $folderLocation."/".$_POST['filename'].".png";
		}		
	}


	if (isset($_POST['jsonData'])) {

		file_put_contents($folderLocation."/".$_POST['filename'].".pt", $_POST['jsonData']);

		echo $folderLocation."/".$_POST['filename'].".pt";
	}
?>
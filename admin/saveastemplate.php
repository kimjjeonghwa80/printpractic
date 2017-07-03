<?php

	header( 'Content-Type: text/html; charset=utf-8' );

	require("library/config.php");

	// if($_POST['isadmin'] == true) {

		ini_set('max_execution_time', 24000);

		ini_set('upload_max_filesize', 12000);

		ini_set('post_max_size', 24000);

		$folderLocation = $_POST['path'];

		if(!file_exists($folderLocation)) {

		   mkdir($folderLocation, 0777, true);

		   chmod($folderLocation, 0777);
		}

		$insert_Qry = "INSERT INTO template (template_name, canvas_thumbnail, canvas_json, shopify_product_id, etsy_listing_id, cat_id, created_date, modified_date) VALUES ('".$_POST['filename']."', '', '', '', '', '".$_POST['category']."', now(), now())";

		$runQry = mysql_query($insert_Qry);

	 	$last_template_id = mysql_insert_id();

		$img = $_POST['pngimageData']; // Your data 'data:image/png;base64,AAAFBfj42Pj4';

		$img = str_replace('data:image/png;base64,', '', $img);

		$img = str_replace(' ', '+', $img);

		$data = base64_decode($img);

		file_put_contents($folderLocation."/" .$last_template_id.".png", $data);

		if (isset($_POST['jsonData'])) {

			//$jsonunicode = jsonRemoveUnicodeSequences($_POST['jsonData']);
			file_put_contents($folderLocation."/".$last_template_id.".pt", $_POST['jsonData']);

		}

		$update_Qry = "UPDATE template set canvas_thumbnail = 'admin/templates/". $last_template_id . ".png', canvas_json = 'admin/templates/". $last_template_id . ".pt' WHERE template_id = " . $last_template_id;

		$runQry = mysql_query($update_Qry);

		/*function jsonRemoveUnicodeSequences($struct) {
		   return preg_replace("/\\\\u([a-f0-9]{4})/e", "iconv('UCS-4LE','UTF-8',pack('V', hexdec('U$1')))", json_encode($struct));
		}*/
		echo $last_template_id;

/*	} 

	if($_POST['isclient'] == true) {

		$folderLocation = "../client/".$_POST['path'];

		if(!file_exists($folderLocation)) {

			mkdir($folderLocation, 0777, true);

			chmod($folderLocation, 0777);
		}

		$insert_Qry = "INSERT INTO user_templates (userid, template_name, canvas_thumbnail, canvas_json, created_date, modified_date, cat_id) VALUES ('0', '".$_POST['filename']."', '', '', now(), now(), '".$_POST['chkdatcatid']."')";

		$runQry = mysql_query($insert_Qry);

		$last_template_id = mysql_insert_id();

		$img = $_POST['pngimageData']; // Your data 'data:image/png;base64,AAAFBfj42Pj4';

		$img = str_replace('data:image/png;base64,', '', $img);

		$img = str_replace(' ', '+', $img);

		$data = base64_decode($img);

		file_put_contents($folderLocation."/" .$last_template_id.".png", $data);

		if (isset($_POST['jsonData'])) {

			//$jsonunicode = jsonRemoveUnicodeSequences($_POST['jsonData']);
			file_put_contents($folderLocation."/".$last_template_id.".pt", $_POST['jsonData']);

		}

		$update_Qry = "UPDATE user_templates set canvas_thumbnail = 'templates/". $last_template_id . ".png', canvas_json = 'templates/". $last_template_id . ".pt' WHERE template_id = " . $last_template_id;
		
		$runQry = mysql_query($update_Qry);

		echo $last_template_id;

	} 
*/
?>
<?php

	header( 'Content-Type: text/html; charset=utf-8' );

	include "library/config.php";

	ini_set('upload_max_filesize', '10M');
	ini_set('post_max_size', '10M');
	ini_set('max_input_time', 1300);
	ini_set('max_execution_time', 1300);

	$folderLocation = $_POST['path'];

	if(!file_exists($folderLocation)) {

	   mkdir($folderLocation, 0777, true);

	   chmod($folderLocation, 0777);
	}

	$templateid = $_POST['templateid'];

	$img = $_POST['pngimageData'];
	$img = str_replace('data:image/png;base64,', '', $img);
	$img = str_replace(' ', '+', $img);
	$data = base64_decode($img);
	file_put_contents($folderLocation."/" .$templateid.".png", $data);

	if (isset($_POST['jsonData'])) {
		//$jsonunicode = jsonRemoveUnicodeSequences($_POST['jsonData']);
		file_put_contents($folderLocation."/".$templateid.".ype", $_POST['jsonData']);
	}

	$update_Qry = "UPDATE user_templates set canvas_thumbnail = 'templates/". $templateid . ".png', canvas_json = 'templates/". $templateid . ".ype', modified_date = NOW() WHERE template_id = " . $templateid;
	$runQry = mysql_query($update_Qry);

	echo $templateid;

	/*function jsonRemoveUnicodeSequences($struct) {
	   return preg_replace("/\\\\u([a-f0-9]{4})/e", "iconv('UCS-4LE','UTF-8',pack('V', hexdec('U$1')))", json_encode($struct));
	}*/
?>
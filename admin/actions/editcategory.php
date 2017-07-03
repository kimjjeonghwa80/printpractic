<?php
	require("../library/config.php");
	if(isset($_POST["res_id"]) && $_POST["res_id"] != '') {
		$tempquery = "SELECT * FROM `template_categories` where tempcat_id = '". $_POST["res_id"]."'";
		$tempquery_res = mysql_query($tempquery);
		$rowcount = mysql_num_rows($tempquery_res);
		if ($rowcount > 0){
			while ($site = mysql_fetch_array($tempquery_res)){
			echo $site['tempcat_name']."+".$site['tempcat_id'];
			}
		}
	}
	if(isset($_POST["c_id"]) && $_POST["c_id"] != '') {
		$name = $_POST['c_name'];
		$UpdateItem = "Update template_categories set tempcat_name =  '$name' where tempcat_id = '". $_POST["c_id"]."'";
		$run_Query = mysql_query($UpdateItem) or die("ERROR: " . $UpdateItem);
		if($run_Query){
			echo "Category Name Updated.";
		}
	}
?>
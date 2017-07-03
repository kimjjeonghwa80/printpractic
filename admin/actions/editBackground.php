<?php
	require("../library/config.php");
	if(isset($_POST["res_Bid"]) && $_POST["res_Bid"] != '') {
		$tempquery = "SELECT * FROM `bg_categories` where bgcat_id = '". $_POST["res_Bid"]."'";
		$tempquery_res = mysql_query($tempquery);
		$rowcount = mysql_num_rows($tempquery_res);
		if ($rowcount > 0){
			while ($site = mysql_fetch_array($tempquery_res)){
			echo $site['bgcat_name']."+".$site['bgcat_id'];
			}
		}
	}
	if(isset($_POST["c_id"]) && $_POST["c_id"] != '') {
		$name = $_POST['c_name'];
		$UpdateItem = "Update bg_categories set bgcat_name =  '$name' where bgcat_id = '". $_POST["c_id"]."'";
		$run_Query = mysql_query($UpdateItem) or die("ERROR: " . $UpdateItem);
		if($run_Query){
			echo "Category Name Updated.";
		}
	}
?>
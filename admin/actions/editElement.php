<?php
	require("../library/config.php");
	if(isset($_POST["res_Eid"]) && $_POST["res_Eid"] != '') {
		$tempquery = "SELECT * FROM `element_categories` where category_id = '". $_POST["res_Eid"]."'";
		$tempquery_res = mysql_query($tempquery);
		$rowcount = mysql_num_rows($tempquery_res);
		if ($rowcount > 0){
			while ($site = mysql_fetch_array($tempquery_res)){
			echo $site['category']."+".$site['category_id'];
			}
		}
	}
	if(isset($_POST["c_id"]) && $_POST["c_id"] != '') {
		$name = $_POST['c_name'];
		$UpdateItem = "Update element_categories set category =  '$name' where category_id = '". $_POST["c_id"]."'";
		$run_Query = mysql_query($UpdateItem) or die("ERROR: " . $UpdateItem);
		if($run_Query){
			echo "Category Name Updated.";
		}
	}
?>
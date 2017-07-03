<?php
	require("../library/config.php");
	if(isset($_POST["cat_id"]) && $_POST["cat_id"] != '') {
		$tempquery = "SELECT * FROM `text_categories` where textcat_id = '". $_POST["cat_id"]."'";
		$tempquery_res = mysql_query($tempquery);
		$rowcount = mysql_num_rows($tempquery_res);
		if ($rowcount > 0){
			while ($site = mysql_fetch_array($tempquery_res)){
			echo $site['textcat_name']."+".$site['textcat_id'];
			}
		}
	}
	if(isset($_POST["c_id"]) && $_POST["c_id"] != '') {
		$name = $_POST['c_name'];
		$UpdateItem = "Update text_categories set textcat_name =  '$name' where textcat_id = '". $_POST["c_id"]."'";
		$run_Query = mysql_query($UpdateItem) or die("ERROR: " . $UpdateItem);
		if($run_Query){
			echo "Category Name Updated.";
		}
	}
?>
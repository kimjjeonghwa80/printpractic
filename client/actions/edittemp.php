<?php
	require("../library/config.php");
	if(isset($_POST["tem_id"]) && $_POST["tem_id"] != '') {
		$tempquery = "SELECT * FROM `user_templates` where template_id = '". $_POST["tem_id"]."'";
		$tempquery_res = mysql_query($tempquery);
		$rowcount = mysql_num_rows($tempquery_res);
		if ($rowcount > 0){
			while ($site = mysql_fetch_array($tempquery_res)){
			echo $site['template_name'];
			}
		}
	}
	if(isset($_POST["e_id"]) && $_POST["e_id"] != '') {
		$name = $_POST['e_name'];
		$UpdateItem = "Update user_templates set template_name =  '$name' where template_id = '". $_POST["e_id"]."'";
		$run_Query = mysql_query($UpdateItem) or die("ERROR: " . $UpdateItem);
		if($run_Query){
			echo "Template name Updated.";
		}
	}
?>
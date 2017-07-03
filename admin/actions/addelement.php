<?php
	include("../library/config.php");
		$rescategory = $_POST["elementCategoty"];
		$reselementName = $_POST["elementName"];
		$reselement = $_POST["element"];
		$elename = str_replace("C:\\fakepath\\", "", $reselement);
		
			$insert_Query = "INSERT INTO adminelements(cat_id,element_name,element_path,element_json) values ('$rescategory','$reselementName','$elename','')";
			//$insert_Query = "INSERT INTO element(cat_id,element_name,element_path,element_json,userid) values ('$rescategory','$reselementName','$elename','','1')";
			$run_Query = mysql_query($insert_Query) or die("ERROR: " . $insert_Query);
		if($run_Query)
		{
		echo "New Element Added Successfully.";
		}
		
?>
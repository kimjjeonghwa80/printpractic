<?php
	include("../library/config.php");
	$resuser_id = $_POST["elementuser_id"];
	$reselementName = $_POST["elementName"];
	$reselement = $_POST["element"];
	$elename = str_replace("C:\\fakepath\\", "", $reselement);

	$insert_Query = "INSERT INTO element (element_name, element_path, element_json, userid) values ('$reselementName', '$elename', '', '$resuser_id')";
	$run_Query = mysql_query($insert_Query) or die("ERROR: " . $insert_Query);
	if($run_Query)
	{
		echo "New Element Added Successfully.";
	}		
?>
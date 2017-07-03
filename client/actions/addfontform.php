<?php
	include("../library/config.php");

	$resfontname = $_POST["fontname"];
	$resaddimage =  "fontfile/".$_POST["addimage"];
	$resCheckboxes =$_POST["Checkboxes"];
	
	$insert_Query = "INSERT INTO font_file(id, ff_name, ff_path, ff_access) values ('', '$resfontname', '$resaddimage', '$resCheckboxes')";
	$run_Query = mysql_query($insert_Query) or die("ERROR: " . $insert_Query);
	if($run_Query)
	{
		echo "New Font Added Successfully.";
	}
		
?>

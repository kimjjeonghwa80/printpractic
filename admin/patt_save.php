<?php
	include("library/config.php");

		$respattername = "uploads/".$_POST["pat_fileName"];
		
		$insert_Query = "INSERT INTO pattern (pattern_path) values ('$respattername')";
		$run_Query = mysql_query($insert_Query) or die("ERROR: " . $insert_Query);
		if($run_Query)
		{
			echo "New Pattern Added Successfully.";
		}
?>
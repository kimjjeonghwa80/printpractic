<?php
	include("../library/config.php");
		$resbgid = $_POST["new_bgid"];
		$resbgName = $_POST["bgName"];
		$resbg = $_POST["background"];
		$bgname = str_replace("C:\\fakepath\\", "", $resbg);
		
			$insert_Query = "INSERT INTO user_background(bg_name, bg_path, userid) values ('$resbgName', '$bgname', '$resbgid')";
			echo $insert_Query;
			$run_Query = mysql_query($insert_Query) or die("ERROR: " . $insert_Query);
		if($run_Query)
		{
		echo "New Background Added Successfully.";
		}
		
?>
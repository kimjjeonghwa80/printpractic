<?php
	require("../library/config.php");

	if (isset($_POST['bgid']) && $_POST['bgid'] != '')
	{
		$delete_Query = "DELETE FROM user_background WHERE id = ".$_POST['bgid']."";
		$run_Query = mysql_query($delete_Query) or die("ERROR: " . $delete_Query);
		if ($run_Query)
		{
			echo "Background(s) Deleted Successfully.";
		}
	}

?>

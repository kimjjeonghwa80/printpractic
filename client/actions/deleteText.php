<?php
	require("../library/config.php");

	if (isset($_POST['textid']) && $_POST['textid'] != '')
	{
		$delete_Query = "DELETE FROM texts WHERE text_id = ".$_POST['textid']."";
		$run_Query = mysql_query($delete_Query) or die("ERROR: " . $delete_Query);
		if ($run_Query)
		{
			echo "Text(s) Deleted Successfully.";
		}
	}

?>

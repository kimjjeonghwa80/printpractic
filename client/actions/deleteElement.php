<?php
	require("../library/config.php");

	if (isset($_POST['elementid']) && $_POST['elementid'] != '')
	{

		$delete_Query = "DELETE FROM element WHERE id = ".$_POST['elementid']."";
		$run_Query = mysql_query($delete_Query) or die("ERROR: " . $delete_Query);
		if ($run_Query)
		{
			echo "Element(s) Deleted Successfully.";
		}
	}

?>

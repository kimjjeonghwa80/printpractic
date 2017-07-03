<?php
	require("../library/config.php");

	if (isset($_POST['userimg_id']) && $_POST['userimg_id'] != '')
	{
		$delete_Query = "DELETE FROM useruploads WHERE id = ".$_POST['userimg_id']."";
		$run_Query = mysql_query($delete_Query) or die("ERROR: " . $delete_Query);
		if ($run_Query)
		{
			echo "Image(s) Deleted Successfully.";
		}
	}

?>

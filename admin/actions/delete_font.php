<?php
	include ("../library/config.php");
	if(isset($_POST["loc_id"]) && $_POST["loc_id"] != '') {
		$loc_id =$_POST["loc_id"];
		$delete_Ele = "DELETE FROM font_file WHERE id = $loc_id";
		$run_Qy = mysql_query($delete_Ele) or die("ERROR: " . $delete_Ele);
			if($run_Qy)
			{
				echo "Deleted font Successfully.";
			}

	}  else {

			echo "Font is not Deleted.";
	}
?>
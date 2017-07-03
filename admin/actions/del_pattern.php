<?php
	include ("../library/config.php");
	if (isset($_POST['res_id']) && $_POST['res_id'] != '')
	{	
		$selected_pat = $_POST["res_id"];
		$sel_Query = mysql_query("SELECT pattern_path FROM pattern WHERE id = $selected_pat");
		
		if (mysql_num_rows($sel_Query) > 0)
		{
			while ($result = mysql_fetch_array($sel_Query))
			{
				$m_img_path =  $result['pattern_path'];
				unlink($m_img_path);
			}
		}
		
		$delete_Ele = "DELETE FROM pattern WHERE id = $selected_pat";
		$run_EleQuery = mysql_query($delete_Ele) or die("ERROR: " . $delete_Ele);
		if ($run_EleQuery)
		{
			echo "Pattern Deleted Successfully.";
		}		
	}
?>
<?php 
	include "library/config.php";

	$sel_Qry = "select canvas_json from user_templates where template_id = " . $_GET['id'];
	$runQry = mysql_query($sel_Qry);

  	while($row = mysql_fetch_array($runQry))
	{
		$json = file_get_contents($row['canvas_json']);
		echo $json;
	}
?>
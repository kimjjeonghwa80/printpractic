<?php 
	include "library/config.php";

	$sel_Qry = "select canvas_json from template where shopify_product_id = " . $_GET['id'];
	$runQry = mysql_query($sel_Qry);

  	while($row = mysql_fetch_array($runQry))
	{
		$templatespath = "../".$row['canvas_json'];
		$json = file_get_contents($templatespath);
		echo $json;
	}
?>
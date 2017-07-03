<?php 
	include "../library/config.php";
	$sel_id = "select cat_id from template where shopify_product_id = " . $_GET['id'];
	$runid = mysql_query($sel_id);
  	$row_id = mysql_fetch_array($runid);
	$sel_Qry = "select * from template_categories where tempcat_id = " . $row_id['cat_id'];
	$runQry = mysql_query($sel_Qry);
  	$row = mysql_fetch_array($runQry);
	echo  $row['tempcat_name']."+".$row['tempcat_id'];
?>
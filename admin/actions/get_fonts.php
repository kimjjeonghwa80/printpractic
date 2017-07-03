<?php
	include("../library/config.php");
	$query = "SELECT * FROM font_file";
	$runQuery = mysql_query($query);
	if(mysql_num_rows($runQuery) > 0)
	{
	  	while($row = mysql_fetch_array($runQuery))
		{
			echo "<li><a href='javascript:void(0);''><font face='".$row['ff_name']."' size='4'>".$row['ff_name']."</font></a></li>";			
	  	}
	} 
?>
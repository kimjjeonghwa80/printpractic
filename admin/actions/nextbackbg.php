<?php
	include("../library/config.php");

	$query = "SELECT geoimages FROM geofilter";

	$runQuery = mysql_query($query);

	if(mysql_num_rows($runQuery) > 0)

	{
		$row = mysql_fetch_array($runQuery);	

		$buffer = explode(',', $row['geoimages']);

        foreach($buffer as $buffers) {

		    $categories =  $buffers . "\n";

			$select_Query = "SELECT bg_path FROM background WHERE id IN (".$categories.")";

			$run_Query = mysql_query($select_Query) or die("ERROR: " . $select_Query);

			if(mysql_num_rows($run_Query) > 0)

			{

			  	while($row1 = mysql_fetch_array($run_Query))

				{

					echo $row1['bg_path'].",";	

			  	}

			}


		}	

	} 

?>
<?php

require("../library/config.php");

$geo_filter = $_POST['bgGeoid'];

if (isset($geo_filter) && $geo_filter != ''){

	$rows = mysql_result(mysql_query('SELECT COUNT(*) FROM geofilter'), 0);

	if (!$rows) { 

		$insert_Query = "INSERT INTO geofilter (geoimages) VALUES ('$geo_filter')";

		$run_Query = mysql_query($insert_Query) or die("ERROR: " . $insert_Query);

		if ($run_Query) {

			echo "Added Geofilters Background Images.";

		}

	} else {

	    $insert_Query = "UPDATE geofilter SET geoimages='$geo_filter'";

	    $run_Query = mysql_query($insert_Query) or die("ERROR: " . $insert_Query);

	    if($run_Query) {

	        echo "Updated Geofilters Background Images.";
	    }

	}
	
}

?>
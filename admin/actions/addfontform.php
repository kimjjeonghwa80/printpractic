<?php
	include("../library/config.php");

	$resaddim = preg_replace('/\\.[^.\\s]{3,4}$/', '', $_POST["addimage"]);
	$new_resaddim = str_replace(" ","_",$resaddim);
	$ffilename = str_replace("-Regular","",$new_resaddim);
	$new_addimage = str_replace(" ","",$_POST["addimage"]);
	$ext = pathinfo($new_addimage, PATHINFO_EXTENSION);
	$regu = "-Regular";
	if( strpos( $new_addimage, $regu) !== false ) {		
	    $filename = $new_addimage;
	} else {
	    $filename = str_replace('.'.$ext, '', $new_addimage).'-Regular'.'.'.$ext;
	}
	$resaddimage =  "./tcpdf/fonts/googlefonts/".$ffilename."/".$filename;
	$insert_Query = "INSERT INTO font_file(ff_name, ff_path) values ('$ffilename', '$resaddimage')";
	$run_Query = mysql_query($insert_Query) or die("ERROR: " . $insert_Query);
	if($run_Query)
	{
		echo "New Font Added. Refresh the page to load the new font.";
	}
		
?>
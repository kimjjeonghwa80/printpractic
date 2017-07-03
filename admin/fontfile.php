<?php // You need to add server side validation and better error handling here

$data = array();

if(isset($_GET['files']))
{	
	$error = false;
	$files = array();

		$tcpdf = './tcpdf/';
		if (!is_dir($tcpdf))
		{
			mkdir($tcpdf, 0777);
		}

		$fonts = $tcpdf.'fonts/';
		if (!is_dir($fonts))
		{
			mkdir($fonts, 0777);
		}

		$googlefonts = $fonts.'googlefonts/';
		if (!is_dir($googlefonts))
		{
			mkdir($googlefonts, 0777);
		}

		$old_filename = pathinfo($_FILES['element_file']['name'], PATHINFO_FILENAME);

		$new_filename = str_replace(" ","_",$old_filename);

		$res_filename = $new_filename;


		$regul = "-Regular";

		if( strpos($new_filename, $regul) !== false ) {

		    $ffilename = str_replace("-Regular","",$res_filename);

		} else {

		    $ffilename = $res_filename;
		}

		$prof_path = $googlefonts . $ffilename ."/";
		
		if (!is_dir($prof_path))
		{
			mkdir($prof_path, 0777);
		}

	foreach($_FILES as $file)
	{

		$old_name = basename($file['name']);

		$new_name = str_replace(" ","",$old_name);

		$res_name = $new_name;

		$regu = "-Regular";

		$ext = pathinfo($res_name, PATHINFO_EXTENSION);

		if( strpos($new_name, $regu) !== false ) {

		    $filename = $res_name;

		} else {

		    $filename = str_replace('.'.$ext, '', $res_name).'-Regular'.'.'.$ext;
		}

		if(move_uploaded_file($file['tmp_name'], $prof_path .$filename))
		{
			$files[] = $prof_path .$filename;
		}
		else
		{
		    $error = true;
		}
	}
	$data = ($error) ? array('error' => 'There was an error uploading your files') : array('files' => $files);
	echo "Uploaded Successfullly.";
}
else
{
	$data = array('success' => 'Form was submitted', 'formData' => $_POST);
	echo "Uploaded not Successfullly.";

}
?>
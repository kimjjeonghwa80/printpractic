<?php // You need to add server side validation and better error handling here

$data = array();

if(isset($_GET['files']))
{	
	$error = false;
	$files = array();
	
		$prof_path="./fontfile/";
		if (!is_dir($prof_path))
		{
			mkdir($prof_path, 0777);
		}

		//$uploaddir = './fontfile/'.$_SESSION['loginid'].'/';
	foreach($_FILES as $file)
	{
		if(move_uploaded_file($file['tmp_name'], $prof_path .basename($file['name'])))
		{
			$files[] = $prof_path .$file['name'];
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
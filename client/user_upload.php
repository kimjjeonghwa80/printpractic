<?php // You need to add server side validation and better error handling here
	require("lock.php");
	require("library/config.php");
	$imguser = "";
	if(isset($login_session) && $login_session != '') {
		$sql="SELECT * FROM customers WHERE user_login='".$login_session."'";
		$runQry = mysql_query($sql);
		$row = mysql_fetch_array($runQry);
		$imguser = $row['id'];
	}		
$data = array();

if(isset($_GET['files']))
{	
	$error = false;
	$files = array();
	
		$prof_path="userimage/".$imguser.'/';
		if (!is_dir($prof_path))
		{
			mkdir($prof_path, 0777);
		}
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
}
else
{
	$data = array('success' => 'Form was submitted', 'formData' => $_POST);
}
?>
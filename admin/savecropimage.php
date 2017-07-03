<?php
	//file to save the cropped images.
	
	if(isset($_FILES['file']) and !$_FILES['file']['error']){

		$folderLocation = $_SERVER['DOCUMENT_ROOT'] . "/uploads/croppedimages/";
		if(!file_exists($folderLocation)) {
		   mkdir($folderLocation, 0777, true);
		   chmod($folderLocation, 0777);
		}
	    
	    move_uploaded_file($_FILES['file']['tmp_name'], $folderLocation . $_POST['filename']);
	    echo "/uploads/croppedimages/" . $_POST['filename'];
	}
?>
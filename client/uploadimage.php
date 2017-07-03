<?php
    if (!isset($_SESSION)) {
       session_start();
    }
	require("lock.php");
	require("library/config.php");

	$fn = (isset($_SERVER['HTTP_X_FILENAME']) ? $_SERVER['HTTP_X_FILENAME'] : false);

	if ($fn) {

		// AJAX call
		file_put_contents(
			'uploads/' . $fn,
			file_get_contents('php://input')
		);

		$insert_image = "INSERT INTO useruploads(userid, imgpath) VALUES('".$userid."', 'uploads/". $fn . "')";
		$run_Query = mysql_query($insert_image) or die("ERROR: " . $insert_image);

		if($run_Query)
		{
		echo "Upload image is Added Successfully.";
		}
		exit();

	}
	else {

		// form submit
		$files = $_FILES['fileselect'];

		foreach ($files['error'] as $id => $err) {
			if ($err == UPLOAD_ERR_OK) {
				$fn = $files['name'][$id];
				move_uploaded_file(
					$files['tmp_name'][$id],
					'uploads/' . $fn
				);
				echo "<p>File $fn uploaded.</p>";
			}
		}
	}
?>
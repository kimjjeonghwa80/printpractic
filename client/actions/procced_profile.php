<?php
	include("../library/config.php");

	if(isset($_POST["user_id"]) && $_POST["user_id"] != '') {
		$res_id =$_POST["user_id"];
		$res_fname =$_POST["first_name"];
		$res_lname =$_POST["last_name"];
		$res_path ='userimage/'.$res_id.'/'.$_POST["userimg_path"];
		
		$insert_Query = "Update customers set first_name ='$res_fname', last_name ='$res_lname', img_path ='$res_path' where id = '$res_id'";
		$run_Query = mysql_query($insert_Query) or die("ERROR: " . $insert_Query);
			if($run_Query)
			{
				echo "Updated Profile Successfully.";
			}

	}  else {
			echo "Not Updated Profile.";
	}
?>
<?php

	session_start();

	$userid=$_SESSION['userid'];

	require("library/config.php");

	$limit = $_GET['limit'];
	$last_temp_id = $_GET['offset'];
	$query = "";
	if(isset($_GET['catid']) && $_GET['catid'] != '') {
		$query = "SELECT * FROM user_templates WHERE template_id AND cat_id = ".$_GET['catid']." AND template_id > $last_temp_id ORDER BY template_id ASC LIMIT $limit";
	} else {
		//$query = "SELECT * FROM user_templates WHERE template_id = template_id > $last_temp_id AND userid = $userid ORDER BY template_id ASC LIMIT $limit";
		$query = "SELECT * FROM user_templates WHERE template_id > $last_temp_id AND userid = $userid AND userid > 0";
	}
	$runQuery1 = mysql_query($query);
	if(mysql_num_rows($runQuery1) > 0)
	{
	  	while($row = mysql_fetch_array($runQuery1))
		{
?>
	   <div class="col-lg-6 col-md-8 col-xs-12 thumb" id="<?php echo $row['template_id']; ?>" style="padding:2px;">

		  <a class="thumbnail" title="<?php echo $row['template_name']; ?>" href='javascript:loadTemplate(<?php echo $row["template_id"]; ?>);' style="margin-bottom: 0px;">
			<?php
				//read the file get content
				$templatespath = $row['canvas_json'];	
				$json = file_get_contents($templatespath);
				$json_array = json_decode($json, true);
				$json = $json_array[0];
				$json_array = json_decode($json, true);
				$width = $json_array['width'] / 96;
				$height = $json_array['height'] / 96;
				//display size
				echo "<span class='badge' style='font-size:10px; position: absolute; bottom: 10px; right: 10px; background-color:#fff; color:#777;'>$width x $height</span>";
			?>		  	

			<?php
				if(isset($_GET['refresh']) && $_GET['refresh'] == true && $row['template_id'] == $_GET['tempid']) {
			?>
				<img class="tempImage img-responsive" src="<?php echo $row['canvas_thumbnail'].'?'.rand(); ?>" alt="" style="">
			<?php
				} else {
			?>
				<img class="tempImage img-responsive" src="<?php echo $row['canvas_thumbnail']; ?>" alt="" style="">
			<?php
				}
			?>

			<span class="thumb-overlay">
				<h3><?php echo $row['template_name']; ?></h3>
			</span>
		  </a><i class="fa fa-trash-o deleteTemp" id="<?php echo $row['template_id']; ?>"></i>
		  <a href="#" onclick="myFunction(<?php echo $row['template_id']; ?>);" class="template-edit"  style="margin-left:10px;">
			<i class="fa fa-pencil-square-o" style="font-size: 18px;"></i>
		  </a> 

	   </div>

<?php

	  }

	}

?>


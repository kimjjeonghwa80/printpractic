<?php
	require("lock.php");

	$query = "SELECT * FROM adminelements";
	$runQuery = mysql_query($query);
	if(mysql_num_rows($runQuery) > 0)
	{
	  while($row = mysql_fetch_array($runQuery))
		{

			$elename = str_replace("C:\\fakepath\\", "",$row['element_path']);
?>
<?php if($row['element_json'] != '') { ?>
	   <div class="col-lg-6 col-md-8 col-xs-12 thumb" id="<?php echo $row['id']; ?>" style="padding:5px;">
		  <a class="thumbnail" href="javascript:loadElement(<?php echo $row["id"]; ?>);" style="margin-bottom: 0;">
			<img class="img-responsive" data-imgsrc="../admin/<?php echo $elename; ?>" src="../admin/<?php echo $elename; ?>" alt="" style="height:125px; width:200px; ">
		  </a>
	   </div>

<?php } else { ?>
	   <div class="col-lg-6 col-md-8 col-xs-12 thumb" id="<?php echo $row['id']; ?>" style="padding:5px;">
		  <a class="thumbnail" href="#" style="margin-bottom: 0;">
			<img class="catImage img-responsive" data-imgsrc="../admin/<?php echo $elename; ?>" src="../admin/<?php echo $elename; ?>" alt="" style="height:125px; width:200px; ">
		  </a>
	   </div>
<?php } ?>

<?php
	  }
	} 

	$client_query = "SELECT * FROM element where userid = ".$userid."";
	$client_runQuery = mysql_query($client_query);
	if(mysql_num_rows($client_runQuery) > 0)
	{
	  while($client_row = mysql_fetch_array($client_runQuery))
		{

			$client_elename = str_replace("C:\\fakepath\\", "",$client_row['element_path']);
?>
<?php if($row['element_json'] != '') { ?>
	   <div class="col-lg-6 col-md-8 col-xs-12 thumb" id="<?php echo $client_row['id']; ?>" style="padding:5px;">
		  <a class="thumbnail" href="javascript:loadElement(<?php echo $rclient_ow["id"]; ?>);" style="margin-bottom: 0;">
			<img class="img-responsive" data-imgsrc="<?php echo $client_elename; ?>" src="<?php echo $client_elename; ?>" alt="" style="height:125px; width:200px; ">
		  </a><i class="fa fa-trash-o catimg-checkbox" id="<?php echo $client_row['id']; ?>"></i>
	   </div>

<?php } else { ?>
	   <div class="col-lg-6 col-md-8 col-xs-12 thumb" id="<?php echo $client_row['id']; ?>" style="padding:5px;">
		  <a class="thumbnail" href="#" style="margin-bottom: 0;">
			<img class="catImage img-responsive" data-imgsrc="<?php echo $client_elename; ?>" src="<?php echo $client_elename; ?>" alt="" style="height:125px; width:200px; ">
		  </a><i class="fa fa-trash-o catimg-checkbox" id="<?php echo $client_row['id']; ?>"></i>
	   </div>
<?php } ?>

<?php
	  }
	} 
?>

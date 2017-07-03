 <?php
	require("library/config.php");
	$queryadmin = "SELECT * FROM  adminuploads";
	$runQueryadmin = mysql_query($queryadmin);
	if(mysql_num_rows($runQueryadmin) > 0)
	{
	  	while($rowadmin = mysql_fetch_array($runQueryadmin))
		{
?>
	   <div class="col-lg-1 thumb" id="<?php echo $rowadmin['id']; ?>" style="padding:5px;">
		  <a class="thumbnail" href="javascript:void(0);" style="margin-bottom: 0;">
			<img class="addImage img-responsive" data-imgsrc="../<?php echo $rowadmin['imgpath']; ?>" src="../<?php echo $rowadmin['imgpath']; ?>" alt=""  width="80px">
		  </a>
	   </div>
<?php
	  }

	} 
	
	$query = "SELECT * FROM useruploads";
	$runQuery = mysql_query($query);
	if(mysql_num_rows($runQuery) > 0)
	{
	  	while($row = mysql_fetch_array($runQuery))
		{
?>

	   <div class="col-lg-1 thumb" id="<?php echo $row['id']; ?>" style="padding:5px;">
		  <a class="thumbnail" href="javascript:void(0);" style="margin-bottom: 0;">
			<img class="addImage img-responsive" data-imgsrc="<?php echo $row['imgpath']; ?>" src="<?php echo $row['imgpath']; ?>" alt=""  width="80px">
		  </a>
	   </div>
<?php
	  }

	}
?>
<?php
    if (!isset($_SESSION)) {
       session_start();
       if(isset($_SESSION['userid'])){
           $uid = $_SESSION['userid'];
       } else {
           $uid = "0";
       }
    }
	require("library/config.php");

	$queryadmin = "SELECT * FROM  adminuploads";
	$runQueryadmin = mysql_query($queryadmin);
	if(mysql_num_rows($runQueryadmin) > 0)
	{
	  	while($rowadmin = mysql_fetch_array($runQueryadmin))
		{
?>
	   <div class="col-lg-6 col-md-8 col-xs-12 thumb" id="<?php echo $rowadmin['id']; ?>" style="padding:5px;">
		  <a class="thumbnail" href="javascript:void(0);" style="margin-bottom: 0;">
			<img class="addImage img-responsive" data-imgsrc="../<?php echo $rowadmin['imgpath']; ?>" src="../<?php echo $rowadmin['imgpath']; ?>" alt="" style="height:125px; width:200px; ">
		  </a>
	   </div>

<?php
	  }

	} 
	if($uid=="0"){
		echo "";
	}else{
		$query = "SELECT * FROM useruploads where userid = ".$uid."";
		$runQuery = mysql_query($query);
		if(mysql_num_rows($runQuery) > 0)
		{
		  	while($row = mysql_fetch_array($runQuery))
			{
	?>
		   <div class="col-lg-6 col-md-8 col-xs-12 thumb" id="<?php echo $row['id']; ?>" style="padding:5px;">
			  <a class="thumbnail" href="javascript:void(0);" style="margin-bottom: 0;">
				<img class="addImage img-responsive" data-imgsrc="<?php echo $row['imgpath']; ?>" src="<?php echo $row['imgpath']; ?>" alt="" style="height:125px; width:200px; ">
			  </a><i class="fa fa-trash-o userimage" id="<?php echo $row['id']; ?>"></i>
		   </div>
	<?php
		  }
		}
	}
?>
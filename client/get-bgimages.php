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
	
	$query = "SELECT * FROM background";
	$runQuery = mysql_query($query);
	
	if(mysql_num_rows($runQuery) > 0){
	 	while($row = mysql_fetch_array($runQuery)){ ?>
	   	<div class="col-lg-6 col-md-8 col-xs-12 thumb" id="<?php  echo $row['id']; ?>" style="padding:5px;">
		  <a class="thumbnail" href="#" style="margin-bottom: 0;">
			<img class="bgImage img-responsive" data-imgsrc="../admin/<?php  echo $row['bg_path']; ?>" src="../admin/<?php  echo $row['bg_path']; ?>" alt="" style="height:125px; width:200px; ">
		  </a>
	   </div>
<?php
  		}
 	} 
	if($uid=="0"){
		echo "";
	}else{		
		$client_query = "SELECT * FROM user_background where userid = ".$uid."";
		$client_runQuery = mysql_query($client_query);
		
		if(mysql_num_rows($client_runQuery) > 0){
		 	while($client_row = mysql_fetch_array($client_runQuery)){ ?>
		   	<div class="col-lg-6 col-md-8 col-xs-12 thumb" id="<?php  echo $client_row['id']; ?>" style="padding:5px;">
			  <a class="thumbnail" href="#" style="margin-bottom: 0;">
				<img class="bgImage img-responsive" data-imgsrc="<?php  echo $client_row['bg_path']; ?>" src="<?php  echo $client_row['bg_path']; ?>" alt="" style="height:125px; width:200px; ">
			  </a><i class="fa fa-trash-o bgimg-checkbox" id="<?php echo $client_row['id']; ?>"></i>
		   </div>
	<?php
	  		}
	 	} 
	 }
 ?>
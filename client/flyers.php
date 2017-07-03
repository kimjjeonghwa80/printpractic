<?php
	session_start();

	require('library/config.php');

	include "../wp-load.php";

	global $current_user;
	get_currentuserinfo();

	$userid = $current_user->ID;
	if ($userid == '') {
    	//show nothing to user
        header('Location: http://www.paperdainty.com/signin/');
        exit;    	
	}
	else { 
	    //write code to show menu here
	}

?>
<!DOCTYPE html>
<html class=''>

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>PD Editor</title>
    <meta name="description" content="">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css" integrity="sha512-dTfge/zgoMYpP7QbHy4gWMEGsbsdZeCXz7irItjcC3sPUFtf0kuFbDz/ixG7ArTxmDjLXDmezHubeNikyKGVyQ==" crossorigin="anonymous">
    <link rel="stylesheet" href="css/style.css">
    <link href='http://fonts.googleapis.com/css?family=Audiowide' rel='stylesheet' type='text/css'>
</head>
<style type="text/css">
    .image-upload > input {
        display: none;
    }
	#preview{
	position:absolute;
	border:3px solid #ccc;
	background:#333;
	padding:5px;
	display:none;
	color:#fff;
	box-shadow: 4px 4px 3px rgba(103, 115, 130, 1);
}

</style>

<body style="background-color: white;">
<header class="site-header flyers">
    <div class="container">
        <div class="logo pull-left navbar-header">
			<a href='http://www.paperdainty.com'><img class="navbar-brand" src="images/APP LOGO.png" style="padding:0px;"></a>
        </div>

        <ul class="menu pull-left">
            <!--<li><a href="">Plans</a></li>-->
        </ul>
        
        <ul class="menu pull-right">
            <li class="dropdown">
                <a aria-expanded="false" role="button" data-toggle="dropdown" class="dropdown-toggle" href="#">
                    <?=$current_user->display_name;?>
                    (<?=$current_user->user_email;?>)
                    <span class="caret"></span>
                </a>
                <ul role="menu" class="dropdown-menu">
                    <li><a href="<?php echo get_edit_user_link();?>">Profile</a></li>
                    <li><a href="<?php echo wp_logout_url();?>">Log out</a></li>
                </ul>
            </li>
        </ul>
    </div>
</header>

<div class="container">
        
        <div class="page-header">
            <div class="pull-right">
                <a href="templates.php" class="btn btn-primary btn-lg" style='background-color:#c7e9d9;border-color:#c7e9d9;'>Start a New Design</a>
            </div>
            <h1>My Designs</h1>
        </div>

        <div class="row">
    <div class="col-sm-12">
        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Created</th>
                        <th>Modified</th>
                    </tr>
                </thead>
				 <tbody>
					<?php 
						$query = "SELECT * FROM user_templates where userid = ".$userid;		
						$runQuery = mysql_query($query);
						if(mysql_num_rows($runQuery) > 0)
						{
						while($row = mysql_fetch_array($runQuery))
						{
						$images = str_replace('templates/','' ,$row['canvas_thumbnail']);
					?>
						<tr>
						   <td>
							  <b><?php echo $row['template_name']; ?></b>
							  <span class="actions">
								  <a href="index.php?tempid=<?php echo $row['template_id']; ?>" class="button-flyer-edit" data-url=""> Edit </a>
								  |
							      <a href="http://www.paperdainty.com/client/<?php echo $row['canvas_thumbnail']; ?>" class="preview"> Preview </a>
								  |
								  <a href="download.php?filename=<?php echo $images; ?>" class="button-flyer-download" target="_blank">	Download </a>							  
								  |
								  <a href="http://www.paperdainty.com/client/flyer.php?flyerid=<?php echo $row['template_id']; ?>" target="_blank" class="button-share"> Share </a>
								  |
								  <a id="<?php echo $row['template_id']; ?>" class="duplicateflyer"> Duplicate </a>
								  |
								  <a id="<?php echo $row['template_id']; ?>" class="button-delete text-danger deleteflyer"> Delete </a>
							  </span>
						   </td>
						   <td><?php echo $row['created_date']; ?></td>
						   <td><?php echo $row['modified_date']; ?></td>
						</tr>
					<?php 
						}
						}
					?>	
				</tbody>
            </table>
        </div>
    </div>
</div>
</div>
<div id="deleteflyers" class="modal fade">
	<div class="modal-dialog">
		<div class="modal-content modal-content-400">
			<div class="jumbotron modal-header" style="border-radius:5px 5px 0px 0px;background-color: #43d2f9; ">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true" style="opacity:1.0;"><img src="img/close.png"></button>
				<h4 class="modal-title">Delete Flyer</h4>
			</div>
			<div class="modal-body" style="margin-top:-30px; ">
				<div class="body">
					<span>Are you sure! Do you want to delete this flyer?</span>
				</div>
			</div>
			<div class="modal-footer clearfix">
				<button type="button" class="btn btn-default" data-dismiss="modal" onClick="javascript:flyerdel();">Delete</button>
				<button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
			</div>
		</div>
	</div>
</div>
<div id="successModal" class="modal fade">
	<div class="modal-dialog">
		<div class="modal-content modal-content-300">
			<div class="jumbotron modal-header" style="border-radius:5px 5px 0px 0px;background-color: #43d2f9; ">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true" style="opacity:1.0;"><img src="img/close.png"></button>
				<h4 class="modal-title">Success</h4>
			</div>
			<div class="modal-body" style="margin-top:-30px; ">
				<div class="body">
					<span id="successMessage"></span>
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Ok</button>
			</div>
		</div>
	</div>
</div>
<div id="alertModal" class="modal fade">
	<div class="modal-dialog">
		<div class="modal-content modal-content-300">
			<div class="jumbotron modal-header" style="border-radius:5px 5px 0px 0px; ">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true" style="opacity:1.0;"><img src="img/close.png"></button>
				<h4 class="modal-title">Alert</h4>
			</div>
			<div class="modal-body" style="margin-top:-30px; ">
				<div class="body">
					<span id="responceMessage"></span>
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Ok</button>
			</div>
		</div>
	</div>
</div>
</body>
<script src='http://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js'></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js" crossorigin="anonymous"></script>
<script type="text/javascript">
var flyerIdToDel = '';
$(document).on("click", ".deleteflyer", function() {
      flyerIdToDel = $(this).attr('id');
      $("#deleteflyers").modal('show');
});

function flyerdel() {
    $('#deleteflyers').modal('hide');
    var tempflyer = flyerIdToDel;

    if (tempflyer != '') {
        $.post("actions/deleteflyer.php", {
            "id": tempflyer
        }, function(data) {
            document.getElementById("successMessage").innerHTML = data;
            $('#successModal').modal('show');
			location.reload();
        });
    } else {
        $("#alertModal").modal('show');
        $('#responceMessage').html('Some Issues occur.');
    }
}

$(document).on("click", ".duplicateflyer", function() {
	var dupflyer = $(this).attr('id');
    if (dupflyer != '') {
        $.post("actions/dupflyers.php", {
            "id": dupflyer
        }, function(data) {
            document.getElementById("successMessage").innerHTML = data;
            $('#successModal').modal('show');
			location.reload();
        });
    } else {
        $("#alertModal").modal('show');
        $('#responceMessage').html('Some Issues occur.');
    }
});
$(document).ready(function(){
	imagePreview();
});
$('a.preview').click(function(){return false;}).click();
this.imagePreview = function(){	
		xOffset = -20;
		yOffset = 40;		
		
    $("a.preview").hover(function(e){
        this.t = this.title;
        this.title = "";	
	     var c = (this.t != "") ? "<br/>" + this.t : "";
         $("body").append("<p id='preview'><img src='"+ this.href +"' alt='Image preview' style='max-width:400px; max-height:400px;'/>"+ c +"</p>");								 
         $("#preview")
            .css("top",(e.pageY - xOffset) + "px")
            .css("left",(e.pageX + yOffset) + "px")
            .fadeIn("slow");
    },
	
    function(){
        this.title = this.t;
        $("#preview").remove();

    });	
	
    $("a.preview").mousemove(function(e){
        $("#preview")
            .css("top",(e.pageY - xOffset) + "px")
            .css("left",(e.pageX + yOffset) + "px");
    });			
};
</script>
</html>
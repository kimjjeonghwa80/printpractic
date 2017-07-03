<?php
	if (!isset($_SESSION)) {
       session_start();
    }
	require('library/config.php');
?>
<!DOCTYPE html>
<html class=''>

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>PrintPractic Designer</title>
    <meta name="description" content="">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css" integrity="sha512-dTfge/zgoMYpP7QbHy4gWMEGsbsdZeCXz7irItjcC3sPUFtf0kuFbDz/ixG7ArTxmDjLXDmezHubeNikyKGVyQ==" crossorigin="anonymous">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">  
    <link rel="stylesheet" href="../admin/css/styleclient.css">
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
		z-index: 100000;
	}

	.row {
		margin-left: 0px;
	}
</style>

<body style="background-color: white;" class="templates-index">
<header class="site-header flyers">
    <div class="container">
        <div class="logo pull-left navbar-header">
            <div class="header" style="color:#f2ddd3; text-align: center; letter-spacing: 3px; margin-top: 13px; background-color: transparent;"><h3>PrintPractic designer</h3></div>
        </div>
        <ul class="menu pull-left">
            <li><a href="javascript:void(0);">My Designs</a></li>
            <li><a href="javascript:void(0);">Plans</a></li>
        </ul>
    </div>
</header>
	<div class="container">
		<div class="row con-templates">
			<div class="page-header">
				<h1>Select a template to start customizing: &nbsp;</h1>
			</div>
		<?php 
		$query = "SELECT * FROM template_categories";
		$runQuery = mysql_query($query) or die("ERROR: " . $query);
		if(mysql_num_rows($runQuery) > 0){
			while($row = mysql_fetch_array($runQuery)){
		?>
			<div class="row templates">
						<?php 
							$query1 = "SELECT * FROM template WHERE cat_id =".$row['tempcat_id']."";
							$runQuery1 = mysql_query($query1) or die("ERROR: " . $query1);
							if(mysql_num_rows($runQuery1) > 0){
						?><h1><?php echo $row['tempcat_name']; ?></h1><?php
								while($row1 = mysql_fetch_array($runQuery1)){
									$imag = str_replace("editor/","",$row1['canvas_thumbnail']);
						?>
						<div class="thumbnail">
							<h3><?php echo $row1['template_name']; ?></h3>													  
							<!--<a href="index.php?admintempid=<?php echo $row1['template_id']; ?>" class="preview foo" value="../<?php echo $imag; ?>">
								<img src="../<?php echo $imag; ?>" alt="Recently Added Recruiting Flyer" width="150">
								<div class="overlay" style="height:194.11764705882px">
									<div><i class="fa fa-check"></i></div>
								</div>
							</a>-->
							<a class="preview foo" href="index.php?shopifyprodid=<?php echo $row1['shopify_product_id']; ?>" id="../<?php echo $imag; ?>">
								<img src="../<?php echo $imag; ?>" alt="Recently Added Recruiting Flyer" width="150">
								<div class="overlay" style="height:194.11764705882px">
									<div><i class="fa fa-check"></i></div>
								</div>
							</a>
						</div>
						<?php 
								}
							}
						?>		
				</div>
		<?php
				}
			}
		?>		
		</div>
	</div>
</body>
<script src='http://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js'></script>
<script src="https://ajax.googleapis.com/ajax/libs/webfont/1.5.18/webfont.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js" crossorigin="anonymous"></script>
<script src="../admin/js/bootstrap-tour.js"></script>
<script type="text/javascript">
$(document).ready(function(){
	imagePreview();
	$(".foo").click(function(){
	    // Get the src of the image
	    var src = "";
	    src = $(this).attr("href");
	    // Send Ajax request to backend.php, with src set as "img" in the POST data
	    $.post("backend.php", {"img": src});
	});

});
$('a.preview').click(function(){return false;}).click();
// Configuration of the x and y offsets
this.imagePreview = function(){	
		xOffset = -20;
		yOffset = 40;		
		
    $("a.preview").hover(function(e){
        this.t = this.title;
        this.title = "";	
	     var c = (this.t != "") ? "<br/>" + this.t : "";
         $("body").append("<p id='preview'><img src='"+ this.id +"' alt='Image preview' style='max-width:400px; max-height:400px;'/>"+ c +"</p>");								 
         $("#preview")
            .css("top",(e.pageY - xOffset) + "px")
            .css("left",(e.pageX + yOffset) + "px")
            .fadeIn("slow");
			e.preventDefault();
    },
	
    function(){
        this.title = this.t;
        $("#preview").remove();

    });	
	
    $("a.preview").mousemove(function(e){
        $("#preview")
            .css("top",(e.pageY - xOffset) + "px")
            .css("left",(e.pageX + yOffset) + "px");
			e.preventDefault();
    });			
};
$('a.preview').click(function(e){
  window.location = this.href;
  e.preventDefault();
})
</script>
</html>
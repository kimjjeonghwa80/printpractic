<?php
	require('library/config.php');
	/*include 'sendmail.php';

	$Status = 0;
	
	if(isset($_POST['name']) && $_POST['name'] != "") {
	
		$name = $_POST['name'];
		$email = $_POST['email'];
		$to = $_POST['email'];
		$phone = $_POST['phone'];
		$comments = $_POST['comments'];

		$emailSubject = "You've Received a New Lead";
		$emailBody    = "Flyer name and the Prospect details: <br><br>

					  Name: $name<br>
					  Email: $email<br>
					  Phone: $phone<br>
					  Comment: $comments<br><br>

					  Enjoy!<br>";
		$subject      = 'You have Received a New Lead';
		$headers      = "MIME-Version: 1.0" . "\r\n";
		$headers .= "Content-type:text/html;charset=iso-8859-1" . "\r\n";
		$headers .= 'From: Kpom Services <kpomservices@gmail.com>' . "\r\n";
		if (mail($to, $emailSubject, $emailBody, $headers)) {

		echo "Email Sent Successfully";
		
		$Status = 1;

		}

		$Status = 1;

	}*/
 
?>
  <?php 
    $query = "SELECT `template_id`, `template_name`, `canvas_thumbnail` FROM user_templates WHERE template_id = '".$_GET['flyerid']."'";    
    $runQuery = mysql_query($query);
    if(mysql_num_rows($runQuery) > 0)
    {
      $row = mysql_fetch_array($runQuery);
  ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta name="author" content="Paperdainty.com" />
    <meta name="description" content="Learn more about this property">
    <meta http-equiv="X-UA-Compatible" content="IE=Edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>Check out This Great New Listing</title>
    <meta property="og:site_name" content="Paperdainty.com"/>
    <meta property="og:url" content="http://www.paperdainty.com/client/<?php echo "flyer.php?flyerid=".$row['template_id']; ?>"/>
    <meta property="og:type" content="Post"/>
    <meta property="og:title" content="Learn more about this property"/>
    <meta property="og:site_name" content="Paperdainty.com" />
    <meta property="og:image" content="http://www.paperdainty.com/client/<?php echo $row['canvas_thumbnail']; ?>"/>
    <meta property="og:description" content="<?php echo $row['template_name']; ?>"/>
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="Learn more about this property">
    <meta name="twitter:description" content="<?php echo $row['template_name']; ?>">
    <meta name="twitter:image" content="http://www.paperdainty.com/client/<?php echo $row['canvas_thumbnail']; ?>>">
    <meta name="twitter:image:src" content="http://www.paperdainty.com/client/<?php echo $row['canvas_thumbnail']; ?>">
    <meta name="twitter:image:alt" content="Shared Image">
    <meta name="twitter:image:width" content="650">
    <meta name="twitter:image:height" content="650">    
    <link href="css/bootstrap.min.css" rel="stylesheet">
</head>
<style type="text/css">
	body {
		padding: 100px 0 0;
    	background-color: #333;
	}
</style>
<body>

    <div class="modal fade" id="my-modal-box" tabindex="-1" role="dialog" aria-labelledby="my-modal-box-l" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            <div class="modal-title" id="my-modal-box-l">
              <h4>Share This</h4>
            </div>
          </div>
          <div class="modal-body">
              <form role="form">
                <div class="form-group">
                  <span class="input-group-btn">                   
                    <form>
                      <div class="input-group" style='width:100%'>
                        <input type="text" class="form-control" id="copy-input" placeholder="" value="http://www.paperdainty.com/<?php echo $_SERVER['REQUEST_URI']; ?>" disabled/>                        
                        <span class="input-group-btn">
                          <button class="btn btn-default" type="button" id="copy-button"
                              data-toggle="tooltip" data-placement="button"
                              title="Copy to Clipboard">
                            Copy
                          </button>
                        </span>
                      </div>
                    </form>

                  </span>                  
                </div>
              </form><hr>

            <h4>Share on</h4>
            <div class="addthis_toolbox addthis_default_style addthis_32x32_style">
            <a class="addthis_button_preferred_1"></a>
            <a class="addthis_button_preferred_2"></a>
            <a class="addthis_button_preferred_3"></a>
            <a class="addthis_button_preferred_4"></a>
            <a class="addthis_button_compact"></a>
            <a class="addthis_counter addthis_bubble_style"></a>
			      <script type="text/javascript" src="//s7.addthis.com/js/300/addthis_widget.js"></script>
            <script type="text/javascript">
            var addthis_share = addthis_share || {}
            addthis_share = {
              passthrough : {
                twitter: {
                  text: "<?php echo $row['template_name']; ?> - Check out This Great New Listing - ziploy.com"
                }
              }
            }
            </script>             
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="navbar navbar-fixed-top navbar-default navbar-static" role="navigation" style="margin-top:30px;">
      <div class="container">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#b-menu-1">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="#"><?php echo $row['template_name']; ?></a>
        </div>
        <div class="collapse navbar-collapse" id="b-menu-1">
          <ul class="nav navbar-nav navbar-right">
            <li data-toggle="modal" data-target="#my-modal-box">
			<button class="btn btn-primary navbar-btn" data-editor-share="">
				<span class="fa fa-share"></span>
				Share
			</button>
          </ul>
        </div>
      </div>
    </div>

    <div class="container">
      <div class="row row-offcanvas row-offcanvas-right">
        <div class="col-xs-12 col-sm-9">

          <div class="">
            	<p><img src="<?php echo $row['canvas_thumbnail']; ?>" class="img-responsive" /></p>
          </div>
        </div>
		
        <div class="col-sm-3 sidebar-offcanvas" id="sidebar">
          <!-- box 5 -->
          <div class="panel panel-default">
            <div class="panel-heading">
              <h2 class="panel-title">Contact Request</h2>
            </div>
            <div class="panel-body">
              <form role="form" id="contactme" name="contactme" action="<?php echo "flyer.php?flyerid=".$row['template_id']; ?>" method="post">
				<fieldset>
					<?php if(isset($Status) && $Status == 1 ){ ?>
					<div class="form-group has-success">
						<label class="control-label" for="inputSuccess"><i class="fa fa-times-circle-o"></i> Thank you for your interest! You should be hearing back shortly.</label>
					</div>
					<?php } ?>
					<div class="form-group">
					  <label for="name">Name</label>
					  <input type="text" class="form-control" id="name" name="name" placeholder="Enter Name">
					</div>
					<div class="form-group">
					  <label for="email">Email address</label>
					  <input type="email" class="form-control" id="email" name="email" placeholder="Enter email">
					</div>
					<div class="form-group">
					  <label for="phone">Phone Number (Optional)</label>
					  <input type="text" class="form-control" id="phone" name="phone" placeholder="Enter Phone">
					</div>
					<div class="form-group">
					  <label for="comments">Comments</label>
					  <textarea type="text" class="form-control" id="comments" name="comments" placeholder="Add Comments"></textarea>
					</div>
					<button type="submit" class="btn btn-danger">Contact Me</button>
					</br>
					<h6>
						Easily create your own amazing flyers & more at <a target='_blank' href='http://paperdainty.com'>paperdainty.com</a>.
					</h6>
                </fieldset>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
	<?php 
		}
	?>

	<script src="//ajax.googleapis.com/ajax/libs/jquery/2.0.2/jquery.min.js"></script>
	<script src="js/bootstrap.min.js" type="text/javascript"></script>
	<script src="js/jquery.validate.min.js" type="text/javascript"></script>
	<script src="js/validation-methods.js" type="text/javascript"></script>

		<script type="text/javascript">
		$(document).ready(function () {

            $('#contactme').validate({
                rules: {
					name: {
                        required: true,
                    },
                    email: {
                        required: true,
                        email: true
                    },
                    phone: {
                        required: true,
                        digits: true
                    },
					comments: {
                        required: true,
                    }
                },
                highlight: function (element) {
                    $(element).closest('.form-group').removeClass('has-success').addClass('has-error');
                },
               /* success: function (element) {
					element.text('').addClass('valid')
						.closest('.form-group').removeClass('has-error').addClass('has-success');
				}*/
            });

        });

        $(document).ready(function() {
          $('#copy-button').tooltip();

          $('#copy-button').bind('click', function() {
            var input = document.querySelector('#copy-input');
            input.setSelectionRange(0, input.value.length + 1);
            try {
              var success = document.execCommand('copy');
              if (success) {
                $('#copy-button').trigger('copied', ['Copied!']);
              } else {
                $('#copy-button').trigger('copied', ['Copy with Ctrl-c']);
              }
            } catch (err) {
              $('#copy-button').trigger('copied', ['Copy with Ctrl-c']);
            }
          });

          $('#copy-button').bind('copied', function(event, message) {
            $(this).attr('title', message)
                .tooltip('fixTitle')
                .tooltip('show')
                .attr('title', "Copy to Clipboard")
                .tooltip('fixTitle');
          });
        });    
		</script>
</body>
</html>
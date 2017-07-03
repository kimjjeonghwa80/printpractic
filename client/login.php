<?php
	if (!isset($_SESSION)) {
       session_start();
    }

	require("library/config.php");

	$count = 1;

	if($_SERVER["REQUEST_METHOD"] == "POST"){
		$myusername=addslashes($_POST['email']);
		$mypassword=addslashes($_POST['password']);

		$sql="SELECT * FROM users WHERE username='".$myusername."' AND password='".$mypassword."'";
		$result=mysql_query($sql);
		$row=mysql_fetch_array($result);
		$active=$row['active'];
	    $user_id = $row['id'];
		$count=mysql_num_rows($result);
		 
			if($count==1){
				$_SESSION['email']=$myusername;
				$_SESSION['userid'] = $user_id;
				header("location: index.php");
			}
/*			if($count==1){
				$_SESSION['email']=$myusername;
       			 $_SESSION['userid'] = $userid;
       			 $imgsource = $_SESSION['imgsrc'];
       			 if(isset($imgsource) && !Empty($imgsource)){
       			 	header("location: ".$imgsource."");
       			 } else {
       			 	header("location: index.php");
       			 }				
			}
*/			else
			{
				$count = 0;
				$error="Your Login Name or Password is invalid";
			}
	} 

$email = "";
$pass = "";

if (isset($_GET["u"]))
    {
    $email = $_GET["u"];
    }

if (isset($_GET["p"]))
    {
    $pass = $_GET["p"];
    }
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
    <title>PrintPractic</title>
	<meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
	<link href="../admin/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
	<link href="http://allfont.net/allfont.css?fonts=montserrat-light" rel="stylesheet" type="text/css" />
</head>
<style>
	body {
	   background: #ffffff;
	}
	.form_bg {
		background-color: rgba(256,256,256,.9);
		color:#666;
		padding:20px;
		border-radius:10px;
		position: absolute;
		/*border:1px solid #fff;*/
		margin: auto;
		right: 0;
		left: 0;
/*		width: 400px;*/
/*		height: 250px;*/
	}
	.align-center{
		text-align: center;
	}
	.form-control{
		border-radius:0px;
		width: 300px;
		border-radius: 5px;
		width: 400px;
		background-color: #dfd1a3;
		border: 0;
		height: 50px;		
	}
	label {
		font-weight: lighter;
	}
	.form-group label {
		margin-top:1px;
		font-family: 'Montserrat Light', arial;
		font-size:16px;
		letter-spacing: 1px;
		text-transform: uppercase;
		color: #8e8e8e;
	}
	.form-group .error {
		margin-top:1px;
		font-family: 'Montserrat Light', arial;
		font-size:10px;
		letter-spacing: 1px;
		text-transform: uppercase;
		color: #a94442;
	}
	.logo .header {
		/*height: 180px;*/
		margin: 30px 0;
	}
	.logodesc label {
		font-family: Montserrat Light, arial;
		font-size: 16px;
		letter-spacing: 1px;
		text-transform: uppercase;
		color: #8e8e8e;
	}

	.signin {
		margin-left: 35%;
		margin-top: 0;
		width: 30%;
		background-color: #ceb974;
		color: #fff;
		font-family: 'Montserrat Light', arial;
		font-size:18px;
		border-radius: 10px;
		border: 0;
		padding: 12px 20px;
	}
	.signin:hover {
		background-color: #B89C44;
		color: #fff;
	}	
	body {
/*		background: url('images/bg-body.jpg') no-repeat center 25%; 
*/		background-size: cover;
	}

	.logodesc label {
		top: 28px;
		position: relative;
		font-size: 18px;
		letter-spacing: 1.5px;
	}
	.header h3 {
	text-indent: -9999em;
	margin: 0;
	}

	@media screen and (max-width: 1280px) {
		.signin {
			padding: 8px 20px;
		}

		.form-control {
			height: 40px;
		}

		.form_bg {
			border: 0;
		}
	}

	@media screen and (max-width: 1024px) {
		.container .row br {
			display: none;
		}
	}

	@media screen and (max-width: 768px) {
		.container .row br {
			display: none;
		}

		body {
			min-height: 600px;
		}		
	}

	@media screen and (max-width: 500px) {
		.form-control{
			width: 100%;
		}

	}


	@media screen and (max-width: 400px) {

		.form_bg {
			right: auto;
			left: 25px;
		}

		.signin {
			font-size: 13px;
		}

	}	

</style>

<body class="login">
    <div class="container">
        <div class="row">
            <div class="logo" align="center">
            	<div class="header" style="color:#428bca;text-align: center;letter-spacing: 3px;width: auto;"><h3>PrintPractic Designer</h3></b></div>
                <!--<img src="images/Paper_Logo.png" alt="img">-->
            </div></br>
<!--             <div class="logodesc" align="center">
				<label>Please enter your login details.</label>
			</div><br>
 -->            <div class="form_bg col-xs-10 col-sm-8 col-md-6">
 					<img src="images/logo.jpg" class="logo img-responsive center-block">
                <form id="loginform" action="login.php" method="post">
                    <div class="log">
						<?php if($count==0 ) { ?>
							<div class="form-group has-error"  style="text-align: center; ">
								<label class="control-label" for="inputError">(*) Your Login details is invalid</label>
							</div>
						<?php } ?>
                        <div class="form-group" align="center"><label>Email Address</label>
                            <input type="email" class="form-control" id="email" name="email" value=<?php echo $email;?>>
                        </div>
                        <div class="form-group" align="center"><label>Choose a Password</label>
                            <input type="password" class="form-control" id="password" name="password" value=<?php echo $pass;?>>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-default signin">SIGN IN</button>
				</form>
            </div>
        </div>
        <div align="center" style="display: none;">
			<!--<a href="#"><label style="margin-top:375px; font-family: 'Montserrat Light', arial; font-size:18px; color:#000000;">Forget Password?</label></a>-->
			<a><label style="font-family: 'Montserrat Light', arial; font-size:18px; margin-left: 50px;color:#000000;"><input type="checkbox" value="">&nbsp; Remember Me</label></a>
		</div>
    </div>
</body>

<script src="//ajax.googleapis.com/ajax/libs/jquery/2.0.2/jquery.min.js"></script>
<script src="../admin/js/bootstrap.min.js" type="text/javascript"></script>
<script src="../admin/js/jquery.validate.min.js" type="text/javascript"></script>
<script src="../admin/js/validation-methods.js" type="text/javascript"></script>
<script type="text/javascript">
	$(document).ready(function () {
		$('#loginform').validate({
			rules: {
				email: {
					required: true,
					email: true
				},
				 password: {
					minlength: 6,
					required: true
				},
			},
			highlight: function (element) {
				$(element).closest('.form-group').removeClass('has-success').addClass('has-error');
			},
			 success: function (element) {
				element.text('Input with success').addClass('valid')
					.closest('.form-group').removeClass('has-error').addClass('has-success');
				element.remove('label');
			},
		});
	});
</script>
</html>
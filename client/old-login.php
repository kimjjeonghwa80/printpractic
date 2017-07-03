<?php
	if (!isset($_SESSION)) {
       session_start();
    }

	require("library/config.php");

	$count = 1;

	if (!isset($_SESSION)) {
       session_start();
    }
	if($_SERVER["REQUEST_METHOD"] == "POST"){
		$myusername=addslashes($_POST['email']);
		$mypassword=addslashes($_POST['password']);

		$sql="SELECT * FROM users WHERE username='".$myusername."' AND password='".$mypassword."'";
		$result=mysql_query($sql);
		$row=mysql_fetch_array($result);
		$active=$row['active'];
	    $userid = $row['id'];
		$count=mysql_num_rows($result);
		 
			if($count==1){
				$_SESSION['email']=$myusername;
       			 $_SESSION['userid'] = $userid;
       			 $imgsource = $_SESSION['imgsrc'];
       			 if(isset($imgsource) && !Empty($imgsource)){
       			 	header("location: ".$imgsource."");
       			 } else {
       			 	header("location: index.php");
       			 }				
			}
			else
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
    <title>XOBSpoke</title>
	<meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
	<link href="css/bootstrap.min.css" rel="stylesheet" type="text/css" />
	<link href="http://allfont.net/allfont.css?fonts=montserrat-light" rel="stylesheet" type="text/css" />
</head>
<style>
	body {
	   background: #fce3d7;
	}
	.form_bg {
		/*background-color: rgba(100,100,100,.2);*/
		color:#666;
		padding:20px;
		border-radius:10px;
		position: absolute;
		border:1px solid #fff;
		margin: auto;
		right: 0;
		left: 0;
		width: 400px;
		height: 250px;
	}
	.align-center{
		text-align: center;
	}
	.form-control{
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
	.logo .header {
		/*height: 180px;*/
		width: 180px;
		margin-top: 70px;
		margin-bottom: 0px;
	}
	.logodesc {
		font-family: Montserrat Light, arial;
		font-size: 16px;
		letter-spacing: 1px;
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
		background: #fff; 
	}

	.logodesc label {
		top: 20px;
		position: relative;
	}

	.header h3 {
		width: 618px;
		height: 187px;
		text-indent: -9999em;
		background: url(images/logo.jpg) no-repeat left top;
		margin-right: auto;
		margin-left: auto;
	}



</style>

<body class="login">
    <div class="container">
        <div class="row">
            <div class="logo" align="center">
            	<div class="header" style="color:#428bca;text-align: center;letter-spacing: 3px;width: auto;"><h3>XOBSpoke Designer</h3></b></div>
                <!--<img src="images/Paper_Logo.png" alt="img">-->
            </div></br>
<!--             <div class="logodesc" align="center">
				<label>Please enter your login details.</label>
			</div><br>
 -->            <div class="form_bg">
                <form id="loginform" action="login.php" method="post">
                    <div class="log">
						<?php if($count==0 ) { ?>
							<div class="form-group has-error">
								<label class="control-label" for="inputError" style="text-align:left">(*) Your Login details is invalid</label>
							</div>
						<?php } ?>
                        <div class="form-group" align="center"><label>Email Address</label>
                            <input type="email" class="form-control" id="email" name="email" value=<?php echo $email;?>>
                        </div><br>
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
<script src="js/bootstrap.min.js" type="text/javascript"></script>
<script src="js/jquery.validate.min.js" type="text/javascript"></script>
<script src="js/validation-methods.js" type="text/javascript"></script>
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
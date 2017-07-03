<?php

	require("library/config.php");

	//file_put_contents('postcontent.txt', file_get_contents('php://input'));

	//$json = file_get_contents('php://input');
	
	$json = file_get_contents('postcontent.txt');

	$orderobj = json_decode($json);


	//process the post content

	//get email
	$useremail = $orderobj->email;
	$userid = '';
	$admintemplateid = '';
	$curdate = date('Y-m-d');

	//userid - get user id for email  or  Create user id  for email
    $query = "SELECT id, password FROM users WHERE username = '".$useremail."'";
    $runQuery = mysql_query($query);
    if(mysql_num_rows($runQuery) > 0)
    {
        while($users = mysql_fetch_array($runQuery))
        {
        	$userid = $users['id'];
			$password = $users['password'];
        }
    } else {

		$password = randomPassword();
		$insert_Query = "INSERT INTO users(username, password, last_login_date) values ('$useremail','$password', '$curdate')";
		$run_Query = mysql_query($insert_Query) or die("ERROR: " . $insert_Query);
		if($run_Query)
		{
			//echo "New User Added Successfully.";
 			$userid = mysql_insert_id();
		}
    }

		//send email new password details
	$emailSubject = "New Tempalte Customize and Download";
	$to = $useremail;

	$link = "http://template.xobspoke.com/client/login.php?u=".$useremail."&p=".$password;

	$emailBody = "Please find below the editor login information, <br />purchased design templates will be displayed in the editor after login <br /><br />

	<table>
	    <tr>
	        <td style='background-color: #4ecdc4;border-color: #4c5764;border: 2px solid #45b7af;padding: 10px;text-align: center;'>
	            <a style='display: block;color: #ffffff;font-size: 12px;text-decoration: none;text-transform: uppercase;' href='".$link."'>
	                Customize Your Design Templates
	            </a>
	        </td>
	    </tr>
	</table>

	Additional Details :

	Login Link  :  ".$link."  <br /><br />
	Login Email  :  ".$useremail."  <br /><br />
	Logoin Password   :  ".$password." <br /><br />
	
  </a><br /><br />";

	$headers = "MIME-Version: 1.0" . "\r\n";
	$headers.= "Content-type:text/html;charset=iso-8859-1" . "\r\n";
	$headers.= 'From: Admin <admin@prettytimely.com>' . "\r\n";
	if (mail($to, $emailSubject, $emailBody, $headers))
	{
		//echo "Email Sent Successfully";
	}
	else
	{
		//echo "Email did not send..Please try again..";
	}

	$lineitems = $orderobj->line_items;

	foreach ($lineitems as &$lineitem) {
		
		//get template id for product id
		$productid = $lineitem->product_id;

	    $query = "SELECT template_id FROM template WHERE shopify_product_id = ".$productid;
	    $runQuery = mysql_query($query);
	    if(mysql_num_rows($runQuery) > 0)
	    {
	        while($admintemplates = mysql_fetch_array($runQuery))
	        {
	        	$admintemplateid = $admintemplates['template_id'];
	        	//echo $admintemplateid;
	        }
	    }

		$insert_Query = "INSERT INTO user_templates(userid, template_name, canvas_thumbnail, canvas_json, created_date, modified_date) values ($userid, '', '', '', '$curdate', '$curdate')";
		$run_Query = mysql_query($insert_Query) or die("ERROR: " . $insert_Query);
		if($run_Query)
		{
			//echo "New Template Added Successfully.";
 			$templateid = mysql_insert_id();

 			//copy admin templates to user template
 			copy("templates/".$admintemplateid.".png","../client/templates/".$templateid.".png");
 			copy("templates/".$admintemplateid.".pt","../client/templates/".$templateid.".pt");

			$updated_Query = "UPDATE user_templates SET canvas_thumbnail = 'templates/".$templateid.".png', canvas_json = 'templates/".$templateid.".pt' WHERE template_id = $templateid";
			$run_Query = mysql_query($updated_Query) or die("ERROR: " . $updated_Query);
		}
	}

	function randomPassword() {
	    $alphabet = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890';
	    $pass = array(); //remember to declare $pass as an array
	    $alphaLength = strlen($alphabet) - 1; //put the length -1 in cache
	    for ($i = 0; $i < 8; $i++) {
	        $n = rand(0, $alphaLength);
	        $pass[] = $alphabet[$n];
	    }
	    return implode($pass); //turn the array into a string
	}
?>
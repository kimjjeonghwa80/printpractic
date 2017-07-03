<?php
require ('library/config.php');

$Status = 0;

$mail = $_POST['mailid'];

if (isset($_POST["templateid"]) != "")
{
	$query = "SELECT * from user_templates where template_id = '".$_POST["templateid"]."'";
	$row = mysql_query($query) or die("ERROR: " . $query);
	if (mysql_num_rows($row) > 0)
	{
		$res = mysql_fetch_array($row);
		$emailSubject = "PDF Template Mail";
		$to = $mail;
		$emailBody = "Your Design <br /><br />
		
		Template ID   :  ".$res["template_id"]." <br /><br />
		Template Name :  ".$res["template_name"]." <br /><br />
	    Template Link :  <a href = 'http://template.xobspoke.com/client/outputpdfs/".$res["template_id"].".pdf'>Click Here To View PDF Template
	  </a><br /><br />";
	  
		$subject = 'You have Received a New Template';
		$headers = "MIME-Version: 1.0" . "\r\n";
		$headers.= "Content-type:text/html;charset=iso-8859-1" . "\r\n";
		$headers.= 'From: Kpom Services <kpomservices@gmail.com>' . "\r\n";
		if (mail($to, $emailSubject, $emailBody, $headers))
		{
			echo "Email Sent Successfully";
			$Status = 1;
		}
		else
		{
			echo "Email did not send..Please try again..";
		}
	}
}

?>
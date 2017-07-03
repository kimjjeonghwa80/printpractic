<?php

require_once '/home/zipdesigner/zipdesigner.com/amember/library/Am/Lite.php';

$search = array(2);
if(Am_Lite::getInstance()->haveSubscriptions($search)) {
	echo 'Paid';
} 

$search = array(3);
if(Am_Lite::getInstance()->haveSubscriptions($search)) {
	echo 'Free';
} 

$search = array(1);
if(Am_Lite::getInstance()->haveSubscriptions($search)) {
	echo 'Any';
} 

$search = array(3);
if(Am_Lite::getInstance()->checkAccess($search)) {
	echo 'Free';
}

/*$search = array(2);
if(Am_Lite::getInstance()->checkAccess($search)) {
	echo 'Paid';
}*/

/*$search = array(3);
if(Am_Lite::getInstance()->checkAccess($search)) {
	echo 'Free';
}*/

echo 'User Details :';

echo Am_Lite::getInstance()->isLoggedIn();

echo Am_Lite::getInstance()->getUsername();

//echo Am_Lite::getInstance()->getName();

//print_r(Am_Lite::getInstance()->getPayments());

echo Am_Lite::getInstance()->isUserActive();

//print_r(Am_Lite::getInstance()->getProducts());

echo "</br>";

//echo getcwd();

//echo 'sample files';
?>
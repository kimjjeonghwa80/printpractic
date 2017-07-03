<?php
	if (!isset($_SESSION)) {
       session_start();
    }
    // do any authentication first, then add POST variable to session
    $_SESSION['imgsrc'] = $_POST['img'];
?>
<?php
    include("../library/config.php");

    $respdf = $_POST["res_pdf"];
    $resjpeg = $_POST["res_jpeg"];
    $respng = $_POST["res_png"];
    
    $insert_Query = "UPDATE download_imit SET pdf_limit='$respdf', jpeg_limit='$resjpeg', png_limit='$respng'";
    $run_Query = mysql_query($insert_Query) or die("ERROR: " . $insert_Query);
    if($run_Query)
    {
        echo "Download Limit Updated Successfully.";
    }
?>
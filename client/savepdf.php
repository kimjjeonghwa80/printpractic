<?php
	require_once ('tcpdf/tcpdf.php');

	$jsonData = $_POST['jsonData'];
	$cwidth = $_POST['cwidth'];
	$cheight = $_POST['cheight'];
	$rows = $_POST['rows'];
	$cols = $_POST['cols'];
    $path = $_POST['path'];
	$savecrop = $_POST['savecrop'];	
	
	/*$cwidth = 5*96;
	$cheight = 7*96;
	$savecrop = 'false';
	$rows = 1;
	$cols = 1;*/
	$rc = $rows * $cols;
	$jsonData = json_decode($jsonData);

	//scale to 0.75 for inch based on DPI.
	$scalef = 72/96;
	//crop mark padding
	$cmp = 0;
	if($savecrop != 'false') {
		$cmp = 10;
	}

	$pdf = new TCPDF('', 'px', array($cwidth * $scalef * $cols + $cmp*2, $cheight * $scalef * $rows + $cmp*2), true, 'UTF-8', false, false);
	$pdf->SetCreator(PDF_CREATOR);
	$pdf->SetHeaderMargin(0);
	$pdf->SetFooterMargin(0);
	$pdf->SetLeftMargin(0);
	$pdf->SetRightMargin(0);
	$pdf->setPrintFooter(false);
	$pdf->setPrintHeader(false);
	$pdf->setCellMargins(0,0,0,0);
	$pdf->SetCellPaddings(0,0,0,0);
	// set auto page breaks
	$pdf->SetAutoPageBreak(false);
	$pdf->SetDisplayMode(100);
	$totalcanvas = count($jsonData);

	$offsetwidth = $cwidth * $scalef;
	$offsetheight = $cheight * $scalef;
	class Font
	{
		public $fontName;
		public $fontStyle;
		public $fontWeight;
	}
	for ($x = 0; $x < $totalcanvas; $x += $rc) {
		$pdf->AddPage();
		$pdf->StartTransform();
		//$pdf->ScaleXY($scalef * 100);
		$colscount = 0;
		$rowscount = 0;
		for ($y = $x; $y < ($x+$rc); $y++) {
			$dataString = $jsonData[$y];
			//Replace font path to real and current path. If not than font will not be loaded

			//$dataString = str_replace("http://www.site.com/editor/","./",$dataString);
			//$dataString = str_replace("http://","https://",$dataString);
			$dataString = str_replace("http://efilingservices.org/EmailndPrint/editor/admin/","./",$dataString);

			if($colscount >= $cols) {
				$colscount = 0;
				$rowscount++;
			}

			// start a new XObject Template and set transparency group option
			$template_id = $pdf->startTemplate($offsetwidth*2, $offsetheight*2, true);
			$pdf->StartTransform();

			// Set Clipping Mask
			$pdf->Rect($offsetwidth, $offsetheight, $offsetwidth, $offsetheight, 'CNZ');

			//Return attribute font name
			$decoded_xml = simplexml_load_string($dataString);

			$fontNameArr = array();

			//Store fonts into an array
			foreach($decoded_xml[0] as $i=>$xmlList){

			    $fontFamilyArr = $xmlList->text;

			    $fontName = (xml_attribute($fontFamilyArr,'font-family'));
				$fontStyle = (xml_attribute($fontFamilyArr,'font-style'));
			    $fontWeight = (xml_attribute($fontFamilyArr,'font-weight'));

			    if(!in_array($fontName, $fontNameArr)){
				    
					$localFont = new Font();
					$localFont->fontName = $fontName;
					$localFont->fontStyle = $fontStyle;
					$localFont->fontWeight = $fontWeight;
					
			        array_push($fontNameArr,$fontName);
			    }
			}

			//Load neccesory fonts
			foreach ($fontNameArr as $localFont){

				$fontFamily = $localFont->fontName;
				$fontStyle = $localFont->fontStyle;
				$fontWeight = $localFont->fontWeight;

			    if($fontFamily!='' && strlen($fontFamily)>0){

			        $folderName = str_replace(" ","_", $fontFamily);

			        $fontFileName = str_replace(" ","", $fontFamily);

			        if($fontStyle == "italic") {
			        	$fontStyle = "Italic";
			        } else if($fontWeight == "bold") {
			        	$fontStyle = "Bold";
			        } else {
			        	$fontStyle = "Regular";
			        }

					$fontpath = "./tcpdf/fonts/googlefonts/".$folderName."/".$fontFileName."-".$fontStyle.".ttf";
					if(file_exists($fontpath)) {
						$fontname = TCPDF_FONTS::addTTFfont($fontpath,'TrueTypeUnicode', '', 96);
					} else {
						$fontpath = "./tcpdf/fonts/googlefonts/".$folderName."/".$fontFileName."-Regular.ttf";
						if(file_exists($fontpath)) {
							$fontname = TCPDF_FONTS::addTTFfont($fontpath,'TrueTypeUnicode', '', 96);
						}  else {
						}
					}

					if($fontStyle == "Italic") {
						$fontStyle = "i";
					} else if($fontStyle == "Bold") {
						$fontStyle = "b";
					} else {
						$fontStyle = "";
			        }

			        $pdf->SetFont($fontname, $fontStyle, 14, '', false);
			    }
			}

			$pdf->setXY($offsetwidth, $offsetheight);
			$pdf->ScaleXY($scalef * 100);
			$pdf->ImageSVG('@'.$dataString);

			$pdf->StopTransform();

			// end the current Template
			$pdf->endTemplate();

			$pdf->printTemplate($template_id, ($offsetwidth * $colscount) - $offsetwidth + $cmp, ($offsetheight * $rowscount) - $offsetheight + $cmp, $offsetwidth*2, $offsetheight*2, '', '', false);
			if($savecrop != 'false') {
				$pdf->cropMark(($offsetwidth * $colscount) + $cmp, ($offsetheight * $rowscount) + $cmp, $cmp, $cmp, 'TL', array(136,136,136));
				$pdf->cropMark(($offsetwidth * $colscount) + $offsetwidth + $cmp, ($offsetheight * $rowscount) + $cmp, $cmp, $cmp, 'TR', array(136,136,136));
				$pdf->cropMark(($offsetwidth * $colscount) + $cmp, ($offsetheight * $rowscount) + $offsetheight + $cmp, $cmp, $cmp, 'BL', array(136,136,136));
				$pdf->cropMark(($offsetwidth * $colscount) + $offsetwidth + $cmp, ($offsetheight * $rowscount) + $offsetheight + $cmp, $cmp, $cmp, 'BR', array(136,136,136));
			}
			$colscount++;
		}
		$pdf->StopTransform();
	}
	$pdf->Close();
	//$filename = $_SERVER['DOCUMENT_ROOT'] . "../EmailandPrint/editor/admin/outputpdfs/" . $lot . "/" . $_POST['filename'];
	$filename = $_SERVER['DOCUMENT_ROOT'] . "client/outputpdfs/" . $_POST['filename'];
	$pdf->Output($filename, 'F');
	echo $filename;
	//echo $pdf->Output('temp.pdf', 'D');
	function Hex2RGB($color){
		$color = str_replace('#', '', $color);
		if (strlen($color) != 6){
			return array(0,0,0);
		}
		$rgb = array();
		for ($x=0;$x<3;$x++){
			$rgb[$x] = hexdec(substr($color,(2*$x),2));
		}
		return $rgb;
	}

	function xml_attribute($object, $attribute)
	{
	    if(isset($object[$attribute]))
	        return (string) $object[$attribute];
	}
?>
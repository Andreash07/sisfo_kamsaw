<?php
error_reporting(E_ALL);
//include("sql_convert.php");
ob_start();
include("page_report_medal.php");
$content=ob_get_clean();
$namefile="asasas";
//$medal."_".$nroom."_".$ncamp;;

//convert in pdf

require_once(dirname(__FILE__).'/html2pdf/html2pdf.class.php');
try
  {
    $html2pdf = new HTML2PDF('L', 'A4', 'en', true, 'utf-8', array(2,48,2,0));
	$html2pdf->writeHTML($content);
    $html2pdf->Output($room_name.'_'.$ay_id.'.pdf');
    }
catch(HTML2PDF_exception $e) 
	{
    echo $e;
    exit;
    }
?>
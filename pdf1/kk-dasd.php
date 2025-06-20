<?php 

include ('html2pdf/konek.php');
// Include the main TCPDF library (search for installation path).
require_once('tcpdf/tcpdf.php');

// create new PDF document
$pdf = new TCPDF('L', 'mm', array(210,330), true, 'UTF-8', false);

// set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Sisfo-GKPKampung-Sawah');
$pdf->SetTitle('Kartu Keluarga Jemaat');
$pdf->SetSubject('Data Jemaat');
$pdf->SetKeywords('Data Jemaat, Kartu Keluarga Jemaat, GKP Kampung Sawah');

// set default header data
//$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE.' 001', PDF_HEADER_STRING, array(0,64,255), array(0,64,128));
//$pdf->setFooterData(array(0,64,0), array(0,64,128));

// set header and footer fonts
//$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
//$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

// set default monospaced font
//$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

// set margins
$pdf->SetMargins(127, 127, 127);
$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

// set auto page breaks
$pdf->SetAutoPageBreak(TRUE, 127);

// set image scale factor
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

// set some language-dependent strings (optional)
if (@file_exists(dirname(__FILE__).'/tcpdf/lang/eng.php')) {
	require_once(dirname(__FILE__).'/tcpdf/lang/eng.php');
	$pdf->setLanguageArray($l);
}

// ---------------------------------------------------------

// set default font subsetting mode
$pdf->setFontSubsetting(true);

// Set font
// dejavusans is a UTF-8 Unicode font, if you only need to
// print standard ASCII chars, you can use core fonts like
// helvetica or times to reduce file size.
$pdf->SetFont('times', '', 14, '', true);
// MultiCell($w, $h, $txt, $border=0, $align='J', $fill=0, $ln=1, $x='', $y='', $reseth=true, $stretch=0, $ishtml=false, $autopadding=true, $maxh=0)
$dbopen=bukakoneksi();
$sql="select A.*
		from keluarga_jemaat A ";
$qsql=$dbopen->query($sql);
$rsql=$qsql->fetch_all(MYSQLI_ASSOC);


$sql1="select A.*
		from anggota_jemaat A ";
$qsql1=$dbopen->query($sql1);
$rsql1=$qsql1->fetch_all(MYSQLI_ASSOC);
$arr_anggota=array();
foreach ($rsql1 as $key => $value) {
	# code...
	$arr_anggota[$value['kwg_no']][]=$value;
}
$html="";
// set JPEG quality
$pdf->setJPEGQuality(100);
foreach ($rsql as $key => $value) {
	$pdf->AddPage();
	// Image($file, $x='', $y='', $w=0, $h=0, $type='', $link='', $align='', $resize=false, $dpi=300, $palign='', $ismask=false, $imgmask=false, $border=0, $fitbox=false, $hidden=false, $fitonpage=false)
	$pdf->Image('../assets/images/logo-gkp.png', 15, 10, 0, 25, 'PNG', '', '', true, 150, '', false, false, 1, false, false, false);

	# code...
	if(!isset($arr_anggota[$value['id']])){
		//kalau baru ada keluarganya tidak dicetak jadi langsugn di continue;
		continue;
	}
}
?>
<?php
$pdf->Output('example_001.pdf', 'I');
?>
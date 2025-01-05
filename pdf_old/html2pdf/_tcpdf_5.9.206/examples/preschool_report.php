<?php
 
set_time_limit(0);
session_start();

 ob_start();
	require('../../../../con/dblink_ais3.php');

	$db = db_open();
	if(!$db->autocommit(FALSE)){
		//db_error($json,$db,'Unable to start transaction',100,"");
	}
	

$month = date("n");
$year = date("y");
if($month>6)$academic = $year+1;
else $academic = $year;	
	
$tgl = '';
$ay = $academic;
$student = $_GET['student_id'];
$name_pdf = "Preschool_report";
$ayx = $ay-1;		
$datenow = date("d-F-Y");
 
 
   $sqlget=$db->query("select  c.dob,g.name level,replace(replace(f.name,'Primary',''),'Secondary','') campname,b.level_id,concat(c.firstname,' ',c.lastname) name,d.initials room,right(e.name,4) acayear,concat(concat(c.firstname,' ',c.lastname),' - ',d.initials) searchvalue
	  from students a 
	  left join classrooms b on a.classroom_id=b.id 
	  left join profiles c on a.id=c.id 
	  left join rooms d on a.room_id=d.id 
	  left join academicyears e on b.academicyear_id=e.id 
	  left join camps f on a.camp_id=f.id 
	  left join levels g on b.level_id=g.id 
	  where a.id='".$student."'  ");
	  $rowget=$sqlget->fetch_assoc();
	  
	  $searchvalue=$rowget['searchvalue'];
	  $name=$rowget['name'];
	  $dob=$rowget['dob'];
	  $student_id=$_POST['student_id'];
	  $room=$rowget['room'];
	  $acayear=$rowget['acayear'];
	  $levelid_con1= $rowget['level_id'];
	  $campname= $rowget['campname'];
	  $levelid_con2="and level_id='".$rowget['level_id']."'";	
	
?>
<?php
//============================================================+
// File name   : example_051.php
// Begin       : 2009-04-16
// Last Update : 2011-06-01
//
// Description : Example 051 for TCPDF class
//               Full page background
//
// Author: Nicola Asuni
//
// (c) Copyright:
//               Nicola Asuni
//               Tecnick.com LTD
//               Manor Coach House, Church Hill
//               Aldershot, Hants, GU12 4RQ
//               UK
//               www.tecnick.com
//               info@tecnick.com
//============================================================+

/**
 * Creates an example PDF TEST document using TCPDF
 * @package com.tecnick.tcpdf
 * @abstract TCPDF - Example: Full page background
 * @author Nicola Asuni
 * @since 2009-04-16
 */

require_once('../config/lang/eng.php');
require_once('../tcpdf.php');


// Extend the TCPDF class to create custom Header and Footer
class MYPDF extends TCPDF {
	//Page header
	public function Header() {
		// get the current page break margin
		$bMargin = $this->getBreakMargin();
		// get current auto-page-break mode
		$auto_page_break = $this->AutoPageBreak;
		// disable auto-page-break
		$this->SetAutoPageBreak(false, 0);
		// set bacground image
		$img_file = K_PATH_IMAGES.'pic/cover3.jpg';
		$this->Image($img_file, 0, 0, 250, 175, '', '', '', false, 300, '', false, false, 0);
		// restore auto-page-break status
		$this->SetAutoPageBreak($auto_page_break, $bMargin);
		// set the starting point for the page content
		$this->setPageMark();
	}
}

// create new PDF document
$pdf = new MYPDF('L', PDF_UNIT, 'B5', true, 'UTF-8', false);

// set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Nicola Asuni');
$pdf->SetTitle('TCPDF Example 051');
$pdf->SetSubject('TCPDF Tutorial');
$pdf->SetKeywords('TCPDF, PDF, example, test, guide');

// set header and footer fonts
$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));

// set default monospaced font
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

//set margins
$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
$pdf->SetHeaderMargin(0);
$pdf->SetFooterMargin(0);

// remove default footer
$pdf->setPrintFooter(false);

//set auto page breaks
$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

//set image scale factor
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

//set some language-dependent strings
$pdf->setLanguageArray($l);

// ---------------------------------------------------------

// set font
$pdf->SetFont('times', '', 48);

// add a page
$pdf->AddPage();




if (!file_exists('../../../../ais/teachers/preschool_teacher/uploads/profile/'.$student.'.jpg')) {   
$filefound = '../../../../ais/teachers/preschool_teacher/uploads/profile/pp_default.jpg';                         
}else{
$filefound = '../../../../ais/teachers/preschool_teacher/uploads/profile/'.$student.'.jpg';   	
}


//pp_default.jpg

// Print a text
$html = '
<br>
<br>
<br>
<br>
 

<table   style="margin-top:-30px;width:780px;">
<tr>
<td>&nbsp;</td><td>&nbsp;</td><td style="width:30mm;text-align:center;">&nbsp;</td>
<td style="width:46mm;text-align:center;" >
<span style="background-color:yellow;color:blue;"><img src="'.$filefound.'" style="width:60px;height:75px;"></span>
</td>
</tr>
 
<tr>
<td>&nbsp;</td><td>&nbsp;</td><td >&nbsp;</td>
<td align="center" style="text-align:center;vertical-align:bottom;" >
<p stroke="0.1" fill="true" strokecolor="yellow" color="white" style="font-family:helvetica;font-weight:bold;font-size:11pt;"><br>'.$name.'<br>'.$room.'</p>
</td>
</tr>
</table>
';


$pdf->writeHTML($html, true, false, true, false, '');


 
 
//Close and output PDF document
$pdf->Output('example_051.pdf', 'I');

//============================================================+
// END OF FILE
//============================================================+

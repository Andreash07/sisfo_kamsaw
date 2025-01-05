<?php
 
set_time_limit(0);
session_start();

 ob_start();
	require('../../../con/dblink_ais3.php');

	$db = db_open();
	if(!$db->autocommit(FALSE)){
		//db_error($json,$db,'Unable to start transaction',100,"");
	}
?>

 <style>
thead { display: table-header-group }
tfoot { display: table-footer-group }
tr { page-break-inside: avoid } 

.trwidth(height: 200px;padding:3mm 1mm;)
 </style>
  
<?php

	
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
 
	
$name_pdf = "REPORT_Yellow_Form_";
 
$ayx = $ay-1;		
	 
$datenow = date("d-F-Y");
 
 
 echo"<page  >";
 
	 
	 
	 echo" <img src='pic/cover3.jpg' style='width:1123px;height:790px;'>"; 
				
 


 
			echo"</page>";

 
 
		
 
	?>
	
	
<?php

    $content = ob_get_clean();

    // convert in PDF
    require_once(dirname(__FILE__).'/../html2pdf.class.php');
    try
    {
        $html2pdf = new HTML2PDF('L', 'A4', 'en', true, 'UTF-8', array(0, 0, 0, 0));
		$html2pdf->setDefaultFont('cid0jp');
		$html2pdf->setTestTdInOnePage(false);
        $html2pdf->writeHTML($content, isset($_GET['vuehtml']));
        $html2pdf->Output(''.$name_pdf.'.pdf');
		
    }
    catch(HTML2PDF_exception $e) {
        echo $e;
        exit;
    }
?>
	

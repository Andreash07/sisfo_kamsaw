<?php

set_time_limit(0);
session_start();

 ob_start();
	require('../../../con/dblink_ais.php');

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
img {
    width:50px !important; 
    height:50px !important;
}
    </style>

<?php
$json['year']=substr(date('Y'),2);
$json['month']=date('m');
if($json['month']>6){
	$json['year']++;
}
else if($json['month']<=6){
	$json['year'];
}

		$date= date('Y-m-d');
		if(isset($_GET['date'])){
			$daten = $_GET['date'];
		}else{
			$daten = $date;
		}
$userid =  $_GET['userid'];
 
$datenow = date("d-M-Y");
$name_pdf = "E-learning Attendance";

 
echo"<page backtop='29mm' backbottom='-1mm' backleft='-1mm' backright='-1mm'>
			<page_header>
			<table   style='margin-left:150px;' >";
			echo"<tr >";
			echo"<td ><img src='bbsrc.jpg'style='width:100px;'></td><td>&nbsp;</td><td>&nbsp;</td>
			
			<td>&nbsp;</td><td>&nbsp;</td>
								<td  ><span   style='font-size:16px; ' ><b>E-learning Attendance List  <br>    <br>  </b></span></td>
								<td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td style='font-size:8px;'></td>";
								 
								echo"<td>&nbsp;</td>";
								echo"<td>&nbsp;</td>";
								echo"<td>&nbsp;</td>";
								echo"<td>&nbsp;</td>";
								echo"<td>&nbsp;</td>";
								echo"<td>&nbsp;</td>";
								echo"<td>&nbsp;</td>";
								echo"<td>&nbsp;</td>";
								echo"<td>&nbsp;</td>";
								echo"<td>&nbsp;</td>";
								echo"<td>&nbsp;</td>";
								echo"<td>&nbsp;</td>";
								echo"<td>&nbsp;</td>";
								echo"<td>&nbsp;</td>";
 
 
								echo"<td style='font-size:18px;text-align:center;'>".$cname."</td>";
							 
								 
								
			echo"</tr></table></page_header>";
			
				 
					
					echo"<table border='1' align='center'  style='border-collapse: collapse;border: 1px solid black;font-size:10px;' width='50%'><thead>";
					echo"<tr align='center'  >";
					echo"<td>No</td>";
					echo"<td>Student Name</td>";
					echo"<td>Class</td>";
					echo"<td>Log Time</td>";
					echo"</tr>";
					echo"</thead>";
					
			$i=1;
		 

	 		  	$qs = "
				SELECT A.id as recid, CONCAT( C.firstname,  ' ', C.lastname ) AS Student_Name, D.level_id as levelid,E.name as level, C.id as Student_ID, A.conduct1 as con1, A.conduct2 as con2,A.conduct3 as con3,A.conduct4 as con4, A.promoted as promoted, A.lock1 as lock1, A.lock2 as lock2,A.lockt3 as lock3, A.lockt4 as lock4,F.initials room
FROM classstudents A
JOIN students B ON ( B.id = A.student_id ) 
JOIN profiles C ON ( C.id = B.profile_id ) 
JOIN classrooms D ON (D.id = A.classroom_id)
JOIN levels E ON(E.id = D.level_id)
LEFT JOIN rooms F ON(F.id = B.room_id)
WHERE D.academicyear_id = '".$json['year']."' AND D.staff_id = '".$userid."'
|| A.classroom_id in (select F.classroom_id 
						from co_classrooms F
						join classrooms G on (G.id = F.classroom_id)
						where F.staff_id='".$userid."' && G.academicyear_id='".$json['year']."')
ORDER BY CONCAT( C.firstname,  ' ', C.lastname )
				
				";
 
			$ss = $db->query($qs);	
             while($rs = $ss->fetch_assoc())
				{
			$getlog = "SELECT * FROM `log_in_out` where user_id=".$rs['Student_ID']." and left(time_log,10)='".$daten."' group by time_log order by time_log asc ";
			$slog = $db->query($getlog);
					echo"<tr>";
					echo"<td style='width:30px;height:20px;' align='center'>".$i."   </td>";
	 
				 
					echo('<td style="width:300px;height:20px;">'.$rs['Student_Name'].'</td>');
					echo('<td style="width:80px;height:20px;">'.$rs['room'].'</td>');
					echo('<td style="width:200px;height:20px;"> ');
						$no=1;
						while($rlog = $slog->fetch_assoc())
					{
						echo $no++.'. '.$rlog['time_log'].'<br>';
					}	
						echo(' </td>');  
					echo"</tr>";  
			$i++;
				}
			echo"</table> </page>";



	?>
	
	
<?php

    $content = ob_get_clean();

    // convert in PDF
    require_once(dirname(__FILE__).'/../html2pdf.class.php');
    try
    {
        $html2pdf = new HTML2PDF('P', 'A4', 'en', true, 'UTF-8', array(4,4, 4, 8));
		$html2pdf->setTestTdInOnePage(false);
		 
		if (strpos($rstitle['subject'], 'Chinese') !== false) {
		$html2pdf->setDefaultFont('cid0jp');
		}
        $html2pdf->writeHTML($content, isset($_GET['vuehtml']));
        $html2pdf->Output(''.$name_pdf.'.pdf');
		
	 
    }
    catch(HTML2PDF_exception $e) {
        echo $e;
        exit;
    }
?>
	

<?php
set_time_limit(0);
error_reporting(0);
session_start();
 
	require_once("../../../con/dblink_ais.php");
	$dbopen=db_open();
 
	$user_id=$_SESSION['userid'];
	$camp_id=$_SESSION['campus'];
	$month = date("n");
 $year = date("y");
 if($month>6)$academic = $year+1;
 else $academic = $year;


	 $slesson="
	 SELECT a.*
	 
	 from new_lesson_plan_p   a 



where a.id =  '".$_REQUEST['lpid']."'    ";
	$qlesson=$dbopen->query($slesson);
	$rlesson=$qlesson->fetch_assoc();
	
	
	 	$steacher="SELECT firstname,lastname from profiles where id = '".$rlesson['staff_id']."'";
	$qteacher=$dbopen->query($steacher);
	$rteacher=$qteacher->fetch_assoc();
	
	$steacher="SELECT firstname,lastname from profiles where id = '".$rlesson['staff_id']."'";
	$qteacher=$dbopen->query($steacher);
	$rteacher=$qteacher->fetch_assoc();
	
	$sclass="SELECT rooms.initials 
FROM new_lesson_plan_p
JOIN classsubjects on classsubjects.id = new_lesson_plan_p.class
JOIN rooms on classsubjects.room_id = rooms.id
WHERE new_lesson_plan_p.id = '".$_REQUEST['lpid']."'";
	$qclass=$dbopen->query($sclass);
	$rclass=$qclass->fetch_assoc();
	?>
	 <style>
thead { display: table-header-group }
tfoot { display: table-footer-group }
tr { page-break-inside: avoid } 

.trwidth(height: 200px;padding:3mm 1mm;)

.tdfirst
{
	text-align:center;
	border-top: solid 1px #000000; 
	
	
	background: #f5f5f5
}
</style>
	<page backtop='29mm' backbottom='-1mm' backleft='-1mm' backright='-1mm'>
			<page_header>
	<?php
	
			echo"<table align='center'>";
							echo"<tr>";
							
					 
								echo"<td><img src='bbsrc.jpg'style='width:130px;'></td>
								<td>&nbsp;</td>
								<td>&nbsp;</td>
								<td>&nbsp;</td>
								<td>&nbsp;</td>
								<td>&nbsp;</td>
								<td>&nbsp;</td>
								<td>&nbsp;</td>
								<td>&nbsp;</td>
								<td>&nbsp;</td>
								<td>&nbsp;</td>
								<td align='center'><span id='bbsname' style='font-size:16px;text-align:center;' > LESSON PLAN <br>  <span style='font-size:12px;'>AY: 2018/2019 </span>  </span></td>
								<td>&nbsp;</td>
								<td>&nbsp;</td>
								<td>&nbsp;</td>
								<td>&nbsp;</td>
								<td>&nbsp;</td>
								<td>&nbsp;</td>
								<td>&nbsp;</td>
								<td>&nbsp;</td>
								<td>&nbsp;</td>
								<td>&nbsp;</td>
								<td style='font-size:8px;'> Campus :</td>
								<td style='font-size:12px;text-align:center;'> ".$_SESSION['campus_code']."</td>";
							
							 	
			echo"</tr></table>";
			 
			?>
			</page_header>
			<hr />
				 <table align="center" style="font-size:13px; background: #FFFFFF; ">
		
				 
				  <tr>
				  <td style="width: 10mm;  background: #FFFFFF;">
				 Term
				 </td>
				 <td style="width: 145mm;  background: #FFFFFF;">
				 : Term<?php echo $rlesson['term']; ?>
				 </td>
				 </tr>
				 
				 
				  <tr>
				  <td style="width: 10mm;  background: #FFFFFF;">
				 Week
				 </td>
				 <td style="width: 145mm;  background: #FFFFFF;">
				 : Week<?php echo $rlesson['week']; ?>
				 </td>
				 </tr>
				 
				 
				  <tr>
				  <td style="width: 10mm;  background: #FFFFFF;">
				 Teacher
				 </td>
				 <td style="width: 145mm;  background: #FFFFFF;">
				: <?php echo $rteacher['firstname']; ?>
				 </td>
				 </tr>
				 <?php
				   $sroom="SELECT A.id, A.subject_id, B.name as subject, D.initials as room
					FROM classsubjects A
					join subjects B on (B.id = A.subject_id)
					join classrooms C on (C.id = A.classroom_id)
					join rooms D on (D.id = C.room_id)
					where A.id='".$rlesson['class']."'";

						$qroom=$dbopen->query($sroom); 
						$rroom=$qroom->fetch_assoc();
				 
				 ?>
				  <tr>
				  <td style="width: 30mm;  background: #FFFFFF;">
				 Subject
				 </td>
				 <td style="width: 145mm;  background: #FFFFFF;">
				: <?php echo $rroom['subject']; ?>
				 </td>
				 </tr>
				 
				 <tr>
				  <td style="width: 30mm;  background: #FFFFFF;">
				 Class
				 </td>
				 <td style="width: 145mm;  background: #FFFFFF;">
				: <?php echo $rclass['initials']; ?>
				 </td>
				 </tr>		 
				 </table>

				
<?php 

$arr_days = array("Monday","Tuesday","Wednesday","Thursday","Friday");
$ii = 1;
foreach($arr_days as $rows){
	if($ii==1){$active="active";}else{$active="";}
	
	${'arraypedagogy'.$ii} = '';
	${'arraymaterial'.$ii} = '';
	${'arrayAssessmentBefore'.$ii} ='';
	${'arrayAssessmentDuring'.$ii} = '';
	${'arrayAssessmentAfter'.$ii} = '';
	
		
	${'slesson'.$ii}="SELECT *,left(reflection,4000) reflection1,mid(reflection,4000,4000) reflection2 from objective_day where lessonplan_id = '".$_REQUEST['lpid']."' and day='".$ii."' ";
	${'qlesson'.$ii}=$dbopen->query(${'slesson'.$ii});
	${'rlesson'.$ii}=${'qlesson'.$ii}->fetch_assoc();
	
	${'spedagogy'.$ii}="SELECT * from pedagogy_p where lessonplan_id = '".$_REQUEST['lpid']."' and day_id='".$ii."'";
	${'qpedagogy'.$ii}=$dbopen->query(${'spedagogy'.$ii});
	while(${'rpedagogy'.$ii}=${'qpedagogy'.$ii}->fetch_assoc())
	{
		${'arraypedagogy'.$ii} .= ${'rpedagogy'.$ii}['name'].",";
	}
	
	
	${'smaterial'.$ii}="SELECT * from material_p where lessonplan_id = '".$_REQUEST['lpid']."' and day_id='".$ii."'";
	${'qmaterial'.$ii}=$dbopen->query(${'smaterial'.$ii});
	while(${'rmaterial'.$ii}=${'qmaterial'.$ii}->fetch_assoc())
	{
		${'arraymaterial'.$ii} .= ${'rmaterial'.$ii}['name'].",";
	}
	

	${'sAssessmentBefore'.$ii}="SELECT * from assessment_before_p where lessonplan_id = '".$_REQUEST['lpid']."' and day_id='".$ii."'";
	${'qAssessmentBefore'.$ii}=$dbopen->query(${'sAssessmentBefore'.$ii});
	while(${'rAssessmentBefore'.$ii}=${'qAssessmentBefore'.$ii}->fetch_assoc())
	{
		${'arrayAssessmentBefore'.$ii} .= ${'rAssessmentBefore'.$ii}['name'].",";
		if(${'rAssessmentBefore'.$ii}['descript']!=''){
		${'arrayAssessmentBefore'.$ii}  = ${'rAssessmentBefore'.$ii}['descript'].",";
		}
	}
	

	${'sAssessmentDuring'.$ii}="SELECT * from assessment_during_p where lessonplan_id = '".$_REQUEST['lpid']."' and day_id='".$ii."'";
	${'qAssessmentDuring'.$ii}=$dbopen->query(${'sAssessmentDuring'.$ii});
	while(${'rAssessmentDuring'.$ii}=${'qAssessmentDuring'.$ii}->fetch_assoc())
	{
		${'arrayAssessmentDuring'.$ii} .= ${'rAssessmentDuring'.$ii}['name'].",";
			if(${'rAssessmentDuring'.$ii}['descript']!=''){
		${'arrayAssessmentDuring'.$ii}  = ${'rAssessmentDuring'.$ii}['descript'].",";
		}
	}
	
	
	${'sAssessmentAfter'.$ii}="SELECT * from assessment_after_p where lessonplan_id = '".$_REQUEST['lpid']."' and day_id='".$ii."'";
	${'qAssessmentAfter'.$ii}=$dbopen->query(${'sAssessmentAfter'.$ii});
	while(${'rAssessmentAfter'.$ii}=${'qAssessmentAfter'.$ii}->fetch_assoc())
	{
		${'arrayAssessmentAfter'.$ii} .= ${'rAssessmentAfter'.$ii}['name'].",";
		if(${'rAssessmentAfter'.$ii}['descript']!=''){
		${'arrayAssessmentAfter'.$ii}  = ${'rAssessmentAfter'.$ii}['descript'].",";
		}
	}
	

			
	${'sppt'.$ii}="SELECT * from lp_ppt_p where lp_id = '".$_REQUEST['lpid']."' and day_id='".$ii."'";
	${'qppt'.$ii}=$dbopen->query(${'sppt'.$ii});
	
	${'rowppt'.$ii}=${'qppt'.$ii}->num_rows;
	
	${'svid'.$ii}="SELECT * from lp_vid_p where lp_id = '".$_REQUEST['lpid']."' and day_id='".$ii."'";
	${'qvid'.$ii}=$dbopen->query(${'svid'.$ii});
	${'rowvid'.$ii}=${'qvid'.$ii}->num_rows;
	
	${'spdf'.$ii}="SELECT * from lp_pdf_p where lp_id = '".$_REQUEST['lpid']."' and day_id='".$ii."'";
	${'qpdf'.$ii}=$dbopen->query(${'spdf'.$ii});
	${'rowpdf'.$ii}=${'qpdf'.$ii}->num_rows;
	
	
	
	
		${'assignment'.$ii} = '';
	if(${'rlesson'.$ii}['classwork_assignment'])${'assignment'.$ii}.=${'rlesson'.$ii}['classwork_assignment'].",";
	if(${'rlesson'.$ii}['homework_assignment'])${'assignment'.$ii}.=${'rlesson'.$ii}['homework_assignment'].",";
	if(${'rlesson'.$ii}['lab_assignment'])${'assignment'.$ii}.=${'rlesson'.$ii}['lab_assignment'].",";
	if(${'rlesson'.$ii}['project_assignment'])${'assignment'.$ii}.=${'rlesson'.$ii}['project_assignment'].",";
	
		 
	if(${'rlesson'.$ii}['learning_device']=='1'){${'learning_device'.$ii} ="Using Learning device";} else {${'learning_device'.$ii} ="Not Using learning device";}
	if(${'rlesson'.$ii}['elearning']=='1'){${'elearning'.$ii} ="Using Elearning";} else{ ${'elearning'.$ii} ="Not Using elearning";}

	?>
<table align="center" style="font-size:13px;border-collapse:collapse;border: solid 1px #000000;">
<tr>
	<td colspan="2" class="tdfirst">
		1234567890123
	</td>
</tr>
<tr>	
	<td>Mondayss</td>
	<td>Homeword</td>
</tr>
<tr>	
	<td>Monday</td>
	<td>Homeword</td>
</tr><tr>	
	<td>Monday</td>
	<td>Homeword</td>
</tr>

				 </table>
		<?php		$ii++; 
			}
		?>	
</page>
<?php
    $content = ob_get_clean();

    // convert in PDF
    require_once(dirname(__FILE__).'/../html2pdf.class.php');
    try
    {
        $html2pdf = new HTML2PDF('P', 'A4', 'EN');
		//$html2pdf->setModeDebug();
        $html2pdf->setDefaultFont('Arial');
        $html2pdf->writeHTML($content, isset($_GET['vuehtml']));
        $html2pdf->Output('exemple01.pdf');
    }
    catch(HTML2PDF_exception $e) {
        echo $e;
        exit;
    }
?>
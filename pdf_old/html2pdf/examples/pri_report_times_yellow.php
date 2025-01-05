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

    </style>

<?php
$tgl = '';
$ay = $_POST['ay'];
$term = $_POST['term'];
$class = $_POST['class_id'];
$student = $_POST['student_id'];
 
	
$name_pdf = "REPORT_Yellow_Form_";
 
$ayx = $ay-1;		
	
 if($_POST['term']=='1'){
	$interm = "07,08,09";
	
}else if($_POST['term']=='2'){
	$interm = "10,11,12";
	
}else    if($_POST['term']=='3'){
	$interm = "01,02,03";
	
}else    if($_POST['term']=='4'){
	$interm = "04,05,06";
	
}else    if($_POST['term']=='1-2'){
	$interm = "'07','08','09','10','11','12'";
	
}else    if($_POST['term']=='3-4'){
	$interm = "'01','02','03','04','05','06'";
	
}

$datenow = date("d-F-Y");
 
  
				$gett = " SELECT  concat(b.firstname,' ',b.lastname) namet,c.name room from classrooms a 
				left join profiles b on a.staff_id=b.id 
				left join rooms c on a.room_id=c.id
				where a.academicyear_id='".$ay."' and a.room_id='".$class."' ";
			 
				$sgett = $db->query($gett);	
				 

				 $rgett = $sgett->fetch_assoc();
 

echo"<page backtop='29mm' backbottom='-1mm' backleft='-1mm' backright='-1mm'>
			<page_header>
			<table   style='margin-left:100px;' >";
							echo"<tr >";
			echo"<td ><img src='bbsrc.jpg'style='width:100px;'></td>
			 
			<td>&nbsp;</td><td>&nbsp;</td>
			<td  ><span   style='font-size:16px; ' ><b>Bina Bangsa School - Kebon Jeruk Primary </b><br> <span style='font-size:14px;'>20".$ayx." - 20".$ay."  <br>".$rgett['room']."<br> <b>Summary of Individual Offences <br> Term ".$_POST['term']." </b></span> </span></td>
			 ";
							
								
			echo"</tr>
			
			</table></page_header>";
			
			echo'<br>';
		 
			echo" <table    style='font-size:12px;margin-left:50px; border-collapse: collapse;border:1px solid black; '  ><tr><td>";
			
				echo "Teacher : ".$rgett['namet']."";
				
				echo"</td></tr></table>";
							echo" <table    style='font-size:12px;margin-left:50px; border-collapse: collapse;border:1px solid black; '  ><thead>";
					
					
					
					echo"<tr align='center'  >";
					
					 echo"<td  style='width:25x;border-top: solid 1px #000000; border-right: solid 1px #000000; border-bottom: solid 1px #000000; border-left: solid 1px #000000;  background: #f5f5f5'>No</td>";
				 echo"<td   style='width:200px;border-top: solid 1px #000000; border-right: solid 1px #000000; border-bottom: solid 1px #000000; border-left: solid 1px #000000;  background: #f5f5f5'>Name</td>";
		
 	 	$getcat = " SELECT   * from discipline_pri_cat order by description asc ";
			 
				$getcatx = $db->query($getcat);	
				 

				while($rcat = $getcatx->fetch_assoc() )
				{

		echo"<td   style='width:70px;border-top: solid 1px #000000; border-right: solid 1px #000000; 
		border-bottom: solid 1px #000000; border-left: solid 1px #000000;  background: #f5f5f5'>".$rcat['description']."</td>";
				}
 
			  		echo"<td   style='width:100px;border-top: solid 1px #000000; border-right: solid 1px #000000; 
		border-bottom: solid 1px #000000; border-left: solid 1px #000000;  background: #f5f5f5'>Total</td>";
					echo"</tr>";
				 
					
					
					echo"</thead> <tbody>";
					
			$i=1;
		
 
		 	 	$gdate2 = " 
SELECT  i.name department,h.name subject,concat(g.firstname) teacher,concat(f.firstname,' ',f.lastname) student,e.initials room,d.initials,a.*,f.id as student_id,

case  when  substring(a.date,6,2) in ('07','08','09') then '1' when substring(a.date,6,2) in ('10','11','12') then '2' when substring(a.date,6,2) in ('01','02','03') then '3' when substring(a.date,6,2) in ('04','05','06') then '4' end  as term
 FROM  classstudents b
left join (select * from `discipline_yellowform`  where ay='".$ay."' and substring( date,6,2) in (".$interm.")  ) a  on a.student_id=b.student_id 
left join classrooms c on c.id=b.classroom_id
left join levels d on d.id=c.level_id
left join rooms e on e.id=c.room_id
left join profiles f on f.id=b.student_id

left join profiles g on g.id=a.teacher_id

left join subjects h on h.id=a.subject_id
left join academicdepartments i on i.id=h.academicdepartment_id 
where b.academicyear_id='".$ay."'  and c.room_id='".$class."' 
group by f.id
order by id desc


				";
			//and substring(a.date,6,2) in (".$interm.") 
				
				//die($gdate2);
				$getdate2 = $db->query($gdate2);	
				$total_point = 0;

				while($rdate2 = $getdate2->fetch_assoc() )
				{
				 
				echo"<tr>";
				echo"<td align='center' style='width:40px;height:20px;text-align:center;border-top: solid 1px #000000; border-right: solid 1px #000000; border-bottom: solid 1px #000000; border-left: solid 1px #000000;  background: #f5f5f5'>".$i." </td>";
			 	echo"<td style='border-top: solid 1px #000000; border-right: solid 1px #000000; border-bottom: solid 1px #000000; border-left: solid 1px #000000;  background: #f5f5f5'>".$rdate2['student']." </td>";
				
				$getcat2 = " SELECT  * from discipline_pri_cat order by description asc ";
				$getcatx2 = $db->query($getcat2);	
				while($rcat2 = $getcatx2->fetch_assoc() )
				{
			 	 $getsum = " SELECT  count(*) times from discipline_pri_yellowform  a 
				left join (select a.* from discipline_pri_subcat a left join discipline_pri_cat b on a.cat_id=b.id ) b on a.code=b.code
				
				where b.cat_id='".$rcat2['id']."' and student_id='".$rdate2['student_id']."'  "; 
				$getsum2 = $db->query($getsum);	
				 $rsum = $getsum2->fetch_assoc();
				echo"<td align='center' style='height:20px;text-align:center;border-top: solid 1px #000000; border-right: solid 1px #000000; 
				border-bottom: solid 1px #000000; border-left: solid 1px #000000;  background: #f5f5f5'> ".$rsum['times']." </td>";
				 ${'total'.$rdate2['student_id']} = ${'total'.$rdate2['student_id']} + $rsum['times'] ;
				}
				
				echo"<td align='center' style='text-align:center;border-top: solid 1px #000000; border-right: solid 1px #000000; 
				border-bottom: solid 1px #000000; border-left: solid 1px #000000;  background: #f5f5f5'> ".${'total'.$rdate2['student_id']}." </td>";
			 	echo"</tr>";
				
				 
				$i++;
				}
					
				//echo"<tr><td colspan='9'>TOTAL POINT</td><td align='center'> </td></tr>"	;
					
				  //END OF WHILE
				
			echo"</tbody></table><br><br>"; 
			
				 //end of while
			 
			
			echo" <table    style='font-size:12px;margin-left:50px; border-collapse: collapse;border:1px solid black; '  >";
			echo"<tr><td>";
			echo "_______________________________________________________";
			echo"</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>";
			echo "_________________________";
			echo"</td></tr>";
			echo"<tr><td style='text-align:center;'>";
			echo "Form Teacher's Name and Signature";
			echo"</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td style='text-align:center;'>";
			echo "Date";
			echo"</td></tr>";
			echo"</table>";
			
			
			
			
			
			
			
			
			echo"</page>";


 
	?>
	
	
<?php

    $content = ob_get_clean();

    // convert in PDF
    require_once(dirname(__FILE__).'/../html2pdf.class.php');
    try
    {
        $html2pdf = new HTML2PDF('P', 'A4', 'en', true, 'UTF-8', array(2, 10, 2, 2));
		$html2pdf->setTestTdInOnePage(false);
        $html2pdf->writeHTML($content, isset($_GET['vuehtml']));
        $html2pdf->Output(''.$name_pdf.'.pdf');
		
    }
    catch(HTML2PDF_exception $e) {
        echo $e;
        exit;
    }
?>
	

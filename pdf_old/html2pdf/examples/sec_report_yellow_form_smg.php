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
 
  
 
 
 
			if(!isset($_POST['student_id']) || $_POST['student_id']==''){
				 $kondisi = "";
			}else{
				$kondisi = " and a.student_id='".$_POST['student_id']."'";
			}
				if($_POST['term']==''){
	$gclass = "
				SELECT concat(b.firstname,' ',b.lastname) name , a.student_id 
												FROM `discipline_smg_sec_yellowform` a
												left join profiles b on a.student_id=b.id 
												left join (select b.*,a.student_id from classstudents a left join classrooms b on a.classroom_id=b.id where b.academicyear_id='".$_POST['ay']."' )   c on a.student_id=c.student_id   
												where a.ay='".$ay."'  ".$kondisi."
												and c.room_id='".$class."' group by a.student_id 
				
				
				";
}
else
{
				$gclass = "
				SELECT concat(b.firstname,' ',b.lastname) name , a.student_id 
												FROM `discipline_smg_sec_yellowform` a
												left join profiles b on a.student_id=b.id 
												left join (select b.*,a.student_id from classstudents a left join classrooms b on a.classroom_id=b.id where b.academicyear_id='".$_POST['ay']."' )   c on a.student_id=c.student_id   
												where a.ay='".$ay."' and substring(a.date,6,2) in (".$interm.")   ".$kondisi."
												and c.room_id='".$class."' group by a.student_id 
				
				
				";
}
 
				$getclass = $db->query($gclass);	
				 

				while($rclass = $getclass->fetch_assoc() )
				{
 
 

echo"<page backtop='29mm' backbottom='-1mm' backleft='-1mm' backright='-1mm'>
			<page_header>
			<table   style='margin-left:100px;' >";
							echo"<tr >";
			echo"<td ><img src='bbsrc.jpg'style='width:100px;'></td>
			 
			<td>&nbsp;</td><td>&nbsp;</td>
			<td  ><span   style='font-size:16px; ' ><b>Bina Bangsa School - Semarang Secondary </b><br> Discipline Report Term ".$_POST['term']." ( 20".$ayx."/20".$ay." )</span></td>
			 ";
							
								
			echo"</tr>
			
			</table></page_header>";
			
			
			if($_POST['term']=='1'){
				$term='2';
			}
			else if($_POST['term']==''){
				$term='1,2,3,4';
			}
			else{
				$term= $_POST['term'];
			}
			
			
			echo"<table   style='margin-left:100px;' ><tr>
			<td style='width:950px;' colspan='2'>
			<b>Dear Parent,</b><br>
			<p>This is a report showing all discipline details for Term ".$term.", Year 20".$ayx."/20".$ay.". This has been update to ".$datenow.". The school would like to emphasize that the discipline system is proving to  
			be an exellent way to communicate and convey information to the parents using the yellow discipline notice. We appreciate your support and if you have questions please call the school at (021) 588 0045. 
			</p>
			<i>
			<b>Yang terhormat Orang tua Murid,</b></i><br>
			<p><i>Berikut adalah Laporan Disiplin Term ".$term." putra/putri Bapak/Ibu untuk tahun ajaran 20".$ayx."/20".$ay.". Laporan disiplin ini telah di-update sampai tanggal ".$datenow.". sekolah ingin menunjukan bahwa sistem 
			disipline yang di terapkan sekolah terbukti merupakan cara yang efektif memberikan informasi ke Orang tua Murid melalui Formulir Pelanggaran Disiplin(Form Kuning). Kami sangat menghargai 
			dukungan Bapak/Ibu dan jika Bapak/Ibu memiliki pertanyaan, Bapak/Ibu dapat menghubungi sekolah di nomor telepon (021) 5880045.
			</i>
			</p>
			</td>
			 
			
			</tr>
			<tr>
			<td style='width:950px;'  colspan='2'>
			&nbsp;
			</td>
			</tr>
			<tr>
			<td style='width:950px;'  colspan='2'>
			Submitted : Discipline Committee
			</td>
		 
			</tr>
			
			<tr>
			<td  >
			<b>Discipline File - Complete Entries 20".$ayx."/20".$ay." </b>
			</td>
			<td align='right'>
			<b>Updated to  ".$datenow." </b>
			</td>
			</tr>
			</table>";
			
			
				
					echo" <table    style='font-size:12px;margin-left:100px; '  ><thead>";
					echo"<tr align='center'  >";
					
					 
					echo"<td style='width:80px;border-collapse: collapse;border-top:1px solid black;border-bottom:1px solid black;'>Class</td>";
					echo"<td style='width:150px;border-collapse: collapse;border-top:1px solid black;border-bottom:1px solid black;'>Name</td>";
					 echo"<td style='width:50px;border-collapse: collapse;border-top:1px solid black;border-bottom:1px solid black;'>Offence</td>";
					echo"<td style='width:80px;border-collapse: collapse;border-top:1px solid black;border-bottom:1px solid black;'>Date</td>";
					echo"<td style='width:50px;border-collapse: collapse;border-top:1px solid black;border-bottom:1px solid black;'>Term</td>";
					echo"<td style='width:220px;border-collapse: collapse;border-top:1px solid black;border-bottom:1px solid black;'>Details</td>";
 
					echo"<td style='width:120px;border-collapse: collapse;border-top:1px solid black;border-bottom:1px solid black;'>Authority</td> ";
 
					echo"<td style='width:50px;border-collapse: collapse;border-top:1px solid black;border-bottom:1px solid black;'>Point</td> ";
			  
					echo"</tr>";
				 
					
					
					echo"</thead>";
					
			$i=1;
		
 	if($_POST['term']==''){
		$gdate2 = " 
SELECT   concat(g.firstname) teacher,concat(f.firstname,' ',f.lastname) student,e.initials room,d.initials,a.*,h.description category
  FROM `discipline_smg_sec_yellowform` a 
left join classstudents b on a.student_id=b.student_id 
left join classrooms c on c.id=b.classroom_id
left join levels d on d.id=c.level_id
left join rooms e on e.id=c.room_id
left join profiles f on f.id=b.student_id

left join profiles g on g.id=a.teacher_id
left join (select b.*,a.code from discipline_smg_sec_subcat  a left join discipline_smg_sec_cat b on a.cat_id=b.id ) h on a.code=h.code
 
where b.academicyear_id='".$ay."' and a.student_id='".$rclass['student_id']."'  
group by a.id
order by id desc


				";
	}
	else
	{
				 $gdate2 = " 
SELECT   concat(g.firstname,' ',g.lastname) teacher,concat(f.firstname,' ',f.lastname) student,e.initials room,d.initials,a.*,h.description category

 FROM `discipline_smg_sec_yellowform` a 
left join classstudents b on a.student_id=b.student_id 
left join classrooms c on c.id=b.classroom_id
left join levels d on d.id=c.level_id
left join rooms e on e.id=c.room_id
left join profiles f on f.id=b.student_id
left join profiles g on g.id=a.teacher_id
left join (select b.*,a.code from discipline_smg_sec_subcat  a left join discipline_smg_sec_cat b on a.cat_id=b.id ) h on a.code=h.code
 
where b.academicyear_id='".$ay."' and a.student_id='".$rclass['student_id']."'   and substring(a.date,6,2) in (".$interm.")
group by a.id
order by id desc


				";
	}
				
				
				$getdate2 = $db->query($gdate2);	
				$total_point = 0;

				while($rdate2 = $getdate2->fetch_assoc() )
				{
				 
				echo"<tr>";
				echo"<td align='center'>".$rdate2['room']." </td>";
				echo"<td>".$rdate2['student']." </td>";
				echo"<td align='center'>".$rdate2['category']." </td>";
				echo"<td>".$rdate2['date']." </td>";
				echo"<td align='center'>".$rdate2['term']." </td>";
				echo"<td>".wordwrap($rdate2['offence_details'],50,"<br>\n")." </td>";
		 
				echo"<td>".$rdate2['teacher']." </td>";
				 
				echo"<td align='center'>".$rdate2['point']." </td>";
				echo"</tr>";
				
				$total_point =  $total_point + $rdate2['point'];
				$i++;
				}
					
				echo"<tr><td colspan='7'>TOTAL DEMERIT POINT</td><td align='center'>".$total_point."</td></tr>"	;
					
				  //END OF WHILE
				
			echo"</table><br><br>"; 
			
				 //end of while
			 echo"<table   style='margin-left:100px;' ><tr>
			<td style='width:950px;' colspan='2'><b>Deduction - 20".$ayx."/20".$ay." </b>
			</td></tr></table>";
			echo" <table    style='font-size:12px;margin-left:100px; '  ><thead>";
					echo"<tr align='center'  >";
					
					 
					echo"<td style='width:80px;border-collapse: collapse;border-top:1px solid black;border-bottom:1px solid black;'>Class</td>";
					echo"<td style='width:200px;border-collapse: collapse;border-top:1px solid black;border-bottom:1px solid black;'>Name</td>";
 
					echo"<td style='width:100px;border-collapse: collapse;border-top:1px solid black;border-bottom:1px solid black;'>Date</td>";
					echo"<td style='width:50px;border-collapse: collapse;border-top:1px solid black;border-bottom:1px solid black;'>Term</td>";
					echo"<td style='width:220px;border-collapse: collapse;border-top:1px solid black;border-bottom:1px solid black;'>Details</td>";
					echo"<td style='width:120px;border-collapse: collapse;border-top:1px solid black;border-bottom:1px solid black;'>Authority</td> ";
 
					echo"<td style='width:50px;border-collapse: collapse;border-top:1px solid black;border-bottom:1px solid black;'>Point</td> ";
			  
					echo"</tr>";
				 
					
					
					echo"</thead>";
					
			$i=1;
		
 	if($_POST['term']==''){
		$gdate21 = " 
SELECT  concat(g.firstname) teacher,concat(f.firstname,' ',f.lastname) student,e.initials room,d.initials,a.*

  FROM `discipline_smg_sec_deduction` a 
left join classstudents b on a.student_id=b.student_id 
left join classrooms c on c.id=b.classroom_id
left join levels d on d.id=c.level_id
left join rooms e on e.id=c.room_id
left join profiles f on f.id=b.student_id

left join profiles g on g.id=a.teacher_id
 
where b.academicyear_id='".$ay."' and a.student_id='".$rclass['student_id']."' 

order by id desc


				";
	}
	else
	{
				 $gdate21 = " 
SELECT   concat(g.firstname) teacher,concat(f.firstname,' ',f.lastname) student,e.initials room,d.initials,a.*

 FROM `discipline_smg_sec_deduction` a 
left join classstudents b on a.student_id=b.student_id 
left join classrooms c on c.id=b.classroom_id
left join levels d on d.id=c.level_id
left join rooms e on e.id=c.room_id
left join profiles f on f.id=b.student_id
left join profiles g on g.id=a.teacher_id

 
where b.academicyear_id='".$ay."' and a.student_id='".$rclass['student_id']."'   and substring(a.date,6,2) in (".$interm.")

order by id desc


				";
	}
				
				
				$getdate21 = $db->query($gdate21);	
				$total_point1 = 0;

				while($rdate21 = $getdate21->fetch_assoc() )
				{
				 
				echo"<tr>";
				echo"<td align='center'>".$rdate21['room']." </td>";
				echo"<td>".$rdate21['student']." </td>";
	 
				echo"<td>".$rdate21['date']." </td>";
				echo"<td align='center'>".$rdate21['term']." </td>";
				echo"<td>".wordwrap($rdate21['offence_details'],50,"<br>\n")." </td>";
	 
				echo"<td>".$rdate21['teacher']." </td>";
	 
				echo"<td align='center'>".$rdate21['point']." </td>";
				echo"</tr>";
				
				$total_point1 =  $total_point1 + $rdate21['point'];
				$i++;
				}
					
				echo"<tr><td colspan='6'>TOTAL MERIT POINT</td><td align='center'>".$total_point1."</td></tr>"	;
					$ttotal = $total_point - $total_point1;
				  //END OF WHILE
				  echo"<tr><td colspan='6'>&nbsp;</td></tr>"	;
				echo"<tr><td colspan='6'>TOTAL POINT</td><td align='center'>".$ttotal."</td></tr>"	;
			echo"</table><br><br>"; 		
			
			
			 //end of while
			
			
			
			
			
			echo"</page>";


}
	?>
	
	
<?php

    $content = ob_get_clean();

    // convert in PDF
    require_once(dirname(__FILE__).'/../html2pdf.class.php');
    try
    {
        $html2pdf = new HTML2PDF('L', 'A4', 'en', true, 'UTF-8', array(4, 2, 10, 10));
		$html2pdf->setTestTdInOnePage(false);
        $html2pdf->writeHTML($content, isset($_GET['vuehtml']));
        $html2pdf->Output(''.$name_pdf.'.pdf');
		
    }
    catch(HTML2PDF_exception $e) {
        echo $e;
        exit;
    }
?>
	

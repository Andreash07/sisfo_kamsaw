<?php
    ob_start();
	require('../../../con/dblink_ais.php');
	//$classid= 387; //JC1 ZEAl
	//$classid = 431; //rooms id
	$classid = base64_decode($_GET['classid']);
	//$classid = 284; //Primary 1 Charity KJ
	$db = db_open();
	if(!$db->autocommit(FALSE)){
		//db_error($json,$db,'Unable to start transaction',100,"");
	}	
	//GET principal and Form TEacher
	$qp = "SELECT A.id as Classroom_id,A.room_id as room_id, CONCAT(C.firstname,' ',C.lastname) AS principal, C.title as ptitle, CONCAT(D.firstname,' ',D.lastname) AS formteacher, D.title as ftitle,E.staff_id
		FROM classrooms A 
        JOIN camps E ON(E.id = A.camp_id)
        JOIN profiles D ON (D.id = A.staff_id)
        JOIN profiles C ON (C.id = E.staff_id )
		WHERE A.academicyear_id =16 AND A.room_id = '$classid'";
	
	$sp = $db->query($qp);
	while($rp = $sp->fetch_assoc())
	{
		$room_id = $rp['room_id'];
		$classroomid = $rp['Classroom_id'];
		if($rp['ptitle']==1)
		{
			$principal = 'Mr. '.$rp['principal'];
		}
		else
		{
			$principal = 'Ms. '.$rp['principal'];
		}
		if($rp['ftitle']==1)
		{
			$formteacher = 'Mr. '.$rp['formteacher'];
		}
		else
		{
			$formteacher = 'Ms. '.$rp['formteacher'];
		}
		 
	}
		

	$sql = "SELECT CONCAT( C.firstname,  ' ', C.lastname ) AS Student_Name, C.id as Student_ID, D.id as Subject_ID, D.name AS Subject, G.name as Class, H.initials as Cohort, F.id as campusid, F.name AS Campus, A.ct1 as BMT1, A.cat1 as CAT1, A.mye AS MYE, A.ca1 as CA1, round(A.sa1,2) AS SA1,
P.firstname as Teacher, P.user_id as Teacher_ID,E.lock1 as lock1,E.lock2 as lock2,E.lock3 as lock3,E.lock4 as lock4,A.id as recid,A.ct2 as BMT2, A.ca2 as CAT3,
A.fye as FYE,A.ca2 as CA2, A.sa2 as SA2, A.fya as FA
FROM enrolls A
JOIN students B ON ( B.id = A.student_id ) 
JOIN profiles C ON ( C.id = B.profile_id ) 
JOIN subjects D ON ( D.id = A.subject_id ) 
JOIN classsubjects E ON ( E.id = A.classsubject_id ) 
JOIN camps F ON ( F.id = E.camp_id )
JOIN rooms G ON ( G.id = E.room_id )
JOIN levels H ON ( H.id = E.level_id )
JOIN profiles P ON(P.user_id = E.staff_id)
WHERE E.academicyear_id =16 AND D.category=1 AND G.id = '".$room_id."'
GROUP BY C.id
ORDER BY C.firstname
";

	$s = $db->query($sql);

	while($r = $s->fetch_assoc())
	{
		$studentid = $r['Student_ID'];
		//GET student CODe for STUDENT ID display
		$getcode = "SELECT * FROM students where profile_id='$studentid'";
		$scode = $db->query($getcode);
		while($rcode = $scode->fetch_assoc())
		{
			$student_code = $rcode["code"];
		}
		$studentname = $r['Student_Name'];
		$classname = $r['Class'];
		$campus = $r['Campus'];
		$campusid = $r['campusid'];
		

	?>
		<style type="text/css">
		.bbslogo
		{
			width: 150px;
			height: 130px;
		}
		#sname
		{
			font-size: 14px;
			
		}
		#header
		{
			font-size: 16px;
			text-align: center;
			line-height: 150%;
			font-weight: bold
			
		}
		
		
		.needspace{
			width: 460px;
		}
		.tabletop{
			
			width: 50%;
			}
					
			
		
		.tablerem
		{
			width: 50%;
			
		}
		.tablerem td{
			text-align: center;
			 
		}
		
		.tablegrade{
			
			width: 80%;
			 border-collapse: collapse;
			 padding: 5px;
			 font-size: 12px;
			}
			.tablegrade th
			{
				text-align: center;
				border: 1px solid black;
				padding: 5px;
				font-size: 14px;
			}
			.tablegrade td, 
			{
				border: 1px solid black;
				padding: 5px;
				
				
			}
			
		#conduct
		{
			font-weight: bold;
			line-height: 200%;
		}		
		#remtitle
		{
			font-weight: bold;
			line-height: 150%;
		}	
		
		#rem
		{
			font-style: italic;
		}		
		#legend
		{
			font-size: 10px;
			font-style: italic;
		}
		
		
	</style>
   <page backleft="15mm" backright="5mm"> 
	 <p align="center"><img class="bbslogo" src="bbsrc.jpg" alt="bbslog"></p>
	 
   <div id="header">
		<?php echo($campus."<br>Progress Report - Term 3"."<br>"."March 2016"); ?> 
		
	</div>
    <br><br>
    
	<div id="sname">
		<table class="tabletop">
		<tr>
			<td>Name:</td>
			<td class="needspace"><?php echo($studentname); ?></td>
			<td>Student's ID:</td>
			<td><?php echo($student_code); ?></td>
		</tr>
		<tr>
			<td>Class:</td>
			<td  class="needspace"><?php echo($classname); ?></td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
		</tr>
		</table>
	</div>
	<h2>Academic - Continuous Assessment (CA)</h2>
	<table class="tablegrade">
		<tr>
			<th style='text-align: center; width: 140px;'  rowspan="2">Subject</th>
			<th style='width: 140px;' colspan="2">Progress Report Term 3 CA</th>
		</tr>
		<tr>
			<th style='text-align: center; width: 140px;'>Mark</th>
			<th style='text-align: center; width: 140px;'>Level Average</th>
		</tr>

       <?php 
			
            //Mark Academic
             $qs = "SELECT CONCAT( C.firstname,  ' ', C.lastname ) AS Student_Name, C.id as Student_ID, D.initials as bahasalevel, D.id as Subject_ID, D.name AS Subject, G.initials as Class, H.initials as Cohort,F.initials AS Campus, A.ct1 as BMT1, A.cat1 as CAT1, A.mye AS MYE, A.ca1 as CA1, round(A.sa1,2) AS SA1,
P.firstname as Teacher, P.user_id as Teacher_ID,E.lock1 as lock1,E.lock2 as lock2,E.lock3 as lock3,E.lock4 as lock4,A.id as recid,A.ct2 as BMT2, A.cat3 as CAT3,
A.fye as FYE,A.ca2 as CA2, A.sa2 as SA2, A.fya as FA,H.id as levelid,H.chineselevel_id as chineselevelid
FROM enrolls A
JOIN students B ON ( B.id = A.student_id ) 
JOIN profiles C ON ( C.id = B.profile_id ) 
JOIN subjects D ON ( D.id = A.subject_id ) 
JOIN classsubjects E ON ( E.id = A.classsubject_id ) 
JOIN camps F ON ( F.id = E.camp_id )
JOIN rooms G ON ( G.id = E.room_id )
JOIN levels H ON ( H.id = E.level_id )
JOIN profiles P ON(P.user_id = E.staff_id)
WHERE E.academicyear_id =16 AND D.category=1 AND C.id = '".$studentid."' and A.cat3>0
ORDER BY D.priority";
            
			$sum = 0;
			$ss = $db->query($qs);
			$numsub = $ss->num_rows;
             while($rs = $ss->fetch_assoc())
				{
					//GET LEVEL AVERAGE
					$subjectid = $rs['Subject_ID'];
					$chineselevel = $rs['chineselevelid'];
					$levelid = $rs['levelid'];
					$cat3 = $rs['CAT3'];
					$subject = $rs["Subject"];
					$bahasalevel = $rs['bahasalevel'];
					
					//GET CHINESE DISCOUNT FOR AVERAGE (Secondary)
					if((substr($subject,0,8) == 'Mandarin') || (substr($subject,0,7) == 'Chinese'))
					{
						//GET CHINESE DISCOUNT FOR AVERAGE (Secondary)
					if((substr($subject,0,8) == 'Mandarin') || (substr($subject,0,7) == 'Chinese'))
					{
						//GET chineselevels priority by ID
						
						$qchi = "SELECT * FROM chineselevels where id = '$chineselevel'";
						$schi = $db->query($qchi);
						while($rchi = $schi->fetch_assoc())
						{
							$classchinese = $rchi['priority'];
						}
						
						//GET chineselevels priority by name
						$qchi2 = "SELECT * FROM chineselevels where name = '$subject'";
						$schi2 = $db->query($qchi2);
						while($rchi2 = $schi2->fetch_assoc())
						{
							$enrollchinese = $rchi2['priority'];
						}
						
						
						
						
						$x = $classchinese - $enrollchinese;
						
						if($x>=0)
							$chinesedrop = (100 - ($x * 5)) / 100;
						else
							$chinesedrop = (100 - 0) / 100;
						
						$sum += $chinesedrop * $cat3;
					}
					elseif($bahasalevel=='BIN.L1'){
						$bahasadrop = 85/100;
						$sum += $bahasadrop * $cat3;
					} else if($bahasalevel=='BIN.L2'){
						$bahasadrop = 90/100;
						$sum += $bahasadrop * $cat3;
					} else if($bahasalevel=='BIN.L3'){ 
						$bahasadrop = 95/100;
						$sum += $bahasadrop * $cat3;
					}
					else
					{
						$sum += $cat3;
					}
                
					$check = "SELECT * FROM level_averages WHERE camp_id='".$campusid."' and subject_id='".$subjectid."' and level_id='".$levelid."'";
					$scheck = $db->query($check);
					if($scheck->num_rows > 0)
					{
						while($rcheck= $scheck->fetch_assoc())
						{
							$level_average = $rcheck["average"];
						}
					}
					else
					{
						$level_average = 0;
					}
					//Filter for General Paper
					if($subject=="General Paper")
					{
						$subject = "English (General Paper)";
					}
					echo("<tr>");
						echo("<td style='width: 270px;'>");
						echo($subject);
						//echo('Information and Communication Technology');
						echo("</td>");
						echo("<td style='text-align: center;width: 80px;'>");
						echo(round($cat3).'%');
						echo("</td>");
						echo("<td  style='text-align: center;width: 105px;'>");
						echo($level_average.'%');
						echo("</td>");
						
					echo("</tr>");
				}
				//COmpute for WeightedAverage
				if($numsub>0)
					$wavg = round(($sum / $numsub),2);
				else
					$wavg = 0;
		   echo('</table>');
		   
		   //NON ACADEMIC
		   ?>
		    <table class="tablegrade">
		
		<tr>
			<th style='text-align: left; width: 270px;'>Weighted Average: </th>
			<td style='text-align: center; width: 140px; font-size: 14px; font-weight: bold'>
				<?php echo($wavg.'%'); ?>
			</td>
		</tr>
		</table>
		  
		   <?php
		   //GET Total Attendance
		   $qatt = "SELECT * FROM attendances WHERE academicyear_id = 16 and camp_id = '$campusid'";
		   $satt = $db->query($qatt);
		   while($ratt = $satt->fetch_assoc())
		   {
			   $total_att = $ratt['t3']; //Term3
		   }
		   //GET Conduct and Remarks
		   $qr = "SELECT * FROM classstudents WHERE student_id = '$studentid' and classroom_id='$classroomid'";
		   $sr = $db->query($qr);
		   while($rs = $sr->fetch_assoc())
		   {
			   $conduct = $rs['conduct3'];
			   $remark = $rs['remark2'];
			   $att = $rs['att3'];
			   $avg = $rs['avg3'];
			    switch($conduct)
			   {
				   case "A":
					$conduct = $conduct.'(Excellent)';
					break;
					case "B":
					$conduct = $conduct.'(Good)';
					break;
					case "C":
					$conduct = $conduct.'(Satisfactory)';
					break;
					case "D":
					$conduct = $conduct.'(Needs Improvement)';
					break;
			   }
		   }
		 
		   ?>
		   <table class="tableatt">
		<tr>
			<th style='text-align: left;'>Attendance: </th>
			<td style='text-align: left; width: 330px;'><?php echo($att.'/'.$total_att); ?></td>
			<th style='text-align: left;;'>Conduct: </th>
			<td style='text-align: left; width: 100px;'><?php echo($conduct); ?></td>
		</tr>
		</table>
		   
		   <table class="tablegrade">
		
		<tr>
			<th style='text-align: left; width: 270px;'>Non Academic</th>
			<th style='text-align: center; width: 140px;'>Grade</th>
		</tr>

       <?php 
			
            //NON Academic GRADE Academic
             $qsn = "SELECT CONCAT( C.firstname,  ' ', C.lastname ) AS Student_Name, C.id as Student_ID, D.id as Subject_ID, D.name AS Subject, G.initials as Class, H.initials as Cohort, F.initials AS Campus, A.ct1 as BMT1, A.cat1 as CAT1, A.mye AS MYE, A.ca1 as CA1, round(A.sa1,2) AS SA1,
P.firstname as Teacher, P.user_id as Teacher_ID,E.lock1 as lock1,E.lock2 as lock2,E.lock3 as lock3,E.lock4 as lock4,A.id as recid,A.ct2 as BMT2, A.ca2 as CAT3,
A.fye as FYE,A.ca2 as CA2, A.sa2 as SA2, A.fya as FA,A.gradet3 as t3non,A.gradet1 as t1non
FROM enrolls A
JOIN students B ON ( B.id = A.student_id ) 
JOIN profiles C ON ( C.id = B.profile_id ) 
JOIN subjects D ON ( D.id = A.subject_id ) 
JOIN classsubjects E ON ( E.id = A.classsubject_id ) 
JOIN camps F ON ( F.id = E.camp_id )
JOIN rooms G ON ( G.id = E.room_id )
JOIN levels H ON ( H.id = E.level_id )
JOIN profiles P ON(P.user_id = E.staff_id)
WHERE E.academicyear_id =16 AND D.category=2 AND C.id = '".$studentid."' and A.gradet3!=''
ORDER BY D.priority";
            
          
			$ssn = $db->query($qsn);
			$numsubn = $ssn->num_rows;
             while($rsn = $ssn->fetch_assoc())
				{
					echo("<tr>");
						echo("<td style='width: 170px;'>");
						echo($rsn["Subject"]);
						echo("</td>");
						echo("<td style='text-align: center;width: 80px;'>");
						echo($rsn["t3non"]);
						echo("</td>");
						
					echo("</tr>");
				}
		//GET CCA
			$qcca = "SELECT C.name as cca, A.gradet3 as ccagrade 
					FROM `members` A
					JOIN clubs B ON(B.id = A.club_id)
					JOIN ccas C ON(C.id = A.cca_id)
					WHERE B.academicyear_id = 16 and B.camp_id = '".$campusid."' and A.student_id = '".$studentid."' and A.gradet3!=''";
					
					$scca = $db->query($qcca);
					$numsubn = $numsubn+$scca->num_rows;
					while($rcca = $scca->fetch_assoc())
					{
						echo("<tr>");
						echo("<td style='width: 170px;'>");
						echo('CCA('.$rcca["cca"].')');
						echo("</td>");
						echo("<td style='text-align: center;width: 80px;'>");
						echo($rcca["ccagrade"]);
						echo("</td>");
						echo("</tr>");
					}
		   echo('</table><br>');

		   echo('<page_footer>');
		   
		   echo('<table class="tablerem">');
			echo('<tr>');
				echo('<td style="width: 250px;">'.$formteacher.'<br>_____________________<br>Form Teacher</td>');
				echo('<td style="width: 250px;">'.$principal.'<br>_____________________<br>Principal</td>');
				echo('<td style="width: 170px;">&nbsp;<br>_____________________<br>Parent</td>');
			echo('</tr>');
		   echo('</table>');
		   echo('</page_footer>');
		   
	?>
	
	</page>
<?php
	}
    $content = ob_get_clean();

    // convert in PDF
    require_once(dirname(__FILE__).'/../html2pdf.class.php');
    try
    {
        $html2pdf = new HTML2PDF('P', 'A4', 'en');
        $html2pdf->writeHTML($content, isset($_GET['vuehtml']));
        $html2pdf->Output('exemple01.pdf');
    }
    catch(HTML2PDF_exception $e) {
        echo $e;
        exit;
    }

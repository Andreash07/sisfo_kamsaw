<?php
    ob_start();
	require('../../../con/dblink_ais.php');
	$classid = base64_decode($_GET['classid']);
	$rankq=array();
	$rank=array();
	$top25 = array();
	$ls_student = array();
	$db = db_open();
	if(!$db->autocommit(FALSE)){
		//db_error($json,$db,'Unable to start transaction',100,"");
	}	
	//GET principal and Form TEacher
	$qp = "SELECT A.level_id as level_id, A.id as Classroom_id, A.academicyear_id, CONCAT(C.firstname,' ',C.lastname) AS principal, C.title as ptitle, CONCAT(D.firstname,' ',D.lastname) AS formteacher, D.title as ftitle,E.staff_id,E.id as camp_id
		FROM classrooms A 
        JOIN camps E ON(E.id = A.camp_id)
        JOIN profiles D ON (D.id = A.staff_id)
        JOIN profiles C ON (C.id = E.staff_id )
		WHERE A.id = '".$classid."'";
	
	$sp = $db->query($qp);
	while($rp = $sp->fetch_assoc())
	{
		$level_id = $rp['level_id'];
		$camp_id = $rp['camp_id'];
		$ay_id = $rp['academicyear_id'];
		//Process Weighted Average of all Students under this level/cohort
		$qall = "SELECT C.firstname as fname, B.code as Student_Code, C.id as Student_ID, D.id as Subject_ID, D.name AS Subject, G.name as Class, H.name as Cohort, F.id as campusid, F.name AS campus, A.ct1 as BMT1, A.cat1 as CAT1, A.mye AS MYE, A.ca1 as CA1, round(A.sa1,2) AS SA1,
				P.firstname as Teacher, P.user_id as Teacher_ID,A.id as recid,X.id as classroom_id
				FROM enrolls A
				JOIN students B ON ( B.id = A.student_id ) 
				JOIN profiles C ON ( C.id = B.profile_id ) 
				JOIN subjects D ON ( D.id = A.subject_id ) 
				JOIN classsubjects E ON ( E.id = A.classsubject_id ) 
				JOIN classrooms X ON(X.id = E.classroom_id)
				JOIN camps F ON ( F.id = E.camp_id )
				JOIN rooms G ON ( G.id = E.room_id )
				JOIN levels H ON ( H.id = E.level_id )
				JOIN profiles P ON(P.user_id = E.staff_id)
				JOIN users Z on (Z.id = B.user_id)
				WHERE E.academicyear_id ='".$ay_id."' AND D.category=1 AND H.id = '".$level_id."' and F.id='".$camp_id."' && Z.status=1
				GROUP BY C.id
				ORDER BY C.firstname";
				$sall = $db->query($qall);
				$total_stud = $sall->num_rows;
				$t25_old = $total_stud*.25;
				$t25 = round($t25_old);
				
				while($rall = $sall->fetch_assoc())
				{
					$studentid = $rall['Student_ID'];
					$cohort = $rall['Cohort'];
					$classroomid = $rall['classroom_id'];
					
					//Mark Academic
					 $qsall = "SELECT A.id as recid, CONCAT( C.firstname,  ' ', C.lastname ) AS Student_Name, C.id as Student_ID, D.initials as bahasalevel, D.id as Subject_ID, D.name AS Subject, G.initials as Class, H.initials as Cohort,F.initials AS Campus, A.ct1 as BMT1, A.cat1 as CAT1, A.mye AS MYE, A.ca1 as CA1, round(A.sa1,2) AS SA1,
					P.firstname as Teacher, P.user_id as Teacher_ID,E.lock1 as lock1,E.lock2 as lock2,E.lock3 as lock3,E.lock4 as lock4,A.id as recid,A.ct2 as BMT2, A.cat3 as CAT3,
					A.fye as FYE,A.ca2 as CA2, A.sa2 as SA2, A.fya as FA,H.id as levelid,H.chineselevel_id as chineselevelid,A.award as Medal
					FROM enrolls A
					JOIN students B ON ( B.id = A.student_id ) 
					JOIN profiles C ON ( C.id = B.profile_id ) 
					JOIN subjects D ON ( D.id = A.subject_id ) 
					JOIN classsubjects E ON ( E.id = A.classsubject_id ) 
					JOIN camps F ON ( F.id = E.camp_id )
					JOIN rooms G ON ( G.id = E.room_id )
					JOIN levels H ON ( H.id = E.level_id )
					JOIN profiles P ON(P.user_id = E.staff_id)
					JOIN users Z on (Z.id = B.user_id)
					WHERE E.academicyear_id ='".$ay_id."' AND D.category=1 AND C.id = '".$studentid."' AND A.fya > 0 and E.classroom_id='".$classroomid."' && Z.status=1
					ORDER BY D.priority";
					$sum = 0;
					$ssall = $db->query($qsall);
					$numsub = $ssall->num_rows;
					
					while($rsall = $ssall->fetch_assoc())
					{
						//GET LEVEL AVERAGE
						$subjectid = $rsall['Subject_ID'];
						$chineselevel = $rsall['chineselevelid'];
						$levelid = $rsall['levelid'];
						$MYE = $rsall['MYE'];
						$CA1 = $rsall['CA1'];
						$FYE = $rsall['FYE'];
						$FA = $rsall['FA'];
						$recid = $rsall['recid'];
						$CA2 = $rsall['CA2'];
						$SA2 = $rsall['SA2'];
						$subject = $rsall["Subject"];
						$bahasalevel = $rsall['bahasalevel'];
						$medal = $rsall['Medal'];
						//FORMULA FOR FA
						//$NewFA = ($CA1*.20)+($MYE*.25)+ ($CA2*.20)+ ($CA1*.35);
						
						
						//GET CHINESE DISCOUNT FOR AVERAGE (Secondary)
						if((substr($subject,0,8) == 'Mandarin') || (substr($subject,0,7) == 'Chinese'))
						{
							//GET chineselevels priority by ID
							
							$qchi = "SELECT * FROM chineselevels where id = '".$chineselevel."'";
							$schi = $db->query($qchi);
							while($rchi = $schi->fetch_assoc())
							{
								if($levelid>=15) //means jc1 or jcb
								{
									$classchinese = $rchi['priority2'];
								}
								else
								{
									$classchinese = $rchi['priority'];
								}
							}
							
							//GET chineselevels priority by name
							$qchi2 = "SELECT * FROM chineselevels where name = '".$subject."'";
							$schi2 = $db->query($qchi2);
							while($rchi2 = $schi2->fetch_assoc())
							{
								$enrollchinese = $rchi2['priority'];
							}
							
							$x = $classchinese - $enrollchinese;
							
							if($x>=0)
							{
								if($x>5)
								{
									$x = 5; //MAX 75%
									$chinesedrop = (100 - ($x * 5)) / 100;
								}
								else
								{
									$chinesedrop = (100 - ($x * 5)) / 100;
								}
							}
							else
							{
								$chinesedrop = (100 - 0) / 100;
							}
							$sum += $chinesedrop * $FA;
						}
						elseif($bahasalevel=='BIN.L1'){
							$bahasadrop = 85/100;
							$sum += $bahasadrop * $FA;
						} else if($bahasalevel=='BIN.L2'){
							$bahasadrop = 90/100;
							$sum += $bahasadrop * $FA;
						} else if($bahasalevel=='BIN.L3'){ 
							$bahasadrop = 95/100;
							$sum += $bahasadrop * $FA;
						}
						else
						{
							$sum += $FA;
						}
					
							$level_average = 0;
						
					} //One Student
					
				//COmpute for WeightedAverage
				if($numsub>0)
					$wavg = round(($sum / $numsub),2);
				else
					$wavg = 0;
				
				//SAVE WeightedAverage
				$qaw = "UPDATE classstudents SET avg4 = '".$wavg."' WHERE student_id = '".$studentid."' and classroom_id='".$classroomid."'";
				$saw = $db->query($qaw);
			} //ALL Student
		

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
		

	$sql = "SELECT C.firstname as fname, CONCAT( C.firstname,  ' ', C.lastname ) AS Student_Name, B.code as Student_Code, C.id as Student_ID, D.id as Subject_ID, D.name AS Subject, G.name as Class, H.name as Cohort, F.id as campusid, F.name AS campus, A.ct1 as BMT1, A.cat1 as CAT1, A.mye AS MYE, A.ca1 as CA1, round(A.sa1,2) AS SA1,
P.firstname as Teacher, P.user_id as Teacher_ID,E.lock1 as lock1,E.lock2 as lock2,E.lock3 as lock3,E.lock4 as lock4,A.id as recid
FROM enrolls A
JOIN students B ON ( B.id = A.student_id ) 
JOIN profiles C ON ( C.id = B.profile_id ) 
JOIN subjects D ON ( D.id = A.subject_id ) 
JOIN classsubjects E ON ( E.id = A.classsubject_id )
JOIN classrooms J ON ( J.id = E.classroom_id )
JOIN camps F ON ( F.id = E.camp_id )
JOIN rooms G ON ( G.id = E.room_id )
JOIN levels H ON ( H.id = E.level_id )
JOIN profiles P ON(P.user_id = E.staff_id)
WHERE J.academicyear_id ='".$ay_id."' AND D.category=1 AND H.id = '".$level_id."' AND F.id = '".$camp_id."'
GROUP BY C.id
ORDER BY C.firstname";

	$s = $db->query($sql);

	while($r = $s->fetch_assoc())
	{
		//reset variable
		$get25='';
		$s25='';
		$r25='';
		//reset variable
		
		$campusid = $r['campusid'];
		$studentid = $r['Student_ID'];
		$fname = $r['fname'];
		//GET Top 3
		$rank[$r['Student_ID']]='';
		$top25[$r['Student_ID']] = '';
		$get25 = "SELECT B.*
					FROM classrooms A
					JOIN classstudents B ON(B.classroom_id = A.id)
					WHERE A.level_id='".$level_id."' and A.academicyear_id='".$ay_id."' and A.camp_id='".$camp_id."' order by B.avg4 desc";
		$s25 = $db->query($get25);
		if($s25->num_rows>0)
		{
			$rankq[$r['Student_ID']] = 0;
			while($r25 = $s25->fetch_assoc())
			{
				$rankq[$r['Student_ID']] = $rankq[$r['Student_ID']] +1;
				$savg4[$r['Student_ID']] = $r25['avg4'];
				if($studentid==$r25['student_id'])
				{
					break;
				}
				
			}
				if(($rankq[$r['Student_ID']] == 1)&& ($savg4[$r['Student_ID']]>0))
				{
					$rank[$r['Student_ID']]=$fname.' is 1st in '.$cohort.' Cohort.';
				}
				else if(($rankq[$r['Student_ID']] == 2)&& ($savg4[$r['Student_ID']]>0))
				{
					$rank[$r['Student_ID']]=$fname.' is 2nd in '.$cohort.' Cohort.';
				}
				else if(($rankq[$r['Student_ID']] == 3)&& ($savg4[$r['Student_ID']]>0))
				{
					$rank[$r['Student_ID']]=$fname.' is 3rd in '.$cohort.' Cohort.';
				}
				else
				{
					$rank[$r['Student_ID']]='';
					if(($rankq[$r['Student_ID']]<=$t25) && ($savg4[$r['Student_ID']]>0))
					{
						$top25[$r['Student_ID']]=$fname." is in top 25% of the ".$cohort.' cohort.';
					}
				}
		}
		
		
		/*$studentcode = $r['Student_Code'];
		$studentname = $r['Student_Name'];
		$classname = $r['Class'];
		$cohort = $r['Cohort'];
		$campusid = $r['campusid'];*/
		$campus = $r['campus'];
		$campus = substr($campus,0,strpos($campus," Secondary"));
	}
	//GET ALL STUDENT ON THE CLASS
	$sqlc = "SELECT C.firstname as fname, CONCAT( C.firstname,  ' ', C.lastname ) AS Student_Name, B.code as Student_Code, C.id as Student_ID, D.id as Subject_ID, D.name AS Subject, G.name as Class, H.name as Cohort, F.id as campusid, F.name AS campus, A.ct1 as BMT1, A.cat1 as CAT1, A.mye AS MYE, A.ca1 as CA1, round(A.sa1,2) AS SA1,
P.firstname as Teacher, P.user_id as Teacher_ID,E.lock1 as lock1,E.lock2 as lock2,E.lock3 as lock3,E.lock4 as lock4,A.id as recid
FROM enrolls A
JOIN students B ON ( B.id = A.student_id ) 
JOIN profiles C ON ( C.id = B.profile_id ) 
JOIN subjects D ON ( D.id = A.subject_id ) 
JOIN classsubjects E ON ( E.id = A.classsubject_id )
JOIN classrooms J ON ( J.id = E.classroom_id )
JOIN camps F ON ( F.id = E.camp_id )
JOIN rooms G ON ( G.id = E.room_id )
JOIN levels H ON ( H.id = E.level_id )
JOIN profiles P ON(P.user_id = E.staff_id)
WHERE J.academicyear_id ='".$ay_id."' AND D.category=1 AND J.id = '".$classid."' AND F.id = '".$camp_id."'
GROUP BY C.id
ORDER BY C.firstname";

	$sc = $db->query($sqlc);

	while($rc = $sc->fetch_assoc())
	{
		$ls_student[]=$rc;
	}
	?>
		<style type="text/css">
		.bbslogo
		{
			width: 120px;
			height: 100px;
		}
		#sname
		{
			font-size: 14px;
			
		}
		#header
		{
			font-size: 14px;
			text-align: center;
			line-height: 120%;
			font-weight: bold
			
		}
		
		
		.needspace{
			width: 280px;
		}
		.tabletop{
			font-size: 12px;
			width: 50%;
			}
					
			
		
		.tablerem
		{
			width: 50%;
			font-size: 12px;
			
		}
		.tablerem td{
			text-align: center;
			
		}
		
		.tablegrade{
			
			font-size: 12px;
			width: 50%;
			border-collapse: collapse;
			 border-spacing: 5px 5px;
			}
			.tablegrade th
			{
				
				text-align: center;
				border-top: 1px solid #000000;
				border-bottom: 1px solid #000000;
				padding-top: 2px;
				padding-bottom: 2px;
				
			}
			.tablegrade td{
				
			}
			
			
		#conduct
		{
			font-weight: bold;
			font-size: 12px;
			line-height: 200%;
		}		
		#remtitle
		{
			font-weight: bold;
			line-height: 150%;
			font-size: 12px;
		}	
		
		#rem
		{
			font-style: italic;
			font-size: 12px;
		}		
		#legend
		{
			font-size: 10px;
			font-style: italic;
		}
		
		
	</style>
 <?php
	foreach($ls_student as $LsStudent){
	?>
	<page backleft="5mm" backright="5mm"> 
	 <p align="center"><img class="bbslogo" src="bbsrc.jpg" alt="bbslog"></p>
   <div id="header">
		<?php echo($campus."<br>".$LsStudent['Cohort']."<br>Academic Transcript"."<br>"."Semester 2"."<br>"."June 20".$ay_id."<br>"); ?> 
	</div>
	<div id="sname">
		<table class="tabletop">
		<tr>
			<td  style="font-weight: bold;">Name:</td>
			<td class="needspace"><?php echo($LsStudent['Student_Name']); ?></td>
			<td style="font-weight: bold;">Student's ID:</td>
			<td><?php echo($LsStudent['Student_Code']); ?></td>
		</tr>
		<tr>
			<td style="font-weight: bold;">Class:</td>
			<td  class="needspace"><?php echo($LsStudent['Class']); ?></td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
		</tr>
		</table>
	</div>
	
	<table class="tablegrade">
		<tr>
			<th style='text-align: left; width: 120px;'>Subject</th>
			<th style='width: 70px;'>CA2<br>(20%)</th>
			<th style='width: 70px;'>Final Exam(35%)</th>
			<th style='width: 70px;'>Sem 2 Mark(55%)</th>
			<th style='width: 70px;'>Final-Year Mark</th>
			<th>Awards</th>
		</tr>
	
       <?php 
			
            //Mark Academic
             $qs = "SELECT A.id as recid, CONCAT( C.firstname,  ' ', C.lastname ) AS Student_Name, C.id as Student_ID, D.initials as bahasalevel, D.id as Subject_ID, D.name AS Subject, G.initials as Class, H.initials as Cohort,F.initials AS Campus, A.ct1 as BMT1, A.cat1 as CAT1, A.mye AS MYE, A.ca1 as CA1, round(A.sa1,2) AS SA1,
			P.firstname as Teacher, P.user_id as Teacher_ID,E.lock1 as lock1,E.lock2 as lock2,E.lock3 as lock3,E.lock4 as lock4,A.id as recid,A.ct2 as BMT2, A.cat3 as CAT3,
			A.fye as FYE,A.ca2 as CA2, A.sa2 as SA2, A.fya as FA,H.id as levelid,H.chineselevel_id as chineselevelid,A.award as Medal,F.id as campusid
			FROM enrolls A
			JOIN students B ON ( B.id = A.student_id ) 
			JOIN profiles C ON ( C.id = B.profile_id ) 
			JOIN subjects D ON ( D.id = A.subject_id ) 
			JOIN classsubjects E ON ( E.id = A.classsubject_id ) 
			JOIN camps F ON ( F.id = E.camp_id )
			JOIN rooms G ON ( G.id = E.room_id )
			JOIN levels H ON ( H.id = E.level_id )
			JOIN profiles P ON(P.user_id = E.staff_id)
			WHERE E.academicyear_id ='".$ay_id."' AND D.category=1 AND C.id = '".$LsStudent['Student_ID']."' AND A.fya > 0 and E.classroom_id='".$classid."'
			ORDER BY D.priority";
		//	die($qs);
            
          
			$sum = 0;
			$ss = $db->query($qs);
			$numsub = $ss->num_rows;
             while($rs = $ss->fetch_assoc())
				{
					//GET LEVEL AVERAGE
					$subjectid = $rs['Subject_ID'];
					$chineselevel = $rs['chineselevelid'];
					$levelid = $rs['levelid'];
					$MYE = $rs['MYE'];
					$CA1 = $rs['CA1'];
					$FYE = $rs['FYE'];
					$FA = $rs['FA'];
					$recid = $rs['recid'];
					$CA2 = $rs['CA2'];
					$SA2 = $rs['SA2'];
					$subject = $rs["Subject"];
					$bahasalevel = $rs['bahasalevel'];
					$medal = $rs['Medal'];
					//FOR NO FYE DUE TO EXCUSED ABSENT
					
					
					//Filter for General Paper
					if($subject=="General Paper")
					{
						//if($campusid!=6)
							$subject = "English (General Paper)";
					}
					echo("<tr>");
						echo("<td style='width: 150px;'>");
						echo($subject);
						//echo('Information and Communication Technology');
						echo("</td>");
						echo("<td style='text-align: center;'>");
						echo(round($CA2).'%');
						echo("</td>");
						if($FYE==-1)
						{
							echo("<td style='text-align: center;'>");
							echo('A');
							echo("</td>");

						}
						else
						{
							echo("<td style='text-align: center;'>");
							echo(round($FYE).'%');
							echo("</td>");
							
						}
						
						echo("<td style='text-align: center;'>");
						echo(round($SA2).'%');
						echo("</td>");
						echo("<td style='text-align: center;'>");
						echo(round($FA).'%');
						echo("</td>");
						echo("<td  style='text-align: center;'>");
						echo($medal);
						//echo('SILVER');
						echo("</td>");
						
					echo("</tr>");
				}
				
		   echo('</table><br>');
		   ?>
		   <table class="tablegrade">
		
		<tr>
			<th style='text-align: left; width: 320px;'>Non Academic</th>
			<th style='text-align: center; width: 170px;'>Grade</th>
		</tr>
		
       <?php 
			
            //NON Academic GRADE Academic
             $qsn = "SELECT CONCAT( C.firstname,  ' ', C.lastname ) AS Student_Name, C.id as Student_ID, D.id as Subject_ID, D.name AS Subject, G.initials as Class, H.initials as Cohort, F.initials AS Campus, A.ct1 as BMT1, A.cat1 as CAT1, A.mye AS MYE, A.ca1 as CA1, round(A.sa1,2) AS SA1,
P.firstname as Teacher, P.user_id as Teacher_ID,E.lock1 as lock1,E.lock2 as lock2,E.lock3 as lock3,E.lock4 as lock4,A.id as recid,A.ct2 as BMT2, A.ca2 as CAT3,
A.fye as FYE,A.ca2 as CA2, A.sa2 as SA2, A.fya as FA,A.gradet3 as t3non,A.gradet1 as t1non,A.grade2 as Grade2
FROM enrolls A
JOIN students B ON ( B.id = A.student_id ) 
JOIN profiles C ON ( C.id = B.profile_id ) 
JOIN subjects D ON ( D.id = A.subject_id ) 
JOIN classsubjects E ON ( E.id = A.classsubject_id ) 
JOIN camps F ON ( F.id = E.camp_id )
JOIN rooms G ON ( G.id = E.room_id )
JOIN levels H ON ( H.id = E.level_id )
JOIN profiles P ON(P.user_id = E.staff_id)
WHERE E.academicyear_id ='".$ay_id."' AND D.category=2 AND C.id = '".$LsStudent['Student_ID']."' and A.grade2 != '' and E.classroom_id='".$classid."'
ORDER BY D.priority";
            
          
			$ssn = $db->query($qsn);
			$numsubn = $ssn->num_rows;
             while($rsn = $ssn->fetch_assoc())
				{
					echo("<tr>");
						echo("<td>");
						echo($rsn["Subject"]);
						echo("</td>");
						echo("<td style='text-align: center;'>");
						echo($rsn["Grade2"]);
						echo("</td>");
						
					echo("</tr>");
				}
		//GET CCA
			$qcca = "SELECT C.name as cca, A.grade2 as ccagrade,  AVG(A.score2) as AVG2
					FROM `members` A
					JOIN clubs B ON(B.id = A.club_id)
					JOIN ccas C ON(C.id = A.cca_id)
					WHERE B.academicyear_id = '".$ay_id."' and B.camp_id = '".$LsStudent['campusid']."' and A.student_id = '".$LsStudent['Student_ID']."' && A.score2!=''";
					//die($qcca);
					
					$scca = $db->query($qcca);
					$numcca=$scca->num_rows;
					$numsubn = $numsubn+$scca->num_rows;
					if($numcca>0){						
						while($rcca = $scca->fetch_assoc())
						{
							//=2 || $campusid==4 || $campusid==6 || $campusid==8 || $campusid==10
							if($rcca["AVG2"]!= NULL){
								if(in_array($LsStudent['campusid'], array(2,4,6,8,10))){
									if(round($rcca["AVG2"]) >=17){
										$grade_cca='A';
									}
									else if(round($rcca["AVG2"]) >=14){
										$grade_cca='B';
									}
									else if(round($rcca["AVG2"]) >=9){
										$grade_cca='C';
									}
									else if(round($rcca["AVG2"]) >=0){
										$grade_cca='D';
									}
								}
							}
							else{
								$grade_cca="-";
							}
						}
						echo("<tr>");
						echo("<td>");
						echo('CCA');
						echo("</td>");
						echo("<td style='text-align: center;'>");
						echo($grade_cca);
						echo("</td>");
						echo("</tr>");
					}
		   echo('</table><hr>');
		   //NON ACADEMIC
		   ?>
		    
		  
		   <?php
		   //GET Total Attendance
		   $qatt = "SELECT * FROM attendances WHERE academicyear_id = '".$ay_id."' and camp_id = '".$LsStudent['campusid']."'";
		   $satt = $db->query($qatt);
		   while($ratt = $satt->fetch_assoc())
		   {
			   $total_att = $ratt['t3']+$ratt['t4']; //sem1
		   }
		   //GET Conduct and Remarks
		   $qr = "SELECT * FROM classstudents WHERE student_id ='".$LsStudent['Student_ID']."' and classroom_id='".$classid."'";
		   $sr = $db->query($qr);
		   while($rs = $sr->fetch_assoc())
		   {
			   $conduct = $rs['conduct4'];
			   $remark = $rs['remark4'];
			   $att = $rs['att3']+$rs['att4'];
			   $avg = $rs['avg4'];
			   $promoted = $rs['promoted'];
			    switch($conduct)
			   {
				   case "A":
					$conduct = $conduct.' (Excellent)';
					break;
					case "B":
					$conduct = $conduct.' (Good)';
					break;
					case "C":
					$conduct = $conduct.' (Satisfactory)';
					break;
					case "D":
					$conduct = $conduct.' (Needs Improvement)';
					break;
			   } 
			   //get attandance
				//==1) || ($campusid==2) || ($campusid==3) || ($campusid==5) || ($campusid==6) || ($campusid==7) || ($campusid==8) || ($campusid==9|| ($campusid==10)
			   if(in_array($LsStudent['campusid'], array(1,2,3,5,6,7,8,9,10)))
			   {
				  $getatt = "SELECT COUNT(student_id) as total FROM attendance_students WHERE att_status NOT IN(1,3,0) and student_id = '".$LsStudent['Student_ID']."' && (date>='20".$ay_id."-01-10' && date<='20".$ay_id."-06-30')";
					$satt = $db->query($getatt);
					
						while($ratt = $satt->fetch_assoc())
						{
							$att = $total_att - $ratt['total'];
						}
			   }	
			   else
			   {
				   $att = $rs['att3']+$rs['att4'];
			   }
		   }
		 
		   ?>
		   <table class="tablegrade">
		
		<tr>
			<td style='text-align: left; width: 120px; font-weight: bold;'>Weighted Average: </td>
			<td style='text-align: left; width: 80px; font-size: 12px; font-weight: bold'>
				<?php echo($avg.'%'); ?>
			</td>
			<td style='text-align: left;font-weight: bold;'>Attendance: </td>
			<td style='text-align: left; width: 60px;'><?php echo($att.'/'.$total_att); ?></td>
			<td style='text-align: left;font-weight: bold;'>Conduct: </td>
			<td style='text-align: left; width: 100px;'><?php echo($conduct); ?></td>
		</tr>
		</table>
		
		   
		<?php
		  // echo('<div id="legend">Mark Range Guide: A*(90-100),A(80-89),B(70-79),C(60-69),D(50-59),E(40-49),F(30-39),G(20-29)</div><br>');
		   // if($level_id!=16)
		  // {
			if(strpos($promoted,"ro")==1)
			{
				$promoted = substr($promoted,12);
				echo('<div id="conduct">Promoted to: <span style="font-weight: regular;">'.$promoted.'</span></div>');
			}
			else
			{
				echo('<div id="conduct">Status: <span style="font-weight: regular;">'.$promoted.'</span></div>');
			}
			
		   /*
		   if($rank!='')
		   {
		   echo('<div id="conduct" style="text-align: center;">'.$rank.'</div>');
		   }
		   */
		    echo('<div id="remtitle">Remarks: '.$t25.'of'.$t25_old.'</div>');
			if($rank[$LsStudent['Student_ID']]!='')
			{
				echo('<div id="rem">'.$rank[$LsStudent['Student_ID']].' '.$remark.'</div>');
			}
			else if($top25[$LsStudent['Student_ID']]!='')
			{
				echo('<div id="rem">'.$top25[$LsStudent['Student_ID']].' '.$remark.'</div>');
			}
			else{
				echo('<div id="rem">'.$remark.'</div>');
			}
		   
		 //  }
		  echo('<page_footer>');
		   echo('<table class="tablerem">');
			
			echo('<tr>');
				echo('<td style="width: 170px;">'.$formteacher.'<br>______________________<br>Form Teacher</td>');
				echo('<td style="width: 170px;">'.$principal.'<br>________________________<br>Principal</td>');
				echo('<td style="width: 150px;">&nbsp;<br>________________________<br>Parent</td>');
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
        $html2pdf = new HTML2PDF('P', 'A5', 'en');
        $html2pdf->writeHTML($content, isset($_GET['vuehtml']));
        $html2pdf->Output('exemple01.pdf');
    }
    catch(HTML2PDF_exception $e) {
        echo $e;
        exit;
    }
if(!$db->commit()){
	//db_error($json,$db,'commit false',101,'');
}
	?>
<?php
    ob_start();
	require('../../../con/dblink_ais.php');
	//$classid= 387; //JC1 ZEAl
	//$classid = 431; //rooms id
	//$classid = 26; //Primary 1 Charity KJ
	$classid = base64_decode($_GET['classid']);
	$ay = $_GET['ay'];
	$db = db_open();
	if(!$db->autocommit(FALSE)){
		//db_error($json,$db,'Unable to start transaction',100,"");
	}	
	//GET principal and Form TEacher
	$qp = "SELECT A.id as classroom_id, A.room_id as room_id, A.academicyear_id, CONCAT(C.firstname,' ',C.lastname) AS principal, C.title as ptitle, CONCAT(D.firstname,' ',D.lastname) AS formteacher, D.title as ftitle,E.staff_id
		FROM classrooms A 
        JOIN camps E ON(E.id = A.camp_id)
        JOIN profiles D ON (D.id = A.staff_id)
        JOIN profiles C ON (C.id = E.staff_id )
		WHERE A.academicyear_id ='$ay' AND A.id = '$classid'";
	//die($qp);
	$sp = $db->query($qp);
	while($rp = $sp->fetch_assoc())
	{
		$academicyear_id = $rp["academicyear_id"];
		$year_to_date = $rp["academicyear_id"];
		$classroom_id = $rp["classroom_id"];
		$room_id = $rp["room_id"];
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
JOIN classrooms X ON(X.id = E.classroom_id) 
JOIN camps F ON ( F.id = E.camp_id )
JOIN rooms G ON ( G.id = E.room_id )
JOIN levels H ON ( H.id = E.level_id )
JOIN profiles P ON(P.user_id = E.staff_id)
WHERE E.academicyear_id ='".$academicyear_id."' AND D.category=1 AND X.id = '".$classroom_id."'
GROUP BY C.id
ORDER BY Student_Name ASC
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
		<?php echo($campus."<br>Student's Progress Report - Term 3"."<br>"."March 20".$year_to_date); ?> 
		
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
	 <p align="center"><b>Index :    A (All the time)  M (Most of the time)  S (Sometimes)  N (Never)</b></p>
	<table class="tablegrade">
		<tr>
			<th style='text-align: center; width: 20px;'>No</th>
			<th style='text-align: center; width: 400px;'>Behaviour</th>
			<th style='text-align: center; width: 20px;'>E</th>
			<th style='text-align: center; width: 20px;'>M</th>
			<th style='text-align: center; width: 20px;'>S</th>
			<th style='text-align: center; width: 20px;'>CL</th>
		</tr>

       <?php 
			$arr_desc[0] = "Attentive & can focus on his/her work.";
			$arr_desc[1] = "Uses his/her time constructively/wisely.";
			$arr_desc[2] = "Monitors his/her own progress towards goals.";
			$arr_desc[3] = "Maintains neatness and orderliness of his/her work.";
			$arr_desc[4] = "Shows ability in planning and carries out his/her plans to the end.";
			$arr_desc[5] = "Hands in neat and complete homework.";
			$arr_desc[6] = "Completes work in a timely manner.";
			$arr_desc[7] = "Asks for teacher assistance in appropriate manner.";
			$arr_desc[8] = "Shows initiative in day-to-day work.";
			$arr_desc[9] = "Can work independently; thinks things through for himself/herself.";
			$arr_desc[10] = "Shows interest and enthusiasm for the things we do.";
			$arr_desc[11] = "Demonstrates best effort.";
			$arr_desc[12] = "Works quietly without disturbing others.";
			$arr_desc[13] = "Helpful and dependable in the classroom.";
			$arr_desc[14] = "Has good self discipline.";
			$arr_desc[15] = "Is friendly and cooperative.";
			$arr_desc[16] = "Works well in groups.";
			$arr_desc[17] = "Accepts responsibility well.";
			$arr_desc[18] = "Respectful of others.";
			$arr_desc[19] = "Has a sense of humour we all enjoy.";
			
			for($i=0;$i<20;$i++)
			{
				//reset variable first
					$maths='';
					$english='';
					$science='';
					$chinese='';
					
					$desc = $arr_desc[$i];
					$ctr = $i+21; //+21 starts for term3 / for term1 should be +1 (mark+ctr)
					//ENGLISH BEHAVIOR
					$qe = "SELECT * 
					FROM `behaves` A
					JOIN classsubjects B ON(B.id = A.classsubject_id)
					JOIN classrooms X ON(X.id = B.classroom_id) 
					JOIN subjects C ON(C.id = A.subject_id)
					WHERE C.initials2 = 'EL'
					AND A.student_id = '".$studentid."'
                    AND B.classroom_id='".$classid."' and B.academicyear_id='".$academicyear_id."'";
					$se = $db->query($qe);
					while($re = $se->fetch_assoc())
					{
					
						$english= $re['mark'.$ctr];
					}	
					//SCIENCE BEHAVIOR
					$qs = "SELECT * 
					FROM `behaves` A
					JOIN classsubjects B ON(B.id = A.classsubject_id)
					JOIN classrooms X ON(X.id = B.classroom_id)
					JOIN subjects C ON(C.id = A.subject_id)
					WHERE C.initials2 = 'SCI'
					AND A.student_id = '".$studentid."'
                    AND B.classroom_id='".$classid."' and B.academicyear_id='".$academicyear_id."'";
					$ss = $db->query($qs);
					while($rs = $ss->fetch_assoc())
					{
					
						$science= $rs['mark'.$ctr];
					}
					//MAths BEHAVIOR
					$qm = "SELECT * 
					FROM `behaves` A
					JOIN classsubjects B ON(B.id = A.classsubject_id)
					JOIN classrooms X ON(X.id = B.classroom_id)
					JOIN subjects C ON(C.id = A.subject_id)
					WHERE C.initials2 = 'MAT'
					AND A.student_id = '".$studentid."'
                   AND B.classroom_id='".$classid."' and B.academicyear_id='".$academicyear_id."'";
					$sm = $db->query($qm);
					while($rm = $sm->fetch_assoc())
					{
					
						$maths= $rm['mark'.$ctr];
					}
					//CHINESE BEHAVIOR
					$qch = "SELECT * 
					FROM `behaves` A
					JOIN classsubjects B ON(B.id = A.classsubject_id)
					JOIN classrooms X ON(X.id = B.classroom_id)
					JOIN subjects C ON(C.id = A.subject_id)
					WHERE C.initials2 = 'CL'
					AND A.student_id = '".$studentid."'
                    AND B.classroom_id='".$classid."' and B.academicyear_id='".$academicyear_id."' && A.mark".$ctr." !=''";
					$sch = $db->query($qch);
					$num_sch=$sch->num_rows;
					if($num_sch==0){
						$chinese='';
					}
					else{						
						while($rch = $sch->fetch_assoc())
						{
						
							$chinese= $rch['mark'.$ctr];
						}
					}
					
					echo("<tr>");
						echo("<td style='width: 20px; text-align: center'>");
						echo($i+1);
						echo("</td>");
						echo("<td style='width: 400px;'>");
						echo($desc);
						echo("</td>");
						echo("<td style='text-align: center;width: 20px;'>");
						echo($english);
						echo("</td>");
						echo("<td style='text-align: center;width: 20px;'>");
						echo($maths);
						echo("</td>");
						echo("<td style='text-align: center;width: 20px;'>");
						echo($science);
						echo("</td>");
						echo("<td style='text-align: center;width: 20px;'>");
						echo($chinese);
						echo("</td>");
						
					echo("</tr>");
			}
				
		   echo('</table>');

		  
			//GET Remarks
		   $qr = "SELECT * FROM classstudents WHERE student_id = '$studentid' and classroom_id='$classroom_id'";
		   $sr = $db->query($qr);
		   while($rs = $sr->fetch_assoc())
		   {
			   
			   $remark = $rs['remark3'];
			   
		   }
		 
		   echo('<div id="remtitle">Remarks: </div>');
		   echo('<div id="rem">'.$remark.'</div>');
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

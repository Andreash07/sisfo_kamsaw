<?php
    ob_start();
	session_start();
	require('../../../con/dblink_ais.php');
	$classid = base64_decode($_GET['classid']);
	$rankq=array();
	$rank=array();
	$top25 = array();
	$ls_student = array();
	$as_pum_actual=0;
	$jc1sa1=0;
	$jc1sa2=0;
	if($_SESSION['campus']==6)
		{
			$konusr = '';
		}
		else
		{
			$konusr = '&& Z.status=1 ';
		}
	
	$arr_jj = array(3731,3730); //james and jeff
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
		
		if($_SESSION['campus']==6)
		{
			$konusr = '';
		}
		else
		{
			if($ay_id < 20){
				$konusr = ' ';
			}else{
				$konusr = '&& Z.status=1 ';
			}
		}
		
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
				WHERE E.academicyear_id ='".$ay_id."' AND D.category=1 AND H.id = '".$level_id."' and F.id='".$camp_id."' $konusr
				GROUP BY C.id
				ORDER BY C.firstname";
				$sall = $db->query($qall);
				$total_stud = $sall->num_rows;
				$t25 = $total_stud*.25;
				$t25 = round($t25);
				$FA =0;
				while($rall = $sall->fetch_assoc())
				{
					$studentid = $rall['Student_ID'];
					$cohort = $rall['Cohort'];
					$classroomid = $rall['classroom_id'];
					
						//jeff dan james
					if(in_array($studentid,$arr_jj)){
						$kondition_spec =" and D.name not like '%manda%'";
					}else{
						$kondition_spec = " ";
					}
					
					
					if($camp_id==10)
					{
						
						//Mark Academic
					   $qsall = "SELECT A.id as recid, CONCAT( C.firstname,  ' ', C.lastname ) AS Student_Name, C.id as Student_ID, D.initials3 as bahasalevel, D.id as Subject_ID, D.name AS Subject, G.initials as Class, H.initials as Cohort,F.initials AS Campus, A.ct1 as BMT1, A.cat1 as CAT1, A.mye AS MYE, A.ca1 as CA1, round(A.sa1,2) AS SA1,
					P.firstname as Teacher, P.user_id as Teacher_ID,E.lock1 as lock1,E.lock2 as lock2,E.lock3 as lock3,E.lock4 as lock4,A.id as recid,A.ct2 as BMT2, case when A.cat3 < '40' then '40' else A.cat3 end  as CAT3,
					A.fye as FYE,case when A.ca2 < '40' then '40' else A.ca2 end  as CA2, A.sa2 as SA2, A.fya as FA,H.id as levelid,H.chineselevel_id as chineselevelid,A.award as Medal
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
					WHERE E.academicyear_id ='".$ay_id."' AND D.category=1 AND C.id = '".$studentid."' AND A.fya > 0 and E.classroom_id='".$classid."' $konusr
					ORDER BY D.priority";
					}
					else
					{
						
					//Mark Academic
					 $qsall = "SELECT A.id as recid, CONCAT( C.firstname,  ' ', C.lastname ) AS Student_Name, C.id as Student_ID, D.initials3 as bahasalevel, D.id as Subject_ID, D.name AS Subject, G.initials as Class, H.initials as Cohort,F.initials AS Campus, A.ct1 as BMT1, A.cat1 as CAT1, A.mye AS MYE, A.ca1 as CA1, round(A.sa1,2) AS SA1,
					P.firstname as Teacher, P.user_id as Teacher_ID,E.lock1 as lock1,E.lock2 as lock2,E.lock3 as lock3,E.lock4 as lock4,A.id as recid,A.ct2 as BMT2, case when A.cat3 < '40' then '40' else A.cat3 end  as CAT3,
					A.fye as FYE,case when A.ca2 < '40' then '40' else A.ca2 end  as CA2, A.sa2 as SA2, A.fya as FA,H.id as levelid,H.chineselevel_id as chineselevelid,A.award as Medal
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
					WHERE E.academicyear_id ='".$ay_id."' AND D.category=1 AND C.id = '".$studentid."' AND A.fya > 0 and E.classroom_id='".$classid."' 
					$konusr && A.subject_id != '588' ".$kondition_spec."
					ORDER BY D.priority";
					//die($qsall);
					}
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
						$recid = $rsall['recid'];
						$CA2 = $rsall['CA2'];
						$SA2 = $rsall['SA2'];
						$subject = $rsall["Subject"];
						$bahasalevel = $rsall['bahasalevel'];
						$medal = $rsall['Medal'];
						//FORMULA FOR FA
						//$NewFA = ($CA1*.20)+($MYE*.25)+ ($CA2*.20)+ ($CA1*.35);
						
						if($level_id=='17'){
							 
						 $qsjc = "SELECT A.*,ifnull(B.sa1,0) jc1sa1,ifnull(B.sa2,0) jc1sa2,round((A.as_pum_actual+ifnull(B.sa1,0)+ifnull(B.sa2,0))/3 ,2) avgmark FROM (
						 SELECT CONCAT( C.firstname,  ' ', C.lastname ) AS Student_Name, B.id as Student_ID, D.code as code,D.id as Subject_ID, 
						 D.name AS Subject, D.mata_pelajaran as matpel, G.initials as Class, H.initials as Cohort, F.initials AS Campus, A.mark2 AS amark, A.grade2 as agrade,
						 P.firstname as Teacher, P.user_id as Teacher_ID, A.id as recid, A.a_target as atarget, A.apum as apum, A.aspum as aspum , 
						 case when A.grade1_actual!='' and A.as_pum_actual='0' then '40' else A.as_pum_actual end as_pum_actual,D.priority,
						 A.grade1_actual
							FROM enrollprelims A
							 
							left JOIN students B ON ( B.id = A.student_id ) 
							left JOIN profiles C ON ( C.id = B.profile_id ) 
							left JOIN subjectprelims D ON ( D.id = A.subjectprelim_id ) 
							left JOIN classsubjectprelims E ON ( E.id = A.classsubjectprelim_id ) 
							left JOIN camps F ON ( F.id = E.camp_id )
							left JOIN rooms G ON ( G.id = E.room_id )
							left JOIN levels H ON ( H.id = E.level_id )
							left JOIN profiles P ON(P.user_id = E.staff_id)
							WHERE E.academicyear_id ='".$ay_id."' AND D.category=1 AND B.id = '".$studentid."' AND D.code NOT like '0%'
							and E.classroom_id='".$classid."' 
							) A 
							left join ( SELECT a.*,b.academicyear_id,c.mata_pelajaran 
							FROM `enrolls` a left join classsubjects b on a.classsubject_id=b.id  
							left join subjects c on a.subject_id=c.id  where student_id='".$studentid."' 
							and b.level_id in (16) and a.sa1 > 0 and a.sa2 >0 ) B 
							ON ( B.mata_pelajaran = A.matpel )  
							ORDER BY A.priority asc";
							//die($qsjc);
							$ssjc = $db->query($qsjc);
							//$numsub = $ss->num_rows;
							$rsjc = $ssjc->fetch_assoc();
							if($rsjc['as_pum_actual'] > 0){ $as_pum_actual= 1;}else{$as_pum_actual= 0;}
							if($rsjc['jc1sa1'] > 0){ $jc1sa1= 1;}else{$jc1sa1= 0;}
							if($rsjc['jc1sa2'] > 0){ $jc1sa2= 1;}else{$jc1sa2= 0;}
							$FA = ($rsjc['as_pum_actual']+$rsjc['jc1sa1']+$rsjc['jc1sa2']) / ($as_pum_actual+$jc1sa1+$jc1sa2);	
						}else{
							//echo $level_id;
							$FA = $rsall['FA'];
						}
						
						$arr_alevel = array(16,17); // sec 1,2,3 acc & jc1
						$arr_igcse  = array(7,9,11,8,10,12,13,14); // sec 1,2,3 exp
					    if(in_array($level_id,$arr_alevel)){
							
							if($bahasalevel=='AMAT'  || strpos($subject, 'Infor') !== false || strpos($subject, 'Litera') !== false || strpos($subject, 'Art and') !== false ){
							$typeexam="IGCSE";
							}else{
							$typeexam="AS LEVEL";
							}
							
						}else if(in_array($level_id,$arr_igcse)){
							$typeexam="IGCSE";
						}
							if($level_id=='13' || $level_id=='14'){
								$pum =  $FA ;
							}else{

								 $qtres = "
								SELECT a.* FROM `subjectprelim_threshold` a 
								left join subjectprelims  b on a.subjectprelim_id=b.id 
								where  a.program='".$typeexam."' and b.initials = '$bahasalevel' 
								 ";

								$sqtreshold = $db->query($qtres);

								 if ($sqtreshold->num_rows > 0) 
								{ 
									while($rtres = $sqtreshold->fetch_assoc())
									{
										
										if(in_array($level_id,$arr_alevel)){
											
											if($bahasalevel=='AMAT'  || strpos($subject, 'Infor') !== false || strpos($subject, 'Litera') !== false  || strpos($subject, 'Art and') !== false  ){
												$astar = $rtres['ig_astar'];
										$a = $rtres['ig_a'];
										$b = $rtres['ig_b'];
										$c = $rtres['ig_c'];
										$d = $rtres['ig_d'];
										$e = $rtres['ig_e'];
										$u = $rtres['ig_u'];
											}else{
												
										//$astar = $rtres['as_astar'];
										$a = $rtres['as_a'];
										$b = $rtres['as_b'];
										$c = $rtres['as_c'];
										$d = $rtres['as_d'];
										$e = $rtres['as_e'];
										$u = $rtres['as_u'];
											}
										}else if(in_array($level_id,$arr_igcse)){
										$astar = $rtres['ig_astar'];
										$a = $rtres['ig_a'];
										$b = $rtres['ig_b'];
										$c = $rtres['ig_c'];
										$d = $rtres['ig_d'];
										$e = $rtres['ig_e'];
										$u = $rtres['ig_u'];	
										}
									}
									
								
								if($typeexam=='AS LEVEL'){
									
									if($FA>=$a)
									{
										 
										$pum = (($FA-$a)/((100)-$a))*20;
										$pum = $pum + 80;//80 is A
									}
									else if(($FA>=$b) && ($FA<$a))
									{
										 
										$pum = (($FA-$b)/(($a)-$b))*10;
										$pum = $pum + 70; //70 is B
									}
									else if(($FA>=$c) && ($FA<$b))
									{
										 
										$pum = (($FA-$c)/(($b)-$c))*10;
										$pum = $pum + 60; //60 is C
									}
									else if(($FA>=$d) && ($FA<$c))
									{
										 
										$pum = (($FA-$d)/(($c)-$d))*10;
										$pum = $pum + 50; //50 is D
									}
									else if(($FA>=$e) && ($FA<$d))
									{
										 
										$pum = (($FA-$e)/(($d)-$e))*10;
										$pum = $pum + 40; //40 is E
									}
									else
									{
										 
										//pum = 0; //U should be ungraded
										$pum = ($FA-$u)/(($e)-$u);
										$pum = $pum * 39; //29 is U
										
									}
									
									
									
								}else{	
								
								
								
									if(($FA>=$astar) && ($astar!=0))
								{
									 
									$pum = (($FA-$astar)/(100-$astar))*10;
									$pum = $pum + 90; //90 is A*
								 // echo"astar".$FA.'-'.$astar;
								}
								else if(($FA>=$a) && ($FA<$astar))
								{
									 
									$pum = (($FA-$a)/(($astar)-$a))*10;
									$pum = $pum + 80;//80 is A
							 // echo"a".$FA.'-'.$a;
								}
								else if(($FA>=$b) && ($FA<$a))
								{
									
									$pum = (($FA-$b)/(($a)-$b))*10;
									$pum = $pum + 70; //70 is B
								 //	 echo"b".$FA.'-'.$b;
								}
								else if(($FA>=$c) && ($FA<$b))
								{
									  // (((53 -49)/((56)-49))*10 ) + 60
									$pum = (($FA-$c)/(($b)-$c))*10;
									$pum = $pum + 60; //60 is C
								// 	 echo"c".$FA.'-'.$c;
								}
								else if(($FA>=$d) && ($FA<$c))
								{
									 
									$pum = (($FA-$d)/(($c)-$d))*10;
									$pum = $pum + 50; //50 is D
								//	echo"d".$FA.'-'.$d;
								}
								else if(($FA>=$e) && ($FA<$d))
								{
									 
									$pum = (($FA-$e)/(($d)-$e))*10;
									$pum = $pum + 40; //40 is E
								// 	echo"e".$FA.'-'.$e;
								}
								else if(($FA>=$f) && ($FA<$e))
								{
									 
									$pum = (($FA-$f)/(($e)-$f))*10;
									$pum = $pum + 30; //40 is F
									
									if($subjectid==7 || $subjectid==6 || $subjectid==4){//for additional mathematics, mathematics, english
										$pum = ($FA-$u)/(($e)-$u);
										$pum = $pum * 39; //39 is U									
									}
								//	echo"f";
								}
								else if(($FA>=$g) && ($FA<$f))
								{
									 
									$pum = (($FA-$g)/(($f)-$g))*10;
									$pum = $pum + 20; //40 is G
								//	echo"g";
								}
								else
								{
									 
								 
									$pum = ($FA-$u)/(($e)-$u);
									$pum = $pum * 19; //39 is U
								//	echo"u";
								}
								
								
								
								}
									
									
								
								}else{
									
										$pum =  $FA ;
								  //	echo"bbb";
										$astar = 0;
										$a = 0;
										$b = 0;
										$c = 0;
										$d = 0;
										$e = 0;
										$f = 0;
										$g = 0;
										$u = 0;
										
									
								}
							}
						
						
						
					if($pum < $FA){
						$pum= $FA;
					 }else{
					 
						$pum= $pum;
					 }
						
						
						
						
						
						
						
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
							$sum += $chinesedrop * $pum;
						}
						elseif($bahasalevel=='BIN.L1'){
							$bahasadrop = 85/100;
							$sum += $bahasadrop * $pum;
						} else if($bahasalevel=='BIN.L2'){
							$bahasadrop = 90/100;
							$sum += $bahasadrop * $pum;
						} else if($bahasalevel=='BIN.L3'){ 
							$bahasadrop = 95/100;
							$sum += $bahasadrop * $pum;
						}
						else
						{
							$sum += $pum;
						}
					
							$level_average = 0;
						
					} //One Student
					//echo $sum .'/'. $numsub.'<br>';
				//COmpute for WeightedAverage
				if($numsub>0)
					$wavg = round(($sum / $numsub),2);
				else
					$wavg = 0;
				
				//SAVE WeightedAverage
				//	echo "UPDATE classstudents SET avg4_us = '".$wavg."' WHERE student_id = '".$studentid."' and classroom_id='".$classroomid."' <br>";
			 	$qaw = "UPDATE classstudents SET avg4_us = '".$wavg."' WHERE student_id = '".$studentid."' and classroom_id='".$classid."'";
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
JOIN users Z on (Z.id = B.user_id)
WHERE J.academicyear_id ='".$ay_id."' AND D.category=1 AND H.id = '".$level_id."' AND F.id = '".$camp_id."' $konusr
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
						$top25[$r['Student_ID']]=$fname." is in the top 25% of the ".$cohort.' cohort.';
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
	
		if($_SESSION['campus']==6)
		{
			$konusr = '';
		}
		else
		{
			if($ay_id < 21){
				$konusr = ' ';
			}else{
				$konusr = '&& Z.status=1 ';
			}
		}
	
	//GET ALL STUDENT ON THE CLASS
	$sqlc = "SELECT C.firstname as fname, CONCAT( C.firstname,  ' ', C.lastname ) AS Student_Name, B.code as Student_Code, C.id as Student_ID,
	D.id as Subject_ID, D.name AS Subject, G.name as Class, H.name as Cohort, F.id as campusid, F.name AS campus, A.ct1 as BMT1, A.cat1 as CAT1, 
	A.mye AS MYE, A.ca1 as CA1, round(A.sa1,2) AS SA1,
P.firstname as Teacher, P.user_id as Teacher_ID,E.lock1 as lock1,E.lock2 as lock2,E.lock3 as lock3,E.lock4 as lock4,A.id as recid,E.level_id
FROM enrolls A
JOIN students B ON ( B.id = A.student_id ) 
JOIN profiles C ON ( C.id = B.profile_id ) 
JOIN subjects D ON ( D.id = A.subject_id ) 
JOIN classsubjects E ON ( E.id = A.classsubject_id )
JOIN classrooms J ON ( J.id = E.classroom_id )
JOIN camps F ON ( F.id = E.camp_id )
JOIN rooms G ON ( G.id = E.room_id )
JOIN levels H ON ( H.id = J.level_id )
JOIN profiles P ON(P.user_id = E.staff_id)
JOIN users Z on (Z.id = B.user_id)
WHERE J.academicyear_id ='".$ay_id."' AND D.category=1 AND J.id = '".$classid."' AND F.id = '".$camp_id."' $konusr
GROUP BY C.id
ORDER BY C.firstname";
// die($sqlc);
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
	<page backleft="5mm" backright="5mm" backtop="15mm"> 
<!--	 <p align="center"><img class="bbslogo" src="bbsrc.jpg" alt="bbslog"></p>-->
   <div id="header">
		<?php echo($campus."<br>".$LsStudent['Cohort']."<br>US High School Grading System Equivalent "."<br>"."Semester 2"."<br>"."May 20".$ay_id."<br>"); ?> 
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
			<th style='text-align: left; width: 120px;'>Academic Subject</th>
			<th style='width: 70px;'>&nbsp;</th>
			<th style='width: 70px;'>&nbsp;</th>
			<th style='width: 70px;'>&nbsp;</th>
			<th style='width: 70px;'>Mark</th>
			<th  style='width: 55px;'>&nbsp;</th>
		</tr>
	
       <?php 
	   
	   		//jeff dan james
					if(in_array($LsStudent['Student_ID'],$arr_jj)){
						$kondition_spec2 =" and D.name not like '%manda%'";
					}else{
						$kondition_spec2 =" ";
					}
			
			if( $level_id=='17'){
				
						
            //Mark Academic
             $qs = "SELECT A.*,ifnull(B.sa1,0) jc1sa1,ifnull(B.sa2,0) jc1sa2,round((A.as_pum_actual+ifnull(B.sa1,0)+ifnull(B.sa2,0))/3 ,2) avgmark FROM (
			 SELECT CONCAT( C.firstname,  ' ', C.lastname ) AS Student_Name, B.id as Student_ID, D.code as code,D.id as Subject_ID, 
			 D.name AS Subject, D.mata_pelajaran as matpel, G.initials as Class, H.initials as Cohort, F.initials AS Campus, A.mark2 AS amark, 
			 A.grade2 as agrade,
			 P.firstname as Teacher, P.user_id as Teacher_ID, A.id as recid, A.a_target as atarget, A.apum as apum, A.aspum as aspum , 
			 case when A.grade1_actual!='' and A.as_pum_actual='0' then '40' else A.as_pum_actual end as_pum_actual,D.priority,
			 A.grade1_actual
				FROM enrollprelims A
				 
				left JOIN students B ON ( B.id = A.student_id ) 
				left JOIN profiles C ON ( C.id = B.profile_id ) 
				left JOIN subjectprelims D ON ( D.id = A.subjectprelim_id ) 
				left JOIN classsubjectprelims E ON ( E.id = A.classsubjectprelim_id ) 
				left JOIN camps F ON ( F.id = E.camp_id )
				left JOIN rooms G ON ( G.id = E.room_id )
				left JOIN levels H ON ( H.id = E.level_id )
				left JOIN profiles P ON(P.user_id = E.staff_id)
				WHERE E.academicyear_id ='".$ay_id."' AND D.category=1 AND B.id = '".$LsStudent['Student_ID']."' AND D.code NOT like '0%'
				) A 
				left join ( SELECT a.*,b.academicyear_id,c.mata_pelajaran 
				FROM `enrolls` a left join classsubjects b on a.classsubject_id=b.id  
				left join subjects c on a.subject_id=c.id  where student_id='".$LsStudent['Student_ID']."' and b.level_id in (16) and a.sa1 > 0 and a.sa2 >0 ) B 
				ON ( B.mata_pelajaran = A.matpel )  
				ORDER BY A.priority asc";
            
        // die($qs);
			$ss = $db->query($qs);
			$numsub = $ss->num_rows;
             while($rs = $ss->fetch_assoc())
				{
					
					$subjectid = $rs['Subject_ID']; 
					$levelid = $rs['levelid'];
					$subject = $rs["Subject"];
 
					  if($rs["as_pum_actual"] > 0 || ( $rs["as_pum_actual"]=='0' && $rs['grade1_actual']!='' )) //TEST FIRST IF NOT EMPty
					{
						
						//DETERMINE THE VALUE FOR qualification
						if(($rs["Subject_ID"]==11) || ($rs["Subject_ID"]==24))//GENERAL PAPER SHOULD BE AS
						{
							$qualification="AS LEVEL";
							$agrade = strtolower($rs["agrade"]);
							$subjectname = "General Paper";
						}
						elseif($rs["Subject_ID"]==17 && $rs["aspum"]>-1){
							$apum = $rs["aspum"];
							$qualification="A LEVEL";
							$agrade = $rs["asgrade"];
							$subjectname = $rs["Subject"];
						}
						else
						{
							$qualification="A LEVEL";
							$code=substr($rs["code"],0,1);
							if($code=="0"){	
								$qualification="IGCSE";
							}
							$agrade = $rs["agrade"];
							$subjectname = $rs["Subject"];
							$apum = $rs["apum"];
						}
 
						if($rs['as_pum_actual'] > 0){ $as_pum_actual= 1;}else{$as_pum_actual= 0;}
						if($rs['jc1sa1'] > 0){ $jc1sa1= 1;}else{$jc1sa1= 0;}
						if($rs['jc1sa2'] > 0){ $jc1sa2= 1;}else{$jc1sa2= 0;}
						$avgprelim = ($rs['as_pum_actual']+$rs['jc1sa1']+$rs['jc1sa2']) / ($as_pum_actual+$jc1sa1+$jc1sa2);	
						echo("<tr>");
						echo("<td style='width: 150px;'>");
						echo($rs["Subject"]);
						//echo('Information and Communication Technology');
						echo("</td>");
						echo("<td style='text-align: center;'>");
						//echo(round($CA2).'%');
						echo'&nbsp;';
						echo("</td>");
						echo("<td style='text-align: center;'>");
						//echo(round($SA2).'%');
						echo'&nbsp;';
						echo("</td>");
						
						 
						
						echo("<td style='text-align: center;'>");
						//echo(round($SA2).'%');
						echo'&nbsp;';
						echo("</td>");
 
						echo("<td  style='text-align: center;width: 40px;'>");
 
							if($campus=='Malang' && $rs["Subject_ID"]==24)  { $FA = round($rs["avgmark"]);}
							else { $FA= round($avgprelim);}
							
							
							 
					 
					  $arr_alevel = array(16,17); // sec 1,2,3 acc & jc1
					  
					     
							
							if($subject=='Additional Mathematics'  || strpos($subject, 'Infor') !== false || strpos($subject, 'Litera') !== false || strpos($subject, 'Art and') !== false ){
							$typeexam="IGCSE";
							}else{
							$typeexam="AS LEVEL";
							}
							 
								 $qtres = "
								SELECT a.* FROM `subjectprelim_threshold` a 
								left join subjectprelims  b on a.subjectprelim_id=b.id 
								where  a.program='".$typeexam."' and a.subjectprelim_id = '$subjectid' 
								 ";

								$sqtreshold = $db->query($qtres);

								 if ($sqtreshold->num_rows > 0) 
								{ 
									while($rtres = $sqtreshold->fetch_assoc())
									{
										
										 	
											if($subject=='Additional Mathematics'  || strpos($subject, 'Infor') !== false || strpos($subject, 'Litera') !== false  || strpos($subject, 'Art and') !== false  ){
												$astar = $rtres['ig_astar'];
										$a = $rtres['ig_a'];
										$b = $rtres['ig_b'];
										$c = $rtres['ig_c'];
										$d = $rtres['ig_d'];
										$e = $rtres['ig_e'];
										$u = $rtres['ig_u'];
											}else{
												
										//$astar = $rtres['as_astar'];
										$a = $rtres['as_a'];
										$b = $rtres['as_b'];
										$c = $rtres['as_c'];
										$d = $rtres['as_d'];
										$e = $rtres['as_e'];
										$u = $rtres['as_u'];
											}
									 
									}
									
								
								if($typeexam=='AS LEVEL'){
									
									if($FA>=$a)
									{
										 
										$pum = (($FA-$a)/((100)-$a))*20;
										$pum = $pum + 80;//80 is A
									}
									else if(($FA>=$b) && ($FA<$a))
									{
										 
										$pum = (($FA-$b)/(($a)-$b))*10;
										$pum = $pum + 70; //70 is B
									}
									else if(($FA>=$c) && ($FA<$b))
									{
										 
										$pum = (($FA-$c)/(($b)-$c))*10;
										$pum = $pum + 60; //60 is C
									}
									else if(($FA>=$d) && ($FA<$c))
									{
										 
										$pum = (($FA-$d)/(($c)-$d))*10;
										$pum = $pum + 50; //50 is D
									}
									else if(($FA>=$e) && ($FA<$d))
									{
										 
										$pum = (($FA-$e)/(($d)-$e))*10;
										$pum = $pum + 40; //40 is E
									}
									else
									{
										 
										//pum = 0; //U should be ungraded
										$pum = ($FA-$u)/(($e)-$u);
										$pum = $pum * 39; //29 is U
										
									}
									
									
									
								}else{	
								
								
								
									if(($FA>=$astar) && ($astar!=0))
								{
									 
									$pum = (($FA-$astar)/(100-$astar))*10;
									$pum = $pum + 90; //90 is A*
								 // echo"astar".$FA.'-'.$astar;
								}
								else if(($FA>=$a) && ($FA<$astar))
								{
									 
									$pum = (($FA-$a)/(($astar)-$a))*10;
									$pum = $pum + 80;//80 is A
							 // echo"a".$FA.'-'.$a;
								}
								else if(($FA>=$b) && ($FA<$a))
								{
									
									$pum = (($FA-$b)/(($a)-$b))*10;
									$pum = $pum + 70; //70 is B
								 //	 echo"b".$FA.'-'.$b;
								}
								else if(($FA>=$c) && ($FA<$b))
								{
									  // (((53 -49)/((56)-49))*10 ) + 60
									$pum = (($FA-$c)/(($b)-$c))*10;
									$pum = $pum + 60; //60 is C
								// 	 echo"c".$FA.'-'.$c;
								}
								else if(($FA>=$d) && ($FA<$c))
								{
									 
									$pum = (($FA-$d)/(($c)-$d))*10;
									$pum = $pum + 50; //50 is D
								//	echo"d".$FA.'-'.$d;
								}
								else if(($FA>=$e) && ($FA<$d))
								{
									 
									$pum = (($FA-$e)/(($d)-$e))*10;
									$pum = $pum + 40; //40 is E
								// 	echo"e".$FA.'-'.$e;
								}
								else if(($FA>=$f) && ($FA<$e))
								{
									 
									$pum = (($FA-$f)/(($e)-$f))*10;
									$pum = $pum + 30; //40 is F
									
									if($subjectid==7 || $subjectid==6 || $subjectid==4){//for additional mathematics, mathematics, english
										$pum = ($FA-$u)/(($e)-$u);
										$pum = $pum * 39; //39 is U									
									}
								//	echo"f";
								}
								else if(($FA>=$g) && ($FA<$f))
								{
									 
									$pum = (($FA-$g)/(($f)-$g))*10;
									$pum = $pum + 20; //40 is G
								//	echo"g";
								}
								else
								{
									 
								 
									$pum = ($FA-$u)/(($e)-$u);
									$pum = $pum * 19; //39 is U
								//	echo"u";
								}
								
								
								
								}
									
									
								
								}else{
									
										$pum =  $FA ;
								  //	echo"bbb";
										$astar = 0;
										$a = 0;
										$b = 0;
										$c = 0;
										$d = 0;
										$e = 0;
										$f = 0;
										$g = 0;
										$u = 0;
										
									
								}
						 
						
								
								
						
						 
						  if($pum < $FA){
							 echo(round($FA).'%')  ; 
						 }else{
						 
							echo(round($pum).'%')  ; 
						 }
							
							
						echo("</td>");
					echo("</tr>");
					 
					}
				}
				/*
			}else if($level_id=='13' || $level_id=='14'  ){
			

		//Mark Academic
             $qs = "SELECT CONCAT( C.firstname,  ' ', C.lastname ) AS Student_Name, B.id as Student_ID, D.code as code, 
			 A.qualification1 as qualification1,  A.qualification2 as qualification2, D.id as Subject_ID, D.name AS Subject, 
			 G.initials as Class, H.initials as Cohort, F.initials AS Campus, A.mark2 AS amark, A.grade2 as agrade, 
			 A.lock1 as lock1, A.lock2 as lock2, A.id as recid, A.igcse_target as igtarget, A.apum as apum, D.code as syllabuscode
				FROM enrollprelims A
				JOIN students B ON ( B.id = A.student_id ) 
				JOIN profiles C ON ( C.id = B.profile_id ) 
				JOIN subjectprelims D ON ( D.id = A.subjectprelim_id ) 
				JOIN classsubjectprelims E ON ( E.id = A.classsubjectprelim_id ) 
				JOIN camps F ON ( F.id = E.camp_id )
				JOIN rooms G ON ( G.id = E.room_id )
				JOIN levels H ON ( H.id = E.level_id )
				WHERE E.academicyear_id ='".$ay_id."' AND D.category=1 AND B.id = '".$LsStudent['Student_ID']."' ".$kondition_spec2 ."
				ORDER BY D.priority desc";
				//JOIN profiles P ON(P.user_id = E.staff_id) //kadang user belum di update in localhost
            // die($qs);
          
			$ss = $db->query($qs);
			$numsub = $ss->num_rows;
             while($rs = $ss->fetch_assoc())
				{
					 
					echo("<tr>");
						echo("<td style='width: 150px;'>");
						echo($rs["Subject"]);
						//echo('Information and Communication Technology');
						echo("</td>");
						echo("<td style='text-align: center;'>");
						//echo(round($CA2).'%');
						echo'&nbsp;';
						echo("</td>");
						echo("<td style='text-align: center;'>");
						//echo(round($SA2).'%');
						echo'&nbsp;';
						echo("</td>");
						
						 
						
						echo("<td style='text-align: center;'>");
						//echo(round($SA2).'%');
						echo'&nbsp;';
						echo("</td>");
						echo("<td style='text-align: center;'>");
					 
						 
						 
						echo round($rs["apum"]);
						//echo(round($rs['FA']).'%'); 
						 //echo('-'.round($FA).'%');
						
						echo("</td>");
						echo("<td  style='text-align: center;'>");
						//echo($medal);
						echo'&nbsp;';
						//echo('SILVER');
						echo("</td>");
						
					echo("</tr>");
				}

*/


			
			}else{
				 
			
			
			
			
			if($camp_id==10)
			{
				
				
				
				$qs = "SELECT A.id as recid, CONCAT( C.firstname,  ' ', C.lastname ) AS Student_Name, C.id as Student_ID, D.initials3 as bahasalevel, D.id as Subject_ID, D.name AS Subject, G.initials as Class, H.initials as Cohort,F.initials AS Campus, A.ct1 as BMT1, A.cat1 as CAT1, A.mye AS MYE, A.ca1 as CA1, round(A.sa1,2) AS SA1,
			P.firstname as Teacher, P.user_id as Teacher_ID,E.lock1 as lock1,E.lock2 as lock2,E.lock3 as lock3,E.lock4 as lock4,A.id as recid,A.ct2 as BMT2, case when A.cat3 < '40' then '40' else A.cat3 end  as CAT3,
			A.fye as FYE,case when A.ca2 < '40' then '40' else A.ca2 end  as CA2, A.sa2 as SA2, 
			case when  E.level_id in ('13','14')  then A.sa1 else A.fya end  as FA 
			,H.id as levelid,H.chineselevel_id as chineselevelid,A.award as Medal,F.id as campusid
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
			WHERE E.academicyear_id ='".$ay_id."' AND D.category=1 AND C.id = '".$LsStudent['Student_ID']."' AND A.fya > 0 and E.classroom_id='".$classid."' $konusr
			ORDER BY D.priority";
			
			}
			else {
				
				
				
				if($level_id=='13' || $level_id=='14'){
					
					$kondisisss2213123=" AND  A.sa1 > 0 ";
					$konsec4=" AND left(D.code,1)='0'  ";
					
					}else{
					$kondisisss2213123=" AND  A.fya > 0 ";
					$konsec4=" AND left(D.code,1)!='0'  ";
						
					}
				
			if($ay_id=='20'){	
				
            //Mark Academic
              $qs = "SELECT A.id as recid, CONCAT( C.firstname,  ' ', C.lastname ) AS Student_Name, C.id as Student_ID, D.initials3 as bahasalevel, D.id as Subject_ID, D.name AS Subject, G.initials as Class, H.initials as Cohort,F.initials AS Campus, A.ct1 as BMT1, A.cat1 as CAT1, A.mye AS MYE, A.ca1 as CA1, round(A.sa1,2) AS SA1,
			P.firstname as Teacher, P.user_id as Teacher_ID,E.lock1 as lock1,E.lock2 as lock2,E.lock3 as lock3,E.lock4 as lock4,A.id as recid,A.ct2 as BMT2, case when A.cat3 < '40' then '40' else A.cat3 end  as CAT3,
			A.fye as FYE,case when A.ca2 < '40' then '40' else A.ca2 end  as CA2, A.sa2 as SA2, 
			case when E.level_id in ('13','14') then A.sa1 else A.fya end  as FA
			,H.id as levelid,H.chineselevel_id as chineselevelid,A.award as Medal,F.id as campusid
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
			WHERE E.academicyear_id ='".$ay_id."' AND D.category=1 AND C.id = '".$LsStudent['Student_ID']."' and E.classroom_id='".$classid."' 
			$konusr && A.subject_id != '588' ".$kondition_spec2 ." ".$kondisisss2213123."
			ORDER BY D.priority";
			}else{
			$qs = "
			SELECT CONCAT( C.firstname,  ' ', C.lastname ) AS Student_Name, B.id as Student_ID, D.code as code, A.qualification1 as qualification1,  A.qualification2 as qualification2, D.id as Subject_ID, D.name AS Subject, G.initials as Class, H.initials as Cohort, F.initials AS Campus, A.mark1 as asmark, A.grade1 as asgrade, A.mark2 AS amark, A.grade2 as agrade,
				P.firstname as Teacher, P.user_id as Teacher_ID,A.lock1 as lock1,A.lock2 as lock2,A.id as recid,A.igcse_target as igtarget,A.as_target as astarget,A.a_target as atarget,A.apum as FA,A.aspum as aspum
				FROM enrollprelims A
				JOIN students B ON ( B.id = A.student_id ) 
				JOIN profiles C ON ( C.id = B.profile_id ) 
				JOIN subjectprelims D ON ( D.id = A.subjectprelim_id ) 
				JOIN classsubjectprelims E ON ( E.id = A.classsubjectprelim_id ) 
				JOIN camps F ON ( F.id = E.camp_id )
				JOIN rooms G ON ( G.id = E.room_id )
				JOIN levels H ON ( H.id = E.level_id )
				JOIN profiles P ON(P.user_id = E.staff_id)
				WHERE E.academicyear_id ='".$ay_id."' AND D.category=1 AND B.id = '".$LsStudent['Student_ID']."' ".$konsec4."
				ORDER BY D.priority desc
		 ";
			}
		//	die($qs);
            }
			
			
			
          
			$sum = 0;
			$ss = $db->query($qs);
			$numsub = $ss->num_rows;
			$pum=0;
			$qtres = "";
		 
             while($rs = $ss->fetch_assoc())
				{
					//GET LEVEL AVERAGE
					$subjectid = $rs['Subject_ID'];
					$FA = $rs['FA'];
					$recid = $rs['recid'];
					$subject = $rs["Subject"];  
					//FOR NO FYE DUE TO EXCUSED ABSENT
					
				/*	if($camp_id=10)
					{
						
					}
					else
					{						
						if($subjectid=="588")
						{
						continue;
						}
					} */
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
						//echo(round($CA2).'%');
						echo'&nbsp;';
						echo("</td>");
						if($FYE==-1)
						{
							echo("<td style='text-align: center;'>");
							//echo('A');
							echo'&nbsp;';
							echo("</td>");

						}
						else
						{
							echo("<td style='text-align: center;'>");
							//echo(round($FYE).'%');
							echo'&nbsp;';
							echo("</td>");
							
						}
						
						echo("<td style='text-align: center;'>");
						//echo(round($SA2).'%');
						echo'&nbsp;';
						echo("</td>");
						echo("<td style='text-align: center;'>");
					 
					 
					 
					  $arr_alevel = array(16,17); // sec 1,2,3 acc & jc1
					  $arr_igcse = array(7,9,11,8,10,12,13,14); // sec 1,2,3 exp
					    if(in_array($level_id,$arr_alevel)){
							
							if($bahasalevel=='AMAT'  || strpos($subject, 'Infor') !== false || strpos($subject, 'Litera') !== false || strpos($subject, 'Art and') !== false ){
							$typeexam="IGCSE";
							}else{
							$typeexam="AS LEVEL";
							}
							
						}else if(in_array($level_id,$arr_igcse)){
							$typeexam="IGCSE";
						}
							if($level_id=='13' || $level_id=='14'){
								$pum =  $FA ;
							}else{

								 $qtres = "
								SELECT a.* FROM `subjectprelim_threshold` a 
								left join subjectprelims  b on a.subjectprelim_id=b.id 
								where  a.program='".$typeexam."' and b.initials = '$bahasalevel' 
								 ";

								$sqtreshold = $db->query($qtres);

								 if ($sqtreshold->num_rows > 0) 
								{ 
									while($rtres = $sqtreshold->fetch_assoc())
									{
										
										if(in_array($level_id,$arr_alevel)){
											
											if($bahasalevel=='AMAT'  || strpos($subject, 'Infor') !== false || strpos($subject, 'Litera') !== false  || strpos($subject, 'Art and') !== false  ){
												$astar = $rtres['ig_astar'];
										$a = $rtres['ig_a'];
										$b = $rtres['ig_b'];
										$c = $rtres['ig_c'];
										$d = $rtres['ig_d'];
										$e = $rtres['ig_e'];
										$u = $rtres['ig_u'];
											}else{
												
										//$astar = $rtres['as_astar'];
										$a = $rtres['as_a'];
										$b = $rtres['as_b'];
										$c = $rtres['as_c'];
										$d = $rtres['as_d'];
										$e = $rtres['as_e'];
										$u = $rtres['as_u'];
											}
										}else if(in_array($level_id,$arr_igcse)){
										$astar = $rtres['ig_astar'];
										$a = $rtres['ig_a'];
										$b = $rtres['ig_b'];
										$c = $rtres['ig_c'];
										$d = $rtres['ig_d'];
										$e = $rtres['ig_e'];
										$u = $rtres['ig_u'];	
										}
									}
									
								
								if($typeexam=='AS LEVEL'){
									
									if($FA>=$a)
									{
										 
										$pum = (($FA-$a)/((100)-$a))*20;
										$pum = $pum + 80;//80 is A
									}
									else if(($FA>=$b) && ($FA<$a))
									{
										 
										$pum = (($FA-$b)/(($a)-$b))*10;
										$pum = $pum + 70; //70 is B
									}
									else if(($FA>=$c) && ($FA<$b))
									{
										 
										$pum = (($FA-$c)/(($b)-$c))*10;
										$pum = $pum + 60; //60 is C
									}
									else if(($FA>=$d) && ($FA<$c))
									{
										 
										$pum = (($FA-$d)/(($c)-$d))*10;
										$pum = $pum + 50; //50 is D
									}
									else if(($FA>=$e) && ($FA<$d))
									{
										 
										$pum = (($FA-$e)/(($d)-$e))*10;
										$pum = $pum + 40; //40 is E
									}
									else
									{
										 
										//pum = 0; //U should be ungraded
										$pum = ($FA-$u)/(($e)-$u);
										$pum = $pum * 39; //29 is U
										
									}
									
									
									
								}else{	
								
								
								
									if(($FA>=$astar) && ($astar!=0))
								{
									 
									$pum = (($FA-$astar)/(100-$astar))*10;
									$pum = $pum + 90; //90 is A*
								 // echo"astar".$FA.'-'.$astar;
								}
								else if(($FA>=$a) && ($FA<$astar))
								{
									 
									$pum = (($FA-$a)/(($astar)-$a))*10;
									$pum = $pum + 80;//80 is A
							 // echo"a".$FA.'-'.$a;
								}
								else if(($FA>=$b) && ($FA<$a))
								{
									
									$pum = (($FA-$b)/(($a)-$b))*10;
									$pum = $pum + 70; //70 is B
								 //	 echo"b".$FA.'-'.$b;
								}
								else if(($FA>=$c) && ($FA<$b))
								{
									  // (((53 -49)/((56)-49))*10 ) + 60
									$pum = (($FA-$c)/(($b)-$c))*10;
									$pum = $pum + 60; //60 is C
								// 	 echo"c".$FA.'-'.$c;
								}
								else if(($FA>=$d) && ($FA<$c))
								{
									 
									$pum = (($FA-$d)/(($c)-$d))*10;
									$pum = $pum + 50; //50 is D
								//	echo"d".$FA.'-'.$d;
								}
								else if(($FA>=$e) && ($FA<$d))
								{
									 
									$pum = (($FA-$e)/(($d)-$e))*10;
									$pum = $pum + 40; //40 is E
								// 	echo"e".$FA.'-'.$e;
								}
								else if(($FA>=$f) && ($FA<$e))
								{
									 
									$pum = (($FA-$f)/(($e)-$f))*10;
									$pum = $pum + 30; //40 is F
									
									if($subjectid==7 || $subjectid==6 || $subjectid==4){//for additional mathematics, mathematics, english
										$pum = ($FA-$u)/(($e)-$u);
										$pum = $pum * 39; //39 is U									
									}
								//	echo"f";
								}
								else if(($FA>=$g) && ($FA<$f))
								{
									 
									$pum = (($FA-$g)/(($f)-$g))*10;
									$pum = $pum + 20; //40 is G
								//	echo"g";
								}
								else
								{
									 
								 
									$pum = ($FA-$u)/(($e)-$u);
									$pum = $pum * 19; //39 is U
								//	echo"u";
								}
								
								
								
								}
									
									
								
								}else{
									
										$pum =  $FA ;
								  //	echo"bbb";
										$astar = 0;
										$a = 0;
										$b = 0;
										$c = 0;
										$d = 0;
										$e = 0;
										$f = 0;
										$g = 0;
										$u = 0;
										
									
								}
							}
						
								
								
						
						 
					  if($pum < $FA){
						 echo(round($FA).'%')  ; 
					 }else{
					 
						echo(round($pum).'%')  ; 
					 }
					 
						//echo(round($rs['FA']).'%'); 
						 //echo('-'.round($FA).'%');
						
						echo("</td>");
						echo("<td  style='text-align: center;'>");
						//echo($medal);
						echo'&nbsp;';
						//echo('SILVER');
						echo("</td>");
						
					echo("</tr>");
					
		 
				}
				}
				
		   echo('</table><br>');
		   ?>
		   <table class="tablegrade">
		
		<tr>
			<th style='text-align: left; width: 320px;'>Non Academic</th>
			<th style='text-align: center; width: 170px;'>Grade</th>
		</tr>
		
       <?php 
	   
	   
	   	
			if($level_id=='13' || $level_id=='14'){
				$fild2="A.grade1";
				$kondisi_non_aca="and  A.grade1!=''  ";
			}else{
				$fild2="A.grade2";
				$kondisi_non_aca="and A.grade2 != '' ";
			}
			
			
            //NON Academic GRADE Academic
             $qsn = "SELECT CONCAT( C.firstname,  ' ', C.lastname ) AS Student_Name, C.id as Student_ID, D.id as Subject_ID, D.name AS Subject, G.initials as Class, H.initials as Cohort, F.initials AS Campus, A.ct1 as BMT1, A.cat1 as CAT1, A.mye AS MYE, A.ca1 as CA1, round(A.sa1,2) AS SA1,
P.firstname as Teacher, P.user_id as Teacher_ID,E.lock1 as lock1,E.lock2 as lock2,E.lock3 as lock3,E.lock4 as lock4,A.id as recid,A.ct2 as BMT2, A.ca2 as CAT3,
A.fye as FYE,case when A.ca2 < '40' then '40' else A.ca2 end  as CA2, A.sa2 as SA2, A.fya as FA,A.gradet3 as t3non,A.gradet1 as t1non,".$fild2." as Grade2
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
WHERE E.academicyear_id ='".$ay_id."' AND D.category=2 AND C.id = '".$LsStudent['Student_ID']."'   ".$kondisi_non_aca."   and E.classroom_id='".$classid."' $konusr
ORDER BY D.priority";
            
          
			$ssn = $db->query($qsn);
			$numsubn = $ssn->num_rows;
             while($rsn = $ssn->fetch_assoc())
				{
					
					
				if($level_id =='6'){
					if($rsn['Grade2']=='A'){
						$grademark=95;
					}
					else if($rsn['Grade2']=='B'){
						$grademark=84;
					}
					else if($rsn['Grade2']=='C'){
						$grademark=69;
					}
					else if($rsn['Grade2']=='D'){
						$grademark=60;
					}
					else if($rsn['Grade2']==NULL){
						$grademark=0;
					}
					 
				}
				else if($level_id > 6 && $level_id < 17){
					if($rsn['Grade2']=='A'||$rsn['Grade2']=='A+'){
						$grademark=90;
					}
					else if($rsn['Grade2']=='B'){
						$grademark=80;
					}
					else if($rsn['Grade2']=='C'){
						$grademark=70;
					}
					else if($rsn['Grade2']=='D'){
						$grademark=60;
					}
					else if($rsn['Grade2']==NULL){
						$grademark=0;
					}
					
				}else if($level_id==17){
					
					/*
						if($rsn['Grade2']=='A'||$rsn['Grade2']=='A+'){
							$grademark=90;
						}
						else if($rsn['Grade2']=='B'){
							$grademark=80;
						}
						else if($rsn['Grade2']=='C'){
							$grademark=70;
						}
						else if($rsn['Grade2']==NULL){
							$grademark=0;
						}
					*/	
					if($rsn['Grade2']=='A'||$rsn['Grade2']=='A+'){
						$grademark=90;
					}
					else if($rsn['Grade2']=='B'){
						$grademark=80;
					}
					else if($rsn['Grade2']=='C'){
						$grademark=70;
					}
					else if($rsn['Grade2']=='D'){
						$grademark=60;
					}
					else if($rsn['Grade2']==NULL){
						$grademark=0;
					}
					 

				} 
					
					
					
					
					
					
					
					echo("<tr>");
						echo("<td>");
						echo($rsn["Subject"]);
						echo("</td>");
						echo("<td style='text-align: center;'>");
						echo($rsn['Grade2']);
						echo("</td>");
						
					echo("</tr>");
				}
				
		  
		 
		if($level_id=='13' || $level_id=='14'){
			 
		}else{		 	
			 
			 //	$fild3="A.grade2";
			 
		//GET CCA
			$qcca = "SELECT C.name as cca, A.grade2 as ccagrade,  AVG(A.score_final) as AVG2
					FROM `members` A
					JOIN clubs B ON(B.id = A.club_id)
					JOIN ccas C ON(C.id = A.cca_id)
					WHERE B.academicyear_id = '".$ay_id."' and B.camp_id = '".$LsStudent['campusid']."' and A.student_id = '".$LsStudent['Student_ID']."' &&  A.grade2 !='' ";
					//die($qcca);
					
					$scca = $db->query($qcca);
					$numcca=$scca->num_rows;
					//$numsubn = $numsubn+$scca->num_rows;
					if($numcca>0){						
						while($rcca = $scca->fetch_assoc())
						{
							
							/*
							//=2 || $campusid==4 || $campusid==6 || $campusid==8 || $campusid==10
							if($rcca["AVG2"]!= NULL){
								
								if(in_array($LsStudent['campusid'], array(2,4,6,8,10,14))){
								if($rcca['AVG2']=='A'||$rcca['AVG2']=='A+'){
										$grade_cca=90;
									}
									else if($rcca['AVG2']=='B'){
										$grade_cca=80;
									}
									else if($rcca['AVG2']=='C'){
										$grade_cca=70;
									}
									else if($rcca['AVG2']=='D'){
										$grade_cca=60;
									}
									else if($rcca['AVG2']==NULL){
										$grade_cca=0;
									}
					
								
								/*
									if(round($rcca["AVG2"]) >=17){
										//$grade_cca='A';
										$grade_cca=round($rcca["AVG2"]);
									}
									else if(round($rcca["AVG2"]) >=14){
										//$grade_cca='B';
										$grade_cca=round($rcca["AVG2"]);
									}
									else if(round($rcca["AVG2"]) >=9){
										//$grade_cca='C';
										$grade_cca=round($rcca["AVG2"]);
									}
									else if(round($rcca["AVG2"]) >=0){
										//$grade_cca='D';
										$grade_cca=round($rcca["AVG2"]);
									}
									
								}
							}
							*/
							
							//=2 || $campusid==4 || $campusid==6 || $campusid==8 || $campusid==10
							if($rcca["AVG2"]!= NULL){
								if(in_array($LsStudent['campusid'], array(2,4,6,8,10,14))){
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
								
								
								echo("<tr>");
								echo("<td>");
								echo('CCA');
								echo("</td>");
								echo("<td style='text-align: center;'>");
								echo($grade_cca);
								echo("</td>");
								echo("</tr>");
							}
							else{
								$grade_cca="-";
							}
						}
						
					}
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
			   $avg = $rs['avg4_us'];
			   $promoted = $rs['promoted'];
			   
			    	  if($camp_id==4)
			   {
				   
				   if($rs['conduct4'])
				   {
					   $conduct = $rs['conduct4'];
				   }
				   else
				   {
					$qryellow = "SELECT sum(point) as total_point FROM discipline_yellowform WHERE student_id = '".$LsStudent['Student_ID']."' and month(date) IN (1,2,3,4,5,6 ) and ay='".$ay_id."'";
					$sryellow = $db->query($qryellow);
					$rsyellow = $sryellow->fetch_assoc();
					if($rsyellow['total_point'] <= 10)$conduct = 'A';
					else if($rsyellow['total_point'] > 10 and $rsyellow['total_point'] <=20 )$conduct = 'B';
					else if($rsyellow['total_point'] > 20 and $rsyellow['total_point'] <=40 )$conduct = 'C';
					else $conduct = 'D';
				   }
			   }
			   else
			   {
				$conduct = $rs['conduct4'];
			   }
			   
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
			   if(in_array($LsStudent['campusid'], array(1,2,3,4,5,6,7,8,9,10,12,14)))
			   {
				  $getatt = "SELECT COUNT(student_id) as total FROM attendance_students WHERE att_status NOT IN(1,3,0) and student_id = '".$LsStudent['Student_ID']."' && (date>='20".$ay_id."-01-08' && date<='20".$ay_id."-06-30')";
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
		
		<?php 
		if($level_id=='13' || $level_id=='14' || $level_id=='17' ){
			?>
	 
			<td style='text-align: left;font-weight: bold;'>Attendance: </td>
			<td style='text-align: left; width: 260px;'><?php echo($att.'/'.$total_att); ?></td>
			<td style='text-align: left;font-weight: bold;'>Conduct: </td>
			<td style='text-align: left; width: 100px;'><?php echo($conduct); ?></td>
			
		<?php 
		}else{
			
			?>
			<td style='text-align: left; width: 120px; font-weight: bold;'>Academic Subject Weighted Average: </td>
			<td style='text-align: left; width: 80px; font-size: 12px; font-weight: bold'>
				<?php echo(round($avg,2).'%'); ?>
			</td>
			
			<td style='text-align: left;font-weight: bold;'>Attendance: </td>
			<td style='text-align: left; width: 60px;'><?php echo($att.'/'.$total_att); ?></td>
			<td style='text-align: left;font-weight: bold;'>Conduct: </td>
			<td style='text-align: left; width: 100px;'><?php echo($conduct); ?></td>
			
		<?php 
			
		}
		?>
			
		</tr>
		</table>
		
		   
		<?php
		  // echo('<div id="legend">Mark Range Guide: A*(90-100),A(80-89),B(70-79),C(60-69),D(50-59),E(40-49),F(30-39),G(20-29)</div><br>');
		   // if($level_id!=16)
		  // {
			  
			   
		if($level_id=='13' || $level_id=='14' || $level_id=='17'){
			
		}else{
		 
			if(strpos($promoted,"ro")==1)
			{
				$promoted = substr($promoted,12);
				echo('<div id="conduct">Promoted to: <span style="font-weight: regular;">'.$promoted.'</span></div>');
			}
			else
			{
				echo('<div id="conduct">Status: <span style="font-weight: regular;">'.$promoted.'</span></div>');
			}
		}	
		   /*
		   if($rank!='')
		   {
		   echo('<div id="conduct" style="text-align: center;">'.$rank.'</div>');
		   }
		   */
		    echo('<div id="remtitle">Remarks: </div>');
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
		  echo('<page_footer backtop="-10mm">');
		   echo('<table class="tablerem" style="margin-top:-110px;">');
			if($principal=='Mr. Richard H'){
				$principals="Richard Herawaty";
			}else{
				$principals=$principal;
			}
			echo('<tr>');
				echo('<td style="width: 170px;">&nbsp;'.$principals.'<br>________________________<br>Principal</td>');
				echo('<td style="width: 170px;">&nbsp;</td>');
				echo('<td style="width: 150px;">&nbsp; </td>');
				 
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
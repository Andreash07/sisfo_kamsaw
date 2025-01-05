<?php
error_reporting(E_ALL);
//include("sql_convert.php");
ob_start();
 
include("../konek.php");

$buka=bukakoneksi();
$sid=$_GET['sid'];
 
$sstudent="SELECT CONCAT(D.firstname,' ',D.lastname) as student, C.name as room, B.academicyear_id as year, B.id as classroom,G.title,G.description,G.requirements,E.camp_id
from summer_course_enrolls A
left join summer_courses G on (G.id = A.summer_course_id)
left join students E on (E.id = A.student_id)
left join classrooms B on (B.id = E.classroom_id)
left join rooms C on (C.id = B.room_id)
left join profiles D on (D.id = E.profile_id)
left join users F on (F.id = D.id)
where A.id ='".$sid."' 
"; //limit 2
$qstudent=$buka->query($sstudent);


//perulangan page report		
//$rows=$query->num_rows;
$date=date('Y-m-d');
//$level_id=$_GET['level_id'];
$day=substr($date,8,2);
$month=substr($date,5,2);
$year=substr($date,0,4);
if($month=='01'){
	$month="January";
}else if($month=='02'){
	$month="February";
}else if($month=='03'){
	$month="March";
}else if($month=='04'){
	$month="April";
}else if($month=='05'){
	$month="May";
}else if($month=='06'){
	$month="June";
}else if($month=='07'){
	$month="July";
}else if($month=='08'){
	$month="Augst";
}else if($month=='09'){
	$month="September";
}else if($month=='10'){
	$month="October";
}else if($month=='11'){
	$month="November";
}else if($month=='12'){
	$month="December";
}
/*
//level
if($level_id=='13' || $level_id=='14'){
	$level="Secondary Education";
}else if($level_id=='17'){
	$level="Junior College Education";
}else if($level_id=='6'){
	$level="Primary Education";
}else if($level_id=='6'){
	$level="Primary Education";
}else if($level_id=='23'){
	$level="Preschool Education";
}
*/
$level="CERTIFICATION OF PARTICIPATION";
//code_campus

//code_certificate
/*
if($level_id=='13' || $level_id=='14'){
	$level_cert="CSE";
}else if($level_id=='17'){
	$level_cert="CJCE";
}else if($level_id=='6'){
	$level_cert="CPE";
}else if($level_id=='23'){
	$level_cert="CPSE";
}
*/
//code_year
if($year=='16'){
	$year='2016';
}else if($year=='17'){
	$year='2017';
}
$level_cert="CSC";
$rows=$qstudent->num_rows;
if($rows==0){
	$i=0000;
	//$ncamp=null;
	//$nroom=null;
		echo '<page orientation="paysage">
		<div style="margin: auto;">
		<br>
		<br>
		<br>
		<br>
		<br>';
		echo '<div style="line-height:1.1; font-family:times; color:black; text-align:center; font-size:26pt"><b>'.$level.'</b></div>
		<br>';
		echo '<div style="line-height:0.9; font-family:times; color:black; text-align:center; font-size:16pt">is awarded to</div>
		<br>
		<br>';
		echo '<b><div style="line-height:1; font-family:aparabi; font-style:italic; color:black; text-align:center; font-size:60pt">No_Name</div></b>
		<br>
		<br>';
		echo '<div style="line-height:1; font-family:times; color:black; text-align:center; font-size:16pt">on</div>	
		<br>
		<br>';		
		echo '<div style="line-height:1; font-family:times; color:black; text-align:center; font-size:18pt">'.$day.' '.$month.' '.$year.'<br></div>
		<br>
		<br>
		<br>
		<br>
		<br>';
	echo "</div>
			<br>
			<br>
			<br>
			<br>";
		
			//principal
		echo "<div style='margin:auto;'>
			<table>
				<tr>";
			echo "<td style='width:445px; font-family:aparaji; font-size:14pt; text-align:center;'>asdasdds</td>";
		
			echo "<td style='width:175px;'></td>";
		
		//teacher
			echo "<td style='width:445px; font-family:aparaji;  font-size:14pt; text-align:center;'>Paulus Sia</td>";

		echo "</tr>
			</table>
		</div>";
	echo"</page>";
	}

	
else{
	$i=1;
	while($rstudent=$qstudent->fetch_assoc()){
		$kampus = $rstudent['camp_id'];
	if($kampus=='1' || $kampus =='2'){
		$n_kampus="KJ";
	}else if ($kampus=='3' || $kampus=='4'){
		$n_kampus="PIK";
	}else if ($kampus=='5' || $kampus=='6'){
		$n_kampus="BDG";
	}else if ($kampus=='7' || $kampus=='8'){
		$n_kampus="SMG";
	}else if ($kampus=='9' || $kampus=='10'){
		$n_kampus="MLG";
	}else if ($kampus=='12' || $kampus=='14'){
		$n_kampus="BPN";
	}	
		
	if($i<10){
		$c_i="000".$i;
	} 
	else 
		if($i<100){
		$c_i="00".$i;
	} 
	else 
		if($i<1000){
		$c_i="0".$i;
	} 
	else 
		if($i>1000){
		$c_i=$i;
	}
		//$ncamp=$r['Campus'];
		//$nroom=$r['Class_Name'];
			echo '<page orientation="paysage">
	<div  style="padding-top:155mm;  background-image: url(Certificate 24092020_compressed.jpg);  background-size: contain;">
	<div style="margin: auto;">
		<br>
	 
		 
	  ';
	
		$namefile=str_replace(' ', '-', $rstudent['student'].'_'.substr(str_replace("'", '', $rstudent['title']), 0,20));
		echo '<div style="margin-top:-220pt;"><div style="line-height:0.5; font-family:aparabi; font-style:italic; color:black; text-align:left;margin-left:237pt; font-size:43pt"><b>'.$rstudent['student'].'</b></div>
		 <br>';
		echo '<div style="line-height:0.9; font-family:times; color:black; text-align:left;margin-left:237pt; font-size:10pt"><b>HAS SUCCESSFULLY COMPLETED 4 HOURS OF</b></div>
		<br>';
			
		echo '<div style="line-height:1; font-family:times; color:black; text-align:left;margin-left:237pt; font-size:14pt"><b>'.$rstudent['title'].'</b></div>
		<br>
		<div style="line-height:1; font-family:times; color:black; text-align:left;margin-left:237pt; font-size:10pt"><b>HELD ON THRUSDAY, 24th September, 2020.</b> </div>	
		</div>	
		<br> 	
		<br>
		<br>
		<br>
		<br>
		<br>
		<br>
		
 
		 
		<span style="line-height:1; font-family:times; color:black; text-align:left;margin-left:272pt; font-size:10pt">
		<img src="richard_kjs.png" style="height: 15mm;">
		</span>	
		<span style="line-height:1; font-family:times; color:black; text-align:left;margin-left:115pt; font-size:10pt">
		<img src="mr mohan.jpeg" style="height: 15mm;  margin-left:22mm;">
		
		</span>	
		<br>
		<br>
		<br>
		<br>
		<br>
		<br>
		<br>
		<br>
		<br>
		<br>
		<br>
		<br>
		<br>
 
		';
	 
	echo "</div>
			 
			";
 
	echo"</div>";
	echo"</page>";
	$i++;
	}	
}
//final	
 

$content=ob_get_clean();
//$namefile="asasas";
//$medal."_".$nroom."_".$ncamp;;

//convert in pdf

require_once(dirname(__FILE__).'/html2pdf/html2pdf.class.php');
try
  {
    $html2pdf = new HTML2PDF('L', 'A4', 'en', true, 'utf-8', array(0,0,0,0));
	$html2pdf->writeHTML($content);
    $html2pdf->Output('E-Cert_'.$namefile.'.pdf');
    }
catch(HTML2PDF_exception $e) 
	{
    echo $e;
    exit;
    }
?>
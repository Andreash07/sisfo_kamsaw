<?php
include ("sql_convert.php");
//perulangan page report		
//$rows=$query->num_rows;
$date=$_GET['date'];
$level_id=$_GET['level_id'];
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
//code_campus
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
//code_certificate
if($level_id=='13' || $level_id=='14'){
	$level_cert="CSE";
}else if($level_id=='17'){
	$level_cert="CJCE";
}else if($level_id=='6'){
	$level_cert="CPE";
}else if($level_id=='23'){
	$level_cert="CPSE";
}
//code_year
if($year=='16'){
	$year='2016';
}else if($year=='17'){
	$year='2017';
}

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
		<div style="margin: auto;">
		<br>
		<br>
		<br>
		<br>
		<br>';
		echo '<div style="line-height:1; font-family:times; color:black; text-align:center; font-size:26pt"><b>'.$level.'</b></div>
		<br>';
		echo '<div style="line-height:0.9; font-family:times; color:black; text-align:center; font-size:16pt">is awarded to</div>
		<br>
		<br>';
		echo '<div style="line-height:0.5; font-family:aparabi; font-style:italic; color:black; text-align:center; font-size:43pt"><b>'.$rstudent['student'].'</b></div>
		<br>
		<br>';
		echo '<div style="line-height:1; font-family:times; color:black; text-align:center; font-size:16pt">on</div>	
		<br>
		<br>';		
		echo '<div style="line-height:1; font-family:times; color:black; text-align:center; font-size:18pt"><b>'.$day.' '.$month.' '.$year.'</b></div>
		<br>
		<br>
		<br>
		<br>
		<br>';
	echo "</div>
			<br>
			<br>
			<br>
			<br>
			<br>
			";
	
		//principal
		
		echo "<table >
				<tr>";
				if($kampus==2)
				{
					echo "<td style='width:445px; font-family:aparaji; font-size:14pt; text-align:center;'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
					<span style='margin-top:-65px;'><img src='richard_kjs.png' style='height: 70px;'><br>
			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".$principal."</span></td>"; 
				}else if($kampus==4){
				echo "<td style='width:445px; font-family:aparaji; font-size:14pt; text-align:center;'>
				&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span style='margin-top:-10px;'>".$principal."</span></td>"; 
				}else if($kampus==3){
				echo "<td style='width:445px; font-family:aparaji; font-size:14pt; text-align:center;'>
			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span style='margin-top:12px;'>".$principal."</span></td>"; 	
					
				}
				else
				{
			echo "<td style='width:445px; font-family:aparaji; font-size:14pt; text-align:center;'>
			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span style='margin-top:20px;'>".$principal."</span></td>"; 
				}
	
			

		//teacher
		if($kampus==2)
				{
					echo "<td style='width:150px;'></td>";
	echo "<td style='width:445px; font-family:aparaji;  font-size:14pt; text-align:center;'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span style='margin-top:5px;'>
			Paulus Sia</span></td>"; 
				}else if($kampus==4){
					echo "<td style='width:160px;'></td>";
					echo "<td style='width:390px; font-family:aparaji;  font-size:14pt; text-align:center;'><span style='margin-top:-10px;'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Paulus Sia</span></td>";
				}else if($kampus==3){
					echo "<td style='width:160px;'></td>";
					echo "<td style='width:390px; font-family:aparaji;  font-size:14pt; text-align:center;'><span style='margin-top:10px;'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Paulus Sia</span></td>"; 
				}else{
					echo "<td style='width:160px;'></td>";
					echo "<td style='width:390px; font-family:aparaji;  font-size:14pt; text-align:center;'><span style='margin-top:20px;'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Paulus Sia</span></td>"; 
				}
		echo "</tr>
			</table>";
	echo "<div style='position: absolute; bottom:10px; right:10px; font-family:times;  font-size:9pt;'>".$c_i."/".$level_cert."/".$n_kampus."/".$year."</div>";
	echo"</page>";
	$i++;
	}	
}
//final	
?>
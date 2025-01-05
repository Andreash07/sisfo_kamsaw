<?php
include ("../konek.php");

$buka=bukakoneksi();
$camp_id=$_POST['kampus'];
$level_id=$_POST['level_id'];
if($level_id=='0'){
	$level_id = 6;
}
$select="select A.id, A.graduation_date
		from graduation_date A
		where camp_id='".$camp_id."' && level_id='".$level_id."'";
$qgraduate=$buka->query($select);
$rows=$qgraduate->num_rows;
if($rows==0){
	$json['graduate'][]=0;
}
if($rows>0){	
while($rgraduate=$qgraduate->fetch_assoc()){
	$json['graduate'][]=$rgraduate;
}
}
mysqli_close($buka);
echo json_encode($json);


?>
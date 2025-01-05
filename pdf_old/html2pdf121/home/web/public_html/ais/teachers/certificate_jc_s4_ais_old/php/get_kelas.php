<?php
include ("../konek.php");

$buka=bukakoneksi();
$camp_id=$_POST['idcam'];
$select="SELECT B.name as class_name, B.id as room_id, a.level_id, A.id as classroom_id, a.camp_id, a.academicyear_id
from classrooms A 
join rooms B on(b.id = a.room_id)
where (a.camp_id='".$camp_id."' && a.academicyear_id=16) && (b.initials like 'S4%' || b.initials like 'JC2%')
order by a.level_id ASC";
$qcamps=$buka->query($select);
if(!$qcamps){}
else
{
	while($r=$qcamps->fetch_assoc())
	{
	$json['data'][]=$r;
	}
}

echo json_encode($json);

?>
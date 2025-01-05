<?php
include("../konek.php");

$buka=bukakoneksi();
//cek ay first
$syear="select academicyear_id from classrooms where id ='".$_GET['classroom_id']."'";
$qyear=$buka->query($syear);
while($ryear=$qyear->fetch_assoc()){
	$ay_id=$ryear['academicyear_id'];
}
//cek ay first

$level_id=$_GET['level_id'];
$kampus=$_GET['kampus'];
$room=$_GET['room_id'];
if($level_id=='0'){
	//$kon=" && A.classroom_id = '".$_REQUEST['classroom_id']."' && C.name LIKE '%kindergarten 2%'";	
	$kon=" && C.name LIKE '%kindergarten 2%' && F.id NOT IN (6466,6468)";	
}else{
	$kon=" && B.level_id ='".$level_id."' ";	

}
$sstudent="SELECT CONCAT(D.firstname,' ',D.lastname) as student, C.name as room, B.academicyear_id as year, B.id as classroom
from classstudents A 
join students E on (E.id = A.student_id)
join classrooms B on (B.id = A.classroom_id)
join rooms C on (C.id = B.room_id)
join profiles D on (D.id = E.profile_id)
join users F on (F.id = D.id)
where A.camp_id ='".$kampus."' $kon && B.academicyear_id ='".$ay_id."' && F.status = 1 && D.firstname NOT LIKE '%sample%'
group by A.student_id
order by student ASC
"; //limit 2
$qstudent=$buka->query($sstudent);

/*$pselect="SELECT A.id as Classroom_id, A.room_id as room_id, CONCAT(C.firstname,' ',c.lastname) AS principal, A.level_id as level, C.title as ptitle, CONCAT(D.firstname,' ',D.lastname) AS formteacher, D.title as ftitle,E.staff_id
		FROM classrooms A 
        JOIN camps E ON(E.id = A.camp_id)
        JOIN profiles D ON (D.id = A.staff_id)
        JOIN profiles C ON (C.id = E.staff_id )
		WHERE A.academicyear_id =16 AND A.id = '".$classroom."'";*/
$pselect="Select A.id as camp_id, CONCAT(C.firstname,' ',C.lastname) AS principal, C.title as ptitle
		FROM camps A 
        JOIN profiles C ON (C.id = A.staff_id)
		WHERE A.id='".$kampus."'";
//$qstudent=$buka->query($sstudent);
//academic_year
$qstudentyear=$buka->query($sstudent);
$rstudentyear=$qstudentyear->fetch_assoc();
$room_name=$rstudentyear['room'];
//die($pselect);
//$year=$rstudentyear['year'];


$qprincipal=$buka->query($pselect);
$rprincipal=$qprincipal->fetch_assoc();

if($level_id=='23' && $kampus=='3')$principal = 'Pusparini Margie Wirda';
else if($level_id=='23' && $kampus=='1')$principal = 'Maria Criselda Espelita';
else if($level_id=='23' && $kampus=='7')$principal = 'Oriana Diplacido';
else $principal=$rprincipal['principal'];
?>
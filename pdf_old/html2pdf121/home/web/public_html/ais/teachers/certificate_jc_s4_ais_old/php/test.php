<?php 
include("../konek.php");
$ptselect="SELECT A.id as Classroom_id, A.room_id as room_id, CONCAT(C.firstname,' ',c.lastname) AS principal, A.level_id as level, C.title as ptitle, CONCAT(D.firstname,' ',D.lastname) AS formteacher, D.title as ftitle,E.staff_id
		FROM classrooms A 
        JOIN camps E ON(E.id = A.camp_id)
        JOIN profiles D ON (D.id = A.staff_id)
        JOIN profiles C ON (C.id = E.staff_id )
		WHERE A.academicyear_id =16 AND A.id = '".$ruang."'";
$ptquery=$buka->query($select);		

				while($rpt=$ptquery->fetch_assoc()){
		echo "<div>";
		echo "<div style='float: left'>".$rpt['principal']."</div>";
		echo "<div style='float: right'>".$rpt['formteacher']."</div>";
		echo "</div>";
				}
?>
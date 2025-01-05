<html>
<body>
<head>
<style>
<style type="text/css">
table {

	width: 100%;

	margin:0; 

 	padding:0;

	font-family: "Trebuchet MS", Trebuchet, Arial, sans-serif;	

	color: #1c5d79;

	

}

table, tr, th, td {

	border-collapse: collapse;

}

caption {

margin:0; 

 	padding:0;

	background: #f3f3f3;

	height: 40px;

	line-height: 40px;

	text-indent: 28px;

	font-family: "Trebuchet MS", Trebuchet, Arial, sans-serif;	

	font-size: 14px;

	font-weight: bold;

	color: #555d6d;

	text-align: left;

	letter-spacing: 3px;

	border-top: dashed 1px #c2c2c2;

	border-bottom: dashed 1px #c2c2c2;

}



/* HEAD */



thead {

	background-color: #FFFFFF;

	border: none;

}

thead tr th {

	height: 32px;

	line-height: 32px;

	text-align: center;

	color: #1c5d79;

	background-image: url(../bbswebsite/col_bg.gif);

	background-repeat: repeat-x;

	border-left:solid 1px #FF9900;

	border-right:solid 1px #FF9900;	

	border-collapse: collapse;

	

}



/* BODY */



tbody tr {

	background: #dfedf3;

	font-size: 16px;

}

tbody tr.odd {

	background: #F0FFFF;

}

tbody tr:hover, tbody tr.odd:hover {

	background: #ffffff;

}

tbody tr th, tbody tr td {

	padding: 6px;

	border: solid 1px #326e87;

}

tbody tr th {

	background: #1c5d79;

	font-family: "Trebuchet MS", Trebuchet, Arial, sans-serif;	

	font-size: 14px;

	padding: 6px;

	text-align: center;

	font-weight: bold;

	color: #FFFFFF;

	border-bottom: solid 1px white;

}

tbody tr th:hover {

	background: #ffffff;



}



/* LINKS */



table a {

	color: #FF6600;

	text-decoration: none;

	font-size: 13px;

	border-bottom: solid 1px white;

}

table a:hover {

	color: #FF9900;

	border-bottom: none;

}



/* FOOTER */



tfoot {

	background: #f3f3f3;

	height: 24px;

	line-height: 24px;

	font-family: "Trebuchet MS", Trebuchet, Arial, sans-serif;	

	font-size: 14px;

	font-weight: bold;

	color: #555d6d;

	text-align: center;

	letter-spacing: 3px;

	border-top: solid 2px #326e87;

	border-bottom: dashed 1px #c2c2c2;

}

tfoot tr th, tfoot tr td {

	/*padding: .1em .6em;*/

	

}

tfoot tr th {

	border-top: solid 1px #326e87;

}

tfoot tr td {

	text-align: right;

	

}

.note{
    font-family:tahoma;
    font-size:12px;
    color:#333333;
}
.input{
    font-family:Verdana, Arial, Helvetica, sans-serif;
    font-weight:normal;
    font-size:12px;
    border:1px #6a6a6a solid;
}
.text{
    font-family:tahoma;
    font-size:11px;
    font-weight:bold;
    color:#6a6a6a;
    background-color:#EAEAEA;
}
.btn{
    font-weight:bold;
}


a:link {
	color: #003366;
	text-decoration: none;
}
a:visited {
	text-decoration: none;
	color: #003366;
}
a:hover {
	text-decoration: none;
	color: #FF0000;
}
a:active {
	text-decoration: none;
	color: #003366;
}
.style3 {
	font-size: 14px;
	font-weight: bold;
	font-style: italic;
}
body,td,th {
	font-family: Geneva, Arial, Helvetica, sans-serif;
	font-size: small;
	color: #666666;
}
</style>
<?php
function stDev($arr)
{
    // Calculates the standard deviation for all non-zero items in an array
 
    $n = count(array_filter($arr));   // Counts non-zero elements in the array.
    $mean = array_sum($arr) / $n;     // Calculates the arithmetic mean.
    $sum = 0;        
 
    foreach( $arr as $key=>$a )
    {
        $sum = $sum + pow( $a - $mean , 2 );
    }
 
    $stdev = sqrt( $sum / $n ) ;
	
    return $stdev;
}

require('dblink.php');

$arr_class = array();

$db = db_open();

if(!$db->autocommit(FALSE)){
	db_error($json,$db,'Unable to start transaction',100,"");
}	
//GET ALL subject first
echo("<table class='stafftable'>");
echo("<tr><th>Exam</th><th>Subject</th><th>Total Students</th><th>U(0-39)</th><th>E(40-49)</th><th>D(50-59)</th><th>C(60-69)</th><th>B(70-79)</th><th>A(80-89)</th><th>A*(90-above)</th><th>Max</th><th>Min</th><th>Mean</th><th>SD</th><th>% of Pass</th></tr>");

$getsub = "SELECT * FROM subjectprelims WHERE code not like '0%' order by code";
$ssub = $db->query($getsub);
while($rsub= $ssub->fetch_assoc())
{
	$sid = $rsub["id"];
	$subject = $rsub['name'];
	$code = $rsub['code'];
	//echo($sid);

$q = "SELECT CONCAT( C.firstname,  ' ', C.lastname ) AS Student_Name, D.name AS Subject, G.initials as Class,  F.initials AS Campus, A.apum AS pum, A.grade2 as grade
	FROM enrollprelims A
	JOIN students B ON ( B.id = A.student_id ) 
	JOIN profiles C ON ( C.id = B.profile_id ) 
	JOIN subjectprelims D ON ( D.id = A.subjectprelim_id ) 
	JOIN classsubjectprelims E ON ( E.id = A.classsubjectprelim_id ) 
	JOIN classrooms X ON(X.id = E.classroom_id)
	JOIN camps F ON ( F.id = E.camp_id )
	JOIN rooms G ON ( G.id = X.room_id )
	WHERE E.academicyear_id =18 AND D.category=1
	and D.id = '".$sid."'
	and A.apum > 0
	ORDER BY A.apum";
	//echo($q);
	$m0to20 = 0;
	$m21to49 = 0;
	$m50to54 = 0;
	$m55to64 = 0;
	$m65to74 = 0;
	$m75to84 = 0;
	$m85above=0;
	$max = 0;
	$min = 100;
	$mean = 0;
	$sd = 0;
	$pass = 0;
	$total = 0;
	
	$s = $db->query($q);
	if (!$s) {
	}
	if ($s->num_rows == 0) {
		$m0to20a =  0;
		$m21to49a = 0;
		$m50to54a = 0;
		$m55to64a = 0;
		$m65to74a = 0;
		$m75to84a = 0;
		$m85abovea=0;
		$max = 0;
		$min = 0;
		$mean = 0;
		$sd = 0;
		$pass = 0;
		$total = 0;
	}
	$ctr = 0;
	while($r = $s->fetch_assoc())
	{
		
			$mark = $r["pum"];
			//echo('mark: '.$mark);
			$total = $total+$mark;
			$arr_marks[$ctr] = $mark;
			if($mark<40)
			{
				$m0to20 = $m0to20 + 1;
			}
			elseif(($mark>=40) && ($mark<50)) //E
			{
				$m21to49 = $m21to49 + 1;
			}
			elseif(($mark>=50) && ($mark<60)) //D
			{
				$m50to54 = $m50to54 + 1;
			}
			elseif(($mark>=60) && ($mark<70)) //C
			{
				$m55to64 = $m55to64 + 1;
			}
			elseif(($mark>=70) && ($mark<80)) //B
			{
				$m65to74 = $m65to74 + 1;
			}
			elseif(($mark>=80) && ($mark<90)) //A
			{
				$m75to84  = $m75to84  + 1;
			}
			else
			{
				$m85above = $m85above+1;
			}
			$ctr++;
			
			//GET OTHRES
			if($mark>$max)
				$max = $mark;
			
			if($mark<$min)
				$min = $mark;
			if($mark>=40)
				$pass = $pass+1;
	}
		$mean = round(($total/$ctr),2);
		$m0to20a =  round((($m0to20/$ctr)*100),2);
		$m21to49a = round((($m21to49/$ctr)*100),2);
		$m50to54a = round((($m50to54/$ctr)*100),2);
		$m55to64a = round((($m55to64/$ctr)*100),2);
		$m65to74a = round((($m65to74/$ctr)*100),2);
		$m75to84a = round((($m75to84/$ctr)*100),2);
		$m85abovea=round((($m85above/$ctr)*100),2);
		$sd = round(stDev($arr_marks),2);
		$pass = round((($pass/$ctr)*100),2);
		if($ctr>0)
		{
			if($mean<50)
			{
				echo("<tr style='background-color: #f7998f;'>");
			}
			else
			{
				echo("<tr>");
			}
			if(substr($code,0,1)=="0")
			{
				$etype = "IGCSE";
			}
			else
			{
				$etype = "A LEVEL";
			}
			echo("<td>".$etype."</td>");
			echo("<td>".$subject."(".$code.")</td>");
			echo("<td>".$ctr."</td>");
			echo("<td>".$m0to20a ."%</td>");
			echo("<td>".$m21to49a ."%</td>");
			echo("<td>".$m50to54a."%</td>");
			echo("<td>".$m55to64a."%</td>");
			echo("<td>".$m65to74a."%</td>");
			echo("<td>".$m75to84a ."%</td>");
			echo("<td>".$m85abovea."%</td>");
			echo("<td>".$max."</td>");
			echo("<td>".$min."</td>");
			echo("<td>".$mean."</td>");
			echo("<td>".$sd."</td>");
			echo("<td>".$pass."%</td>");
			echo("</tr>");
		}
	
} //END OF GET SUBJECT
echo("</table>");
//GET STATS UNTIL HERE


echo("<br><hr><br>");
if(!$db->commit()){
	db_error($json,$db,'commit false',101,'');
}


?>
</body>
</html>

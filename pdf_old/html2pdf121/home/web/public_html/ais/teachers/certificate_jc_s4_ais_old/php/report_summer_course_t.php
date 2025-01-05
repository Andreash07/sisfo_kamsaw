<?php
error_reporting(E_ALL);
//include("sql_convert.php");
ob_start();
 
function convertNumber($number)
{
    list($integer, $fraction) = explode(".", (string) $number);

    $output = "";

    if ($integer{0} == "-")
    {
        $output = "negative ";
        $integer    = ltrim($integer, "-");
    }
    else if ($integer{0} == "+")
    {
        $output = "positive ";
        $integer    = ltrim($integer, "+");
    }

    if ($integer{0} == "0")
    {
        $output .= "zero";
    }
    else
    {
        $integer = str_pad($integer, 36, "0", STR_PAD_LEFT);
        $group   = rtrim(chunk_split($integer, 3, " "), " ");
        $groups  = explode(" ", $group);

        $groups2 = array();
        foreach ($groups as $g)
        {
            $groups2[] = convertThreeDigit($g{0}, $g{1}, $g{2});
        }

        for ($z = 0; $z < count($groups2); $z++)
        {
            if ($groups2[$z] != "")
            {
                $output .= $groups2[$z] . convertGroup(11 - $z) . (
                        $z < 11
                        && !array_search('', array_slice($groups2, $z + 1, -1))
                        && $groups2[11] != ''
                        && $groups[11]{0} == '0'
                            ? " and "
                            : ", "
                    );
            }
        }

        $output = rtrim($output, ", ");
    }

    if ($fraction > 0)
    {
        $output .= " point";
        for ($i = 0; $i < strlen($fraction); $i++)
        {
            $output .= " " . convertDigit($fraction{$i});
        }
    }

    return $output;
}

function convertGroup($index)
{
    switch ($index)
    {
        case 11:
            return " decillion";
        case 10:
            return " nonillion";
        case 9:
            return " octillion";
        case 8:
            return " septillion";
        case 7:
            return " sextillion";
        case 6:
            return " quintrillion";
        case 5:
            return " quadrillion";
        case 4:
            return " trillion";
        case 3:
            return " billion";
        case 2:
            return " million";
        case 1:
            return " thousand";
        case 0:
            return "";
    }
}

function convertThreeDigit($digit1, $digit2, $digit3)
{
    $buffer = "";

    if ($digit1 == "0" && $digit2 == "0" && $digit3 == "0")
    {
        return "";
    }

    if ($digit1 != "0")
    {
        $buffer .= convertDigit($digit1) . " hundred";
        if ($digit2 != "0" || $digit3 != "0")
        {
            $buffer .= " and ";
        }
    }

    if ($digit2 != "0")
    {
        $buffer .= convertTwoDigit($digit2, $digit3);
    }
    else if ($digit3 != "0")
    {
        $buffer .= convertDigit($digit3);
    }

    return $buffer;
}

function convertTwoDigit($digit1, $digit2)
{
    if ($digit2 == "0")
    {
        switch ($digit1)
        {
            case "1":
                return "ten";
            case "2":
                return "twenty";
            case "3":
                return "thirty";
            case "4":
                return "forty";
            case "5":
                return "fifty";
            case "6":
                return "sixty";
            case "7":
                return "seventy";
            case "8":
                return "eighty";
            case "9":
                return "ninety";
        }
    } else if ($digit1 == "1")
    {
        switch ($digit2)
        {
            case "1":
                return "eleven";
            case "2":
                return "twelve";
            case "3":
                return "thirteen";
            case "4":
                return "fourteen";
            case "5":
                return "fifteen";
            case "6":
                return "sixteen";
            case "7":
                return "seventeen";
            case "8":
                return "eighteen";
            case "9":
                return "nineteen";
        }
    } else
    {
        $temp = convertDigit($digit2);
        switch ($digit1)
        {
            case "2":
                return "twenty-$temp";
            case "3":
                return "thirty-$temp";
            case "4":
                return "forty-$temp";
            case "5":
                return "fifty-$temp";
            case "6":
                return "sixty-$temp";
            case "7":
                return "seventy-$temp";
            case "8":
                return "eighty-$temp";
            case "9":
                return "ninety-$temp";
        }
    }
}

function convertDigit($digit)
{
    switch ($digit)
    {
        case "0":
            return "zero";
        case "1":
            return "one";
        case "2":
            return "two";
        case "3":
            return "three";
        case "4":
            return "four";
        case "5":
            return "five";
        case "6":
            return "six";
        case "7":
            return "seven";
        case "8":
            return "eight";
        case "9":
            return "nine";
    }
}
include("../konek.php");

$buka=bukakoneksi();
$sid=$_GET['sid'];
 
  $sstudent=" SELECT count(A.id) total,CONCAT(D.firstname,' ',D.lastname) as student,  G.title,G.description,G.requirements 
from summer_courses_pic A
left join summer_courses G on (G.id = A.summer_courses_id)
left join profiles D on (D.id = A.user_id)
left join users F on (F.id = A.user_id)
where A.user_id='".$_GET['usd']."' and A.summer_courses_id='".$_GET['sid']."'
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
$level="CERTIFICATION OF COMPLETION";
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
$namefile="";
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
		<div  style="padding-top:150.5mm;  background-image: url(Certificate_t 24092020_compressed.jpg);  background-size: contain;">
		<div style="margin: auto;">
		<br>
		 
		';
		
		echo '<div style="margin-top:-220pt;">
		 
		 <br>
		 <br>
		<div style="line-height:0.5; font-family:aparabi; font-style:italic; color:black; text-align:center; font-size:43pt"><b>'.$rstudent['student'].'</b></div>
		 <br>';
		echo ' 
		<br> 
		<br> 
		 <div style="line-height:1; font-family:times; color:black; text-align:center;font-size:16pt"><b>'.$rstudent['title'].'</b></div>	
		</div>';
		$namefile=str_replace(' ', '-', $rstudent['student'].'_'.substr(str_replace("'", '', $rstudent['title']), 0,20));
		 
	 //<img src="sgn-paulus_com.png" style="height: 15mm;">
        //<img src="yuliana.png" style="height: 15mm;">
		echo '<br> 	<br> 
	 
		<br>
		<br>
		<br>
		<br>
		<br>
		
		<span style="line-height:1; font-family:times; color:black; text-align:left;margin-left:250pt; font-size:10pt">
		
            <img src="richard_kjs.png" style="height: 15mm;margin-left:7mm;">
		</span>	
		<span style="line-height:1; font-family:times; color:black; text-align:left;margin-left:165pt; font-size:10pt">
            <img src="mr mohan.jpeg" style="height: 15mm; margin-left:10mm;">
		
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
		<br>
 
		';
	 
	 
	echo "</div>
		 
			";
	
	
	/*
	echo "<table style='margin-top:12px;'>
				<tr>";
 
					echo "<td style='width:445px; font-family:aparaji; font-size:14pt; text-align:center;'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
					<span style='margin-top:-65px; '><img src='yuliana.png' style='height:15mm;'><br>
					<span style='margin-top:15px;font-size:16pt;'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Ms Yuliana Pusptasari</span>
			<br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;___________________________<br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Superintendent, Academic Supervision Division</span></td>"; 
 
					echo "<td style='width:150px;'></td>";
	echo "<td style='width:445px; font-family:aparaji;  font-size:14pt; text-align:center;'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
	<span style='margin-top:-65px'>
	<img src='sgn-paulus_com.png' style='height: 15mm;'>
	<br><span style='margin-top:15px; font-size:16pt;'> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Paulus Sia
	</span>
	<br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;___________________________<br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Director of School</span></td>"; 
			//	}
		echo "</tr>
			</table>";
	 */
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
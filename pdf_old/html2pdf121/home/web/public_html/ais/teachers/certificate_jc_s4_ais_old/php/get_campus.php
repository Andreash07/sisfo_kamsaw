<?php
include ("../konek.php");

$buka=bukakoneksi();
$select="select * from camps where id %2 = 0";
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
<?php 

ob_start();

include ('html2pdf/konek.php');

include ('../application/helpers/function_helper.php');

$dbopen=bukakoneksi();

$wherekk="";

$wherejemaat="";

$additionName="";

if(isset($_GET['tahun'])){

	$wherejemaat.=" && D.tahun_pemilihan ='".$_GET['tahun']."'";

}

if(isset($_GET['wil'])){

	$wherekk.=" && A.kwg_wil='".$_GET['wil']."'";

	$wherejemaat.=" && A.kwg_wil='".$_GET['wil']."'";

	$additionName.="-Wil_".$_GET['wil'];

}

if(isset($_GET['id'])){

	$wherekk.=" && A.id='".$_GET['id']."'";

	$wherejemaat.=" && A.kwg_no='".$_GET['id']."'";

	$additionName.="-Kel_".$_GET['id'];

}



$sql_angjem="select A.*, B.kwg_nama, B.kwg_alamat, B.kwg_wil, B.kwg_no as no_kk, C.hub_keluarga, COUNT(D.id) as num_pemilih_konvensional, D.path_qrcode, D.sn_surat_suara, D.tahun_pemilihan

				from anggota_jemaat A

				join keluarga_jemaat B on B.id = A.kwg_no

				join ags_hub_kwg C on C.idhubkel = A.hub_kwg

				join pemilih_konvensional D on D.anggota_jemaat_id = A.id && A.kwg_no = D.kwg_no

				where A.id >0 && A.status=1 && A.sts_anggota=1 && B.status=1 && A.status_sidi=1 && YEAR(A.tgl_lahir) < 2005 && D.tipe_pemilihan_id='1' ".$wherejemaat."

				group by A.id

				order by B.kwg_wil ASC, B.kwg_nama ASC, A.no_urut ASC, A.nama_lengkap ASC"; //die($sql_angjem);

$qsql=$dbopen->query($sql_angjem);

$rsql=$qsql->fetch_all(MYSQLI_ASSOC);



$wil=array(1,2,3,4,5,6,7);
$rsql_calon=array();
$calon_wil=array();
$num_rows=array();
$kelCalon=array();
$sumKel=array();

foreach ($wil as $key => $value) {
	// code...
	$sql_calon="select A.*

					from anggota_jemaat A 

					where A.sts_anggota=1 && A.status_sidi=1 && A.status=1 && A.status_pn1=1 && A.kwg_wil='".$value."'

					group by A.id

					order by A.nama_lengkap ASC, A.kwg_wil ASC"; //die($sql_calon);

	$qsql_calon=$dbopen->query($sql_calon);

	$rsql_calon[$value]=$qsql_calon->fetch_all(MYSQLI_ASSOC);

	$num_rows[$value]=$qsql_calon->num_rows;

	$kelCalon[$value]=split_calon($rsql_calon[$value], $num_rows[$value]);
	$sumKel[$value]=count($kelCalon[$value]);
}


//print_r($rsql_calon);



	

$num_data=$num_rows;

$col=4;

$width_col=192/4;

//$row=$num_data/4;





function split_calon($allcalon, $num_rows) {
	//limit
	$limit1=25;
	$limit2=43;
	$kel=$num_rows/$limit1;
	$kel_calon=array();
	for($i=1; $i<=2; $i++){
		$numStart=($limit1*($i-1))-$limit1;
		if($i==1){
			$kel_calon[$i]=array_splice($allcalon, $numStart+$limit1);
		}
		else{
			$kel_calon[$i]=array_splice(array_splice($allcalon, 0, $numStart), $limit1);
		}
	}

	if($kel>2){
		for($i=3; $i<=4; $i++){
			$numStart=($limit1*($i-1))-$limit1;
			if($i==3){
				$kel_calon[$i]=array_splice($allcalon, $numStart+$limit1);
			}
			else{
				$kel_calon[$i]=array_splice(array_splice($allcalon, 0, $numStart), $limit1);
			}
		}
	}

	if($kel>4){
		for($i=5; $i<=6; $i++){
			$numStart=($limit1*($i-1))-$limit1;
			if($i==5){
				$kel_calon[$i]=array_splice($allcalon, $numStart+$limit1);
			}
			else{
				$kel_calon[$i]=array_splice(array_splice($allcalon, 0, $numStart), $limit1);
			}
		}
	}

	if($kel>6){
		for($i=7; $i<=8; $i++){
			$numStart=($limit1*($i-1))-$limit1;
			if($i==7){
				$kel_calon[$i]=array_splice($allcalon, $numStart+$limit1);
			}
			else{
				$kel_calon[$i]=array_splice(array_splice($allcalon, 0, $numStart), $limit1);
			}
		}
	}

	if($kel>8){
		for($i=9; $i<=10; $i++){
			$numStart=($limit1*($i-1))-$limit1;
			if($i==7){
				$kel_calon[$i]=array_splice($allcalon, $numStart+$limit1);
			}
			else{
				$kel_calon[$i]=array_splice(array_splice($allcalon, 0, $numStart), $limit1);
			}
		}
	}

	if($kel>10){
		for($i=11; $i<=12; $i++){
			$numStart=($limit1*($i-1))-$limit1;
			if($i==11){
				$kel_calon[$i]=array_splice($allcalon, $numStart+$limit1);
			}
			else{
				$kel_calon[$i]=array_splice(array_splice($allcalon, 0, $numStart), $limit1);
			}
		}
	}

	return $kel_calon;
	//get row for table1 n table2

}
function truncate($text, $chars = 120) {

    if(strlen($text) > $chars) {

        $text = $text;

        $text = substr($text, 0, $chars);

        if(strrpos($text ,' ')>-1){

            $text = substr($text, 0, strrpos($text ,' '));

        }

        else{

            $find=array(',','|','-','_');

            $replace=" ";

            $text = str_replace($find,$replace,$text);

            $text = substr($text, 0, strrpos($text ,' '));

        }

        $text = $text.'...';

    }

    return $text;

}

/*function singkat_nama($string=null){

        //FERININGSIH BUDI

    //$string='FERININGSIH BUDI PRASADA HAGNI';

    $trim_string=trim($string);

    //echo "trim: ".$trim_string."<br>";

    $arr_nama=explode(' ', $trim_string);

    $lastword=-1;

    $limit=21;

    $tot_len=0;

    $cut_position=-1;

    foreach ($arr_nama as $key => $value) {

        // code...

        if($lastword>-1){

            continue;

        }



        $len_word=strlen($value);

        $tot_len=$tot_len+$len_word+1;



        if($tot_len>=$limit){

            if($key>0){

                $lastword=$key-1;

                $cut_position=strlen($arr_nama[$key-1]);

            }

            else{

                $lastword=$key;

                $cut_position=strlen($arr_nama[$key]);

            }

        }else{



        }

    }



    $new_string="";

    if($lastword>-1){

        foreach ($arr_nama as $key => $value) {

            // code...

            if($key<=$lastword){

                $new_string.=$value." ";

            }

            else{

                $len_word=strlen($value);

                $new_string.=substr($value, 0,1).". ";

            }

        }

    }

    else{

        $new_string=$trim_string;

    }

    //echo $tot_len."<br>";

    //echo $lastword."<br>";



    return $new_string;



}*/

?>

<style type="text/css">

/* Page margins are defined using CSS */

    @page {

      margin: 1cm;

      margin-top:2.5cm;

      margin-bottom: 2.5cm;



    /* Header frame starts within margin-top of @page */

      /*@frame header {

      -pdf-frame-content: headerContent; /* headerContent is the #id of the element */

      /*top: 1cm;

      margin-left: 1cm;

      margin-right:1cm;

      height:1cm;

      }*/



    /* Footer frame starts outside margin-bottom of @page */

      @frame footer {

        -pdf-frame-content: footerContent;

        bottom: 2cm;

        margin-left: 1cm;

        margin-right: 1cm;

        height: 1cm;

      }

    }



	.text-center {

		text-align: center;

	}



	.indent-left {

		padding-left: 5px;

	}



	.border {

		border: 1px solid #000;

	}

	.border-b {

		border-bottom: 1px solid #000;

	}

	td {

		/*border: 1px solid #000;*/

	}

	.f-14{

		font-size: 14pt;

	}

	.f-12{

		font-size: 12pt;

	}

	.f-9{

		font-size: 9pt;

	}

	.f-8{

		font-size: 8pt;

	}



	.h-75{

		height: 7.5mm;

	}

	.h-50{

		height: 5mm;

	}

	.h-65{

		height: 6.5mm;

	}



	.bg-gray{

		background-color: #ededed;

	}

	table{

		font-size: 10pt;

		border-spacing: 0px;

    	border-collapse: collapse;

	}

	h2{

		font-size: 22pt;

	}

	h4{

		font-size: 18pt;

	}

	.break {

	    page-break-after: always;

	  }

</style>

<?php

foreach ($rsql as $key => $value) {

	$qrcode=$value['path_qrcode'];

?>

<page backtop="0" backbottom="20;" style="position: relative;">

<table style="width: 200mm; border:1px solid #000;">

	<tr>

		<td>

			<table style="width: 100%;" cellpadding ="0" cellspacing ="0">

				<tr>

					<td>

						<img src="../assets/images/logo-gkp.png" style="width: auto; height: 20mm; margin-top: -2mm;">

					</td>

					<td class="f-9"  style=" width: 190mm; vertical-align:top; padding-left: 10mm;">

						<h4 style="padding: unset; margin:unset; margin-bottom: 1mm; margin-top: -1mm;">GEREJA KRISTEN PASUNDAN</h4>

						Jemaat  "KAMPUNG SAWAH"<br>

						Jl. Raya Kampung Sawah RT.003/04 No.33

						<br>

						Telp. (021) 8450829

					</td>

				</tr>

				<tr>

					<td colspan="2">&nbsp;&nbsp;</td>

				</tr>

			</table>

			<table style="width: 200mm; margin-top:-3mm;" cellpadding ="0" cellspacing ="0">

				<tr>

					<th class="f-9" colspan="6" style="width: 200mm	;">

						&nbsp;

					</th>

				</tr>

				<tr>

					<th class="f-9" style="vertical-align: top; width: 18mm	;">

						Keluarga Jemaat

					</th>

					<th class="f-9" style="vertical-align: top; width: 1mm;">

						: 

					</th>

					<td class="f-9" style="vertical-align: top; width: 27mm;">

						<?=$value['kwg_nama'];?>

					</td>



					<th class="f-9" style="vertical-align: top;  width: 8mm; ">

						Alamat

					</th>

					<th class="f-9" style="vertical-align: top; width: 1mm; ">

						: 

					</th>

					<td class="f-9" style="vertical-align: top; width:30mm;">

						<?=$value['kwg_alamat'];?>

					</td>

					

				</tr>

				<tr>

					<th class="f-9" style="vertical-align: top; width: 18mm; ">

						Peserta Pemilihan

					</th>

					<th class="f-9" style="vertical-align: top; width: 1mm; ">

						: 

					</th>

					<td class="f-9" style="vertical-align: top; width: 27mm;">

						<?=$value['nama_lengkap'];?>

					</td>

					<th class="f-9" style="vertical-align: top; width: 8mm;">

						Wilayah

					</th>

					<th class="f-9" style="vertical-align: top; width: 1mm; ">

						: 

					</th>

					<td class="f-9" style="vertical-align: top; width: 30mm;">

						<?=$value['kwg_wil'];?>

					</td>

				</tr>

				<tr>

					<th colspan="6" style="height: 1mm;">

						&nbsp;

					</th>

				</tr>

			</table>

		</td>

	</tr>

	<tr>

		<td style="font-style: italic; border-bottom: 1px dashed #000;" class="f-8 text-center">

			Catatan: Silahkan guting bagian atas ini sebelum menyerahkan Surat Suara.

		</td>

	</tr>

</table>

<table style="width: 210mm; border:1px solid #000; margin-top: 3mm;" >

	<tr>

		<td>

			<table style="float: right; height: 50mm;" cellpadding ="0" cellspacing ="0">

				<tr>

					<td style="width: 25mm; height: 20mm; vertical-align: top; ">

						<img src="../<?=$qrcode;?>" style="height: 20mm; float: right;">

					</td>

					<td style="width: 170mm; height: 20mm; vertical-align: top; text-align: center;">

						<h4 style="padding: unset; margin: unset;   margin-top: 1mm; margin-bottom: 2mm;">Surat Suara Pemilihan Penatua Tahap 1</h4>

						Periode: 2022 - 2026

					</td>

				</tr>

			</table>

		</td>

	</tr>

</table>

<table style="width: 210mm; border:1px solid #000;" >

	<tr>

		<td class="f-9">

			Panduan: 

			<ol  start="1" style="padding-top: 0px; margin-top:-3mm;">

				<li>Silahakan Gunakan Hak Suara Anda dan <b>Pilih 8 Calon Penatua</b> yang tersedia (<b>4 Perempuan</b> & <b>4 Laki-Laki</b>)!</li>

				<li>Peserta Pemilihan hanya diperbolehkan memilih 8 Calon saja, Jika lebih akan dianggap tidak sah dan tidak akan dihitung.</li>

				<li>Peserta Pemilihan hanya diperbolehkan memilih Calon dari wilayahnya masing-masing.</li>
				<li>Beritanda <img src="../assets/images/check.png" style="height: 15px;"> pada kolom kosong disamping nama Calon</li>

			</ol>

		</td>

	</tr>

</table>

<hr style=" border: 1px solid #333333; margin-top: -3mm;">
<h3 style="margin-bottom: unset;">Calon Penatua (Wilayah <?=$value['kwg_wil'];?>)</h3>

<table style="width: 90mm; border:1px solid #000;" >

	<tr>
		<th style="width: 8mm;" class="border text-center">#</th>
		<th style="width: 60mm;" class="border text-center">Nama Calon</th>
		<th style="width: 12mm;" class="border text-center"></th>
	</tr>

	<?php 
	print_r($kelCalon);die();
		foreach ($kelCalon[1] as $key_calon => $value_calon) {
			// code...
	?>
		<tr>
			<td style="width: 8mm;" class="border"><?=$key_calon+1;?></td>
			<td style="width: 70mm;" class="f-12 border"><?=singkat_nama($value_calon['nama_lengkap']);?></td>
			<th style="width: 12mm;" class="border">
				<div style="border:0px solid #000; width: 25px;height: 25px;"></div>
			</th>
		</tr>
	<?php
	}
	?>
</table>

<table style="width: 90mm; border:1px solid #000;" >

	<tr>
		<th style="width: 8mm;" class="border text-center">#</th>
		<th style="width: 60mm;" class="border text-center">Nama Calon</th>
		<th style="width: 12mm;" class="border text-center"></th>
	</tr>

	<?php 
		foreach ($kelCalon[2] as $key_calon => $value_calon) {
			// code...
	?>
		<tr>
			<td style="width: 8mm;" class="border"><?=$key_calon+1+25;?></td>
			<td style="width: 70mm;" class="f-12 border"><?=singkat_nama($value_calon['nama_lengkap']);?></td>
			<th style="width: 12mm;" class="border">
				<div style="border:0px solid #000; width: 25px;height: 25px;"></div>
			</th>
		</tr>
	<?php
	}
	?>
</table>



<page_footer style="text-align: right;">

   sn: <?=$value['sn_surat_suara'];?>

</page_footer>

</page>



<?php

}

?>

<?php



if(!isset($_GET['dev'])){



$content = ob_get_clean();

//echo dirname(__FILE__).'/html2pdf/html2pdf.class.php';

// convert in PDF

//require_once(dirname(__FILE__).'/../html2pdf.class.php');

require_once(dirname(__FILE__).'/html2pdf/html2pdf.class.php');

try

{

    $html2pdf = new HTML2PDF('P', array(210,330), 'en');

    $html2pdf->writeHTML($content, isset($_GET['vuehtml']));

    $html2pdf->Output('Report KK'.$additionName.'.pdf');

}

catch(HTML2PDF_exception $e) {

    echo $e;

    exit;

}

}

?>
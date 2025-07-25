<?php 
ob_start();
include ('html2pdf/konek.php');
include ('../application/helpers/function_helper.php');
$dbopen=bukakoneksi();
$wherekk="";
$wherejemaat="";
$additionName="";
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

$sql="select A.*
		from keluarga_jemaat A 
		where A.id>0 ".$wherekk."
		order by A.kwg_nama ASC";
$qsql=$dbopen->query($sql);
$rsql=$qsql->fetch_all(MYSQLI_ASSOC);


$sql1="select A.*
		from anggota_jemaat A 
		where A.id>0 ".$wherejemaat."
		order by A.no_urut ASC";
$qsql1=$dbopen->query($sql1);
$rsql1=$qsql1->fetch_all(MYSQLI_ASSOC);
$arr_anggota=array();
foreach ($rsql1 as $key => $value) {
	# code...
	$arr_anggota[$value['kwg_no']][]=$value;
}

$sql2="select A.*
		from ags_hub_kwg A 
		where A.id>0 ";
$qsql2=$dbopen->query($sql2);
$rsql2=$qsql2->fetch_all(MYSQLI_ASSOC);
$arr_hubkwg=array();
foreach ($rsql2 as $key => $value) {
	# code...
	$arr_hubkwg[$value['id']]=$value;
}

$sql3="select A.*
		from ags_sts_kawin A 
		where A.id>0 ";
$qsql3=$dbopen->query($sql3);
$rsql3=$qsql3->fetch_all(MYSQLI_ASSOC);
$arr_sts_kawin=array();
foreach ($rsql3 as $key => $value) {
	# code...
	$arr_sts_kawin[$value['id']]=$value;
}

?>
<style type="text/css">
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
?>
<?php
	# code...
	if(!isset($arr_anggota[$value['id']])){
		//kalau baru ada keluarganya tidak dicetak jadi langsugn di continue;
		continue;
	}
?>
<page>
<table style="width: 210mm; border:1px solid #000;" >
	<tr>
		<td style="width: 155mm;">
			<table style="float: left; height: 50mm;" cellpadding ="0" cellspacing ="0">
				<tr>
					<td style="width: 40mm;">
						<img src="../assets/images/logo-gkp.png" style="width: auto; height: 25mm">
					</td>
					<td class="f-14">
						<h4 style="padding: unset; margin:unset; margin-bottom: 2mm;">GEREJA KRISTEN PASUNDAN</h4>
						Jemaat  "KAMPUNG SAWAH"<br>
						Jl. Raya Kamp. Sawah RT.003/04 No.33
						<br>
						Telp. (021) 8450829
					</td>
				</tr>
			</table>
		</td>
		<td style="width: 160mm;">
			<table style="float: right; height: 50mm;" cellpadding ="0" cellspacing ="0">
				<tr>
					<td style="width: 159mm; height: 25mm; vertical-align: top; ">
						<h2 style="padding: unset; margin: unset; text-align: center;">Kartu Keluarga Jemaat</h2>
					</td>
				</tr>
			</table>
		</td>
	</tr>
	<tr>
		<td colspan="2" style="height: 5mm">&nbsp;</td>
	</tr>
	<tr>
		<td colspan="2">
			<table >
				<tr>
					<td class="f-12" style="width: 40mm; vertical-align: bottom;">
						Nomor Kartu
					</td>
					<td>:</td>
					<td class="f-12 border-b" style="width: 100mm; vertical-align: bottom;">
						<?=$value['kwg_no'];?>
					</td>
					<td style="width: 12mm">
						<!-- untuk space kosong-->
					</td>
					<td class="f-12" rowspan="2" style="width:40mm; vertical-align: middle; height: 10mm">
						Alamat Lengkap
					</td>
					<td  rowspan="2">:</td>
					<td class="f-12 border-b" style=" width:117mm; vertical-align: middle; " rowspan="2">
						<?= checknullString($value['kwg_alamat']);?>
					</td>
				</tr>
				<tr>
					<td class="f-12">
						Keluarga
					</td>
					<td>:</td>
					<td class="f-12 border-b">
						<?=$value['kwg_nama'];?>
					</td>
					<td style="width: 12mm">
						<!-- untuk space kosong-->
					</td>
				</tr>
				<tr>
					<td class="f-12">
						Telepon
					</td>
					<td>:</td>
					<td class="f-12 border-b">
						<?=checknullString($value['kwg_telepon']);?>
					</td>
					<td style="width: 12mm">
						<!-- untuk space kosong-->
					</td>
					<td class="f-12">
						Wilayah
					</td>
					<td>:</td>
					<td class="f-12 border-b">
						<?=checknullString($value['kwg_wil']);?>
					</td>
				</tr>
			</table>
		</td>
	</tr>
</table>
<br>
<br>
<!--<hr>-->
<br>
<table style="width: 320mm;" cellpadding ="0" cellspacing ="0" class="border">
		<tr >
			<td class="border text-center f-12 bg-gray" rowspan="2" style="width: 7mm;">
				No.
			</td>
			<td class="border text-center f-12 bg-gray" rowspan="2" style="width: 30mm;">
				No. Induk
			</td>
			<td class="border text-center f-12 bg-gray" rowspan="2" style="width: 75mm;">
				Nama<br>Lengkap
			</td>
			<td class="border text-center f-12 bg-gray" rowspan="2" style="width: 7mm;">
				Gol<br>Drh
			</td>
			<td class="border text-center f-12 bg-gray" rowspan="2" style="width: 5mm;">
				L/P
			</td>
			<td class="border text-center f-12 bg-gray" rowspan="2" style="width: 16mm;">
				Hub.<br>Kel.
			</td>
			<td class="border text-center f-12 bg-gray" rowspan="2" style="width: 20mm;">
				Status<br>Kawin
			</td>
			<td class="border text-center f-12 bg-gray" colspan="4"  style="width: 140mm;">
				Tempat & Tanggal
			</td>
		</tr>
		<tr>
			<td class="border text-center f-12 bg-gray" style="width: 35mm; border-left: 0px;">
				Lahir
			</td>
			<td class="border text-center f-12 bg-gray" style="width: 35mm;">
				Baptis
			</td>
			<td class="border text-center f-12 bg-gray" style="width: 35mm;">
				Sidi
			</td>
			<td class="border text-center f-12 bg-gray" style="width: 35mm;">
				Pemb. Nikah
			</td>
		</tr>	
		<tr>
			<td class="border text-center bg-gray">
				1
			</td>
			<td class="border text-center bg-gray">
				2
			</td>
			<td class="border text-center bg-gray">
				3
			</td>
			<td class="border text-center bg-gray">
				4
			</td>
			<td class="border text-center bg-gray">
				5
			</td>
			<td class="border text-center bg-gray">
				6
			</td>
			<td class="border text-center bg-gray">
				7
			</td>
			<td class="border text-center bg-gray">
				8
			</td>
			<td class="border text-center bg-gray">
				9
			</td>
			<td class="border text-center bg-gray">
				10
			</td>
			<td class="border text-center bg-gray">
				11
			</td>
		</tr>
<?php
	for ($keyrsql1=0; $keyrsql1<10; $keyrsql1++) {
		if(isset($arr_anggota[$value['id']][$keyrsql1])){
			$valuersql1=$arr_anggota[$value['id']][$keyrsql1];
	//foreach ($arr_anggota[$value['id']] as $keyrsql1 => $valuersql1) {
		# code...
?>
			<tr>
				<td class="border text-center h-65">
					<?=$keyrsql1+1;?>
				</td>
				<td class="border text-center">
					<?=$valuersql1['no_anggota'];?>
				</td>
				<td class="border indent-left">
					<?=$valuersql1['nama_lengkap'];?>
				</td>
				<td class="border text-center">
					<?=checknullString($valuersql1['golongandarah']);?>
				</td>	
				<td class="border text-center">
					<?=checknullString($valuersql1['jns_kelamin']);?>
				</td>
				<td class="border text-center">
					<?=checkhubkwg($valuersql1['hub_kwg'], $arr_hubkwg, 'pdf');?>
				</td>
				<td class="border text-center">
					<?=checksts_kawin($valuersql1['sts_kawin'], $arr_sts_kawin, 'pdf');?>
				</td>
				<td class="border text-center">
					<span class="f-8"><?=substr($valuersql1['tmpt_lahir'], 0,20);?></span>
					<br>
					<?=checknullString(convert_time_dmy($valuersql1['tgl_lahir']));?>
				</td>
				<td class="border text-center">
					<span class="f-8"><?=substr($valuersql1['tmpt_baptis'], 0,20);?></span>
					<br>
					<?=checknullString(convert_time_dmy($valuersql1['tgl_baptis']));?>
				</td>
				<td class="border text-center">
					<span class="f-8"><?=substr($valuersql1['tmpt_sidi'], 0,20);?></span>
					<br>
					<?=checknullString(convert_time_dmy($valuersql1['tgl_sidi']));?>
				</td>
				<td class="border text-center" >
					<span class="f-8"><?=substr($valuersql1['tmpt_nikah'], 0,20);?></span>
					<br>
					<?=checknullString(convert_time_dmy($valuersql1['tgl_nikah']));?>
				</td>
			</tr>
<?php
		}
		else{
		?>
			<tr>
				<td class="border text-center h-65">
					&nbsp;
				</td>
				<td class="border text-center">
				</td>
				<td class="border text-center">
				</td>
				<td class="border text-center">
				</td>
				<td class="border text-center">
				</td>
				<td class="border text-center">
				</td>
				<td class="border text-center">
				</td>
				<td class="border text-center">
				</td>
				<td class="border text-center">
				</td>
				<td class="border text-center">
				</td>
				<td class="border text-center">
				</td>
			</tr>
		<?php
		}
	}
?>
</table>
</page>
<page>
<?php /* ini untuk table halaman kedua*/?>
<br>
<br>
<br>
<table style="width: 320mm;" cellpadding ="0" cellspacing ="0" class="border">
		<tr >
			<td class="border text-center f-12 bg-gray" style="width: 8mm;">
				No.
			</td>
			<td class="border text-center f-12 bg-gray" style="width: 50mm;">
				Pendidikan<br>Terakhir
			</td>
			<td class="border text-center f-12 bg-gray"style="width: 30mm;">
				Pekerjaan
			</td>
			<td class="border text-center f-12 bg-gray" style="width: 65mm;">
				Terdaftar Sebagai <br> Jemaat
			</td>
			<td class="border text-center f-12 bg-gray" style="width: 65mm;">
				Pindahan dari <br> Gereja/Jemaat
			</td>
			<td class="border text-center f-12 bg-gray" style="width: 91mm;">
				Keterangan<br>
				Lain-lain
			</td>
		</tr>
		<tr>
			<td class="border text-center bg-gray">
				12
			</td>
			<td class="border text-center bg-gray">
				13
			</td>
			<td class="border text-center bg-gray">
				14
			</td>
			<td class="border text-center bg-gray">
				15
			</td>
			<td class="border text-center bg-gray">
				16
			</td>
			<td class="border text-center bg-gray">
				17
			</td>
		</tr>
<?php
	for ($keyrsql1=0; $keyrsql1<10; $keyrsql1++) {
		if(isset($arr_anggota[$value['id']][$keyrsql1])){
			$valuersql1=$arr_anggota[$value['id']][$keyrsql1];
	//foreach ($arr_anggota[$value['id']] as $keyrsql1 => $valuersql1) {
		# code...
?>
			<tr>
				<td class="border text-center h-65">
					<?=$keyrsql1+1;?>
				</td>
				<td class="border text-center">
					<?=checknullString($valuersql1['pndk_akhir']);?>
				</td>
				<td class="border text-center">
					<?=checksts_pekerjaan($valuersql1['sts_pekerjaan']);?>
				</td>
				<td class="border text-center">
					<?=checknullString(convert_time_dmy($valuersql1['tgl_attestasi_masuk']));?>
				</td>	
				<td class="border text-center">
					<?=checknullString($valuersql1['pindah_dari']);?>
				</td>
				<td class="border text-center"  style="width: 91mm;">
					<?=checknullString($valuersql1['remarks']);?>
				</td>
			</tr>
<?php
		}
		else{
		?>
			<tr>
				<td class="border text-center h-65">
					&nbsp;
				</td>
				<td class="border text-center">
				</td>
				<td class="border text-center">
				</td>
				<td class="border text-center">
				</td>
				<td class="border text-center">
				</td>
				<td class="border text-center">
				</td>
			</tr>
		<?php
		}
	}
?>
</table>
<br>
<table cellpadding ="0" cellspacing ="0" class="border">
	<tr>
		<td style="width: 318mm; text-align: right; height: 5mm;" colspan="6" class="f-12">
			Kampung Sawah, ................................................... 2020
		</td>
	</tr>
	<tr>
		<td style="width: 80mm; text-align: center;" class="f-12">
			Majelis Jemaat GKP Kampung Sawah
			<br>
			Sekretaris
		</td>
		<td style="width: 20mm" class="f-12"></td>
		<td style="width: 80mm; text-align: center;" class="f-12">
			Majelis Koordinator
			<br>
			Wilayah
		</td>
		<td style="width: 20mm" class="f-12"></td>
		<td style="width: 80mm; text-align: center;" class="f-12">
			Kepala Keluarga
		</td>
	</tr>
	<tr>
		<td style=" text-align: center;  height: 50mm; border-bottom: 1px solid #000;">
		</td>
		<td style="width: 20mm"></td>
		<td style="text-align: center;  height: 50mm; border-bottom: 1px solid #000;">
		</td>
		<td style="width: 20mm"></td>
		<td style="text-align: center; height: 50mm; border-bottom: 1px solid #000;">
		</td>
	</tr>
</table>
</page>

<?php
}
?>
<?php
$content = ob_get_clean();
//echo dirname(__FILE__).'/html2pdf/html2pdf.class.php';
// convert in PDF
//require_once(dirname(__FILE__).'/../html2pdf.class.php');
require_once(dirname(__FILE__).'/html2pdf/html2pdf.class.php');
try
{
    $html2pdf = new HTML2PDF('L', array(210,330), 'en');
    $html2pdf->writeHTML($content, isset($_GET['vuehtml']));
    $html2pdf->Output('Report KK'.$additionName.'.pdf');
}
catch(HTML2PDF_exception $e) {
    echo $e;
    exit;
}
?>
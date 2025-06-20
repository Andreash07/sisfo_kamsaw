<?php 

ob_start();

include ('html2pdf/konek.php');

include ('../application/helpers/function_helper.php');

$dbopen=bukakoneksi();

$wherekk="";

$wherejemaat="";

$additionName="";

if(isset($_GET['tahun'])){

	$tahun_pemilihan=$_GET['tahun'];

	$wherejemaat.=" && D.tahun_pemilihan ='".$_GET['tahun']."'";

}

else{

	$tahun_pemilihan=2021;

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



$sql_angjem="select A.*, B.kwg_nama, B.kwg_alamat, B.kwg_no as no_kk, C.hub_keluarga, COUNT(D.id) as num_pemilih_konvensional, D.path_qrcode, D.sn_surat_suara, D.tahun_pemilihan

				from anggota_jemaat A

				join keluarga_jemaat B on B.id = A.kwg_no

				join ags_hub_kwg C on C.idhubkel = A.hub_kwg

				join pemilih_konvensional D on D.anggota_jemaat_id = A.id && A.kwg_no = D.kwg_no

				where A.id >0 && A.status=1 && A.sts_anggota=1 && B.status=1 && A.status_sidi=1 && YEAR(A.tgl_lahir) < 2005 && D.tipe_pemilihan_id='3' ".$wherejemaat."

				group by A.id

				order by B.kwg_wil ASC, B.kwg_nama ASC, A.no_urut ASC, A.nama_lengkap ASC"; //die($sql_angjem);

				//limit 1

$qsql=$dbopen->query($sql_angjem);

$rsql=$qsql->fetch_all(MYSQLI_ASSOC);



/*$sql_calon="select A.*

				from anggota_jemaat A 

				where A.sts_anggota=1 && A.status_sidi=1 && A.status=1 && A.status_ppj=1

				group by A.id

				order by A.nama_lengkap ASC, A.kwg_wil ASC"; */



$rsql_calon=array();

$num_rows=0;	

$num_data=$num_rows;

$col=6;

$width_col=190/6;

$row=ceil($num_data/6);





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

	.f-7-5{

		font-size: 7pt;

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

	h5{

		font-size: 14pt;

		padding-bottom: 0px;

		margin-bottom: 5px;

	}

	.break {

	    page-break-after: always;

	  }

</style>

<?php

foreach ($rsql as $key => $value) {

	$qrcode=$value['path_qrcode'];

	$wil_angjem=$value['kwg_wil'];

?>

<page backtop="0" backbottom="20;" style="position: relative;">

<table style="width: 210mm; border:1px solid #000;">

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

			<table style="width: 210mm; margin-top:-3mm;" cellpadding ="0" cellspacing ="0">

				<tr>

					<th class="f-9" colspan="7" style="width: 210mm	;">

						&nbsp;

					</th>

				</tr>

				<tr>

					<th class="f-9" style="vertical-align: top; width: 16mm	;">

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

					<td class="f-9" style="vertical-align: top; width:35mm;">

						<?=$value['kwg_alamat'];?>

					</td>

					<td style="vertical-align: top; width:2mm;"></td>

				</tr>

				<tr>

					<th class="f-9" style="vertical-align: top; width: 16mm; ">

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

					<td class="f-9" style="vertical-align: top; width: 35mm;">

						<?=$value['kwg_wil'];?>

					</td>

					<td style="vertical-align: top; width:2mm;"></td>

				</tr>

				<tr>

					<th colspan="7" style="height: 1mm;">

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

					<td colspan="2" style="width: 170mm; height: 20mm; vertical-align: top; text-align: center;">

						<h5>Selamat memilih Penatua GKP Kampung Sawah</h5>

						Sebelum kita memilih, mintalah tuntunan Roh Kudus dalam doa dan ingatlah Firman Tuhan yang melandasi pemilihan yang kita lakukan,

						<br><b>"Apa yang telah engkau dengar dari padaku di depan banyak saksi, percayakanlah itu kepada orang-orang yang dapat dipercayai, yang juga cakap mengajar orang lain"</b>

						<br>

						<b><i>(2 Timotius 2:2)</i></b>

						<br>

						Tuhan memberkati kita semua!

					</td>

				</tr>
<tr>
	<td style="height:50px;">&nbsp;</td>
</tr>
				<tr>

					<td style="width: 25mm; height: 20mm; vertical-align: top; ">

						<img src="../<?=$qrcode;?>" style="height: 20mm; float: right;">

					</td>

					<td style="width: 170mm; height: 20mm; vertical-align: top; text-align: center;">

						<h4 style="padding: unset; margin: unset;   margin-top: 1mm; margin-bottom: 2mm;">Surat Suara Pemilihan Penatua Tahap 2</h4>

						Periode: 2022 - 2026

					</td>

				</tr>

			</table>

		</td>

	</tr>

</table>

<table style="width: 210mm; border:1px solid #000;" >

	<tr>

		<td class="f-9" style="width: 200mm;">

			Panduan: 

			<ol  start="1" style="padding-top: 0px; margin-top:-3mm;">

				<li>Silahkan Gunakan Hak Suara Bpk/Ibu/Sdr/i dan <b>Pilih 8 Calon Penatua</b> yang tersedia dengan ketentuan <b>4 calon</b> (<b>2 Perempuan</b> & <b>2 Laki-Laki</b>) dari <b>Wilayah <?=$wil_angjem;?></b> (Wilayah Bpk/Ibu/Sdr/i) & <b>4 calon</b> (<b>2 Perempuan</b> & <b>2 Laki-Laki</b>) dari <b>Wilayah Lainnya</b>!</li>

				<li>Peserta Pemilihan hanya diperbolehkan memilih <b>8 Calon</b> saja sesuai ketentuan pada <b>nomor 1</b> di atas, jika lebih maka kelebihan nama tersebut tidak akan dihitung.</li>

				<li>Tuliskan <b>Nama Calon</b> yang Bpk/Ibu/Sdr/i <b>Pilih</b> pada bagian kolom tabel yang telah disediakan dan isi sesuai dengan ketentuan pada <b>nomor 1</b> di atas</li>

			</ol>

		</td>

	</tr>

</table>

<hr style=" border: 1px solid #333333; margin-top: -3mm;">

<table style="width: 210mm; border:1px solid #000;" >

	<tr>

		<td>

			Formulir Pilihan <b>Wilayah <?=$wil_angjem;?></b>

		</td>

		<td>

		</td>

		<td>

			Formulir Pilihan <b>Wilayah Lain</b>

		</td>

	</tr>

	<tr>

		<td style="width: 95mm;">

			<table style="width: 100%; " >

				<tr>

					<th style="width: 10%; border:1px solid #000; text-align: center;">#</th>

					<th style="width: 90%; border:1px solid #000; text-align: center;">Nama Calon</th>

				</tr>

				<tr>

					<td style="border:1px solid #000; text-align: left;" colspan="2"><b>Laki-Laki</b></td>

				</tr>

				<tr>

					<td style="width: 10%; border:1px solid #000; text-align: center;">1</td>

					<td style="width: 90%; border:1px solid #000; text-align: center; vertical-align: bottom; height: 8mm;">....................................................................................</td>

				</tr>

				<tr>

					<td style="width: 10%; border:1px solid #000; text-align: center;">2</td>

					<td style="width: 90%; border:1px solid #000; text-align: center; vertical-align: bottom; height: 8mm;">....................................................................................</td>

				</tr>

				<tr>

					<td style="border:1px solid #000; text-align: left;" colspan="2"><b>Perempuan</b></td>

				</tr>

				<tr>

					<td style="width: 10%; border:1px solid #000; text-align: center;">1</td>

					<td style="width: 90%; border:1px solid #000; text-align: center; vertical-align: bottom; height: 8mm;">....................................................................................</td>

				</tr>

				<tr>

					<td style="width: 10%; border:1px solid #000; text-align: center;">2</td>

					<td style="width: 90%; border:1px solid #000; text-align: center; vertical-align: bottom; height: 8mm;">....................................................................................</td>

				</tr>

			</table>	

		</td>

		<td style="width:5mm ;">

		</td>

		<td style="width: 95mm;">

			<table style="width: 100%;" >

				<tr>

					<th style="width: 10%; border:1px solid #000; text-align: center;">#</th>

					<th style="width: 90%; border:1px solid #000; text-align: center;">Nama Calon</th>

				</tr>

				<tr>

					<td style="border:1px solid #000; text-align: left;" colspan="2"><b>Laki-Laki</b></td>

				</tr>

				<tr>

					<td style="width: 10%; border:1px solid #000; text-align: center;">1</td>

					<td style="width: 90%; border:1px solid #000; text-align: center; vertical-align: bottom; height: 8mm;">....................................................................................</td>

				</tr>

				<tr>

					<td style="width: 10%; border:1px solid #000; text-align: center;">2</td>

					<td style="width: 90%; border:1px solid #000; text-align: center; vertical-align: bottom; height: 8mm;">....................................................................................</td>

				</tr>

				<tr>

					<td style="border:1px solid #000; text-align: left;" colspan="2"><b>Perempuan</b></td>

				</tr>

				<tr>

					<td style="width: 10%; border:1px solid #000; text-align: center;">1</td>

					<td style="width: 90%; border:1px solid #000; text-align: center; vertical-align: bottom; height: 8mm;">....................................................................................</td>

				</tr>

				<tr>

					<td style="width: 10%; border:1px solid #000; text-align: center;">2</td>

					<td style="width: 90%; border:1px solid #000; text-align: center; vertical-align: bottom; height: 8mm;">....................................................................................</td>

				</tr>

			</table>	

		</td>

	</tr>

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
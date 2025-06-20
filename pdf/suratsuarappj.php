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

				where A.id >0 && A.status=1 && A.sts_anggota=1 && B.status=1 && A.status_sidi=1 && YEAR(A.tgl_lahir) < 2005 && D.tipe_pemilihan_id='3' ".$wherejemaat."

				group by A.id

				order by B.kwg_wil ASC, B.kwg_nama ASC, A.no_urut ASC, A.nama_lengkap ASC"; //die($sql_angjem);

$qsql=$dbopen->query($sql_angjem);

$rsql=$qsql->fetch_all(MYSQLI_ASSOC);



$sql_calon="select A.*

				from anggota_jemaat A 

				where A.sts_anggota=1 && A.status_sidi=1 && A.status=1 && A.status_ppj=1

				group by A.id

				order by A.nama_lengkap ASC, A.kwg_wil ASC"; //die($sql_calon);

$qsql_calon=$dbopen->query($sql_calon);

$rsql_calon=$qsql_calon->fetch_all(MYSQLI_ASSOC);

$num_rows=$qsql_calon->num_rows;

//print_r($rsql_calon);



	

$num_data=$num_rows;

$col=4;

$width_col=192/4;

$row=$num_data/4;





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

						<h4 style="padding: unset; margin: unset;   margin-top: 1mm; margin-bottom: 2mm;">Surat Suara Pemilihan PPJ</h4>

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

				<li>Silahakan Gunakan Hak Suara Anda dan Pilih 1 Calon PPJ yang tersedia!</li>

				<li>Peserta Pemilihan hanya diperbolehkan memilih 1 Calon saja, Jika lebih akan dianggap tidak sah dan tidak akan dihitung.</li>

				<li>Diperbolehkan memilih Calon dari Wilayah Lain.</li>

			</ol>

		</td>

	</tr>

</table>

<hr style=" border: 1px solid #333333; margin-top: -3mm;">

<table style="width: 210mm; border:1px solid #000;" >

	<tr>

		<td colspan="<?=$col;?>" >Calon PPJ</td>

	</tr>

	<?php 

	//echo $row;

	//die($row);

	//foreach ($rsql_calon as $key_calon => $value_calon) {

		// code...

		$calon=0;

		for ($i=0; $i < round($row); $i++) { 

			// code...

		?>

			<tr>

			<?php

				for ($j=0; $j < $col; $j++) { 

					if(isset($rsql_calon[$calon])){

			?>

					<td style="width: <?=$width_col;?>mm; border: 1px solid #000; text-align: center;" >

						<img src="../<?=$rsql_calon[$calon]['foto_thumb'];?>" style="width: <?=$width_col;?>mm; border-radius: 50%; margin-bottom:2mm;">

						<br>

						<div style="width:5mm;height:5mm; border:1px solid #000; margin-left:-3mm"></div>

						<br>

						<?=$rsql_calon[$calon]['nama_lengkap'];?>

					</td>

			<?php

					}else{

			?>

					<td style="width: <?=$width_col;?>mm"></td>

			<?php

					}

					$calon++;

				}

			?>

			</tr>

			<tr>

				<td colspan="<?=$col;?>" style="height: 2mm;"></td>

			</tr>

		<?php

		}

	?>



	<?php

	//}

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
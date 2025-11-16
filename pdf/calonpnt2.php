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

	#$tahun_pemilihan=2021;
	$tahun_pemilihan=2025;

}
$periode='2026 - 2030';




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

				order by B.kwg_wil ASC, B.kwg_nama ASC, A.no_urut ASC, A.nama_lengkap ASC

				limit 1"; //die($sql_angjem);

//$qsql=$dbopen->query($sql_angjem);

//$rsql=$qsql->fetch_all(MYSQLI_ASSOC);

$rsql=array();



/*$sql_calon="select A.*

				from anggota_jemaat A 

				where A.sts_anggota=1 && A.status_sidi=1 && A.status=1 && A.status_ppj=1

				group by A.id

				order by A.nama_lengkap ASC, A.kwg_wil ASC"; */



$sql_calon="select A.*



				from anggota_jemaat A 



				join jemaat_terpilih1 D on D.anggota_jemaat_id = A.id  && D.tahun_pemilihan='".$tahun_pemilihan."'

				where  A.sts_anggota=1 && A.status=1 &&  D.status = 1

				order by  A.kwg_wil ASC, D.persen_vote DESC, D.last_vote ASC";  #YEAR(A.tgl_lahir) < 2005 && A.status_sidi=1 && DATEDIFF(CURRENT_DATE(), A.tgl_lahir)/365 >=25  &&

				//A.kwg_wil ASC, A.nama_lengkap ASC //

//die($sql_calon);

$qsql_calon=$dbopen->query($sql_calon);

$rsql_calon=$qsql_calon->fetch_all(MYSQLI_ASSOC);

$num_rows=$qsql_calon->num_rows;

//print_r($rsql_calon);



	

$num_data=$num_rows;

$col=6;

$width_col=190/$col;

$row=ceil($num_data/$col);





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

	.break {

	    page-break-after: always;

	  }

</style>

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

			</table>

		</td>

	</tr>

</table>

<table style="width: 210mm; border:1px solid #000; margin-top: 1mm;" >

	<tr>

		<td style="text-align:center;width: 200mm;">

			<h4 style="padding: unset; margin: unset;   margin-top: 0; margin-bottom: 1mm;">Lembar Calon Penatua Tahap 2</h4>

			Periode: <?=$periode;?>

		</td>

	</tr>

</table>

<hr style=" border: 1px solid #333333; margin-top: 1mm;">

<table style="width: 210mm; border:1px solid #000;" >

	<?php 

	//echo $row;

	//die($row);

	//foreach ($rsql_calon as $key_calon => $value_calon) {

		// code...

		$calon=0;

		for ($i=0; $i <= round($row); $i++) { 

			// code...

		?>

			<tr>

			<?php

				for ($j=0; $j < $col; $j++) { 

					if(isset($rsql_calon[$calon])){

						$title="Ibu ";

						if($rsql_calon[$calon]['sts_kawin']==1){

							$title="Sdri. ";

						}

						if(mb_strtolower($rsql_calon[$calon]['jns_kelamin'])=='l'){

							$color_gender="bg-gradient-blue";

							$ico_gender='<i class="fa fa-male" style="font-size:12pt;"></i>';

							$title="Bp. ";

							if($rsql_calon[$calon]['sts_kawin']==1){

							  $title="Sdr. ";

							}

						}

						if($rsql_calon[$calon]['foto_thumb']=='')

						{

							$rsql_calon[$calon]['foto_thumb']='assets/images/user.png';

							$rsql_calon[$calon]['foto']='assets/images/user.png';

						}

						else{

							if(!file_exists('../'.$rsql_calon[$calon]['foto_thumb'])){

								$rsql_calon[$calon]['foto']='assets/images/user.png';

								$rsql_calon[$calon]['foto_thumb']='assets/images/user.png';

							}



						}

			?>

					<td style="width: <?=$width_col;?>mm; border: 1px solid #000; text-align: center;" class="f-8" >

						<img src="../<?=$rsql_calon[$calon]['foto'];?>" style="width: <?=$width_col;?>mm; border-radius: 50%; margin-bottom:.5mm; " >

						<?= $title; ?><?=singkat_nama($rsql_calon[$calon]['nama_lengkap'], 30, 'addwhitespace');?>
						<br>
						<b class="f-8">Wil. <?=$rsql_calon[$calon]['kwg_wil'];?></b>

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

				<td colspan="<?=$col;?>" style="height: 1mm;"></td>

			</tr>

		<?php

		}

	?>



</table>

</page>



<?php

//die();

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

    $html2pdf->Output('Calon Pnt Tahap II '.$periode.'.pdf');

}

catch(HTML2PDF_exception $e) {

    echo $e;

    exit;

}

}

?>
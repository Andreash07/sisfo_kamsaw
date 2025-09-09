<html lang="en">
<?php
$action = 'onload="window.print();"';
?>
	<head>
		<title>GKP KamSaw</title>
		<!-- Font Awesome -->

    <link href="<?=base_url();?>/vendors/font-awesome/css/font-awesome.min.css" rel="stylesheet">
		<style>
		.page {
	        /*width: 210mm;*/
	        width: 297mm;
	        /*min-height: 297mm;*/
	        min-height: 210mm;
	        padding: 20mm;
	        margin: 10mm auto;
	        border: 1px #D3D3D3 solid;
	        border-radius: 5px;
	        background: white;
	        box-shadow: 0 0 5px rgba(0, 0, 0, 0.1);
	    }
			@page {
			  size: A4;
			  margin: 0;
			}
			@media print {
			  html, body {
			    /*width: 210mm;
			    height: 297mm;*/

			    height: 210mm;
			    width: 297mm;
			  }
			  /* ... the rest of the rules ... */
			  .page {
            margin: 0;
            border: initial;
            border-radius: initial;
            width: initial;
            min-height: initial;
            box-shadow: initial;
            background: initial;
            page-break-after: always;
        }

			}

			table{
				border-collapse: collapse;
			}
			td{
				border-collapse: collapse;
				border: 1px solid #333;
				padding-left: 4px;
				padding-right: 4px;
			}
			th{
				border-collapse: collapse;
				border: 1px solid #333;
				padding-left: 4px;
				padding-right: 4px;
			}
			.text-center{
				text-align: center;
			}
			.text-left{
				text-align: left;
			}
			.text-right{
				text-align: right;
			}
			.text-danger{
				color: red;
			}
			.text-success{
				color: green;
			}
		</style>
	</head>
	<body style="background: white;" <?php echo $action; ?> >
		<div class="page">
			<table class='table table-striped'>
				<thead>
					<tr>
						<th class='text-center'>#</th>
						<th class='text-center'>Wil</th>
						<th class='text-center'>Keluarga</th>
						<th class='text-center'>Nama Jemaat</th>
						<th class='text-center'>Jns Kel.</th>
						<th class='text-center'>Tanggal Lahir</th>
						<th class='text-center'>Umur</th>
						<th class='text-center'>Tanggal Sidi</th>
						<th class='text-center'>Umur Sidi</th>
						<th class='text-center'>Tanggal Atestasi</th>
					</tr>
				</thead>
				<tbody>
			<?php
			//echo singkat_nama();
			//die();
			$last_kel="";
			$last_kel2="";
			foreach ($data_jemaat as $key => $value) {
				# code...
				if($value->golongandarah==null){
					$value->golongandarah='<i>Data tidak ada</i>';
				}

				if($value->jns_kelamin=='L'){
			  		$jns_kelamin="L";
			    }
			    else{
			      	$jns_kelamin="P";
			    }
			    if($value->status_baptis=='1'){
			  		$ico_status_baptis='<i class="fa fa-check-square text-success"></i>';
			    }
			    else{
			  		$ico_status_baptis='<i class="fa fa-times text-danger"></i>';
			    }

			    if($value->status_sidi=='1'){
			  		$ico_status_sidi='<i class="fa fa-check-square text-success"></i>';
			    }
			    else{
			  		$ico_status_sidi='<i class="fa fa-times text-danger"></i>';
			    }
				if($value->tgl_lahir !=''){
					$tgl_lahir = $value->tgl_lahir;
				}
				if($value->tgl_sidi !=''){
					$tgl_sidi = $value->tgl_sidi;
				}
				if($value->tgl_attestasi_masuk !=''){
					$tgl_attestasi_masuk = $value->tgl_attestasi_masuk;
				}

			    $status_seleksi=0;
			    $msg_seleksi='<label class="label label-danger"><i class="fa fa-times"></i> Tidak Termasuk Kriteria Dipilih</label>';
			    $tglCutoff="2025-03-05";
				if( $value->tgl_lahir == '0000-00-00'){
					$umurLahir=0;
					$umurLahir_lbl="<i style='color:white; background-color:red;'>-</i>";
				}else{
					$umurLahir=getUmur($tglCutoff, $value->tgl_lahir);
					$umurLahir_lbl=$umurLahir." th";
				}

				if( $value->tgl_sidi == '0000-00-00'){
					$umurSidi=0;
					$umurSidi_lbl="<i style='color:white; background-color:red;'>-</i>";
				}
				else{
					$umurSidi=getUmur($tglCutoff, $value->tgl_sidi);
					$umurSidi_lbl=$umurSidi." th";
				}
				if( $value->tgl_attestasi_masuk == '0000-00-00'){
					$umurAttesasi=0;
					$umurAttesasi_lbl="<i style='color:white; background-color:red;'>Lama</i>";
				}
				else{
					$umurAttesasi=getUmur($tglCutoff, $value->tgl_attestasi_masuk);
					$umurAttesasi_lbl=$umurAttesasi." th";
				}

				if($umurLahir<=65 && $umurLahir>=25){
					$status_seleksi=$status_seleksi+1;
				}

				if($umurSidi<2 || ($umurAttesasi <1 && $value->tgl_attestasi_masuk != '0000-00-00') ){
					//continue;
					$status_seleksi=0;
				}
				else{
					$status_seleksi=$status_seleksi+1;
				}

				if($status_seleksi==2){
					$msg_seleksi='<label class="label label-success"><i class="fa fa-check-circle"></i> Termasuk Kriteria Dipilih</label>';
				}

				if($value->status_pn1==1){
					$checked="checked";
				}
				else{
					$checked="";
				}
				
				if($last_kel != $value->kwg_nama){
					
				}
			?>
					<tr>
						<td class='text-center'><?=$key+$numStart+1;?></td>
						<td>
							Wil.<?=$value->kwg_wil;?>
						</td>
						<td>
							<?php 
							if($last_kel != $value->kwg_nama){
							?>
							<?=singkat_nama($value->kwg_nama);?>
							<?php
								$last_kel=$value->kwg_nama;
							}
							?>
						</td>
						<td style="width:80mm;">
							<!--(<?=getUmur(date('Y-m-d'), $value->tgl_lahir);?>)--> <?=singkat_nama($value->nama_lengkap);?>
						</td>
						<td style="text-align:center;">
							<?=$jns_kelamin;?>
						</td>
						<td style="text-align:center;">
							<?=$tgl_lahir;?>
						</td>
						<td style="text-align:center;">
							<?=$value->umur_cocok;?>
						</td>
						<td style="text-align:center;">
							<?=$tgl_sidi;?>
						</td>
						<td style="text-align:center;">
							<?=$value->sidi_cocok;?>
						</td>
						<td style="text-align:center;">
							<?=$tgl_attestasi_masuk;?> <?=$value->attestasi_cocok;?>
						</td>
					</tr>
					<?php 
					/*if($last_kel2!=$value->kwg_nama ){
					?>
						<tr>
							<td colspan="10" style="height:1mm;">&nbsp;</td>
						</tr>
					<?php 
						#$last_kel=$value->kwg_nama;
					}*/
					?>
			<?php
				#$last_kel2=$value->kwg_nama;
			}
			?>
				</tbody>
			</table>
		</div>
	</body>
</html>
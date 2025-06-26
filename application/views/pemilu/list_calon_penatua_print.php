<table class='table table-striped'>
	<thead>
		<tr>
			<th class='text-center'>#</th>
			<th class='text-center'>Nama Jemaat</th>
			<th class='text-center'> Jenis Kelamin</th>
			<th class='text-center'>Umur</th>
			<th class='text-center'>Umur Sidi</th>
			<th class='text-center'>Umur Atestasi</th>
			<!--<th class='text-center' style="width: 30%;">Wilayah</th>-->
		</tr>
	</thead>
	<tbody>
<?php
//echo singkat_nama();
//die();
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

    $status_seleksi=0;
    $msg_seleksi='<label class="label label-danger"><i class="fa fa-times"></i> Tidak Termasuk Kriteria Dipilih</label>';
    $tglCutoff="2022-04-03";
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
	
?>
		<tr>
			<td class='text-center'><?=$key+$numStart+1;?></td>
			<td>
				<?=singkat_nama($value->nama_lengkap);?>
			</td>
			<!--<td style="width: 30%;">
				Wilayah <?=$value->kwg_wil;?>
			</td>-->
			<td style="text-align:center;">
				<?=$jns_kelamin;?>
			</td>
			<td style="text-align:center;">
				<?=getUmur(date('Y-m-d'), $value->tgl_lahir);?>
			</td>
			<td>
				<?=$umurSidi;?>
				Tahun
			</td>
			<td>
				<?=$umurAttesasi;?>
				Tahun
			</td>
		</tr>
<?php
}
?>
	</tbody>
</table>	
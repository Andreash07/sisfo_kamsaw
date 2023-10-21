<style type="text/css">
	table{
		border: 1px #000 solid;
		border-collapse: collapse
	}
	th{
		border: 1px #000 solid;
	}
	td{
		border: 1px #000 solid;
	}
</style>
<table cellpadding="0" cellmargin="0">
	<thead>
		<tr>
			<th cellpadding="0">#</th>
			<th cellpadding="0">Wilayah</th>
			<th cellpadding="0"># KK</th>
			<th cellpadding="0">KK</th>
			<th cellpadding="0">No Anggota</th>
			<th cellpadding="0">Anggota Jemaat</th>
			<th cellpadding="0">Jenis Kelamin</th>
			<th cellpadding="0">Hub. Kel</th>
			<th cellpadding="0">Alamat</th>
			<th cellpadding="0">Gol. Darah</th>
			<th cellpadding="0">Tgl Lahir</th>
			<th cellpadding="0">Telepon</th>
			<th cellpadding="0">Tgl Baptis</th>
			<th cellpadding="0">Tempat Baptis</th>
			<th cellpadding="0">Tgl Sidi</th>
			<th cellpadding="0">Tempat Sidi</th>
			<th cellpadding="0">Pendidikan Akhir</th>
		</tr>
	</thead>
	<tbody>
		<?php
		$urutKK=0;
		$urutKK_display='';
		$namaKK_before="";
		$notelp_before="";
		$i=0;
		foreach ($angjem as $key => $value) {
			// code...
			$namaKK_new=$value->kwg_id;
			if($namaKK_before == $namaKK_new){
				$value->kwg_nama='';
				$value->kwg_alamat='';
				$urutKK_display='';
			}else{
				$urutKK++;
				$urutKK_display=$urutKK;
			}

			if($notelp_before == $value->kwg_telepon){
				$value->kwg_telepon='';
			}

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

			
			$namaKK_before=$value->kwg_id;
			if($value->kwg_telepon!=''){
				$notelp_before=$value->kwg_telepon;
			}
		?>
		<tr>
			<td cellpadding="0"><?=++$i;?></td>
			<td cellpadding="0"><?=$value->kwg_wil;?></td>
			<td cellpadding="0"><?=$urutKK_display;?></td>
			<td cellpadding="0">
				<?=$value->kwg_nama;?>
			</td>
			<td cellpadding="0"><?=$value->no_anggota;?></td>
			<td cellpadding="0"><?=$value->nama_lengkap;?></td>
			<td cellpadding="0"><?=$value->jns_kelamin;?></td>
			<td cellpadding="0"><?=$value->hub_keluarga;?></td>
			<td cellpadding="0">
				<?=$value->kwg_alamat;?>
			</td>
			<td cellpadding="0" style="text-align: center;"><?=$value->golongandarah;?> </td>
			<td cellpadding="0" style="text-align: center;"><?=convert_tgl_dMY($value->tgl_lahir);?> </td>
			<td cellpadding="0"><?=$value->kwg_telepon;?></td>
			<td cellpadding="0" style="text-align: center;"><?=convert_tgl_dMY($value->tgl_baptis);?> </td>
			<td cellpadding="0" style="text-align: center;"><?= $value->tmpt_baptis;?> </td>
			<td cellpadding="0" style="text-align: center;"><?=convert_tgl_dMY($value->tgl_sidi);?> </td>
			<td cellpadding="0" style="text-align: center;"><?= $value->tmpt_baptis;?> </td>
			<td cellpadding="0" style="text-align: center;"><?= $value->pndk_akhir;?> </td>
		</tr>
		<?php
		}
		?>
	</tbody>
</table>
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
			<th cellpadding="0">KK</th>
			<th cellpadding="0">Anggota Jemaat</th>
			<th cellpadding="0">Umur</th>
			<th cellpadding="0">Umur Sidi</th>
			<th cellpadding="0">Umur Attesasi</th>
		</tr>
	</thead>
	<tbody>
		<?php
		$namaKK_before="";
		$i=0;
		foreach ($angjem as $key => $value) {
			// code...
			$namaKK_new=$value->kwg_id;
			if($namaKK_before == $namaKK_new){
				$value->kwg_nama='';
			}

			$tglCutoff="2022-04-03";
			$tglCutoffMemilih="2021-08-31";
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
				$umurSidi=getUmur($tglCutoffMemilih, $value->tgl_sidi);
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

			if($value->status_sidi!=1 && $value->tgl_sidi =='0000-00-00'){
				continue;
			}
			$namaKK_before=$value->kwg_id;
		?>
		<tr>
			<td cellpadding="0"><?=++$i;?></td>
			<td cellpadding="0"><?=$value->kwg_wil;?></td>
			<td cellpadding="0">
				<?=$value->kwg_nama;?>
			</td>
			<td cellpadding="0"><?=$value->nama_lengkap;?></td>
			<td cellpadding="0" style="text-align: center;"><?=$umurLahir_lbl;?> </td>
			<td cellpadding="0" style="text-align: center;"><?=$umurSidi_lbl;?> </td>
			<td cellpadding="0" style="text-align: center;"><?=$umurAttesasi_lbl;?> </td>
		</tr>
		<?php
		}
		?>
	</tbody>
</table>
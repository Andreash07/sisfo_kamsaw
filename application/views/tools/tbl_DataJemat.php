<style type="text/css">
	td{
		border:1px solid #000;
	}
	table{
		border:1px solid #000;
	}
</style>
<table cellspacing="0" cellpadding="0">
	<tr>
		<td>
			Nama_Gereja
		</td>
		<td>
			No_Anggota
		</td>
		<td>
			No_Kartu_Keluarga
		</td>
		<td>
			Nama_Jemaat
		</td>
		<td>
			Baptis_SIDI
		</td>
		<td>
			Jenis_Kelamin
		</td>
		<td>
			Kota_Lahir
		</td>
		<td>
			Tanggal_Lahir
		</td>
		<td>
			Alamat_Tinggal
		</td>
		<td>
			Kode_Pos_Tinggal
		</td>
		<td>
			RT_Tinggal
		</td>
		<td>
			RW_Tinggal
		</td>
		<td>
			Propinsi_Tinggal
		</td>
		<td>
			Kota_Kabupaten_Tinggal
		</td>
		<td>
			Kecamatan_Tinggal
		</td>
		<td>
			Kelurahan_Tinggal
		</td>
		<td>
			Status_Nikah 
		</td>
		<td>
			Pendidikan
		</td>
		<td>
			Pekerjaan
		</td>
		<td>
			Catatan Khusus
		</td>
	</tr>
	<?php 
	foreach ($anggota_KK as $key => $value) {
		# code...
	?>
		<tr>
			<td>
				GKP Kampung Sawah
			</td>
			<td>
				<?=$value->no_anggota;?>
			</td>
			<td>
				<?=$value->no_kk;?>
			</td>
			<td>
				<?= ucfirst($value->nama_lengkap);?>
			</td>
			<td>
				<?= checkBaptisSidi($value->status_baptis, $value->status_sidi);?>
			</td>
			<td>
				<?= $value->jns_kelamin;?>
			</td>
			<td>
				<?= $value->tmpt_lahir;?>
			</td>
			<td>
				<?= $value->tgl_lahir;?>
			</td>
			<td>
				<?= $value->alamat_KK;?>
			</td>
			<td style="font-size: 9pt;">
				Kode_Pos_Tinggal
			</td>
			<td style="font-size: 9pt;">
				RT_Tinggal
			</td>
			<td style="font-size: 9pt;">
				RW_Tinggal
			</td>
			<td style="font-size: 9pt;">
				Propinsi_Tinggal
			</td>
			<td style="font-size: 9pt;">
				Kota_Kabupaten_Tinggal
			</td>
			<td style="font-size: 9pt;">
				Kecamatan_Tinggal
			</td>
			<td style="font-size: 9pt;">
				Kelurahan_Tinggal
			</td>
			<td>
				<?=$sts_kawin[$value->sts_kawin]->status_kawin2;?>
			</td>
			<td style="font-size: 9pt;">
				<?=$pndk_terakhir[strtolower($value->pndk_akhir)]->penyetaraan;?>
			</td>
			<td style="font-size: 9pt;">
				Pekerjaan
			</td>
			<td>
				<?=$value->remarks;?>
			</td>
		</tr>
	<?php
	}
	?>
</table>
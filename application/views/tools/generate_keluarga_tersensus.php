<h3>Wilayah <?=$wilayah;?></h3>
<table>
	<tr>
		<th></th>
		<th style="background-color: green; color: white;">Data Sensus Sudah Masuk - Status Aktif</th>
		<th style="background-color: pink; color:black;">Keluarga Baru</th>
		<th style="background-color: red; color: white;">Data Sensus Belum Masuk</th>
		<th style="background-color: orange; color: white;">Data Sensus Sudah Masuk - Status Tidak Aktif</th>
	</tr>
</table>
<table>
	<thead>
		<tr>
			<th>#</th>
			<th>Nama Keluarga</th>
			<th colspan="2">Status</th>
			<th>Perubahan Nama</th>
		</tr>
	</thead>
	<tbody>
		<?php
		$i=0;
		foreach ($old_anggota as $key => $value) {
			# code...
			//check sudah masuk data sensus apa belum
			$color="red";
			$nama_baru="-";
			if(isset($new_anggota[$value->kwg_no]) && $value->status_migration==1 && $value->status==1){
				$color="green";
				$nama_baru=$new_anggota[$value->kwg_no]->kwg_nama;
			}
			else if(isset($new_anggota[$value->kwg_no]) && $value->status==0){
				$color="orange";
				$nama_baru=$new_anggota[$value->kwg_no]->kwg_nama;
			}


		?>
			<tr>
				<th><?=$key+1;?></th>
				<td style="text-align: right;"><?=$value->kwg_nama;?></td>
				<td style="background-color: blue;">&nbsp;</td>
				<td style="background-color: <?=$color;?>;">&nbsp;</td>
				<td><?=$nama_baru;?></td>
			</tr>
		<?php
			unset($new_anggota[$value->kwg_no]);
			$i=$key+1;
		}

		foreach ($new_anggota as $key => $value) {
			# code...
			$i++;
			if($value->status==1){
				$color="green";
				$nama_baru=$value->kwg_nama;
			}
			else if($value->status==0){
				$color="orange";
				$nama_baru=$value->kwg_nama;
			}
		?>
			<tr>
				<th><?=$i;?></th>
				<td style="text-align: right;">-</td>
				<td style="background-color: pink;">&nbsp;</td>
				<td style="background-color: <?=$color;?>;">&nbsp;</td>
				<td><?=$nama_baru;?></td>
			</tr>
		<?php
		}
		?>
	</tbody>
</table>
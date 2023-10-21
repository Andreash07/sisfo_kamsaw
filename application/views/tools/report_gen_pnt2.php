<table>
	<thead>
		<tr>
			<th rowspan="2">#</th>
			<th rowspan="2">Calon</th>
			<th colspan="3">Perolehan Suara</th>
		</tr><tr>
			<th >O</th>
			<th >K</th>
			<th >Total</th>
		</tr>
	</thead>
	<tbody>
		<?php 
		foreach ($data as $key => $value) {
			// code...
			$percent=0;
			$percent=($value->total / $angjem->peserta) * 100;
		?>
		<tr>
			<td><?=$key+1;?></td>
			<td><?=$value->nama_lengkap;?></td>
			<td><?=$value->onlen;?></td>
			<td><?=$value->konvensional;?></td>
			<td><?=$value->total;?> (<?=round($percent,2);?>%)</td>
		</tr>
		<?php
		}
		?>
	</tbody>
</table>
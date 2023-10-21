<table>
	<thead>
		<tr>
			<th rowspan="2">#</th>
			<th rowspan="2">Wilayah</th>
			<th rowspan="2">Peserta Pemilih</th>
			<th colspan="2">Penggunaan Hak Suara</th>
			<th colspan="3">Suara Masuk</th>
		</tr>
		<tr>
			<th >Estimasi</th>
			<th >Persentasi</th>
			<th >Total</th>
			<th >Sah</th>
			<th >Tidak Sah</th>
		</tr>
	</thead>
	<tbody>
		<?php
		$kapasitas_hak_suara=8;
		$ls_max_wil_peserta=array();
		$max_peserta=max($num_user_perwil);
		$min_peserta=min($num_user_perwil);
		$ls_min_wil_peserta=array();

		$max_avg=0;
		$min_avg=0;

		$max_total=0;
		$min_total=0;
		foreach ($wilayah as $key => $value) {
			// code...
			$avg=0;
			$total_suara_masuk=0;
			$max_kapasitas_suara=0;
			if(!isset($num_user_perwil[$value->wilayah])){
				$num_user_perwil[$value->wilayah]=0;
			}

			if(!isset($num_vote_sah[$value->wilayah])){
				$num_vote_sah[$value->wilayah]=0;
			}

			if(!isset($num_vote_nonsah[$value->wilayah])){
				$num_vote_nonsah[$value->wilayah]=0;
			}

			$total_suara_masuk=$num_vote_sah[$value->wilayah]+$num_vote_nonsah[$value->wilayah];

			$max_kapasitas_suara=$num_user_perwil[$value->wilayah]*$kapasitas_hak_suara;
			$avg=($total_suara_masuk/$max_kapasitas_suara)*100;

			if($max_peserta==$num_user_perwil[$value->wilayah]){
				$ls_max_wil_peserta[]=$value->wilayah;
			}

			if($min_peserta==$num_user_perwil[$value->wilayah]){
				$ls_min_wil_peserta[]=$value->wilayah;
			}

			$avg_bg="";
			if($max_avg<$avg){
				$max_avg=$avg;
				$avg_bg="background-color:green;";
			}

			if($min_avg>$avg){
				$min_avg=$avg;
				$avg_bg="background-color:red;";
			}

			$total_bg="";
			if($max_total<$total_suara_masuk){
				$max_total=$total_suara_masuk;
				$total_bg="background-color:green;";
			}

			if($min_total>$total_suara_masuk){
				$min_total=$total_suara_masuk;
				$total_bg="background-color:red;";
			}
		?>
			<tr>
				<td ><?=$key+1;?></td>
				<td >Wilayah <?=$value->wilayah;?></td>
				<td id="peserta_wil<?=$value->wilayah;?>"><?=$num_user_perwil[$value->wilayah];?></td>
				<td ><?=$max_kapasitas_suara;?></td>
				<td style="<?=$avg_bg;?>"><?=$avg;?>%</td>
				<td style="<?=$total_bg;?>"><?=$total_suara_masuk;?></td>
				<td ><?=$num_vote_sah[$value->wilayah];?></td>
				<td ><?=$num_vote_nonsah[$value->wilayah];?></td>
			</tr>
		<?php
		}
		?>
	</tbody>
</table>

<?php 
foreach ($ls_max_wil_peserta as $key => $value) {
	// code...
?>
	<script type="text/javascript">
		document.getElementById("peserta_wil<?=$value;?>").style.backgroundColor  = "green"; 
	</script>
<?php
}
?>

<?php 
foreach ($ls_min_wil_peserta as $key => $value) {
	// code...
?>
	<script type="text/javascript">
		document.getElementById("peserta_wil<?=$value;?>").style.backgroundColor  = "red"; 
	</script>
<?php
}
?>
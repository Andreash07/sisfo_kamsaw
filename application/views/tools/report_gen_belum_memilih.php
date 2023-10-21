<?php
$this->load->view('layout/header');
?>
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
<div class="container-fluid">
	
<?php 
$tglCutoff="2022-04-03";
$tglCutoff=date('Y-m-d');
$tglCutoffMemilih=date('d-m-Y H:i');
?>
Jumlah Data <b><?=count($angjem);?></b>
<br>
Jumlah Data Suara Masuk Sah <?= count($sudah_vote_online)+count($sudah_vote_offline);?> (Online: <?=count($sudah_vote_online);?> + Konvensional: <?=count($sudah_vote_offline);?>)
<br>
Jumlah Data Golput <b id="golput">0</b> (Termasuk Konvensional: <b id="konvensional">0</b>)
<br>
Jumlah Data Belum Dikunci <b id="tidaksah">0</b>
<br>
Tgl Cut Off: <?=$tglCutoffMemilih;?>
<table class="table table-striped" cellpadding="0" cellmargin="0">
	<thead>
		<tr>
			<th cellpadding="0">#</th>
			<th cellpadding="0">Wilayah</th>
			<th cellpadding="0">KK</th>
			<th cellpadding="0">Anggota Jemaat</th>
			<th cellpadding="0">HP</th>
			<th cellpadding="0">Status</th>
		</tr>
	</thead>
	<tbody>
		<?php
		$namaKK_before="";
		$i=0;
		$noHP="";
		$noHPLast="";
		$golput=0;
		$tidaksah=0;
		$numkonvensional=0;
		$lbl="";
		foreach ($angjem as $key => $value) {
			// code...
			$lbl="";
			//check if konvensional diskip
			if(isset($konvensional[$value->id]) && !isset($sudah_vote_offline[$value->id])){
				$numkonvensional=$numkonvensional+1;
				$golput=$golput+1;
				//$lbl='<span class="text-danger">Konvensional</span>';
				continue;
			}

			$status_vote='<span style="background:red; color:#fff;">Belum</span>';
			if(isset($sudah_vote[$value->id])){
				//check dulu suara sudah dilock atau belum
				//print_r($sudah_vote[$value->id]);die();
				if($sudah_vote[$value->id]->locked==0){
					$status_vote='<span style="background:gray; color:#fff;">Belum dilock</span>';
					$tidaksah=$tidaksah+1;
				}
				else{
					continue;
					//$status_vote='<span style="background:green; color:#fff;">Sudah </span>';
				}

			}
			$golput=$golput+1;



			$noHP="";
			$namaKK_new=$value->kwg_id;
			if($namaKK_before == $namaKK_new){
				$value->kwg_nama='';
			}

			if( $value->tgl_lahir == '0000-00-00'){
				$umurLahir=0;
				$umurLahir_lbl="<i style='color:red; ;'>-</i>";
			}else{
				$umurLahir=getUmur($tglCutoff, $value->tgl_lahir);
				$umurLahir_lbl=$umurLahir." th";
			}

			if( $value->tgl_sidi == '0000-00-00'){
				$umurSidi=0;
				$umurSidi_lbl="<i style='color:red; ;'>-</i>";
			}
			else{
				$umurSidi=getUmur($tglCutoffMemilih, $value->tgl_sidi);
				$umurSidi_lbl=$umurSidi." th";
			}
			if( $value->tgl_attestasi_masuk == '0000-00-00'){
				$umurAttesasi=0;
				$umurAttesasi_lbl="<i style='color:red; ;'>Lama</i>";
			}
			else{
				$umurAttesasi=getUmur($tglCutoff, $value->tgl_attestasi_masuk);
				$umurAttesasi_lbl=$umurAttesasi." th";
			}

			if($value->status_sidi!=1 && $value->tgl_sidi =='0000-00-00'){
				//continue;
			}
			if($value->sts_kawin!=1){
				//continue;
			}
			$namaKK_before=$value->kwg_id;

			if($value->telepon!=null && $value->telepon!=0 && $value->telepon!=''){
				$noHP=$value->telepon;
			}
			else if($value->kwg_telepon!=null && $value->kwg_telepon!=0 && $value->kwg_telepon!=''){
				$noHP=$value->kwg_telepon;
			}
			$noHP_curr=$noHP;

			if($noHP!=null && ($noHPLast==$value->telepon || $noHPLast==$value->kwg_telepon)){
				$noHP="";
			}

			$noHPLast=$noHP_curr;
			if($noHP!=null){
				$noHP="'".$noHP;
			}

			if($value->tgl_meninggal=='0000-00-00'){
				$value->tgl_meninggal='';
			}
		?>
		<tr>
			<td cellpadding="0"><?=++$i;?></td>
			<td cellpadding="0"><?=$value->kwg_wil;?></td>
			<td cellpadding="0">
				<?=$value->kwg_nama;?>
			</td>
			<td cellpadding="0"><?=$value->nama_lengkap;?></td>
			<td cellpadding="0"><?=$noHP;?></td>
			<td cellpadding="0">
				<?=$status_vote;?>
				<br>
				<?=$lbl;?>
			</td>
		</tr>
		<?php
		}

		foreach ($konvensional as $key => $value) {
			// code...
			$lbl="";
			//check if konvensional diskip
			if(isset($sudah_vote_offline[$value->id])){
				continue;
			}

			$status_vote='<span style="background:red; color:#fff;">Belum</span>';
			if(isset($sudah_vote[$value->id])){
				//check dulu suara sudah dilock atau belum
				//print_r($sudah_vote[$value->id]);die();
				if($sudah_vote[$value->id]->locked==0){
					$status_vote='<span style="background:gray; color:#fff;">Belum dilock</span>';
					$tidaksah=$tidaksah+1;
				}
				else{
					continue;
					//$status_vote='<span style="background:green; color:#fff;">Sudah </span>';
				}

			}
			$status_vote='<span class="text-danger">Konvensional</span>';



			$noHP="";
			$namaKK_new=$value->kwg_id;
			if($namaKK_before == $namaKK_new){
				$value->kwg_nama='';
			}

			if( $value->tgl_lahir == '0000-00-00'){
				$umurLahir=0;
				$umurLahir_lbl="<i style='color:red; ;'>-</i>";
			}else{
				$umurLahir=getUmur($tglCutoff, $value->tgl_lahir);
				$umurLahir_lbl=$umurLahir." th";
			}

			if( $value->tgl_sidi == '0000-00-00'){
				$umurSidi=0;
				$umurSidi_lbl="<i style='color:red; ;'>-</i>";
			}
			else{
				$umurSidi=getUmur($tglCutoffMemilih, $value->tgl_sidi);
				$umurSidi_lbl=$umurSidi." th";
			}
			if( $value->tgl_attestasi_masuk == '0000-00-00'){
				$umurAttesasi=0;
				$umurAttesasi_lbl="<i style='color:red; ;'>Lama</i>";
			}
			else{
				$umurAttesasi=getUmur($tglCutoff, $value->tgl_attestasi_masuk);
				$umurAttesasi_lbl=$umurAttesasi." th";
			}

			if($value->status_sidi!=1 && $value->tgl_sidi =='0000-00-00'){
				//continue;
			}
			if($value->sts_kawin!=1){
				//continue;
			}
			$namaKK_before=$value->kwg_id;

			if($value->telepon!=null && $value->telepon!=0 && $value->telepon!=''){
				$noHP=$value->telepon;
			}
			else if($value->kwg_telepon!=null && $value->kwg_telepon!=0 && $value->kwg_telepon!=''){
				$noHP=$value->kwg_telepon;
			}
			$noHP_curr=$noHP;

			if($noHP!=null && ($noHPLast==$value->telepon || $noHPLast==$value->kwg_telepon)){
				$noHP="";
			}

			$noHPLast=$noHP_curr;
			if($noHP!=null){
				$noHP="'".$noHP;
			}

			if($value->tgl_meninggal=='0000-00-00'){
				$value->tgl_meninggal='';
			}
		?>
		<tr>
			<td cellpadding="0"><?=++$i;?></td>
			<td cellpadding="0"><?=$value->kwg_wil;?></td>
			<td cellpadding="0">
				<?=$value->kwg_nama;?>
			</td>
			<td cellpadding="0"><?=$value->nama_lengkap;?></td>
			<td cellpadding="0"><?=$noHP;?></td>
			<td cellpadding="0">
				<?=$status_vote;?>
				<br>
				<?=$lbl;?>
			</td>
		</tr>
		<?php
		}
		?>
	</tbody>
</table>

<script type="text/javascript">
	document.getElementById("golput").innerHTML = '<?=$golput;?>';
	document.getElementById("tidaksah").innerHTML = '<?=$tidaksah;?>';
	document.getElementById("konvensional").innerHTML = '<?=$numkonvensional;?>';
</script>


</div>
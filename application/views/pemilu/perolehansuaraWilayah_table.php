<table class="table table-striped">
	<thead>
		<tr>
			<th rowspan="2" style="text-align:center;">#</th>
			<th rowspan="2" style="text-align:center;">Calon</th>
			<th colspan="3" style="text-align:center;">Suara</th>
		</tr>
		<tr>
			<th style="text-align:center;">O</th>
			<th style="text-align:center;">K</th>
			<th style="text-align:center;">Total</th>
		</tr>
	</thead>
	<tbody>
<?php 

$percent=0;

$Tot_percent=0;

$Tot_masuk=0;

$Tot_banyaksuara=0;

$slot=10;



if(isset($voted_wil) && count($voted_wil) > 0){

	foreach ($voted_wil as $keyvoted => $valuevoted) {

		# code...
		if($valuevoted->voted_konvensional==null){
			$valuevoted->voted_konvensional=0;
		}
		$online=0;
		$online=$valuevoted->voted - $valuevoted->voted_konvensional;
		$percent=$valuevoted->voted/$NumAngjem*100;

		//$Tot_masuk=$Tot_masuk+$valuevoted;

		$btn_Slot="";

		$btn_Process="";

		if($valuevoted->status_terpilih ==1 || $valuevoted->status_terpilih == NULL){

			//inibeart

			$slot=$slot-1;

		}



		if($slot>=0 && $valuevoted->status_terpilih == null){

			$btn_Process='<button class="btn btn-info btn-small" id="btn_ProsesPemilihan" id_calon="'.$valuevoted->id.'"  tahun_pemilihan="'.$valuevoted->tahun_pemilihan.'"  wilayah="'.$valuevoted->kwg_wil.'" data-toggle="modal" data-target="#modal'.$valuevoted->id.'" >Proses</button>';



			$btn_Slot.='<button class="btn btn-success btn-small" id="btn_AcceptPemilihan" id_calon="'.$valuevoted->id.'"  tahun_pemilihan="'.$valuevoted->tahun_pemilihan.'"  wilayah="'.$valuevoted->kwg_wil.'" data-dismiss="modal" title="Terima"><i class="fa fa-check"></i></button>';

			$btn_Slot.='<button class="btn btn-danger btn-small" id="btn_CancelPemilihan" id_calon="'.$valuevoted->id.'" tahun_pemilihan="'.$valuevoted->tahun_pemilihan.'" wilayah="'.$valuevoted->kwg_wil.'" data-dismiss="modal" title="Batal"><i class="fa fa-times"></i></button>';



		}

		else{

				$btn_Process.="<label class='btn label label-warning disabled'><i class='fa fa-info'></i> Tidak Terpilih</label>";

		}

		

		if($valuevoted->status_terpilih == 1){

			$btn_Process="<label class='btn label label-success' data-toggle='modal' data-target='#modal".$valuevoted->id."' ><i class='fa fa-success'></i> Diterima</label>";

		}

		else if($valuevoted->status_terpilih == 2){

			$btn_Process="<label class='btn label label-danger' data-toggle='modal' data-target='#modal".$valuevoted->id."'><i class='fa fa-times'></i> Dibatalkan</label>";

		}



		$disTextArea="";

		if($valuevoted->status_terpilih != null){

			$disTextArea="disabled";

		}



	?>

		<tr>
			<th ><?=$keyvoted+1;?>.</th>
			<td ><?=$valuevoted->nama_lengkap;?></td>
			<th ><?=$online;?></th>
			<th ><?=$valuevoted->voted_konvensional;?></th>
			<td ><?=$valuevoted->voted;?> (<?= round($percent,2);?>%)</td>
		</tr>
	<?php

	}

}

else{

?>

Belum ada data pemilihan masuk.

<?php

}



//$Tot_percent=($NumAngjem-$Tot_masuk)/$NumAngjem*100;

?>
	</tbody>
</table>
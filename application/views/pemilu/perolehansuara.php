<?php 
$percent=0;
$Tot_percent=0;
$Tot_masuk=0;
$Tot_banyaksuara=0;
$slot=10;

?>
<table class="table table-striped">
	<thead>
		<tr>
			<th class="text-center" rowspan="2">#</th>
			<th class="text-center" rowspan="2">Calon</th>
			<th class="text-center" rowspan="2">Wilayah</th>
			<th class="text-center" colspan="3">Perolehan</th>
			<th class="text-center"rowspan="2">Action</th>
		</tr>
		<tr>
			<th class="text-center" >Wil.Domisili</th>
			<th class="text-center" >Wil.Non-Domisili</th>
			<th class="text-center">Total</th>
		</tr>
	</thead>
	<tbody>
<?php
$tot_suara=0;
if(isset($voted) && count($voted) > 0){
	foreach ($voted as $keyvoted => $valuevoted) {
		# code...
		$percent=$valuevoted->voted/$NumAngjem*100;
		$tot_suara=$tot_suara+$valuevoted->voted;
		$btn_Slot="";
		$btn_Process="";
		$wil_domisili='Tidak diketahui';
	    $num_wil_domisili=0;
	    $num_wil_nondomisili=0;
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

	 	$foto_thumb=base_url().'assets/images/default-user.png';
	    $foto=base_url().'assets/images/default-user.png';
	    if($valuevoted->foto != null){
	    	$foto_thumb=base_url().$valuevoted->foto_thumb;
	    	$foto=base_url().$valuevoted->foto;
	    }

	    $wil_domisili=$valuevoted->wilayah;
    	$num_wil_domisili=0;
    	$num_wil_nondomisili=0;
	    if(isset($voted_domisili[$valuevoted->id])){
	    	$num_wil_domisili=$voted_domisili[$valuevoted->id];
	    }
	    if(isset($voted_nondomisili[$valuevoted->id])){
	    	$num_wil_nondomisili=$voted_nondomisili[$valuevoted->id];
	    }

	?>
		<tr>
			<td class="text-center"><?=$keyvoted+1;?></td>
			<td style=" vertical-align: middle;">
				<img src="<?=$foto_thumb;?>" data-caption="<?=$valuevoted->nama_lengkap;?>" alt="<?=$valuevoted->nama_lengkap;?>" class="img-circle img-responsive" style="width: 77px;height: 77px;object-fit: cover; cursor: pointer; margin-right: 10px; display: inline;" href="<?=$foto;?>" data-fancybox="images" data-caption="<?=$valuevoted->nama_lengkap;?>">
	            <?=$valuevoted->nama_lengkap;?></td>
			<td class="text-center"><?=$valuevoted->wilayah;?></td>
			<td class="text-center">
                <?=$num_wil_domisili;?>
			</td>
			<td class="text-center">
                <?=$num_wil_nondomisili;?>
			</td>
			<td class="text-center">
			 	<div class="progress" style="margin-bottom: 0px;">
	                <div class="progress-bar bg-blue" role="progressbar" aria-valuenow="<?=$percent;?>" aria-valuemin="0" aria-valuemax="100" style="width: <?=$percent;?>%;">
	                  <span class="sr-only"><?=$valuevoted->voted;?></span>
	                </div>
              	</div>
      		 	<small class="">
	              	&nbsp;<?=$valuevoted->voted;?> (<?= round($percent,2);?>%)
              	</small>
			</td>
			<td class="text-center">
	             <?=$btn_Process;?>
		    </td>
		    <!-- ini modal penerimaan -->
	        <div id="modal<?=$valuevoted->id;?>" class="modal fade bs-example-modal-sm" tabindex="-1" role="dialog" aria-hidden="true">
		        <div class="modal-dialog modal-sm">
		          	<div class="modal-content">
			            <div class="modal-header">
			              <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span>
			              </button>
			              <h4 class="modal-title" id="myModalLabel2"><?=$valuevoted->nama_lengkap;?></h4>
			            </div>
			            <div class="modal-body">
			              <h4>Catatan</h4>
			              <textarea id="txt_note_<?=$valuevoted->id;?>" name="txt_note_<?=$valuevoted->id;?>" class="form-control" rows="3" placeholder="Ketikan catatan Calon Terpilih jika ada..." style="resize: none;" <?=$disTextArea;?>><?= $valuevoted->note;?></textarea>
			            </div>
			            <div class="modal-footer">
			              <?=$btn_Slot;?>
			            </div>
		          	</div>
		        </div>
	      	</div>
	      	<!-- ini modal penerimaan -->
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

<script type="text/javascript">
	$('#tot_suara').html('<?=$tot_suara;?>')
</script>
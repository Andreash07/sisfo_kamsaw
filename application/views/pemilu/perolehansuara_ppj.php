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
			<th class="text-center">#</th>
			<th class="text-center">Calon</th>
			<th class="text-center">Wilayah</th>
			<th class="text-center">Perolehan</th>
			<th class="text-center">Action</th>
		</tr>
	</thead>
	<tbody>
<?php
if(isset($voted) && count($voted) > 0){
	foreach ($voted as $keyvoted => $valuevoted) {
		# code...
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

	 	$foto_thumb=base_url().'assets/images/default-user.png';
	    $foto=base_url().'assets/images/default-user.png';
	    if($valuevoted->foto != null){
	    	$foto_thumb=base_url().$valuevoted->foto_thumb;
	    	$foto=base_url().$valuevoted->foto;

    	 	if(strpos($valuevoted->foto, 'https://') >=0 ){
            	$foto_thumb=$valuevoted->foto_thumb;
            	$foto=$valuevoted->foto;
          	}
	    }

	    $title="Ibu ";
        if($valuevoted->sts_kawin==1){
          $title="Sdri. ";
        }
        if(mb_strtolower($valuevoted->jns_kelamin)=='l'){
          $color_gender="bg-gradient-blue";
          $ico_gender='<i class="fa fa-male" style="font-size:12pt;"></i>';
          $title="Bp. ";
          if($valuevoted->sts_kawin==1){
            $title="Sdr. ";
          }
        }

	?>
		<tr>
			<td class="text-center"><?=$keyvoted+1;?></td>
			<td style=" vertical-align: middle;">
				<img src="<?=$foto_thumb;?>" data-caption="<?=$title.$valuevoted->nama_lengkap2;?>" alt="<?=$title.$valuevoted->nama_lengkap2;?>" class="img-circle img-responsive" style="width: 77px;height: 77px;object-fit: cover; cursor: pointer; margin-right: 10px; display: inline;" href="<?=$foto;?>" data-fancybox="images" data-caption="<?=$title.$valuevoted->nama_lengkap2;?>"> <?=$title.$valuevoted->nama_lengkap2;?></td>
			<td class="text-center"><?=$valuevoted->wilayah;?></td>
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
			              <h4 class="modal-title" id="myModalLabel2"><?=$title.$valuevoted->nama_lengkap2;?></h4>
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